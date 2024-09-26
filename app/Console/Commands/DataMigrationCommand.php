<?php

namespace App\Console\Commands;

use App\Enums\ActivityTypeEnum;
use App\Enums\ApplicationStatusEnum;
use App\Enums\ConstitutionTypeEnum;
use App\Enums\RegionTypeEnum;
use App\Enums\RoleEnum;
use App\Enums\SocialCategoryEnum;
use App\Models\Activity;
use App\Models\Application;
use App\Models\ApplicationTimeline;
use App\Models\Bank;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Models\BankBranch;
use App\Models\Meeting;
use App\Models\MeetingApplication;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DataMigrationCommand extends Command
{
    private $dryRun = false;

    private $activities;
    private $regions;
    private $users;
    private $oldBlocks;

    private $activityMappings = [
        'Travel agencies and tour operators services' => 'Travel agencies and tour operator services',
        'Trade / Shops.' => 'Trade/Shops',
        ' Entertainment  services including theatres, live bands & other cultural services.' => 'Entertainment services including theatres, live bands & other cultural services',
        'Smal goods carrier, self driven' => 'Small Goods Carrier self driven costing upto Rs.10 lakhs (ex-showroom price) including mechanized farm equipments, combines and harvesters used for farming (excluding tractors)',
        '“Servicing  Industry 5’ Undertakings  engaged  in maintenance,  repair,  testing  or servicing of all types of vehicles including Autos & machinery of any description including  Electronics/ Electrical equipment/ instruments i.e. measuring/ control instru' => '“Servicing Industry” Undertakings engaged in maintenance, repair testing or servicing of all types of vehicles including Autos & machinery of any description including Electronics/Electrical equipment/instrument i.e. measuring/control instruments, television, Mobiles transformers, motor, watches etc',
        'Equipment Rental and Leasing' => 'Equipment Rental & Leasing',
        'Recreational. cultural and sporting services (other than audiovisual scrvices)' => 'Recreational, cultural and sporting services (other than audiovisual services)',
        'lnternet browsing/setting up of cyber cafes' => 'Internet browsing/setting up of cyber cafes',
        'Health and fltness facilities' => 'Health and fitness facilities',
        'Other manufacturing' => 'Other manufacturing n.e.c.',
        'Manufacture of food products' => 'Manufacturing of food products',
        'Manufacture of computers and peripheral equipment' => 'Manufacturing of computers and peripheral equipment',
        'Manufacture of other electrical equipment' => 'Manufacturing of other electrical equipment',
        'Commercial training/ skill development or coaching services' => 'Commercial training/skill development or coaching services',
        'Warehousing and Transportation of Agricultural produce' => 'Warehousing and Transportation of Agricultural produce(composite unit)',
        'Digltal Photo labs/Photo or Video Studio wilh processing lab facility.' => 'Digital Photo labs/Photo or Video Studio with processing lab facility',
        'Manufacture of other fabricated metal products; metalworking service activities' => 'Manufacture of other fabricated metal products',
        'Casting of metals' => 'Metal work service activities',
        'E-rickshaw, solar powered three wheelers' => 'E-rickshaw, solar powered three wheelers, which are only self driven',
        'Manufacture of other food products' => 'Manufacturing of food products',
        'Printing press- offset & letter press' => 'Printing press-offset & letter press',
        'Manufacture of wood and of products of wood and cork, except furniture; manufacture of articles of straw and plaiting materials' => 'Manufacture of products of wood, cork, straw and plaiting materials',
        'Manufacture of bodies (coachwork) for motor vehicles; manufacture of trailers and semi-trailers' => 'Manufacture of bodies (coachwork) for motor vehicles',
        'Printing and service activities related to printing' => 'Printing publishing',
        'Documentary fi lms on themes like family planning, social forestry, energy conservation and commercial advertising' => 'Documentary films on themes like family planning, social forestry, energy conservation and commercial advertising',
        'Manufacture of wearing apparel' => 'Manufacture of other textiles',
        'Manufacture of electrical equipment' => 'Manufacturing of other electrical equipment',
        'Community kitchens for supplying food lo hospitals, Old age homes, Orphanages , Housing and industries.' => 'Community kitchens for supplying food to hospitals, Old age homes, Orphanages, Housing and industries',
        'Manufacture of computer, electronic and optical products' => 'Manufacturing of computers and peripheral equipment',
        'Manufacture of basic precious and other non-ferrous metals' => 'Manufacture of basic metals',
        'Blue printing and enlargement of drawing/ designs facilities' => 'Blue Printing and enlargement of drawing/designs facilities',
        'Repair and installation of machinery and equipment' => 'Installation of industrial machinery and equipment',
        'Coloured or black and white studios eqiiipped with processing laboratory' => 'Coloured or black and white studios equipped with processing laboratory',
        'Traditional Handicrafi.' => 'Traditional Handicraft',
        'Teleprinter/ fax services' => 'Teleprinter/fax services',
        'Manufacture of general purpose machinery' => 'Manufacture of machinery and equipment n.e.c.',
        'Waste disFosal services' => 'Waste disposal services',
        'Laboratories engaged in Testing of Raw Materials/ Finished Products' => 'Laboratories engaged in Testing of Raw Materials/Finished Products',
        'Manufacture of textiles' => 'Manufacture of other textiles',
        'Services  by  holder of intellectual property right providing intellectual property services other than copyright' => 'Services by holder of intellectual property right providing intellectual property services other than copyright',
        'Survey anal exploration o1' => 'Survey and exploration of mineral',
        'Survey and map malting service' => 'Survey and map making service',
        'Manufacture of other transport equipment' => 'Manufacture of transport equipment n.e.c.',
        'Manufacture of measuring, testing, navigating and control equipment; watches and clocks' => 'Manufacture of measuring, testing, navigating and control equipment',
        'Manufacture of rubber products' => 'Manufacture of rubber and plastics products',
        'Silage Unit' => 'Establishment of Silage units',
        "Cold Storage Facilities for Milk and Milk\r\nProduct" => 'Establishment of cold storage facilities for milk and milk products',
        'Agricultural Implements & Equipments' => 'Manufacturing of Agricultural Implements & Equipments',
        'Retail Outlets for Agriculture' => 'Construction of Retail Outlets for Agriculture (composite unit)',
        'EV Charging Station' => 'EV Charging Stations',
        'Raising of Vegetable Nursery' => 'Raising of Vegetable Nursery(composite units)',
        'Processing and preserving of fish, crustaceans and molluscs' => 'Processing and preserving of meat and fish',
        'Processing and preserving of meat' => 'Processing and preserving of meat and fish',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mmsy:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Old MMSY applications to the new database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Do not run on Server - Completed
        // $this->createUsers();


        // $this->createApplications();

        // $this->createMeetings();

        $this->createAnnexureARecords();

        return 0;
    }

    function info($string, $verbosity = null) {
        parent::info("\n$string", $verbosity);
    }

    function tryParseDateTime(string $str, bool $onlyDate = false):string
    {
        return Carbon::createFromFormat(substr($str, 2, 1) == '-' ? 'd-m-Y h:i A' : 'Y-m-d H:i:s', $str)->format($onlyDate ? 'Y-m-d' : 'Y-m-d H:i:s');
    }

    private function createAnnexureARecords() {
        $this->info('Processing Annexure-A records ...');
        
        // Fetch the records from the old database
        $oldAnnexureARecords = DB::connection('old-mysql')
            ->table('tb_gm_annexure_a')
            ->get();
        
        // Initialize the pending loan disbursement counter
        $pendingLoanDisbursementCount = 0;
        $LoanRejectionCount = 0;
        $Rejected60cases = 0;
        $Pending60casesAtDIC = 0;
        $Pending60casesAtNodal = 0;
        $Release60cases = 0;
        $R40cases = 0;
    
        // Use a progress bar for better visualization
        $this->withProgressBar($oldAnnexureARecords, function($oldAnnexureA) use (&$pendingLoanDisbursementCount,&$LoanRejectionCount,&$Rejected60cases,&$Pending60casesAtDIC, &$Pending60casesAtNodal, &$Release60cases, &$R40cases) {
            $application = Application::where('data->old_data->a_id', $oldAnnexureA->gaa_app_id)->first();
    
            if ($application) {
                $this->info("Processing application {$oldAnnexureA->gaa_app_id} ...");
                
                // Add initial timeline entry
                $this->addApplicationTimeline(
                    $application,
                    ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE,
                    ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                    $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                    'Approved in DLC',
                    RoleEnum::GM_DIC,
                    $application->gm_id
                );
    
                // Check if the loan is approved (gaa_status == 2)
                if ($oldAnnexureA->gaa_status == 2) {
                    $applicationStatus = ApplicationStatusEnum::UNKNOWN;
                    
                    $managerIds = $application->bank_branch_manager_ids ?? [];
                    $managerId = !empty($managerIds) ? $managerIds[0] : null;
    
                    // Add timeline entry for loan approval
                    $this->addApplicationTimeline(
                        $application,
                        ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                        ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST,
                        $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                        'Loan Approved',
                        RoleEnum::BANK_MANAGER,
                        $managerId
                    );
    
                    // Update application data with loan information
                    $applicationData = $application->data;
                    $applicationData->loan = [
                        'term_loan' => intval($oldAnnexureA->gaa_term_loan_1) ? intval($oldAnnexureA->gaa_term_loan_1) : intval($oldAnnexureA->gaa_term),
                        'sanction_date' => $this->fixDate($oldAnnexureA->gaa_date_sanction, $this->tryParseDateTime($oldAnnexureA->gaa_approved_by), $oldAnnexureA->gaa_date_installment),
                        'account_number' => $oldAnnexureA->gaa_amount_subcidy,
                        'working_capital' => intval($oldAnnexureA->gaa_working_capital) ? intval($oldAnnexureA->gaa_working_capital) : intval($oldAnnexureA->gaa_working_1),
                        'disbursed_amount' => intval($oldAnnexureA->gaa_amount_installment),
                        'own_contribution' => intval($oldAnnexureA->gaa_own_contribution) ? intval($oldAnnexureA->gaa_own_contribution) : intval($oldAnnexureA->gaa_own),
                        'disbursement_date' => $this->fixDate($oldAnnexureA->gaa_date_installment, $this->tryParseDateTime($oldAnnexureA->gaa_approved_by)),
                    ];
                    
    
                    #Pending at nodal bank for 60%
                    if ($oldAnnexureA->gaa_nodal_submit_date != null && $oldAnnexureA->gaa_subsidy_edit_remarks == '' && $oldAnnexureA->gaa_nodal_status == 0){
                        $applicationData->old_annexure_a = $oldAnnexureA;
                        // die($applicationData);
                        $applicationStatus = ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE;
                        $this->addApplicationTimeline(
                            $application,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE,
                            $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                            '',
                            RoleEnum::GM_DIC,
                            $application->gm_id
                        );
                        
                        $Pending60casesAtNodal++;
                         // Update subsidy data
                        $applicationData->subsidy = [
                            'amount' => $oldAnnexureA->gaa_amount_of_subsidy_involved_25,
                            'amount60' => $oldAnnexureA->gaa_amount_of_subsidy_involved_60,
                            'percentage' => intval($oldAnnexureA->gaa_eligile_subsidy),
                        ];
                        
                    }

                    # pending for 60% at DIC
                    if ($oldAnnexureA->gaa_nodal_submit_date == null && $oldAnnexureA->gaa_subsidy_edit_remarks == '' && $oldAnnexureA->gaa_nodal_status == 0 ){
                        $applicationData->old_annexure_a = $oldAnnexureA;
                        // die($applicationData);
                        $applicationStatus = ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST;
                        $this->addApplicationTimeline(
                            $application,
                            ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST,
                            $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                            'Loan Approved',
                            RoleEnum::BANK_MANAGER,
                            $managerId
                        );
                        
                        $Pending60casesAtDIC++;
                        
                    }
                    #Rejected cases by nodal bank for 60 %
                    if ($oldAnnexureA->gaa_nodal_status == 0 && $oldAnnexureA->gaa_subsidy_edit_remarks != '' ){
                        $applicationData->old_annexure_a = $oldAnnexureA;
                        // die($applicationData);
                        $applicationStatus = ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST;
                        $this->addApplicationTimeline(
                            $application,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST,
                            $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                            trim($oldAnnexureA->gaa_subsidy_edit_remarks) ? trim($oldAnnexureA->gaa_subsidy_edit_remarks) : '60% Subsidy Request Rejected BY Nodal Bank',
                            RoleEnum::NODAL_BANK,
                            $application->nodal_bank_user_ids[0]
                        );
                        
                        $Rejected60cases++;
                        
                    }

                    // Handle 60% subsidy release
                    if($oldAnnexureA->gaa_nodal_status == 1 && $oldAnnexureA->gaa_status == 2 && $oldAnnexureA->gaa_amount_of_eligible != '' && $oldAnnexureA->gaa_nodal_submit_date != null && $oldAnnexureA->gaa_date_of_dis_subsidy != null) {
                        // $applicationData = $application->data;
                        $applicationData->subsidy = [
                            'amount' => $oldAnnexureA->gaa_amount_of_subsidy_involved_25,
                            'amount60' => $oldAnnexureA->gaa_amount_of_subsidy_involved_60,
                            'percentage' => intval($oldAnnexureA->gaa_eligile_subsidy),
                        ];
                        // If 'subsidy' is not set or is an object, convert it to an array
                        if (!is_array($applicationData->subsidy)) {
                            $applicationData->subsidy = (array) ($applicationData->subsidy ?? []); // Ensure it's an array
                        }
                        $applicationData->subsidy['date60'] = $this->fixDate($oldAnnexureA->gaa_date_of_dis_subsidy, $this->tryParseDateTime($oldAnnexureA->gaa_approved_by));
                        $applicationData->subsidy['utrno60'] = 'NA(Old Release)';
                        $applicationStatus = ApplicationStatusEnum::SUBSIDY_60_RELEASED;
    
                        $this->addApplicationTimeline(
                            $application,
                            ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE,
                            ApplicationStatusEnum::SUBSIDY_60_RELEASED,
                            $this->fixDate($oldAnnexureA->gaa_date_of_dis_subsidy, $this->tryParseDateTime($oldAnnexureA->gaa_approved_by)) ?? $this->tryParseDateTime($oldAnnexureA->gaa_approved_by),
                            trim($oldAnnexureA->gaa_subsidy_edit_remarks) ? trim($oldAnnexureA->gaa_subsidy_edit_remarks) : '60% Subsidy Released',
                            RoleEnum::NODAL_BANK,
                            $application->nodal_bank_user_ids[0]
                        );
                        $Release60cases++;
                        // Handle 40% subsidy release
                        $oldFourtysubsidyEntry = DB::connection('old-mysql')
                            ->table('tb_fourtysubsidy')
                            ->where('fs_app_id', $oldAnnexureA->gaa_app_id)
                            ->first();
    
                        if ($oldFourtysubsidyEntry) {
                            $R40cases++;
                            $this->addApplicationTimeline(
                                $application,
                                ApplicationStatusEnum::SUBSIDY_60_RELEASED,
                                ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE,
                                $this->fixDate($oldFourtysubsidyEntry->gm_date, $oldFourtysubsidyEntry->fs_created) ?? $oldFourtysubsidyEntry->fs_created,
                                '40% Subsidy Requested',
                                RoleEnum::GM_DIC,
                                $application->gm_id
                            );
    
                            $applicationData->old_40_subsidy = $oldFourtysubsidyEntry;
                            $applicationStatus = ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE;
    
                            if($oldFourtysubsidyEntry->nodal_status == 1 && $oldFourtysubsidyEntry->gm_status == 1) {
                                $this->addApplicationTimeline(
                                    $application,
                                    ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE,
                                    ApplicationStatusEnum::SUBSIDY_40_RELEASED,
                                    $this->fixDate($oldFourtysubsidyEntry->gm_date, $oldFourtysubsidyEntry->fs_created) ?? $oldFourtysubsidyEntry->fs_created,
                                    '40% Subsidy Released',
                                    RoleEnum::NODAL_BANK,
                                    $application->nodal_bank_user_ids[0]
                                );
                                $applicationStatus = ApplicationStatusEnum::SUBSIDY_40_RELEASED;
                            }
                        }
                    }
    
                    // Update the application data and status
                    $application->update([
                        'data' => $applicationData,
                        'status_id' => $applicationStatus->id(),
                    ]);
    
                } 
                // Handle rejected loans
                else if(($oldAnnexureA->gaa_status == 1 || $oldAnnexureA->gaa_status == 3) && $oldAnnexureA->gaa_remarks != '') {
                    $this->info("Application {$oldAnnexureA->gaa_app_id} is loan rejected ...");
                    $bankBranchManagerIds = $application->bank_branch_manager_ids ?? [];
                    $managerId = !empty($bankBranchManagerIds) ? $bankBranchManagerIds[0] : null;
                    
                    $this->addApplicationTimeline(
                        $application,
                        ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                        ApplicationStatusEnum::LOAN_REJECTED,
                        $this->tryParseDateTime($oldAnnexureA->gaa_created),
                        $oldAnnexureA->gaa_remarks ? $oldAnnexureA->gaa_remarks : 'Loan Rejected',
                        RoleEnum::BANK_MANAGER,
                        $managerId
                    );
                    $LoanRejectionCount++;
                    // Update the application status to "Loan Rejected"
                    $application->update([
                        'status_id' => ApplicationStatusEnum::LOAN_REJECTED->id(),
                    ]);
    
                } 
                // Handle pending loan disbursement
                else if($oldAnnexureA->gaa_status == 1 && (empty($oldAnnexureA->gaa_remarks) || $oldAnnexureA->gaa_remarks == null)) {
                    $bankBranchManagerIds = $application->bank_branch_manager_ids ?? [];
                    $managerId = !empty($bankBranchManagerIds) ? $bankBranchManagerIds[0] : null;
    
                    // Increment the pending loan disbursement count
                    $pendingLoanDisbursementCount++;
    
                    $this->info("Application {$oldAnnexureA->gaa_app_id} is pending for loan disbursement ...");
    
                    $this->addApplicationTimeline(
                        $application,
                        ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                        ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
                        $this->tryParseDateTime($oldAnnexureA->gaa_created),
                        $oldAnnexureA->gaa_remarks ? $oldAnnexureA->gaa_remarks : '',
                        RoleEnum::BANK_MANAGER,
                        $managerId
                    );
    
                    // Update the application status to "Pending for Loan Disbursement"
                    $application->update([
                        'status_id' => ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id(),
                    ]);
                }
            } else {
                $this->info("Application {$oldAnnexureA->gaa_app_id} not found!");
            }
        });
    
        // Output the total count of applications pending for loan disbursement
        $this->info("Total applications pending for loan disbursement: {$pendingLoanDisbursementCount}");
        $this->info("Total applications pending for loan Rejection: {$LoanRejectionCount}");
        $this->info("Total applications Rejected for DIC 60% inspection: {$Rejected60cases}");
        $this->info("Total applications Pending at DIC for 60% Request: {$Pending60casesAtDIC}");
        $this->info("Total applications Pending at Nodal for 60% Release: {$Pending60casesAtNodal}");
        $this->info("Total applications Realeased from Nodal for 60% Subsidy: {$Release60cases}");
        $this->info("Total applications came in 40 %: {$R40cases}");
    }
    

    private function fixDate(?string $str, $referenceDate, $fallbackDate = null) : ?string
    {
        $str = trim($str);
        if(!$str) {
            return null;
        }

        if(strlen($str) == 10 && $str != '0000-00-00') {
            $date = null;
            if(substr($str, 2, 1) == '-') {
                $date = Carbon::createFromFormat('d-m-Y', $str);
            } else if(substr($str, 2, 1) == '/') {
                $date = Carbon::createFromFormat('d/m/Y', $str);
            } else if(substr($str, 2, 1) == '.') {
                $date = Carbon::createFromFormat('d.m.Y', $str);
            } else if(substr($str, 4, 1) == '-') {
                $date = Carbon::createFromFormat('Y-m-d', $str);
            } else {
                $date = Carbon::createFromTimestamp(strtotime($str));
            }
            if($date > now() || $date->format('Y-m-d') < '2020-01-01') {
                return date('Y', strtotime($referenceDate)) . $date->format('-m-d');
            }
            return $date->format('Y-m-d');
        } else if($fallbackDate) {
            return $this->fixDate($fallbackDate, $referenceDate);
        }
        return null;
    }

    private function createMeetings()
    {

        $this->info('Processing meetings ...');
        $oldMeetings = DB::connection('old-mysql')
            ->table('tb_gm_meeting_schedules')
            ->where('gms_status', 1)
            ->where('gms_district_id', '>', 0)
            ->get();

        $this->withProgressBar($oldMeetings, function ($oldMeeting) {
            $meeting = Meeting::find($oldMeeting->gms_id);
            $meetingData = [
                'id' => $oldMeeting->gms_id,
                'title' => $oldMeeting->gms_discription,
                'district_id' => $oldMeeting->gms_district_id + 2,
                'datetime' => "{$oldMeeting->gms_date} {$oldMeeting->gms_time}",
                'was_conducted' => now()->format('Y-m-d H:i:s') > "{$oldMeeting->gms_date} {$oldMeeting->gms_time}",
                'chair_person' => $oldMeeting->gms_place,
                'created_at' => $oldMeeting->gms_created,
                'created_by' => 0,
            ];
            if ($meeting) {
                $meeting->update($meetingData);
            } else {
                $this->dryRun || DB::table('meetings')->insert($meetingData);
                $meeting = $this->dryRun ? new Meeting($meetingData) : Meeting::find($oldMeeting->gms_id);
            }

            $oldMeetingApplications = DB::connection('old-mysql')
                ->table('tb_gm_application_forms')
                ->where('gma_meeting_id', $oldMeeting->gms_id)
                ->get();
            $this->withProgressBar($oldMeetingApplications, function ($oldMeetingApplication) use ($meeting) {
                $application = Application::where('data->old_data->a_id', $oldMeetingApplication->gma_app_id)->first();
                if ($application) {
                    $meetingApplication = MeetingApplication::firstWhere([
                        'meeting_id' => $meeting->id,
                        'application_id' => $application->id,
                    ]);
                    $status = ($oldMeetingApplication->gma_gm_status == 1 && $oldMeetingApplication->gma_status != 3) ? 'APPROVED' : ($oldMeetingApplication->gma_status == 3 ? 'REJECTED' : 'PENDING');
                    if (!$meetingApplication) {
                        $this->dryRun || DB::table('meeting_applications')->insert([
                            'meeting_id' => $meeting->id,
                            'application_id' => $application->id,
                            'remarks' => $oldMeetingApplication->gma_remarks ? substr(trim($oldMeetingApplication->gma_remarks), 0, 255) : null,
                            'status' => $status,
                            'created_at' => $oldMeetingApplication->gma_created,
                            'created_by' => 0,
                            'updated_at' => $oldMeetingApplication->gma_approved_date,
                        ]);
                    }
                    if ($status != 'PENDING') {
                        $this->dryRun || $application->update([
                            'status_id' => ($status == 'APPROVED' ? ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT : ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE)->id(),
                        ]);
                    }
                }
            });
        });
    }

    private function createApplications()
    {

        $applications = DB::connection('old-mysql')
            ->table('tb_application_forms')
            ->where('a_id', '>', 8)
            ->get();

        $this->info('Processing applications ...');
        $this->withProgressBar($applications, function ($oldApplication, ProgressBar $progress) {
            if ((!trim($oldApplication->a_unit_address) && !trim($oldApplication->a_pin))) {
                if ($oldApplication->a_status == 1) {
                    return;
                }
            }

            $oldAnnexureA = DB::connection('old-mysql')
                ->table('tb_gm_annexure_a')
                ->where('gaa_app_id', $oldApplication->a_id)
                ->first();
            $application = Application::where('data->old_data->a_id', $oldApplication->a_id)->first();
            $applicationData = null;
            try {
                $applicationData = $this->getApplicationData($oldApplication, $oldAnnexureA);
            } catch (\Exception$ex) {
                $this->info($ex->getMessage());
                return;
            }
            if ($application) {
                $this->dryRun || DB::table('applications')
                    ->where('id', $application->id)
                    ->update($applicationData);
            } else {
                $this->dryRun || DB::table('applications')
                    ->insert($applicationData);
                $application = $this->dryRun ? new Application($applicationData) : Application::where('data->old_data->a_id', $oldApplication->a_id)->first();
            }

            if ($oldApplication->a_status > 1) {
                $this->processCseApplications($application, $oldApplication, $oldAnnexureA);
            }
        });
        $this->info("\nProcessed applications ...");
    }

    private function processCseApplications(Application $application, $oldApplication)
    {
        $cseApplicationEntries = DB::connection('old-mysql')
            ->table('tb_cse_application_status')
            ->where('ca_app_id', $oldApplication->a_id)
            ->orderBy('ca_created')
            ->get();
        $submitted = false;
        $reverted = false;
        foreach ($cseApplicationEntries as $cseApplicationEntry) {

            $cseApplicationEntry->ca_remarks = substr(trim($cseApplicationEntry->ca_remarks), 0, 255);
            $cseApplicationEntry->ca_bank_remarks = substr(trim($cseApplicationEntry->ca_bank_remarks), 0, 255);

            if ($cseApplicationEntry->ca_status == 1) {
                if (!$submitted && !$reverted) {
                    $randomHours = mt_rand(1, 24);
                    $this->dryRun || $this->addApplicationTimeline($application, ApplicationStatusEnum::INCOMPLETE, ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER, date('Y-m-d H:i:s', strtotime("-$randomHours hours", strtotime($oldApplication->a_created))), 'Application submitted.');

                    $this->dryRun || $this->addApplicationTimeline($application, ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER, ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT, $cseApplicationEntry->ca_created, $cseApplicationEntry->ca_remarks);
                    $reverted = true;
                }
            } else {
                if (!$submitted) {
                    $this->dryRun || $this->addApplicationTimeline($application, $reverted ? ApplicationStatusEnum::REVERTED_BACK_TO_APPLICANT : ApplicationStatusEnum::INCOMPLETE, ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER, $oldApplication->a_created, $reverted ? 'Application re-submitted.' : 'Application submitted.');

                    $this->dryRun || $this->addApplicationTimeline($application, ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER, ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS, $cseApplicationEntry->ca_created, $cseApplicationEntry->ca_remarks, RoleEnum::NODAL_DIC, $this->getUserId($cseApplicationEntry->ca_created_by));
                    $submitted = true;

                    if ($cseApplicationEntry->ca_bank_status == 2) {
                        $branchManagers = $application->bank_branch_manager_ids;
                        $this->dryRun || $this->addApplicationTimeline($application, ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS, ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE, is_null($cseApplicationEntry->ca_bank_approved_date) ? date('Y-m-d H:i:s', strtotime("+7 days", strtotime($cseApplicationEntry->ca_created))) : $cseApplicationEntry->ca_bank_approved_date, $cseApplicationEntry->ca_bank_remarks ? $cseApplicationEntry->ca_bank_remarks : 'NA', RoleEnum::BANK_MANAGER, empty($branchManagers) ? 0 : $branchManagers[0]);
                        $application->status_id = ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id();
                    } else {
                        $application->status_id = ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id();
                    }
                    $this->dryRun || $application->update();
                }
            }
        }
    }

    private function getUserId(string $email): int
    {
        if (!$this->users) {
            $this->users = DB::table('users')
                ->select(['id', 'email'])
                ->get();
        }
        $user = $this->users->firstWhere('email', $email);
        return $user ? $user->id : 0;
    }

    private function addApplicationTimeline(Application $application, ApplicationStatusEnum $oldStatus, ApplicationStatusEnum $newStatus, string $datetime, string $remarks = '', ?RoleEnum $creatorRole = null, $userId = 0)
    {
        $timeline = ApplicationTimeline::where([
            'application_id' => $application->id,
            'old_status_id' => $oldStatus->id(),
            'new_status_id' => $newStatus->id(),
        ])->first();
        $remarks = substr($remarks, 0, 255);
        if ($timeline) {
            DB::table('application_timelines')
                ->where('id', $timeline->id)
                ->update([
                    'creator_role_id' => $creatorRole?->value,
                    'remarks' => $remarks,
                    'created_at' => $datetime,
                    'created_by' => $userId ? $userId : 1,
                ]);
        } else {
            DB::table('application_timelines')
                ->insert([
                    'application_id' => $application->id,
                    'old_status_id' => $oldStatus->id(),
                    'new_status_id' => $newStatus->id(),
                    'creator_role_id' => $creatorRole?->value,
                    'remarks' => $remarks,
                    'created_at' => $datetime,
                    'created_by' => $userId ? $userId : 1 ,
                ]);
        }
    }

    private function getApplicationData($oldApplication, $oldAnnexureA = null)
    {
        return [
            'id' => $oldApplication->a_id,
            'name' => $oldApplication->a_name,
            'form_id' => 1,
            'data' => json_encode([
                'enterprise' => $this->getEnterpriseDetails($oldApplication),
                'owner' => $this->getOwnerDetails($oldApplication),
                'cost' => $this->getCostDetails($oldApplication, $oldAnnexureA),
                'finance' => $this->getFinanceDetails($oldApplication, $oldAnnexureA),
                'old_data' => $oldApplication,
                'old_annexure_a' => $oldAnnexureA,
            ]), 'region_id' => $oldApplication->a_unit_district + 2,
            'created_at' => $oldApplication->a_created,
            'created_by' => 0,
            'status_id' => ApplicationStatusEnum::INCOMPLETE->id(),
        ];
    }

    private function getEnterpriseDetails($oldApplication)
    {
        $address = $this->getAddress($oldApplication->a_unit_address, $oldApplication->a_unit_district + 2, $oldApplication->a_unit_block);
        return [
            'name' => $oldApplication->a_name,
            'activity_type_id' => $this->getActivityTypeId($oldApplication->a_type_activity),
            'activity_id' => $this->getActivityId($oldApplication->a_activity_name),
            'activity_details' => $oldApplication->a_type_activity == 'Manufacturing' ? null : $oldApplication->a_product_des,
            'products' => $oldApplication->a_type_activity == 'Manufacturing' ? $oldApplication->a_product_des : null,
            'constitution_type_id' => $this->getConstitutionId($oldApplication->a_organisation),
            'employment' => intval($oldApplication->a_emp_gen),
            'area_type' => $oldApplication->a_unit,
            'pincode' => $oldApplication->a_unit_pin,
            'district_id' => $oldApplication->a_unit_district + 2,
            'constituency_id' => $address[RegionTypeEnum::CONSTITUENCY->id()],
            'tehsil_id' => $address[RegionTypeEnum::TEHSIL->id()],
            'block_id' => $address[RegionTypeEnum::BLOCK_TOWN->id()],
            'panchayat_id' => $address[RegionTypeEnum::PANCHAYAT_WARD->id()],
            'address' => $oldApplication->a_unit_address,
        ];
    }

    private function getOwnerDetails($oldApplication)
    {
        $address = $this->getAddress($oldApplication->a_address, $oldApplication->a_addresss_district_id + 2, $oldApplication->a_block ? $oldApplication->a_block : null);
        return [
            'name' => $oldApplication->a_name,
            'mobile' => $oldApplication->a_mobile_1,
            'email' => $oldApplication->a_email,
            'guardian_prefix' => 'NA',
            'guardian' => $oldApplication->a_relative_name ?? 'NA',
            'pincode' => $oldApplication->a_pin,
            'district_id' => $oldApplication->a_addresss_district_id + 2,
            'constituency_id' => $address[RegionTypeEnum::CONSTITUENCY->id()],
            'tehsil_id' => $address[RegionTypeEnum::TEHSIL->id()],
            'block_id' => $address[RegionTypeEnum::BLOCK_TOWN->id()],
            'panchayat_id' => $address[RegionTypeEnum::PANCHAYAT_WARD->id()],
            'address' => $oldApplication->a_address,
            'birth_date' => $oldApplication->a_dob,
            'aadhaar' => base64_decode($oldApplication->a_adhar),
            'pan' => $oldApplication->a_pan,
            'gender' => $this->getGender($oldApplication->a_gender),
            'is_widow' => $oldApplication->a_special_category == 'Widow',
            'marital_status' => 'NA',
            'spouse_aadhaar' => 'NA',
            'is_specially_abled' => null,
            'social_category_id' => $this->getSocialCategoryId($oldApplication->a_social_category),
            'belongs_to_minority' => $oldApplication->a_social_category == 'Minority' ? 'Yes' : 'No',
        ];
    }

    private function getCostDetails($oldApplication, $oldAnnexureA)
    {
        return [
            'land_status' => ($oldAnnexureA ? $oldAnnexureA->gaa_land : $oldApplication->a_land) > 0 ? 'To be Taken on Lease' : 'Not Required',
            'land_cost' => intval($oldAnnexureA ? $oldAnnexureA->gaa_land : $oldApplication->a_land),
            'building_status' => ($oldAnnexureA ? $oldAnnexureA->gaa_technical : $oldApplication->a_technical) > 0 ? 'To be Taken on Rent' : 'Not Required',
            'building_cost' => intval($oldAnnexureA ? $oldAnnexureA->gaa_technical : $oldApplication->a_technical),
            'building_area' => 'NA',
            'assets_cost' => $oldAnnexureA ? (intval($oldAnnexureA->gaa_other) + intval($oldAnnexureA->gaa_other_fix) + intval($oldAnnexureA->gaa_physical) + intval($oldAnnexureA->gaa_specify)) : (intval($oldApplication->a_other) + intval($oldApplication->a_other_fix) + intval($oldApplication->a_physical) + intval($oldApplication->a_specify)),
            'assets_detail' => 'NA',
            'machinery_cost' => intval($oldAnnexureA ? $oldAnnexureA->gaa_machinery : $oldApplication->a_machinery),
            'machinery_detail' => 'NA',
            'working_capital' => intval($oldAnnexureA ? (is_null($oldAnnexureA->gaa_working_capital) ? $oldAnnexureA->gaa_working : $oldAnnexureA->gaa_working_capital) : $oldApplication->a_working),
        ];
    }

    private function getFinanceDetails($oldApplication, $oldAnnexureA = null)
    {
        $projectCost = ($oldAnnexureA ? intval($oldAnnexureA->gaa_land) : intval($oldApplication->a_land))
             + ($oldAnnexureA ? intval($oldAnnexureA->gaa_technical) : intval($oldApplication->a_technical))
             + ($oldAnnexureA ? (intval($oldAnnexureA->gaa_other) + intval($oldAnnexureA->gaa_other_fix) + intval($oldAnnexureA->gaa_physical) + intval($oldAnnexureA->gaa_specify)) : (intval($oldApplication->a_other) + intval($oldApplication->a_other_fix) + intval($oldApplication->a_physical) + intval($oldApplication->a_specify)))
             + ($oldAnnexureA ? intval($oldAnnexureA->gaa_machinery) : intval($oldApplication->a_machinery))
             + ($oldAnnexureA ? (intval($oldAnnexureA->gaa_working_capital) ? intval($oldAnnexureA->gaa_working_capital) : intval($oldAnnexureA->gaa_working)) : intval($oldApplication->a_working));

        if ($projectCost == 0 && $oldApplication->a_status == 1) {
            throw new \Exception("Skipping incomplete application {$oldApplication->a_id} due to parameters!");
        }

        if (!$projectCost) {
            if (!$oldAnnexureA) {
                throw new \Exception("Skipping incomplete application {$oldApplication->a_id} due to missing Annexure-A.");
            }
            dd($oldApplication, 'Project cost is zero!');
        }

        $ownContribution = $oldAnnexureA ? (is_null($oldAnnexureA->gaa_own_contribution) ? $oldAnnexureA->gaa_own : $oldAnnexureA->gaa_own_contribution) : $oldApplication->a_own;

        return [
            'own_contribution' => round((intval($ownContribution) / $projectCost) * 100, 4),
            'bank_branch_id' => $this->getBankBranchId($oldApplication->a_first_ifsc, $oldApplication->a_branch_id),
        ];
    }

    private function getBankBranchId(string $ifsc, int $oldBranchId): int
    {
        if (!trim($ifsc)) {
            if ($oldBranchId > 0) {
                $oldBranch = DB::connection('old-mysql')
                    ->table('tb_branch_details')
                    ->where('bd_id', $oldBranchId)
                    ->first();
                if ($oldBranch) {
                    $ifsc = $oldBranch->bd_ifsc_code;
                } else {
                    dd('Unable to map branch!', $ifsc, $oldBranchId);
                }
            } else {
                dd('Unable to map branch!', $ifsc, $oldBranchId);
            }
        }
        $ifscMappings = [
            'HPSCB0000567' => 'HPSC0000567',
            '?SBIN0004589' => 'SBIN0004589',
            'IDIB000U030' => 'IDIB000U527',
            'HPGB0009903' => 'PUNB0HPGB04',
            'CORP0001473' => 'UBIN0914738',
            'IDIB000S184' => 'IDIB000S744',
        ];
        if (isset($ifscMappings[$ifsc])) {
            $ifsc = $ifscMappings[$ifsc];
        }
        $bankBranch = BankBranch::withTrashed()->firstWhere('ifsc', $ifsc);
        if (!$bankBranch) {
            dd($ifsc, 'Bank branch not found!', $oldBranchId);
        }
        return $bankBranch->id;
    }

    private function getActivityId(string $oldActivityId)
{
    // Load activities once if not already loaded
    if (!$this->activities) {
        $this->activities = DB::connection('old-mysql')
            ->table('tb_activities')
            ->where('a_status', 1)
            ->get();
    }

    // Find old activity by id
    $oldActivity = $this->activities->firstWhere('a_id', $oldActivityId == 30 ? 169 : $oldActivityId);

    if (!$oldActivity) {
        dd('Old activity not found in database!', $oldActivityId);
    }

    // Normalize the old activity name
    $normalizedOldName = $this->normalizeString($oldActivity->a_name);

    // Check for direct match using normalized names
    $activity = Activity::where(DB::raw('LOWER(REPLACE(name, ".", ""))'), $normalizedOldName)
        ->orWhere(DB::raw('LOWER(REPLACE(name, ".", ""))'), $this->normalizeString($oldActivity->a_name))
        ->first();

    // If no exact match is found, try fuzzy matching
    if (!$activity) {
        $newActivities = Activity::all();  // Load all new activities for fuzzy matching

        $bestMatchActivity = null;
        $bestMatchScore = 0;

        foreach ($newActivities as $newActivity) {
            // Normalize new activity name
            $normalizedNewName = $this->normalizeString($newActivity->name);

            // Perform word-by-word matching
            $oldActivityWords = explode(' ', $normalizedOldName);
            $newActivityWords = explode(' ', $normalizedNewName);

            // Get the number of matching words
            $matchingWords = array_intersect($oldActivityWords, $newActivityWords);
            $matchScore = count($matchingWords);

            // If word matching gives a high score, choose this activity
            if ($matchScore > $bestMatchScore) {
                $bestMatchScore = $matchScore;
                $bestMatchActivity = $newActivity;
            }

            // If we have a perfect match on words, break early
            if ($matchScore === count($oldActivityWords)) {
                $activity = $newActivity;
                break;
            }

            // Fallback: Use Levenshtein distance or similar_text for more flexible matching
            if (!$activity && $this->isSimilar($normalizedOldName, $normalizedNewName)) {
                $bestMatchActivity = $newActivity;
                $bestMatchScore = PHP_INT_MAX; // Assume fuzzy match is the last resort
            }
        }

        if (!$activity && $bestMatchActivity) {
            $activity = $bestMatchActivity;
        }

        if (!$activity) {
            // Log or store activities that are not found for manual review
            dd("\n'{$oldActivity->a_name}' activity not found even after fuzzy matching!");
        }
    }

    return $activity->id;
}


    // Normalize the string by removing noise words, special characters, etc.
    private function normalizeString($string)
    {
        // Convert to lowercase
        $string = strtolower($string);

        // Remove noise words that don't contribute to matching
        $noiseWords = ['costing', 'up to', 'rs', 'lakhs', 'exshowroom', 'price', 'including', 'excluding'];
        $string = str_replace($noiseWords, '', $string);

        // Remove special characters like commas, periods, etc.
        $string = preg_replace('/[^\w\s]/', '', $string);

        // Replace multiple spaces with a single space
        $string = preg_replace('/\s+/', ' ', $string);

        // Trim any extra spaces at the start and end
        return trim($string);
    }

    // Fuzzy matching method using Levenshtein, similar_text, substring, and word matching
    private function isSimilar($str1, $str2)
    {
        // Normalize strings
        $str1 = $this->normalizeString($str1);
        $str2 = $this->normalizeString($str2);

        // Check for exact substring match
        if (strpos($str2, $str1) !== false || strpos($str1, $str2) !== false) {
            return true;
        }

        // Calculate Levenshtein distance
        $levDistance = levenshtein($str1, $str2);

        // Calculate similarity percentage
        $similarPercent = 0;
        similar_text($str1, $str2, $similarPercent);

        // Check for word matching (over 50% word match)
        if ($this->wordMatch($str1, $str2)) {
            return true;
        }

        // Use combined weighted matching (Levenshtein + similar_text)
        $levWeight = 0.4;  // Weight for Levenshtein distance
        $simWeight = 0.6;  // Weight for similar_text percentage
        $matchScore = ($levWeight * (1 - ($levDistance / max(strlen($str1), strlen($str2))))) + ($simWeight * ($similarPercent / 100));

        // Consider it a match if the combined score is high enough (above 70%)
        return $matchScore > 0.7;
    }

    // Check if there is a significant word overlap between two strings
    private function wordMatch($str1, $str2)
    {
        // Split the strings into words
        $words1 = explode(' ', $str1);
        $words2 = explode(' ', $str2);

        // Get the common words between the two sets of words
        $commonWords = array_intersect($words1, $words2);
        $totalWords = max(count($words1), count($words2));

        // If more than 50% of the words match, consider it a match
        return (count($commonWords) / $totalWords) > 0.5;
    }
    private function getActivityTypeId(string $oldActivityType): int
    {
        switch ($oldActivityType) {
            case 'Manufacturing':
                return ActivityTypeEnum::MANUFACTURING->id();
            case 'Trading':
                return ActivityTypeEnum::TRADING->id();
            default:
                return ActivityTypeEnum::SERVICING->id();
        }
    }

    private function getAddress(?string $address, int $districtId, ?int $oldBlockId): array
    {
        $returnAddress = [
            RegionTypeEnum::CONSTITUENCY->id() => null,
            RegionTypeEnum::TEHSIL->id() => null,
            RegionTypeEnum::BLOCK_TOWN->id() => null,
            RegionTypeEnum::PANCHAYAT_WARD->id() => null,
        ];
        if (!$this->regions) {
            $this->regions = Region::all();
        }
        $interestingRegions = $this->regions->filter(fn($r) => str(strtolower($address))->contains(strtolower($r->name)));
        foreach ($interestingRegions as $region) {
            if ($region->type_id == RegionTypeEnum::PANCHAYAT_WARD->id()) {
                $regionParent = $this->regions->filter(fn($r) => $r->id == $region->parent_id)->first();
                if ($regionParent) {
                    $regionGrandParent = $this->regions->filter(fn($r) => $r->id == $regionParent->parent_id)->first();
                    if ($regionGrandParent->id == $districtId) {
                        $returnAddress[RegionTypeEnum::PANCHAYAT_WARD->id()] = $region->id;
                        $returnAddress[RegionTypeEnum::BLOCK_TOWN->id()] = $regionParent->id;
                    }
                }
            } elseif ($region->parent_id == $districtId) {
                $returnAddress[$region->type_id] = $region->id;
            }
        }
        if (is_null($returnAddress[RegionTypeEnum::BLOCK_TOWN->id()]) && ($oldBlockId > 0)) {
            if (!$this->oldBlocks) {
                $this->oldBlocks = DB::connection('old-mysql')
                    ->table('tb_blocks')
                    ->select('bl_id', 'bl_name')
                    ->where('bl_status', 1)
                    ->get();
            }
            $oldBlock = $this->oldBlocks->firstWhere('bl_id', $oldBlockId);
            if ($oldBlock) {
                $newBlock = $this->regions->filter(fn($r) => $r->type_id == RegionTypeEnum::BLOCK_TOWN->id() && $r->name == $oldBlock->bl_name && $r->parent_id == $districtId)->first();
                if ($newBlock) {
                    $returnAddress[RegionTypeEnum::BLOCK_TOWN->id()] = $newBlock->id;
                }
            }
        }

        return $returnAddress;
    }

    private function getGender(string $oldGender): string
    {
        switch ($oldGender) {
            case 'F':
                return 'Female';
            case 'M':
                return 'Male';
            default:
                return 'Other';
        }
    }

    private function getSocialCategoryId(string $oldSocialCategory): int
    {
        $result = 0;
        switch ($oldSocialCategory) {
            case 'OBC':
                $result = SocialCategoryEnum::OBC->id();
                break;
            case 'SC':
                $result = SocialCategoryEnum::SC->id();
                break;
            case 'ST':
                $result = SocialCategoryEnum::ST->id();
                break;
            default:
                $result = SocialCategoryEnum::GENERAL->id();
                break;
        }
        return $result;
    }

    private function getConstitutionId($oldConstitution): int
    {
        switch ($oldConstitution) {
            case 'Pvt.Ltd.':
                return ConstitutionTypeEnum::PRIVATE_LIMITED->id();
            case 'Partnership':
                return ConstitutionTypeEnum::PARTNERSHIP->id();
            case 'LLP':
                return ConstitutionTypeEnum::LIMITED_LIABILITY_PARTNERSHIP->id();
            default:
                return ConstitutionTypeEnum::PROPRIETORSHIP->id();
        }
    }

    /*
     * Users functions area, already done.
    // DIC, GM, DCB, EOS, DD, ADO, SLBC, DOI, Secretary, COB
    private function createUsers()
    {
        throw new Exception('Users have been imported already!');
        // Create DIC Nodals
        $this->info('Creating DIC Nodal users.');
        $this->createDICNodals();
        $this->info("\nCreated DIC Nodal users.");

        // Create DIC GMs
        $this->info('Creating GM DIC users.');
        $this->createDICGMs();
        $this->info("\nCreated GM DIC users.");

        // Create EOs
        $this->info('Creating EO DIC users.');
        $this->createDICEOs();
        $this->info("\nCreated EO DIC users.");

        // Create Branch Managers
        $this->info('Creating Bank Branch Managers.');
        $this->createBranchManagers();
        $this->info("\nCreated Bank Branch Managers.");
    }

    private function createDICNodals()
    {
        $this->createUserWithRole('DIC', RoleEnum::NODAL_DIC->value);
    }

    private function createDICGMs()
    {
        $this->createUserWithRole('GM', RoleEnum::GM_DIC->value);
    }

    private function createDICEOs()
    {
        $this->createUserWithRole('EOS', RoleEnum::EO_DIC->value);
    }

    private function createUserWithRole(string $oldRoleName, int $newRoleId)
    {
        $oldUsers = $this->getOldUsersByRole($oldRoleName);
        $this->withProgressBar($oldUsers, function ($oldUser) use ($newRoleId) {
            $user = User::where('email', $oldUser->ol_username)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $oldUser->ol_name ?? $oldUser->ol_username,
                    'email' => $oldUser->ol_username,
                    'email_verified_at' => $oldUser->ol_created,
                    'password' => 'mmsy@2022',
                ]);
            }
            if($user->roles()->where('roles.id', $newRoleId)->count() == 0) {
                $user->roles()->attach($newRoleId, ['created_at' => now(), 'created_by' => 0, 'metadata' => json_encode(['district_ids' => [$oldUser->ol_district_id + 2]])]);
            }
        });
    }

    private function getOldUsersByRole(string $roleName)
    {
        return DB::connection('old-mysql')
            ->table('tb_officers_login')
            ->where('ol_role_name', $roleName)
            ->where('ol_status', 1)
            ->get();
    }

    private function createBranchManagers()
    {
        $oldBanks = DB::connection('old-mysql')
            ->table('tb_banks')
            ->where('b_status', 1)
            ->get();

        $newBanks = Bank::all();

        $oldBranches = DB::connection('old-mysql')
            ->table('tb_branch_details')
            ->where('bd_status', 1)
            ->orderBy('bd_ifsc_code')
            ->get();

        $this->withProgressBar($oldBranches, function ($oldBranch) use ($oldBanks, $newBanks) {
            $newBranch = BankBranch::where('ifsc', $oldBranch->bd_ifsc_code)->first();
            if (!$newBranch) {
                $oldBank = $oldBanks->firstWhere('b_id', $oldBranch->bd_bank_id);
                $oldBank->b_name = strtolower(trim($oldBank->b_name));
                $bankMappings = [
                    'indian bank e allahabad bank' => 'indian bank',
                    'union bank of india(e-andhra bank)' => 'union bank of india',
                    'e-corporation bank' => 'union bank of india',
                    'hdfc bank ltd' => 'hdfc bank',
                    'kangra central coop bank' => 'kangra central co-operative bank',
                    'the parwanoo urban coop bank ltd' => 'the parwanoo urban co-operative bank',
                    'oriental bank of commerce' => 'punjab national bank',
                    'pnb(e-ubi)' => 'Punjab National Bank',
                ];
                if (isset($bankMappings[$oldBank->b_name])) {
                    $oldBank->b_name = $bankMappings[$oldBank->b_name];
                }
                $newBank = $newBanks->filter(function ($b) use ($oldBank) {
                    return strtolower($b->name) == strtolower($oldBank->b_name);
                })->first();
                if (!$newBank) {
                    dd('Bank not found!', $oldBank);
                }
                $newBranch = BankBranch::create([
                    'name' => $oldBranch->bd_branch_name,
                    'address' => $oldBranch->bd_address,
                    'district_id' => $oldBranch->bd_district_id + 2,
                    'bank_id' => $newBank->id,
                    'ifsc' => $oldBranch->bd_ifsc_code,
                ]);
            }
            $user = User::where('email', $oldBranch->bd_username)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $oldBranch->bd_manager_name ?? $oldBranch->bd_username,
                    'email' => $oldBranch->bd_username,
                    'email_verified_at' => $oldBranch->bd_created,
                    'password' => 'mmsy@2022',
                ]);
            }
            $existing = $user->roles()->where('roles.id', RoleEnum::BANK_MANAGER->value)->first();
            if ($existing) {
                $metadata = json_decode($existing->pivot->metadata);
                if (!in_array($newBranch->id, $metadata->bank_branch_ids)) {
                    $metadata->bank_branch_ids[] = $newBranch->id;
                    $user->roles()->updateExistingPivot(RoleEnum::BANK_MANAGER->value, [
                        'metadata' => json_encode($metadata),
                    ]);
                }
            } else {
                $user->roles()->attach(RoleEnum::BANK_MANAGER->value, ['created_at' => now(), 'created_by' => 0, 'metadata' => json_encode(['bank_branch_ids' => [$newBranch->id]])]);
            }
            if($oldBranch->bd_username == 'simla@ucobank.co.in') {
                if($user->roles()->where('roles.id', RoleEnum::NODAL_BANK->value)->count() == 0) {
                    $user->roles()->attach(RoleEnum::NODAL_BANK->value, ['created_at' => now(), 'created_by' => 0, 'metadata' => null]);
                }
            }
        });
    } */
}
