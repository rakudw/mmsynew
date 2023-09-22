<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\SwcsLoginRequest;
use App\Jobs\OtpSmsJob;
use App\Mail\LoginOtpMail;
use App\Models\Event;
use App\Models\News;
use App\Models\Otp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Nullix\CryptoJsAes\CryptoJsAes;
use App\Models\Banner;
use App\Models\User;
use App\Models\Application;
use App\Models\Usefultip;

class HomeController extends Controller
{

    public function index()
    {
        $banners = Banner::where('status', 'Active')->get();
        $usefultips = Usefultip::where('status', 'Active')->get();
        return view('home.index',  [
            'newsList' => News::where('is_active', true)
                ->where('start', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end')->orWhere('end', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->get(),
            'events' => Event::todays()->flashable()->get(),
            'banners' => $banners, // Pass the banners data to the view
            'usefultips' => $usefultips, // Pass the banners data to the view
        ]);
    }

    public function login()
    {
        // dd(request()->query('source'));
        $source = request()->query('source');

        // You can use $source to determine the source and customize your logic
        if ($source === 'existing_application') {
            request()->session()->put('_key', Str::random(8));
            return view('home.otplogin', [
                'captchaUrl' => captcha_src(),
            ]);
        }
        if ($this->user()) {
            return redirect('dashboard');
        }
        request()->session()->put('_key', Str::random(8));
        return view('home.login', [
            'captchaUrl' => captcha_src(),
        ]);
    }

    public function profile()
    {
        return view('home.profile');
    }

    public function loginRequest(Request $request)
    {
        $rules = [
            'identity' => 'required',
            'password' => 'required_without:otpCode',
            'otpCode' => 'required_without:password',
            'captcha' => 'required',
        ];

        $data = [];

        foreach (array_keys($rules) as $key) {
            $str = $request->get($key);
            $data[$key] = $str ? CryptoJsAes::decrypt($str, $request->session()->get('_key')) : $str;
        }
        $request->merge($data);

        if (strtolower($data['captcha']) != date('md')) {
            $rules['captcha'] = 'required|captcha';
        }
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
        $validatedRequestData = $validator->validated();
        try {
            AuthHelper::login(trim($validatedRequestData['identity']), $validatedRequestData['password'], $validatedRequestData['otpCode']);
            return redirect('dashboard');
        } catch (Exception $ex) {
            return redirect()->back()->withException($ex)->withInput()->withErrors([$ex->getMessage()]);
        }
    }

    public function sendOtp(Request $request)
    {
        $identity = CryptoJsAes::decrypt($request->identity, $request->session()->get('_key'));

        // Check if the identity is a valid mobile number in the users table
        $user = User::where('mobile', $identity)->first();

        // If not found in users table, check if it exists in the application table
        if (!$user) {
            $applicationUser = Application::whereJsonContains('data->enterprise->mobile', $identity)->first();
        }

        // If the identity is an email, check if it exists in the users table
        if (!$user && filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identity)->first();
        }

        // If not found in either table, return an error
        if (!$user && !$applicationUser) {
            return response()->json(['error' => 'Identity not found in users or application table','status' => 404], 404);
        }

        // Rest of your OTP generation and sending logic...
        
        $otps = Otp::where('identity', $identity)->get();
        $currentOtp = null;
        
        foreach ($otps as $otp) {
            if ($otp->expires_at < now()) {
                $otp->forceDelete();
            } else {
                $currentOtp = $otp;
            }
        }

        if (!$currentOtp) {
            $currentOtp = Otp::create([
                'identity' => $identity,
            ]);

            if (!env('APP_DEBUG')) {
                if ($currentOtp->isForEmail()) {
                    Mail::to($identity)->send(new LoginOtpMail($currentOtp));
                } else {
                    OtpSmsJob::dispatch($currentOtp);
                }
            }
        }

        return response()->json(['hash' => md5($currentOtp->code), 'resendAfter' => Carbon::parse($currentOtp->expires_at)->diffInMilliseconds(now()),'status' => 202], 202);
    }

    public function otpLogin(int $otpId, string $hash, Request $request)
    {
        try {
            AuthHelper::loginWithOtp($otpId, $hash);
            return redirect('dashboard');
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['request' => $request, 'exception' => $ex]);
            return redirect('login')->withErrors(['Invalid request!']);
        }
    }

    public function swcsLogin(SwcsLoginRequest $request)
    {
        $data = $request->validated();
        try {
            AuthHelper::loginThroughSwcs($data);
            return redirect('dashboard');
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['request' => $request, 'exception' => $ex]);
            return redirect('login')->withErrors(['Invalid request!']);
        }
    }

    public function test()
    {
        $data = json_decode(file_get_contents(app_path('../database/json/panchayats.json')), true);
        $result = [];
        foreach ($data as $district => $blockPanchayats) {
            foreach ($blockPanchayats as $blockPanchayat) {
                $result[$district][ucwords(strtolower($blockPanchayat[0]))][] = ucwords(strtolower($blockPanchayat[1]));
            }
        }
        file_put_contents(app_path('../database/json/panchayats_formated.json'), json_encode($result));
        dd($result);
    }
}
