<?php

namespace App\Http\Controllers;

use App\Models\Enum;
use App\Models\Activity;
use App\Models\Region;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Form;
use App\Models\User;
use App\Enums\TypeEnum;
use App\Models\Document;
use App\Models\FormDesign;
use App\Helpers\EnumHelper;
use App\Models\Application;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ApplicationHelper;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationDocument;
use App\Models\ApplicationTimeline;
use App\Enums\ApplicationStatusEnum;
use App\Events\ApplicationStatusEvent;
use App\Events\IncompleteApplicationEvent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.index', ['applications' => ApplicationHelper::getApplications()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Form $form, int $formDesignId = null)
    {
        $activity = Enum::where('type', 'ACTIVITY_TYPE')->get();
        $bank = Bank::all();
        $con = Enum::where('type', 'CONSTITUTION_TYPE')->get();
        $CAT = Enum::where('type', 'SOCIAL_CATEGORY')->get();
        $Diss = Region::where('type_id', 404)->get();
        $formDesigns = $form->formDesigns()->orderBy('order')->get();
        // dd($formDesigns[1]->design);
        $formDesign = (is_null($formDesignId) ? $formDesigns : $formDesigns->where('id', $formDesignId))->firstOrFail();
        $formDesign1 = ($formDesigns->where('id', 1))->firstOrFail();
        $formDesign2 = ($formDesigns->where('id', 2))->firstOrFail();
        $formDesign3 = ($formDesigns->where('id', 3))->firstOrFail();
        $formDesign4 = ($formDesigns->where('id', 4))->firstOrFail();
        $application = new Application();
        $this->setTitle($form->name . '|' . $formDesign->name);
        // $this->addJs('resources/ts/form.ts');
        $formDesign->assets && $this->addAssets($formDesign->assets);
        // dd($Diss);
        return view('application.create', compact('form',
        'formDesign', 'formDesign2', 'activity',
        'con', 'CAT', 'Diss', 'bank', 'application', 'formDesigns'));
    }


    public function get()
    {
        // return response()->json(request('activity_type_id'));
        if (request()->has('activity_type_id')) {
        $activities = Activity::where('type_id', request('activity_type_id'))->get(); // Replace with your actual query to fetch activities
        return response()->json($activities);
        }
        else if (request()->has('district_type_id')){
            // return response()->json(request('district_type_id'));
            $cons = Region::where('type_id', 405 )->where('parent_id', request('district_type_id') )->get(); // Replace with your actual query to fetch activities
            $teh = Region::where('type_id', 406 )->where('parent_id', request('district_type_id') )->get(); // Replace with your actual query to fetch activities
            $block = Region::where('type_id', 407 )->where('parent_id', request('district_type_id') )->get(); // Replace with your actual query to fetch activities
            $responseData = [
                'cons' => $cons,
                'teh' => $teh,
                'block' => $block,
            ];
            
            return response()->json($responseData);
        }else if (request()->has('block_type_id')){
            // return response()->json(request('district_type_id'));
            $panchayat = Region::where('type_id', 408 )->where('parent_id', request('block_type_id') )->get(); // Replace with your actual query to fetch activities
            return response()->json($panchayat);
        }else if (request()->has('bank_id')){
            // return response()->json(request('bank_id'));
            $branch = BankBranch::where('bank_id', request('bank_id'))->get(); // Replace with your actual query to fetch activities
            return response()->json($branch);
        } 
    }


    public function saveData(Request $request)
    {   
        $Documenttype = DocumentType::all();
        // $filePath = public_path('validation.json');
       
        // $jsonContent = File::get($filePath);
        
        // $validationRules = json_decode($jsonContent, true);
        // $validator = Validator::make($request->all(), $validationRules);
        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput(); 
        // }
        // // return response()->json($validator);
        // if ($validator->fails()) {
        //     // Handle validation errors as needed
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }
        // else{
            $jsonData = json_encode([
                'cost' => [
                    'land_cost' => $request->input('land_cost'),
                    'assets_cost' => $request->input('assets_cost'),
                    'land_status' => $request->input('land_status'),
                    // Add other cost-related fields here
                ],
                'owner' => [
                    'pan' => $request->input('pan'),
                    'name' => $request->input('owner_name'),
                    'email' => $request->input('owner_email'),
                    // Add other owner-related fields here
                ],
                'finance' => [
                    'bank_branch_id' => $request->input('bank_branch_id'),
                    'own_contribution' => $request->input('own_contribution'),
                    // Add other finance-related fields here
                ],
                'enterprise' => [
                    'name' => $request->input('enterprise_name'),
                    'address' => $request->input('enterprise_address'),
                    // Add other enterprise-related fields here
                ],
            ]);
            // dd($jsonData);
        // }
        $data = json_decode($jsonData);
        $application = new Application();
        $application->name = $request->input('name');
        $application->form_id = 1;
        $application->data = $data;
        $application->region_id = 14;
        $application->status_id = 302;
        $application->save();
        return view('application.newdocument', compact('application','Documenttype'));

        dd($application);
        // return response()->json(request());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Form $form, FormDesign $formDesign, Application $application, Request $request)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }
        $data = (object) $request->validate($formDesign->validations);
        $application = ApplicationHelper::save($application, $form, $formDesign, $data);

        $nextFormDesign = FormDesign::where('form_id', $form->id)->where('order', '>', $formDesign->order)->orderBy('order')->first();
        if ($nextFormDesign) {
            return redirect()->route('application.edit', [
                'application' => $application,
                'formDesignId' => $nextFormDesign->id,
            ]);
        }
        return redirect()->route('application.documents', [
            'application' => $application,
        ]);
    }

    public function documents(Application $application)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }
        $form = $application->form;
        $formDesigns = $form->formDesigns;
        foreach ($formDesigns as $formDesign) {
            if (!property_exists($application->data, $formDesign['slug'])) {
                return redirect()->route('application.edit', [
                    'application' => $application,
                    'formDesignId' => $formDesign['id'],
                ])->withErrors(['Fill in the application form before uploading documents!'], 'errors');
            }
        }
        $allApplicationDocuments = $application->applicationDocuments;
        $applicationDocuments = $allApplicationDocuments->keyBy('document_type_id');
        return view('application.documents', [
            'formDocumentTypes' => $form->formDocumentTypes()->with('documentType')->get(),
            'application' => $application,
            'applicationDocuments' => $applicationDocuments,
            'form' => $form,
            'formDesigns' => $formDesigns,
            'allApplicationDocuments' => $allApplicationDocuments,
        ]);
    }

    public function submit(Application $application)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }
        // Check at least the project should be 10,000 worth
        if($application->project_cost < 10000) {
            return redirect()->route('application.edit', [
                'application' => $application,
                'formDesignId' => 3,
            ])->withErrors(['<em class="fa-solid fa-warning"></em> The project cost of the application is way too low for consideration!']);
        }

        // Check if the owners aadhaar number is already in the database!
        $ownerAadhaar = $application->getData('owner', 'aadhaar');
        if(Application::whereNotIn('status_id', [
            ApplicationStatusEnum::WITHDRAWN->id(),
            ApplicationStatusEnum::INCOMPLETE->id(),
            ApplicationStatusEnum::LOAN_REJECTED->id(),
            ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT->id(),
            ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id(),
            ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id()
            ])->where(fn($query) => $query->whereJsonContains('data->owner->partner_aadhaar', $ownerAadhaar)->orWhere('data->owner->spouse_aadhaar', $ownerAadhaar)->orWhere('data->owner->aadhaar', $ownerAadhaar))->count() > 0) {
            return redirect()->route('application.edit', [
                'application' => $application,
                'formDesignId' => 2,
            ])->withErrors(['<em class="fa-solid fa-warning"></em> There is another application already submitted with this aadhaar number!']);
        }

        // @todo Check if the parther's aadhaar number is already in use

        if (in_array($application->application_status, [ApplicationStatusEnum::INCOMPLETE, ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT])) {
            $newStatusId = Enum::where([
                'type' => TypeEnum::APPLICATION_STATUS->name,
                'name' => ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->value,
            ])->value('id');

            ApplicationTimeline::create([
                'application_id' => $application->id,
                'remarks' => $application->application_status == ApplicationStatusEnum::INCOMPLETE ? 'Application submitted.' : 'Application resubmitted.',
                'old_status_id' => $application->status_id,
                'new_status_id' => $newStatusId,
            ]);
            $application->status_id = $newStatusId;
            $application->update();
        } else if ($application->application_status == ApplicationStatusEnum::LOAN_REJECTED) {
            $newStatusId = Enum::where([
                'type' => TypeEnum::APPLICATION_STATUS->name,
                'name' => ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->value,
            ])->value('id');

            ApplicationTimeline::create([
                'application_id' => $application->id,
                'remarks' => 'Application updated and re-submitted to the bank.',
                'old_status_id' => $application->status_id,
                'new_status_id' => $newStatusId,
            ]);
            $application->status_id = $newStatusId;
            $application->update();
        }
        return redirect()->route('applications.list');
    }

    public function document(Document $document)
    {
        if ($this->user()->roles()->count() || $document->created_by == $this->user()->id) {
            return response($document->content)->withHeaders([
                'Content-disposition' => 'inline; filename=' . $document->name,
                'Access-Control-Expose-Headers' => 'Content-Disposition',
                'Content-Type' => $document->mime,
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function documentRemove(Application $application, Document $document, Request $request)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }

        $applicationDocument = $application->applicationDocuments()->where('document_id', $document->id)->first();
        if ($applicationDocument) {
            $applicationDocument->delete();
        }
        return redirect()->route('application.documents', ['application' => $application->id])->with('success', 'Document was removed from the application!');
    }

    public function upload(Application $application, DocumentType $documentType, Request $request)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }
        $request->validate([
            'file' => 'required|file',
        ]);
        $file = $request->file('file');
        $fileHash = md5_file($file->getRealPath());
        $document = Document::where([
            'hash' => $fileHash,
            'mime' => $file->getMimeType(),
            'created_by' => $this->user()->id,
        ])->first();

        if (!$document) {
            $document = new Document();
            $document->fill([
                'content' => $file->get(),
                'mime' => $file->getMimeType(),
                'name' => $file->getClientOriginalName(),
                'hash' => $fileHash,
            ]);
            $document->save();
        }

        $applicationDocument = $application->applicationDocuments()->where('document_type_id', $documentType->id)->first();
        if ($applicationDocument) {
            $applicationDocument->document_id = $document->id;
            $applicationDocument->update();
        } else {
            $applicationDocument = new ApplicationDocument();
            $applicationDocument->fill([
                'application_id' => $application->id,
                'document_id' => $document->id,
                'document_type_id' => $documentType->id,
                'document_name' => $documentType->name,
            ]);
            $applicationDocument->save();
        }
        return redirect()->route('application.documents', ['application' => $application->id])->with('success', 'Document uploaded successfully!');
    }

    public function uploadGeneric(Application $application, Request $request)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('dashboard')->with('error', 'Application not found!');
        }
        $request->validate([
            'file' => 'required|file',
            'document_name' => 'required',
        ]);
        $file = $request->file('file');
        $fileHash = md5_file($file->getRealPath());
        $document = Document::where([
            'hash' => $fileHash,
            'mime' => $file->getMimeType(),
            'created_by' => $this->user()->id,
        ])->first();

        if (!$document) {
            $document = new Document();
            $document->fill([
                'content' => $file->get(),
                'mime' => $file->getMimeType(),
                'name' => $file->getClientOriginalName(),
                'hash' => $fileHash,
            ]);
            $document->save();
        }

        $applicationDocument = $application->applicationDocuments()->where('document_name', $request->get('document_name'))->first();
        if ($applicationDocument) {
            $applicationDocument->document_id = $document->id;
            $applicationDocument->document_name = $request->get('document_name');
            $applicationDocument->update();
        } else {
            $applicationDocument = new ApplicationDocument();
            $applicationDocument->fill([
                'application_id' => $application->id,
                'document_id' => $document->id,
                'document_name' => $request->get('document_name'),
            ]);
            $applicationDocument->save();
        }
        return redirect()->route('application.documents', ['application' => $application->id])->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function view(Application $application, string $annexure = 'none', ApplicationDocument $applicationDocument = null)
    {
        $application->load([
            'timelines' => fn($query) => $query->with(['creator', 'creatorRole'])->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
        ]);
        if (!$this->user()->can('view', $application)) {
            return redirect()->route('dashboard')->with('danger', 'Application not available for view!');
        }
        $applicationDocuments = array_map(function ($ad) {
            return [
                'name' => $ad->document_name,
                'documentId' => $ad->document_id,
                'id' => $ad->id,
            ];
        }, $application->applicationDocuments()->get()->all());

        $tabs = array_merge([['name' => 'Application', 'id' => 0]], $applicationDocuments);

        $actions = ApplicationHelper::getApplicationActions($application);
        if ($application->application_status == ApplicationStatusEnum::INCOMPLETE) {
            IncompleteApplicationEvent::dispatch($application);
        }

        $oldPortalApplications = [];
        if($this->user()->isNodalDIC()) {
            $aadhaars = [];
            if($application->getData('owner', 'aadhaar')) {
                $aadhaars[] = base64_encode($application->getData('owner', 'aadhaar'));
                if($application->getData('owner', 'spouse_aadhaar')) {
                    $aadhaars[] = base64_encode($application->getData('owner', 'spouse_aadhaar'));
                }
                if($application->getData('owner', 'partner_aadhaar')) {
                    foreach($application->getData('owner', 'partner_aadhaar') as $partnerAadhaar) {
                        $aadhaars[] = base64_encode($partnerAadhaar);
                    }
                }
            }

            // if(!empty($aadhaars)) {
            //     $oldPortalApplications = DB::connection('old-mysql')
            //         ->table('tb_application_forms')
            //         ->whereIn('a_adhar', $aadhaars)
            //         ->select(['a_id', 'a_name'])
            //         ->get();
            // }
        }

        $form = $application->form;
        $this->addJs('resources/ts/view.ts');
        return view('application.view', [
            'application' => $application,
            'form' => $form,
            'formDesigns' => $form->formDesigns,
            'tabs' => $tabs,
            'oldPortalApplications' => $oldPortalApplications,
            'applicationDocument' => $applicationDocument,
            'file' => $applicationDocument ? $applicationDocument->name : null,
            'actions' => $actions,
            'annexure' => strtolower($annexure) == 'none' ? null : strtolower($annexure),
        ]);
    }

    public function annexure(Application $application, $type = 'A', $download = false)
    {
        $pdf = PDF::loadView('annexure.' . strtolower($type), ['application' => $application], [], 'UTF-8');
        $pdf->setPaper('A4');
        return call_user_func_array([$pdf, $download ? 'download' : 'stream'], ["Annexure-{$type}-{$application->id}.pdf"]);
    }

    public function dp(Application $application)
    {
        $dp = $application->documents()->where('document_type_id', 5)->first();
        if ($dp) {
            return response($dp->content)->withHeaders([
                'Content-disposition' => 'inline; filename=' . $dp->name,
                'Access-Control-Expose-Headers' => 'Content-Disposition',
                'Content-Type' => $dp->mime,
            ]);
        } else {
            return response(file_get_contents(app_path() . '/../public/images/bg-circle.jpeg'))->withHeaders([
                'Content-disposition' => 'inline; filename=default.jpg',
                'Access-Control-Expose-Headers' => 'Content-Disposition',
                'Content-Type' => 'image/jpeg',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application, int $formDesignId = null)
    {
        if (!$this->user()->can('update', $application)) {
            return redirect()->route('applications.list')->with('danger', 'Application not available for edit!');
        }
        $form = $application->form;
        $formDesigns = $form->formDesigns()->orderBy('order')->get();
        $formDesign = (is_null($formDesignId) ? $formDesigns : $formDesigns->where('id', $formDesignId))->firstOrFail();
        $this->setTitle($form->name . '|' . $formDesign->name);

        $previouseormDesigns = $formDesigns->where('order', '<', $formDesign->order)->toArray();
        foreach ($previouseormDesigns as $previousFormDesign) {
            if (!property_exists($application->data, $previousFormDesign['slug'])) {
                return redirect()->route('application.edit', [
                    'application' => $application,
                    'formDesignId' => $previousFormDesign['id'],
                ])->with('danger', 'You need to fill in this information first!');
            }
        }

        // $this->addJs('resources/ts/form.ts');
        $this->addAssets($formDesign->assets);
        return view('application.create', compact('form', 'formDesign', 'application', 'formDesigns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        if ($application->status_id < ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id()) {
            if (!$this->user()->can('update', $application)) {
                return redirect()->route('dashboard')->with('error', 'Application not found!');
            }
        }
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $validation = $request->validate([
            'applicationData' => 'nullable',
            'applicationDocument.*' => 'nullable|file',
            'status' => 'required',
            'comment' => 'required',
        ]);

        if (isset($validation['applicationData'])) {
            foreach ($validation['applicationData'] as $key => $newData) {
                $data = $application->data;
                $existingData = property_exists($application->data, $key) ? (array) $application->data->$key : [];
                $data->$key = array_merge($existingData, $newData);
                $application->update(['data' => $data]);
            }
        }

        if (isset($validation['applicationDocument'])) {
            foreach ($validation['applicationDocument'] as $key => $file) {
                $fileHash = md5_file($file->getRealPath());
                $document = Document::where([
                    'hash' => $fileHash,
                    'mime' => $file->getMimeType(),
                    'created_by' => $this->user()->id,
                ])->first();

                if (!$document) {
                    $document = new Document();
                    $document->fill([
                        'content' => $file->get(),
                        'mime' => $file->getMimeType(),
                        'name' => $file->getClientOriginalName(),
                        'hash' => $fileHash,
                    ]);
                    $document->save();
                }

                $docName = ucwords(str_replace('_', ' ', $key));
                $applicationDocument = $application->applicationDocuments()->where('document_name', $docName)->first();
                if ($applicationDocument) {
                    $applicationDocument->document_id = $document->id;
                    $applicationDocument->document_name = $docName;
                    $applicationDocument->update();
                } else {
                    $applicationDocument = new ApplicationDocument();
                    $applicationDocument->fill([
                        'application_id' => $application->id,
                        'document_id' => $document->id,
                        'document_name' => $docName,
                    ]);
                    $applicationDocument->save();
                }
            }
        }

        ApplicationTimeline::create([
            'application_id' => $application->id,
            'remarks' => $validation['comment'],
            'old_status_id' => $application->status_id,
            'new_status_id' => $validation['status'],
        ]);
        $application->status_id = $validation['status'];
        $application->save();

        ApplicationStatusEvent::dispatch($application);

        return back()->with('success', 'Thank you! Application status changed');
    }

    public function applicationDetails(Application $application, $download = 1)
    {
        $pdf = PDF::loadView('pdf.application', ['application' => $application], [], 'UTF-8');
        $pdf->setPaper('A4');
        return call_user_func_array([$pdf, $download ? 'download' : 'stream'], ["application-details-{$application->id}.pdf"]);
    }

    public function preProjectReport(Application $application, $download = 1)
    {
        $pdf = PDF::loadView('pdf.ppr', ['application' => $application], [], 'UTF-8');
        $pdf->setPaper('A4');
        return call_user_func_array([$pdf, $download ? 'download' : 'stream'], ["ppr-mmsy-{$application->id}.pdf"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Application $application)
    {
        if ($this->user()->id == $application->created_by && $application->status_id < EnumHelper::toId(ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->value)) {

            $newStatusId = ApplicationStatusEnum::WITHDRAWN->id();
            ApplicationTimeline::create([
                'application_id' => $application->id,
                'remarks' => 'Application has been withdrawn by the applicant.',
                'old_status_id' => $application->status_id,
                'new_status_id' => $newStatusId,
            ]);

            $application->status_id = $newStatusId;
            $application->update();

            return back()->with('success', 'You\'ve withdrawn the application.');
        }
        return redirect()->route('dashboard')->with('error', 'Application not found!');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $validation = $request->validate([
            'status' => 'required',
            'comment' => 'required',
            'applications' => 'required',
        ]);

        foreach ($validation['applications'] as $id) {
            $app = Application::find($id);

            if ($this->user()->can('update', $app)) {
                ApplicationTimeline::create([
                    'application_id' => $app->id,
                    'remarks' => $validation['comment'],
                    'old_status_id' => $app->status_id,
                    'new_status_id' => $validation['status'],
                ]);

                $app->status_id = $validation['status'];
                $app->save();

                ApplicationStatusEvent::dispatch($app);
            }
        }

        return back()->with('success', 'Applications have been updated.');
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required_without:mobile|email',
            'mobile' => 'required_without:email|numeric|min:1000000000|max:9999999999',
        ]);
        $user = $this->user();
        $user->name = $validated['name'];
        if (!$user->email) {
            if (User::where('email', $validated['email'])->count() == 0) {
                $user->email = $validated['email'];
            } else {
                return back()->with('danger', 'There is another account with this email id.');
            }
        }
        if (!$user->mobile) {
            if (User::where('mobile', $validated['mobile'])->count() == 0) {
                $user->mobile = $validated['mobile'];
            } else {
                return back()->with('danger', 'There is another account with this mobile number.');
            }
        }
        $user->save();

        return back()->with('success', 'Profile has been updated.');
    }

    public function saveCredentials(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $this->user();
        $user->password = $validated['password'];
        $user->save();

        return back()->with('success', 'Password has been updated.');
    }
}
