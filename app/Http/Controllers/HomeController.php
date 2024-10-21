<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\SwcsLoginRequest;
use App\Jobs\OtpSmsJob;
use App\Mail\LoginOtpMail;
use App\Models\Event;
use App\Models\News;
use App\Models\Otp;
use App\Models\Region;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Nullix\CryptoJsAes\CryptoJsAes;
use App\Models\Banner;
use App\Models\Faqs;
use App\Models\Successstories;
use App\Models\Homenotifications;
use App\Models\User;
use App\Models\Application;
use App\Models\Feedback;
use App\Models\Usefultip;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index()
    {
        $banners = Banner::where('status', 'Active')->get();
        $usefultips = Usefultip::where('status', 'Active')->get();
        $faqs = Faqs::where('status', 'Active')->get();
        $stories = Successstories::where('status', 'Active')->get();
        $notifications = Homenotifications::where('status', 'Active')->get();
        $projectPassed = Application::where('status_id', '>', 307)->count();
        $proposedEmp  = Application::where('status_id', '>', 311)->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.employment')) IS NOT NULL")
        ->get()
        ->sum(function ($application) {
            $employment = $application->data->enterprise->employment;
            return is_numeric($employment) ? $employment : 0;
        });
    
        $generateEmp = Application::where('status_id', '>', 315)->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.employment')) IS NOT NULL")
        ->get()
        ->sum(function ($application) {
            $employment = $application->data->enterprise->employment;
            return is_numeric($employment) ? $employment : 0;
        });
    
        $industriesEstablished = Application::where('status_id', '>', 311)->count();
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
            'usefultips' => $usefultips,
            'faqs' => $faqs,
            'stories' => $stories,
            'notifications' => $notifications,
            'projectPassed' => $projectPassed,
            'industriesEstablished' => $industriesEstablished,
            'generateEmp' => $generateEmp,
        ]);
    }

    public function login()
{
    $source = request()->query('source');

    if ($source === 'existing_application') {
        request()->session()->put('_key', Str::random(8));

        // Generate two random numbers for the captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $captchaQuestion = "$num1 + $num2";

        // Store the correct answer in the session
        session(['captcha_answer' => $num1 + $num2]);

        return view('home.otplogin', [
            'captchaQuestion' => $captchaQuestion,
        ]);
    }

    if ($this->user()) {
        return redirect('dashboard');
    }

    request()->session()->put('_key', Str::random(8));

    // Generate two random numbers for the captcha
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $captchaQuestion = "$num1 + $num2";

    // Store the correct answer in the session
    session(['captcha_answer' => $num1 + $num2]);

    return view('home.login', [
        'captchaQuestion' => $captchaQuestion,
    ]);
}
    
public function applicant_login()
    {
        // dd(request()->query('source'));
        $source = request()->query('source');
        if(auth()->user()){
            $applications = Application::where('created_by',auth()->user()->id)->get();
        }else{
            $applications = [];
        }
        // You can use $source to determine the source and customize your logic
        // Generate two random numbers for the captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $captchaQuestion = "$num1 + $num2";
        if ($source === 'existing_application') {
            request()->session()->put('_key', Str::random(8));
            return view('home.otplogin', [
                'captchaQuestion' => $captchaQuestion,
            ]);
        }
        if ($this->user()) {
            return redirect('dashboard');
        }
        // Generate two random numbers for the captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $captchaQuestion = "$num1 + $num2";
        request()->session()->put('_key', Str::random(8));
        return view('home.status', compact('applications'), [
            'captchaQuestion' => $captchaQuestion,
        ]);
    }
    public function grievance(Request $request)
    {
        // Do nothing because of X and Y.
        // dd($request);
        $rules = [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ];
        // Define custom validation messages (optional)
        $messages = [
            'subject.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
        ];
        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator) // Pass validation errors to the view
                ->withInput(); // Keep the old input values
        }
        // dd(auth()->user()->email);
        // dd($request);
        $Feedback = new Feedback();
        $Feedback->subject = $request->input('subject');
        $Feedback->description = $request->input('description');
        $Feedback->type = "grievance" ;  // type 1 for grievance 
        $Feedback->from = auth()->user()->email;
        $Feedback->to = "mmsy2018@gmail.com";
        $Feedback->created_by = auth()->user()->id;
        $Feedback->save();
        return redirect()->back();
                 
    }
    public function feedback( Request $request )
    {
        
        $rules = [
            'description' => 'required|string',
        ];
        // Define custom validation messages (optional)
        $messages = [
            'description.required' => 'The description field is required.',
        ];
        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator) // Pass validation errors to the view
                ->withInput(); // Keep the old input values
        }
        // dd(auth()->user()->email);
        // dd($request);
        $Feedback = new Feedback();
        $Feedback->description = $request->input('description');
        $Feedback->type = "feedback" ;  // type 1 for grievance 
        $Feedback->from = auth()->user()->email;
        $Feedback->created_by = auth()->user()->id;
        $Feedback->save();
        return redirect()->back();
                 
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
        // dd($data);
        // if (strtolower($data['captcha']) != date('md')) {
        //     $rules['captcha'] = 'required|captcha';
        // }
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
        $validatedRequestData = $validator->validated();
        // if ($request->session()->get('captcha_answer') != $data['captcha']) {
        //     // dd($data['captcha']);
        //     return redirect()->back()
        //     ->withErrors(['captcha' => 'The captcha answer is incorrect.'])
        //     ->withInput($data);
        // }
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
            $applicationUser = Application::whereJsonContains('data->owner->mobile', $identity)->first();
        }

        // If the identity is an email, check if it exists in the users table
        if (!$user && filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identity)->first();
        }

        // If not found in either table, return an error
        if (!$user && !$applicationUser) {
            return response()->json(['error' => 'User not found','status' => 404], 404);
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
                  $result = Mail::to($identity)->send(new LoginOtpMail($currentOtp));
                //   return response()->json( $result);
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
    public function mmsyDashboard(){
        $monthStartDate = Carbon::now()->startOfMonth();
        $weekStartDate = Carbon::now()->startOfDay();
        // Calculate the start date for the current month
        for ($i = 0; $i < 12; $i++) {
            // echo $monthStartDate;
            // Calculate the end date for the current month
            $monthEndDate = $monthStartDate->copy()->endOfMonth();
            $monthName = $monthStartDate->format('M'); // Example: "Apr 2023"
            // Count applications for the current month
            $monthlyCount = Application::whereBetween('created_at', [$monthStartDate, $monthEndDate])
                ->count();
            $senctionedMonthlyCount = Application::where('status_id', '>=', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())
            ->whereBetween('created_at', [$monthStartDate, $monthEndDate])
            ->count();

            // Add monthly count to the monthlyCounts array
           
            $monthlyLabels[]= $monthName;
            $monthlyCounts[]= $monthlyCount;
            $senctionedMonthlyCouns[]= $senctionedMonthlyCount;

            // Move to the next month
            $monthStartDate->subMonth();
        }

        // Weekly
        // Calculate the start date for the current week
        for ($i = 0; $i < 7; $i++) {
            // Calculate the end date for the current day
            $weekEndDate = $weekStartDate->copy()->endOfDay();
            $dayName = $weekStartDate->format('D'); // Example: "Sun"
            $dayNumber = $weekStartDate->format('d'); // Example: "01"
            // Count applications for the current day
            $dailyCount = Application::whereBetween('created_at', [$weekStartDate, $weekEndDate])
                ->count();

            // Add daily count to the weeklyCounts array
            // Count applications for the current day
            $dailyCount = Application::whereDate('created_at', $weekStartDate->format('Y-m-d'))
            ->count();

            // Add daily data to the weeklyData array
            $weeklyLabels[]= $dayName;
            $weeklyCounts[]= $dailyCount;

            // Move to the next day
            $weekStartDate->subDay();
        }
        $weeklyCounts = array_reverse($weeklyCounts);
        $monthlyCounts = array_reverse($monthlyCounts);
        $monthlyLabels = array_reverse($monthlyLabels);
        $weeklyLabels = array_reverse($weeklyLabels);
        $senctionedMonthlyCouns = array_reverse($senctionedMonthlyCouns);
        // PichartData
        $generalCount = Application::whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 601 . '%'])->count();

        $scCount = Application::whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 602 . '%'])->count();

        $stCount = Application::whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 603 . '%'])->count();

        $obcCount = Application::whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 604 . '%'])->count();

        $minorityCount = Application::whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.belongs_to_minority'))) LIKE ?", ['%' . 'yes' . '%'])->count();
        $categoryCountsForPie = [$generalCount, $scCount, $stCount, $obcCount, $minorityCount];
        // PichartData

        // Get TotalFYCount 
        $fyWiseapplicationCount = $this->getTotalFyDataWithCount()['dataPoints'];
        $fyWiseapplicationCountTotals = $this->getTotalFyDataWithCount()['totals'];
        // Get TotalFYCount 

        $this->addJs('resources/material/js/plugins/chartjs.min.js');
        return view('home.mmsy_dashboard',compact('monthlyCounts','monthlyLabels','senctionedMonthlyCouns','weeklyCounts','weeklyLabels','categoryCountsForPie','fyWiseapplicationCount','fyWiseapplicationCountTotals'));
    }
    public function getTotalFyDataWithCount(){
        $dataPoints = [];
        $selectedFiscalYears = ['2020-2021', '2021-2022', '2022-2023', '2023-2024'];
        $totals = [
            'Received Application' => 0,
            'Forwarded To Bank' => 0,
            '60% Subsidy Released' => 0,
            'Total Subsidy Released' => 0,
        ];
        foreach ($selectedFiscalYears as $fiscalYear) {
            list($startYear, $endYear) = explode('-', $fiscalYear);

            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";

            // Build queries to count data points

            $receivedCount = Application::where('status_id', '>', 308)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $forwardedToBankCount = Application::whereIn('status_id', [311])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $subsidyReleased60 = Application::whereIn('status_id', [315])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $subsidyReleasedTotal = Application::whereIn('status_id', [315,317])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $totals['Received Application'] += $receivedCount;
            $totals['Forwarded To Bank'] += $forwardedToBankCount;
            $totals['60% Subsidy Released'] += $subsidyReleased60;
            $totals['Total Subsidy Released'] += $subsidyReleasedTotal;
            // Create an array for the current fiscal year's data points
            $fiscalYearData = [
                'Year' => $fiscalYear,
                'Received Application' => $receivedCount,
                'Forwarded To Bank' => $forwardedToBankCount,
                '60% Subsidy Released' => $subsidyReleased60,
                'Total Subsidy Released' => $subsidyReleasedTotal,
            ];
            

            // Add the fiscal year data to the array
            $dataPoints[] = $fiscalYearData;
        }
        $totalsArray = [
            'Year' => 'Total',
            'Received Application' => $totals['Received Application'],
            'Forwarded To Bank' => $totals['Forwarded To Bank'],
            '60% Subsidy Released' => $totals['60% Subsidy Released'],
            'Total Subsidy Released' => $totals['Total Subsidy Released'],
        ];
        return [
            'dataPoints' => $dataPoints,
            'totals' => $totalsArray,
        ];

    }
    public function extractFromCounts(Request $request, $fy, $status_id, $type){
        $title = 'District Wise Data for Application '.$type.' in FY ('.$fy.')';
        $districts = Region::where('type_id',404)->select('name','id')->get();
        $districtsIds = Region::where('type_id',404)->pluck('id')->values();
        $selectedFY = $fy;
       $reportData = $this->numaricQueryRecieved($districtsIds,$selectedFY,$status_id,$type);
        //    dd($reportData);
       $totals = null;

        foreach ($reportData as $item) {
            if (isset($item['Total'])) {
                $totals = $item['Total'];
                break;
            }
        }
        return view('home.extracted_counts',compact('districts','title','reportData','totals'));
    }

    public function numaricQueryRecieved($districtIds, $selectedFY,$status_id,$type)
    {
        $selectedFiscalYears = $selectedFY && $selectedFY !== "All" ? [$selectedFY] : ['2020-2021', '2021-2022', '2022-2023', '2023-2024'];
    
        $reportData = [];
    
        // Initialize totals
        $totals = [
            'General' => 0,
            'SC' => 0,
            'ST' => 0,
            'OBC' => 0,
            'Minority' => 0
        ];
    
        // Loop through each district
        foreach ($districtIds as $districtId) {
            $districtData = [
                'District' => Region::find($districtId)->name, 
                'DistrictId' => $districtId, 
                'Year' => [],
            ];
    
            // Loop through each fiscal year
            foreach ($selectedFiscalYears as $fiscalYear) {
                list($startYear, $endYear) = explode('-', $fiscalYear);
    
                $startDate = "{$startYear}-04-01";
                $endDate = "{$endYear}-03-31";
                $baseQuery = Application::where('region_id', $districtId);

                $generalQuery = clone $baseQuery;
                $scQuery = clone $baseQuery;
                $stQuery = clone $baseQuery;
                $obcQuery = clone $baseQuery;
                $minorityQuery = clone $baseQuery;

                if ($type == 'Application Recieved') {
                    $generalQuery->where('status_id', '>', 308);
                    $scQuery->where('status_id', '>', 308);
                    $stQuery->where('status_id', '>', 308);
                    $obcQuery->where('status_id', '>', 308);
                    $minorityQuery->where('status_id', '>', 308);
                } elseif ($type == 'Total Subsidy Released') {
                    $generalQuery->whereIn('status_id', [315, 317]);
                    $scQuery->whereIn('status_id', [315, 317]);
                    $stQuery->whereIn('status_id', [315, 317]);
                    $obcQuery->whereIn('status_id', [315, 317]);
                    $minorityQuery->whereIn('status_id', [315, 317]);
                } else {
                    $generalQuery->where('status_id', $status_id);
                    $scQuery->where('status_id', $status_id);
                    $stQuery->where('status_id', $status_id);
                    $obcQuery->where('status_id', $status_id);
                    $minorityQuery->where('status_id', $status_id);
                }

                $generalCount = $generalQuery
                    ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 601 . '%'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $scCount = $scQuery
                    ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 602 . '%'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $stCount = $stQuery
                    ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 603 . '%'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $obcCount = $obcQuery
                    ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . 604 . '%'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $minorityCount = $minorityQuery
                    ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.belongs_to_minority'))) LIKE ?", ['%' . 'yes' . '%'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                // Update the totals
                $totals['General'] += $generalCount;
                $totals['SC'] += $scCount;
                $totals['ST'] += $stCount;
                $totals['OBC'] += $obcCount;
                $totals['Minority'] += $minorityCount;
    
                // Create an array for the current fiscal year's data
                $fiscalYearData = [
                    'Year' => $fiscalYear,
                    'General' => $generalCount,
                    'SC' => $scCount,
                    'ST' => $stCount,
                    'OBC' => $obcCount,
                    'Minority' => $minorityCount,
                ];
    
                // Add the fiscal year data to the 'Year' key
                $districtData['Year'][] = $fiscalYearData;
            }
    
            // Add the district data to the report data
            $reportData[] = $districtData;
        }
    
        // Add the totals to the report data
        $reportData[] = ['Total' => $totals];
    
        return $reportData;
    }
}
