<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum ApplicationStatusEnum:string
{
    use DbEnumTrait;

    case UNKNOWN = 'Unknown';
    case INCOMPLETE = 'Incomplete';
    case WITHDRAWN = 'Withdrawn';
    case LOAN_REJECTED = 'Loan Rejected';
    case REVERTED_BACK_TO_APPLICANT = 'Reverted Back to Applicant';
    case PENDING_AT_DISTRICT_INDUSTRIES_CENTER = 'Pending at District Industries Center';
    case REJECTED_AT_DISTRICT_INDUSTRIES_CENTER = 'Rejected at District Industries Center';
    case PENDING_FOR_BANK_CIBIL_COMMENTS = 'Pending for Comments from Bank';
    case PENDING_FOR_DISTRICT_LEVEL_COMMITTEE = 'Pending for District Level Committee';
    case REJECTED_AT_DISTRICT_LEVEL_COMMITTEE = 'Rejected at District Level Committee';
    case PENDING_FOR_LOAN_DISBURSEMENT = 'Pending at Bank for Loan Disbursement';
    case LOAN_DISBURSED = 'Loan Disbursed';
    case PENDING_60_SUBSIDY_REQUEST = 'Pending at DIC for 60% Subsidy Request';
    case PENDING_60_SUBSIDY_RELEASE = 'Pending at Nodal Bank for 60% Subsidy Release';
    case SUBSIDY_60_RELEASED = '60% Subsidy Released';
    case PENDING_40_SUBSIDY_RELEASE = 'Pending at Nodal Bank for 40% Subsidy Release';
    case SUBSIDY_40_RELEASED = '40% Subsidy Released';
    case PENDING_INTEREST_SUBSIDY_RELEASE = 'Pending at Nodal Bank for Interest Subsidy Release';
    case INTEREST_SUBSIDY_RELEASE = 'Interest Subsidy Realeased';
    case CASE_COMPLETED = 'Case Completed';
    case REVERTED_BACK_TO_APPLICANT_BY_GM = 'Reverted Back to Applicant by GM';
    case PENDING_40_SUBSIDY_APPROVAL = 'Pending at DIC for 40% Subsidy Approval';
    case REVERTED_BACK_TO_EO = 'Reverted Back to Extension Officer';
}
