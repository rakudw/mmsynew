<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <form class="form application-form" action="/application/save-data/" method="POST" onsubmit="return confirm('Are you sure you have filled in the correct information? Once submitted, it cannot be edited.')" id="applicant-form">
        @csrf
        <input type="hidden" name="application_id" value="{{ isset($application) ? $application->id : '' }}">
        <table class="table">
            <tbody>
                <tr>
                    <td class="td-1">
                        <table class="table">
                            <tbody>
                                <tr bgcolor="#E36E2C">
                                    <td colspan="6">
                                        <div align="center" class="style1">
                                            <h6>Application For The Approval Under Mukhya Mantri Swavlamban Yojana/मुख्यमंत्री स्वावलंबन योजना के अंतर्गत मंजूरी के लिए आवेदन</h6>
                                            @if($application)<h6>You are editing the Application MMSY-{{ $application->id }}</h6>@endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(A)</th>
                                    <th class="section-heading" ><strong>Legal Type/कानूनी  प्रकार*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Enter the details of major partner below / मुख्य साथी की विवरण नीचे दर्ज करें।</th>
                                </tr>
                                <!-- (17) -->
                                <tr>
                                    <th>(1)</th>
                                    <th ><strong>Aadhaar Number / आधार नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="tel" id="aadhaar" value="{{ old('owner_aadhaar', $application ? $application->data->owner->aadhaar : '') }}" name="owner_aadhaar" required pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$">
                                        <small>Enter Aadhaar Number</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(2)</th>
                                    <th ><strong>Name of Applicant / आवेदक का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="name" value="{{ old('owner_name', $application ? $application->data->owner->name : '') }}" name="owner_name" required autofocus>
                                        <small>Name of Applicant.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(3)</th>
                                    <th ><strong>Father/Husband/Mother Name /प्रतिरक्षक/माता-पिता/पति-पत्नी नाम:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="guardian_prefix" name="owner_guardian_prefix" required>
                                            <option value="">--Select guardian/parent/spouse.--</option>
                                            <option value="S/O" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->guardian_prefix : '') == 'S/O') ? 'selected' : '' }}>S/O</option>
                                            <option value="W/O" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->guardian_prefix : '') == 'W/O') ? 'selected' : '' }}>W/O</option>
                                            <option value="D/O" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->guardian_prefix : '') == 'D/O') ? 'selected' : '' }}>D/O</option>
                                            <option value="C/O" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->guardian_prefix : '') == 'C/O') ? 'selected' : '' }}>C/O</option>
                                        </select>
                                        <input  type="text" name="owner_guardian" value="{{ old('owner_guardian', $application ? $application->data->owner->guardian : '') }}" required="required" autofocus="autofocus" data-prefix="S/O,W/O,D/O,C/O">
                                        <small>Name of the guardian/parent/spouse.</small>
                                    </td>
                                </tr>
                               

                                <!-- (4) -->
                                <tr>
                                    <th>(4)</th>
                                    <th ><strong>Pincode / पिनकोड:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="owner_pincode" name="owner_pincode"  value="{{ old('owner_pincode', $application ? $application->data->owner->pincode : '') }}" min="170000" max="179999" required>
                                        <small>Enter Pincode</small>
                                    </td>
                                </tr>

                                <!-- (5) -->
                                <tr>
                                    <th>(5)</th>
                                    <th ><strong>District / जिला:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_district_id" name="owner_district_id" required>
                                            <option value="">--Select District--</option>
                                            @foreach($diss as $dis)
                                                <option value="{{ $dis->id }}" {{ (old('owner_district_id', $application ? $application->data->owner->district_id : '') == $dis->id) ? 'selected' : '' }}>{{ $dis->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select District</small>
                                    </td>
                                </tr>

                                <!-- (6) -->
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Constituency / संसदीय क्षेत्र:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_constituency_id" name="owner_constituency_id" required>
                                            <option value="">--Select Constituency--</option>
                                        </select>
                                        <small>Select Constituency</small>
                                    </td>
                                </tr>

                                <!-- (7) -->
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Tehsil / तहसील:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_tehsil_id" name="owner_tehsil_id" required>
                                        </select>
                                        <small>Select Tehsil</small>
                                    </td>
                                </tr>

                                <!-- (23) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Block / ब्लॉक:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_block_id" name="owner_block_id" required>
                                        <option value="">--Select Block--</option>
                                        </select>
                                        <small>Select Block</small>
                                    </td>
                                </tr>

                                <!-- (24) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Panchayat/Town / पंचायत/नगर :</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_panchayat_id" name="owner_panchayat_id" required>
                                        <option value="">--Select Panchayat/Town--</option>
                                        </select>
                                        <small>Select Panchayat/Town</small>
                                    </td>
                                </tr>

                                <!-- (25) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>House Number/Street/Landmark/Village name /घर क्रमांक/सड़क/सूचना/गांव का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="owner_address" name="owner_address" value="{{ old('owner_address', $application ? $application->data->owner->address : '') }}" required>
                                        <small>Enter House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>(6)</th>
                                    <th ><strong>Mobile Number / मोबाइल नंबर:</strong><br><small>Mobile Number of the Owner</small></th>
                                    <td colspan="4">
                                        <input type="tel" id="owner_mobile" name="owner_mobile" value="{{ old('owner_mobile', $application ? $application->data->owner->mobile : '') }}" pattern="[1-9]{1}[0-9]{9}" required>
                                        <small>Enter Mobile Number</small>
                                    </td>
                                </tr>

                                <!-- (18) -->
                                <tr>
                                    <th>(7)</th>
                                    <th ><strong>Email / ईमेल:</strong></th>
                                    <td colspan="4">
                                        <input type="email" id="owner_email"  value="{{ old('owner_email', $application ? $application->data->owner->email : '') }}" name="owner_email">
                                        <small>Enter Email Address</small>
                                    </td>
                                </tr>
                                <!-- (27) -->
                                <tr>
                                    <th>(8)</th>
                                    <th ><strong>PAN Number / न नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="pan" name="owner_pan" value="{{ old('owner_pan', $application ? $application->data->owner->pan : '') }}" pattern="^([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([0-9]([0-9]([0-9]([0-9]([a-zA-Z])?)?)?)?)?)?)?)?)?)?$">
                                        <small>Enter PAN Number</small>
                                    </td>
                                </tr>

                                <!-- (28) -->
                                <tr>
                                    <th>(9)</th>
                                    <th ><strong>Gender / लिंग:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="gender" name="owner_gender" required >
                                            <option value="">--Select Gender--</option>
                                            <option value="Female" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->gender : '') == 'Female') ? 'selected' : '' }}>Female</option>
                                            <option value="Male" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->gender : '') == 'Male') ? 'selected' : '' }}>Male</option>
                                            <option value="Other" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->gender : '') == 'Other') ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <small>Select Gender</small>
                                    </td>
                                </tr>

                                <!-- (29) -->
                                <tr>
                                    <th>(10)</th>
                                    <th ><strong>Marital Status / वैवाहिक स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="marital_status" name="owner_marital_status" required>
                                            <option value="">--Select Marital Status--</option>
                                            <option value="Unmarried" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->marital_status : '') == 'Unmarried') ? 'selected' : '' }}>Unmarried</option>
                                            <option value="Married" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->marital_status : '') == 'Married') ? 'selected' : '' }}>Married</option>
                                            <option value="Divorced" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->marital_status : '') == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                                            <option value="Widowed" {{ (old('owner_guardian_prefix', $application ? $application->data->owner->marital_status : '') == 'Widowed') ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                        <small>Select Marital Status</small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>(11)</th>
                                    <th ><strong>Date of Birth / जन्म तिथि:</strong></th>
                                    <td colspan="4">
                                        <input type="date" name="owner_birth_date" value="{{ old('owner_birth_date', $application ? $application->data->owner->birth_date : '') }}" required max="2005-12-31" min="1905-01-01">
                                        <span id="birth_date_age" class="badge badge-info bg-dark"></span>
                                        <small>Enter Date of Birth</small>
                                    </td>
                                </tr>

                                <!-- (32) -->
                                <tr>
                                    <th>(12)</th>
                                    <th ><strong>Specially Abled (दिव्यांग):</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="is_specially_abled" name="owner_is_specially_abled" required>
                                            <option value="No" {{ (old('is_specially_abled', $application ? $application->data->owner->is_specially_abled : '') == 'No') ? 'selected' : '' }}>No</option>
                                            <option value="Yes" {{ (old('is_specially_abled', $application ? $application->data->owner->is_specially_abled : '') == 'Yes') ? 'selected' : '' }}>Yes</option>
                                        </select>
                                        <small>Are you Specially Abled?</small>
                                    </td>
                                </tr>

                                <!-- (33) -->
                                <tr>
                                    <th>(13)</th>
                                    <th ><strong>Category / श्रेणी:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="social_category_id" name="owner_social_category_id" required>
                                            <option value="">--Select Category--</option>
                                        @foreach($cats as $cat)
                                                <option value="{{ $cat->id }}" {{ (old('social_category_id', $application ? $application->data->owner->social_category_id : '') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select Category</small>
                                    </td>
                                </tr>

                                <!-- (34) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Belongs to Minority / अल्पसंख्यक है ?:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="belongs_to_minority" name="owner_belongs_to_minority" required>
                                            <option value="No" {{ (old('owner_belongs_to_minority', $application ? $application->data->owner->belongs_to_minority : '') == 'No') ? 'selected' : '' }}>No</option>
                                            <option value="Yes" {{ (old('is_specially_abled', $application ? $application->data->owner->belongs_to_minority : '') == 'Yes') ? 'selected' : '' }}>Yes</option>
                                        </select>
                                        <small>Do you belong to a Minority?</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(B)</th>
                                    <th class="section-heading" ><strong>Enterprise / उद्यम*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Fill Enterprise Information / उद्यम जानकारी भरें</th>
                                </tr>
                                <tr>
                                    <th>(14)</th>
                                    <th ><strong>Name of Proposed Unit / प्रस्तावित इकाई का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="name" name="name" value="{{ old('name', $application ? $application->data->enterprise->name : '') }}" required autofocus>
                                        <small>The name of the unit you want to set.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(15)</th>
                                    <th ><strong>Type of Activity / गतिविधि का प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_type_id" name="activity_type_id" required data-changes="activity_id" class="button"
                                            data-options="dbase:enum(id,name)[type:ACTIVITY_TYPE]">
                                            <option value="">--Select Activity--</option>
                                            @foreach($activities as $activity)
                                                <option value="{{ $activity->id }} " {{ (old('activity_type_id', $application ? $application->data->enterprise->activity_type_id : '') == $activity->id) ? 'selected' : '' }}>{{ $activity->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Activity type of the unit.</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th ></th>
                                    <th ><strong>Activity of the unit / इकाई की गतिविधि:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_id" name="activity_id" required data-condition="activity_type_id:202,203" class="button"
                                            data-depends="activity_type_id"
                                            data-options="dbase:activity(id,name)[type_id:$activity_type_id]">
                                            <option value="">--Select Unit--</option>
                                        </select>
                                        <small>Activity of the unit.</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Description of Activity in Brief /संक्षेप में गतिविधि का विवरण :</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="activity_details" name="activity_details" value="{{ old('activity_details', isset($application->data->enterprise->activity_details) ? $application->data->enterprise->activity_details : '') }}" required data-condition="activity_type_id:202,203">
                                        <small>Description of the activity to be done by the unit.</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Products to be manufactured / उत्पाद जो निर्मित किए जाने हैं:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="products" name="products" value="{{ old('products', isset($application->data->enterprise->products) ? $application->data->enterprise->products : '') }}" required data-condition="activity_type_id:201">


                                        <small>List of all the products to be manufactured by the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(16)</th>
                                    <th ><strong>Constitution Type / संविधान प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="constitution_type_id" name="constitution_type_id" required class="button"
                                            data-options="dbase:enum(id,name)[type:CONSTITUTION_TYPE]">
                                            <option value="">--Select Constitution--</option>
                                            @foreach($cons as $con)
                                                <option value="{{ $con->id }}" {{ (old('constitution_type_id', $application ? $application->data->enterprise->constitution_type_id : '') == $con->id) ? 'selected' : '' }}>{{ $con->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($application)<button type="button"  id="viewButton" class="button" data-toggle="modal" data-target="#ConstitutionModal" style="display: none;">View Partner Details</button>@endif
                                        <small> Constitution Type </small>
                                        <div class="modal fade modal-xl" id="ConstitutionModal" style="z-index: 9999999;" tabindex="" aria-labelledby="ConstitutionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" style="background-color: #ecf8f9" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myPdfModalLabel">Partner/Shareholder Details</h4> <span>Note: All the Partners/Shareholders should be Himachali Bonafied.</span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div id="partnerShareholderContainer" style="display: flex; flex-wrap: wrap; align-items: flex-end;">
                                                            <button class="btn btn-primary" type="button" id="addPartnerButton">Add More</button>
                                                            <!-- Partner Row Template -->
                                                            @if ($application && $application->data->owner->partner_name)
                                                                @foreach ($application->data->owner->partner_name as $index => $partnerName)
                                                                    <div class="partner-row" style="display: flex; align-items: flex-end;">
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_name">Name:</label>
                                                                            <input type="text" name="partner_name[]" required value="{{ old('partner_name.' . $index, $partnerName) }}">
                                                                        </div>
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_gender">Gender:</label>
                                                                            <select name="partner_gender[]" required>
                                                                                <option value="Male" {{ old('partner_gender.' . $index, optional($application->data->owner->partner_gender)[$index]) == 'Male' ? 'selected' : '' }}>Male</option>
                                                                                <option value="Female" {{ old('partner_gender.' . $index, optional($application->data->owner->partner_gender)[$index]) == 'Female' ? 'selected' : '' }}>Female</option>
                                                                                <option value="Other" {{ old('partner_gender.' . $index, optional($application->data->owner->partner_gender)[$index]) == 'Other' ? 'selected' : '' }}>Other</option>
                                                                            </select>
                                                                        </div>
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_birth_date">Date Of Birth:</label>
                                                                            <input type="date" name="partner_birth_date[]" required max="2005-12-31" min="1905-01-01" value="{{ old('partner_birth_date.' . $index, optional($application->data->owner->partner_birth_date)[$index]) }}">
                                                                        </div>
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_social_category_id">Social Category:</label>
                                                                            <select id="partner_social_category_id" name="partner_social_category_id[]" required>
                                                                                <option value="">--Select Category--</option>
                                                                                @foreach($cats as $cat)
                                                                                <option value="{{ $cat->id }}" {{ old('partner_social_category_id.' . $index, optional($application->data->owner->partner_social_category_id)[$index]) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_is_specially_abled">Specially Abled:</label>
                                                                            <select name="partner_is_specially_abled[]" required>
                                                                                <option value="Yes" {{ old('partner_is_specially_abled.' . $index, optional($application->data->owner->partner_is_specially_abled)[$index]) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                                                <option value="No" {{ old('partner_is_specially_abled.' . $index, optional($application->data->owner->partner_is_specially_abled)[$index]) == 'No' ? 'selected' : '' }}>No</option>
                                                                            </select>
                                                                        </div>
                                                                        <div style="margin-right: 10px;">
                                                                            <label for="partner_aadhaar">Aadhaar Number:</label>
                                                                            <input type="text" name="partner_aadhaar[]" pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$" required value="{{ old('partner_aadhaar.' . $index, optional($application->data->owner->partner_aadhaar)[$index]) }}">
                                                                        </div>
                                                                        <div style="">
                                                                            <label for="partner_mobile">Mobile (Linked To The Aadhaar):</label>
                                                                            <input type="tel" name="partner_mobile[]" pattern="^[6-9]{1}[0-9]{9}$" required value="{{ old('partner_mobile.' . $index, optional($application->data->owner->partner_mobile)[$index]) }}">
                                                                        </div>
                                                                        <div style="display: flex; align-items: center;">
                                                                            <button class="btn btn-danger remove-partner-button" type="button">Remove</button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="partner-row" style="display: flex; align-items: flex-end;">
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_name">Name:</label>
                                                                        <input type="text" name="partner_name[]" required>
                                                                    </div>
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_gender">Gender:</label>
                                                                        <select name="partner_gender[]" required>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                            <option value="Other">Other</option>
                                                                        </select>
                                                                    </div>
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_birth_date">Date Of Birth:</label>
                                                                        <input type="date" name="partner_birth_date[]" required max="2005-12-31" min="1905-01-01">
                                                                    </div>
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_social_category_id">Social Category:</label>
                                                                        <select id="partner_social_category_id" name="partner_social_category_id[]" required>
                                                                            <option value="">--Select Category--</option>
                                                                            @foreach($cats as $cat)
                                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_is_specially_abled">Specially Abled:</label>
                                                                        <select name="partner_is_specially_abled[]" required>
                                                                            <option value="Yes">Yes</option>
                                                                            <option value="No">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <div style="margin-right: 10px;">
                                                                        <label for="partner_aadhaar">Aadhaar Number:</label>
                                                                        <input type="text" name="partner_aadhaar[]" pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$" required>
                                                                    </div>
                                                                    <div style="">
                                                                        <label for="partner_mobile">Mobile (Linked To The Aadhaar):</label>
                                                                        <input type="tel" name="partner_mobile[]" pattern="^[6-9]{1}[0-9]{9}$" required>
                                                                    </div>
                                                                    <div style="display: flex; align-items: center;">
                                                                        <button class="btn btn-danger remove-partner-button" type="button">Remove</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Save</button>
                                                    </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(17)</th>
                                    <th ><strong>Proposed Employment Generation / प्रस्तावित रोजगार उत्पन्न:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="employment" name="employment" value="{{ old('employment', $application ? $application->data->enterprise->employment : '') }}" min="1" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(C)</th>
                                    <th class="section-heading" ><strong>Unit Address / इकाई का पता
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Fill Unit Address / इकाई का पता भरें</th>
                                </tr>
                                <tr>
                                    <th>(18)</th>
                                    <th ><strong>Area Type / क्षेत्र प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="area_type" name="area_type" class="button" required>
                                            <option value="">--Select Area--</option>
                                            <option value="Rural" {{ (old('area_type', $application ? $application->data->enterprise->area_type : '') == 'Rural') ? 'selected' : '' }}>Rural</option>
                                            <option value="Urban" {{ (old('area_type', $application ? $application->data->enterprise->area_type : '') == 'Urban') ? 'selected' : '' }}>Urban</option>
                                        </select>
                                        <small>Area Type</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Pincode / पिनकोड:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="pincode" name="pincode" value="{{ old('employment', $application ? $application->data->enterprise->pincode : '') }}" min="170000" max="179999" required>
                                        <small>Pincode</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>District / जिला:</strong></th>
                                    <td colspan="4">
                                        <select id="district_id" name="district_id" class="button" required>
                                        <option value="">--Select District--</option>
                                            @foreach($diss as $dis)
                                                <option value="{{ $dis->id }}" {{ (old('constitution_type_id', $application ? $application->data->enterprise->district_id : '') == $dis->id) ? 'selected' : '' }}>{{ $dis->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>District</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Constituency / संसदीय क्षेत्र:</strong></th>
                                    <td colspan="4">
                                        <select id="constituency_id" name="constituency_id" class="button" required>
                                        <option value="">--Select Constituency--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Constituency</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Tehsil / तहसील:</strong></th>
                                    <td colspan="4">
                                        <select id="tehsil_id" name="tehsil_id" class="button" required>
                                        <option value="">--Select Tehsil--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Tehsil</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Block / ब्लॉक:</strong></th>
                                    <td colspan="4">
                                        <select id="block_id" name="block_id" class="button" required>
                                        <option value="">--Select Block--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Block</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th>&nbsp;</th>
                                    <th ><strong>Panchayat/Town / पंचायत/नगर:</strong></th>
                                    <td colspan="4">
                                        <select id="panchayat_id" name="panchayat_id" class="button" required>
                                        <option value="">--Select Panchayat/Town--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Panchayat/Town</small>
                                    </td>
                                </tr>
                                <tr class="sub_row">
                                    <th >&nbsp;</th>
                                    <th ><strong>House Number/Street/Landmark/Village name /घर क्रमांक/सड़क/सूचना/गांव का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="address" name="address" value="{{ old('employment', $application ? $application->data->enterprise->address : '') }}" required>
                                        <small>House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="section-heading">(C)</th>
                                    <th class="section-heading"><strong>Project Cost / परियोजना की लागतण
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Project Cost / परियोजना की लागतण</th>
                                </tr>
                                <!-- Land Status -->
                                <tr>
                                    <th>(19)</th>
                                    <th width="300" ><strong>Land Status / भूमि की स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="land_status" name="land_status" required>
                                            <option value="Not Required" {{ (old('land_status', $application ? $application->data->cost->land_status : '') == 'Not Required') ? 'selected' : '' }}>Not Required</option>
                                            <option value="Owned" {{ (old('land_status', $application ? $application->data->cost->land_status : '') == 'Owned') ? 'selected' : '' }}>Owned</option>
                                            <option value="To be Purchased" {{ (old('land_status', $application ? $application->data->cost->land_status : '') == 'To be Purchased') ? 'selected' : '' }}>To be Purchased</option>
                                            <option value="To be Taken on Lease" {{ (old('land_status', $application ? $application->data->cost->land_status : '') == 'To be Taken on Lease') ? 'selected' : '' }}>To be Taken on Lease</option>
                                        </select>
                                        <small>Land Status</small>
                                    </td>
                                </tr>

                                <!-- Cost of Land -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Cost of Land / भूमि का लागत:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="land_cost" name="land_cost" value="{{ old('land_cost', $application ? $application->data->cost->land_cost : '') }}" min="0" data-condition="land_status:To be Purchased,To be Taken on Lease" required>
                                        <small>Cost of Land</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th >(20)</th>
                                    <th ><strong>Building Status / इमारत की स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="building_status" name="building_status" required>
                                            <option value="Already Constructed" {{ (old('building_status', $application ? $application->data->cost->building_status : '') == 'Already Constructed') ? 'selected' : '' }}>Already Constructed</option>
                                            <option value="Not Required" {{ (old('building_status', $application ? $application->data->cost->building_status : '') == 'Not Required') ? 'selected' : '' }}>Not Required</option>
                                            <option value="To be Constructed" {{ (old('building_status', $application ? $application->data->cost->building_status : '') == 'To be Constructed') ? 'selected' : '' }}>To be Constructed</option>
                                            <option value="To be Taken on Rent" {{ (old('building_status', $application ? $application->data->cost->building_status : '') == 'To be Taken on Rent') ? 'selected' : '' }}>To be Taken on Rent</option>
                                        </select>
                                        <small>Building Status</small>
                                    </td>
                                </tr>

                                <!-- (38) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Cost of Building Construction / इमारत निर्माण की लागत:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="building_cost" name="building_cost" value="{{ old('building_cost', $application ? $application->data->cost->building_cost : '') }}" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Cost of Building Construction</small> <span class="badge bg-danger">  Subsidized Component/अनुदानित घटक</span>
                                    </td>
                                </tr>

                                <!-- (39) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Estimated Buildup Area (in Square Feet) पूर्वानुमानित बिल्डअप क्षेत्र (वर्ग फीट में)" :</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="building_area" name="building_area" value="{{ old('building_area', $application ? $application->data->cost->building_area : '') }}" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Estimated Buildup Area (in Square Feet)</small>
                                    </td>
                                </tr>

                                <!-- (40) -->
                                <tr>
                                    <th>(21)</th>
                                    <th ><strong>Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets Cost:</strong></th>
                                    <td colspan="4">
                                        <input  value="{{ old('assets_cost', $application ? $application->data->cost->assets_cost : '') }}" type="number" id="assets_cost" name="assets_cost" min="0" required>
                                        <small>Cost of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small><span class="badge bg-danger">  Subsidized Component/अनुदानित घटक</span>
                                    </td>
                                </tr>

                                <!-- (41) -->
                                <tr>
                                    <th>(22)</th>
                                    <th ><strong>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets:</strong></th>
                                    <td colspan="4">
                                        <input value="{{ old('assets_detail', $application ? $application->data->cost->assets_detail : '') }}" type="text" id="assets_detail" name="assets_detail" required>
                                        <small>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(23)</th>
                                    <th ><strong>Machinery/Equipments Cost / मशीनरी/उपकरण की लागत:</strong></th>
                                    <td colspan="4">
                                        <input  value="{{ old('machinery_cost', $application ? $application->data->cost->machinery_cost : '') }}" type="number" id="machinery_cost" name="machinery_cost" min="0" required>
                                        <small>Machinery/Equipments Cost</small><span class="badge bg-danger">   Subsidized Component/अनुदानित घटक</span>
                                    </td>
                                </tr>

                                <!-- (43) -->
                                <tr>
                                    <th>(24)</th>
                                    <th ><strong>Working Capital/CC Limit / कामकाज पूंजी/क्रेडिट लिमिट:</strong></th>
                                    <td colspan="4">
                                        <input  type="number" id="working_capital_cc" name="working_capital_cc" min="0"  value="{{ old('working_capital_cc', $application ? $application->data->cost->working_capital : '') }}" required>
                                        <small>Working Capital/CC Limit</small>
                                    </td>
                                </tr>

                                <!-- (44) -->
                                <tr>
                                    <th>(25)</th>
                                    <th ><strong>Details of Machinery/Equipments / मशीनरी/उपकरण का विवरण:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="machinery_detail" name="machinery_detail" value="{{ old('working_capital_cc', $application ? $application->data->cost->machinery_detail : '') }}" required>
                                        <small>Details of Machinery/Equipments</small>
                                    </td>
                                </tr>

                                <!-- (45) -->
                                <tr class="sub_row">
                                    <th></th>
                                    <th ><strong>Total Project Cost (Calculated) /कुल प्रोजेक्ट लागत (गणना की गई):</strong></th>
                                    <td colspan="4">
                                        <input type="text" value="{{ old('project_cost') }}" id="project_cost" name="project_cost" readonly required data-calculate="">
                                        <small>Total Project Cost (Calculated)</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(D)</th>
                                    <th class="section-heading" ><strong>Means of Finance / वित्त प्राधिकृति
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Means of Finance / वित्त प्राधिकृति</th>
                                </tr>
                                <tr>
                                    <th>(26)</th>
                                    <th  ><strong>Own Contribution Percentage (10% of Capital Expenditure) / स्वयं सहायता प्रतिशत (पूंजी व्यय का 10%):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution" name="own_contribution" value="{{ old('own_contribution', $application ? $application->data->finance->own_contribution : '') }}" min="10" max="95" step="any"  >
                                        <small>Should be at least 10%.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th  ><strong>Capital Expenditure/ पूंजी व्यय </strong></th>
                                    <td colspan="4">
                                        <input type="number" id="capital_expenditure" value="" readonly step="any" required autofocus>
                                        <small>Land Cost / भूमि लागत + Building Cost / इमारत लागत + Assets Cost / संपत्ति लागत + Machinery Cost / मशीनरी लागत</small>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th></th>
                                    <th  ><strong>Own Contribution Amount / स्वयं सहायता पूंजी </strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution_amount" name="own_contribution_amount"  readonly step="any"  >
                                        <small>Project Cost / परियोजना लागत * (Own Contribution / स्वयं संगठन * 10 / 100)</small>
                                    </td>
                                </tr>
                            
                                <tr>
                                    <th></th>
                                    <th  ><strong>Term Loan/ शब्द ऋण </strong></th>
                                    <td colspan="4">
                                        <input type="number" id="term_loan" name="term_loan" value="{{ old('term_loan') }}"  readonly step="any" required autofocus>
                                        <small>Project Cost / परियोजना लागत - Own Contribution Amount /  स्वयं संगठन राशि - Working Capital / संपत्ति लागत</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th  ><strong>Working Capital / संपत्ति लागत </strong></th>
                                    <td colspan="4">
                                        <input type="number" id="working_capital" name="working_capital" value="{{ old('working_capital') }}"  readonly step="any" required autofocus>
                                        <small>Working Capital - (Working Capital * (Own Contribution Amount / स्वयं संगठन राशि * 10 / 100))</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(27)</th>
                                    <th ><strong>Name of the Loan Financing Bank / ऋण वित्तपोषण बैंक का नाम:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="bank_id" name="bank_id" required>
                                            <option value="">--Select Bank--</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ (old('constitution_type_id', $bankid ? $bankid->bank_id : '') == $bank->id) ? 'selected' : '' }}>{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select name of the bank from which the applicant wants to get the loan.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th ><strong>Name of the Loan Financing Branch / ऋण वित्तपोषण शाखा का नाम:</strong></th>
                                    <td colspan="4">
                                        <!-- <select class="button select2" id="bank_branch_id" name="bank_branch_id" required>
                                            <option value="">--Select Branch--</option>
                                        </select> -->
                                        <input type="text" id="branch" name="branch"  readonly="true" size="11" required> 
                                        <input  id="bank_branch_id" name="bank_branch_id" value="{{ old('bank_branch_id', $application ? $application->data->finance->bank_branch_id : '') }}"  type="hidden" size="11" required> 
                                        <button type="button"  id="openModalBtn" class="button" data-toggle="modal" data-target="#myModal">Select Branch</button>
                                        <small>Name of the bank from which the applicant wants to get the loan. Select the bank by searching for IFS code, branch, or bank name.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input  type="submit" class="button" id="submit-button" value="{{ $application ? 'Update' : 'Save'}} Applicant Data">
                                    </div></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="CSSTableGenerator">
                        <tbody>
                        <tr bgcolor="#E36E2C">
                        <td colspan="2"><h6 align="center" class="style1"> Guidelines for Filling the Online MMSY Application /
                            ऑनलाइन एमएमएसवाई  आवेदन भरने हेतु दिशानिर्देश
                            </h6></td>
                        </tr>
                        <tr>
                        <td>(1)</td>
                        <td><strong>Aadhaar Number / आधार नंबर:</strong> : Kindly enter your Aadhaar Number accurately, as it's essential for precise identification in this form. Ensure it matches your official records./कृपया ध्यानपूर्वक अपना आधार नंबर दर्ज करें, क्योंकि इस फॉर्म में सटीक पहचान के लिए यह महत्वपूर्ण है। सुनिश्चित करें कि यह आपके आधिकारिक रिकॉर्ड से मेल खाता है।</td>
                        </tr>
                        <tr>
                        <td>(2)</td>
                        <td><strong>Name of Applicant / आवेदक का नाम:</strong> : Please provide the Name of Applicant for accurate identification in this form./कृपया इस फॉर्म में सटीक पहचान के लिए आवेदक का नाम प्रदान करें।</td>
                        </tr>
                        <tr>
                        <td>(3)</td>
                        <td><strong>Father/Husband/Mother Name /प्रतिरक्षक/माता-पिता/पति-पत्नी नाम:</strong> :Please provide the Father/Husband/Mother Name for identification in this form./कृपया इस फॉर्म में पहचान के लिए प्रतिरक्षक/माता-पिता/पति-पत्नी का नाम प्रदान करें।</td>
                        </tr>
                        <tr>
                        <td>(4)</td>
                        <td><strong>Pincode / पिनकोड:</strong> :Enter the 6 digit Pincode for location information in this form./कृपया इस फॉर्म में स्थान सूचना के लिए 6-अंकीय पिनकोड दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(5)</td>
                            <td><strong>Address:- District / जिला:</strong> :To ensure accurate location identification and effective communication, please provide the requested details, including district, constituency, tehsil, block, panchayat/town, and specific address information./सटीक स्थान पहचान और प्रभावी संचार सुनिश्चित करने के लिए, कृपया जिला, संसदीय क्षेत्र, तहसील, ब्लॉक, पंचायत/नगर, और विशिष्ट पता जानकारी प्रदान करें।</td>
                            </tr>
                        <tr>
                        <td >(6)</td>
                        <td><strong>Mobile Number of the Applicant/आवेदक का मोबाइल नंबर:</strong> : To facilitate communication and updates, please provide your mobile number./संचार और अपडेट्स को सुविधाजनक बनाने के लिए कृपया अपना मोबाइल नंबर प्रदान करें।</td>
                        </tr>
                        <tr>
                        <td >(7)</td>
                        <td><strong>Email / ईमेल:</strong> : For electronic correspondence and notifications, please provide your email address./इलेक्ट्रॉनिक संवाद और सूचनाओं के लिए कृपया अपना ईमेल पता प्रदान करें।</td>
                        </tr>
                        <tr>
                        <td >(8)</td>
                        <td><strong>PAN Number / न नंबर:</strong> : For financial and taxation purposes, please provide your PAN (Permanent Account Number) if applicable./वित्तीय और करणीय उद्देश्यों के लिए, कृपया यदि लागू हो तो अपना PAN (स्थायी खाता संख्या) प्रदान करें।</td>
                        </tr>
                        <tr>
                        <td >(9)</td>
                        <td><strong>Gender / लिंग:</strong> : Please specify your gender for demographic information./जनसांख्यिकी जानकारी के लिए कृपया अपना लिंग निर्दिष्ट करें।</td>
                        </tr>
                        <tr>
                            <td>(10)</td>
                            <td><strong>Marital Status / वैवाहिक स्थिति:</strong> : Please indicate your marital status for demographic purposes./कृपया जनसांख्यिकी उद्देश्यों के लिए अपनी वैवाहिक स्थिति दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(11)</td>
                            <td><strong>Date of Birth / जन्म तिथि:</strong> :Enter your date of birth for age verification and demographic purposes./आयु सत्यापन और जनसांख्यिकी के उद्देश्यों के लिए अपनी जन्म तिथि दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(12)</td>
                            <td><strong>Specially Abled (दिव्यांग):</strong> :Select 'Yes' if you are specially abled; otherwise, select 'No'./यदि आप विशेष रूप से योग्य हैं, तो 'हां' चुनें; अन्यथा 'नहीं' चुनें।</td>
                        </tr>
                        <tr>
                            <td>(13)</td>
                            <td><strong>Belongs to Minority / अल्पसंख्यक है ?:</strong> :Select 'Yes' if you belong to a minority group, or 'No' if you don't./अगर आप एक अल्पसंख्यक समूह से हैं, तो 'हां' का चयन करें, या अगर आप नहीं हैं, तो 'नहीं' का चयन करें। (i) <strong>Belongs to Minority / अल्पसंख्यक है ?:</strong> :Select 'Yes' if you belong to a minority group, or 'No' if you don't./अगर आप एक अल्पसंख्यक समूह से हैं, तो 'हां' का चयन करें, या अगर आप नहीं हैं, तो 'नहीं' का चयन करें।</td>
                        </tr>
                        <tr>
                            <td>(14)</td>
                            <td><strong>Name of Proposed Unit / प्रस्तावित इकाई का नाम:</strong> :Please enter the intended name for your business or unit. Ensure it's unique, relevant, and aligns with your business goals./कृपया अपने व्यवसाय या इकाई के इंटेंडेड नाम को दर्ज करें। सुनिश्चित करें कि यह अनूठा, सांबंधित है, और आपके व्यवसाय लक्ष्यों के साथ मेल खाता है।</td>
                        </tr>
                        <tr>
                            <td>(15)</td>
                            <td><strong>Type of Activity / गतिविधि का प्रकार:</strong> :Please select the type of activity for your unit from the options provided./कृपया प्रदान किए गए विकल्पों से अपनी इकाई के लिए गतिविधि का प्रकार चुनें।(i)<strong>Activity of the unit / इकाई की गतिविधि:</strong> :Select the specific activity or function performed by the unit / इकाई द्वारा की जाने वाली विशिष्ट गतिविधि या कार्य चुनें।(ii)<strong>Activity of the unit / इकाई की गतिविधि:</strong> Select the specific activity or function performed by the unit / इकाई द्वारा की जाने वाली विशिष्ट गतिविधि या कार्य चुनें।(iii)<strong>Products to be manufactured / उत्पाद जो निर्मित किए जाने हैं:</strong> List the products that the unit intends to manufacture / उन उत्पादों की सूची दें जो इकाई निर्मित करने का इरादा रखती है।</td>
                        </tr>
                        <tr>
                            <td>(16)</td>
                            <td><strong>Constitution Type / संविधान प्रकार:</strong> Choose the constitution type for the unit from the available options / उपलब्ध विकल्पों में से इकाई के संविधान प्रकार का चयन करें।</td>
                        </tr>
                        <tr>
                            <td>(17)</td>
                            <td><strong>Proposed Employment Generation / प्रस्तावित रोजगार उत्पन्न:</strong> Specify the expected number of jobs to be created by the proposed unit / प्रस्तावित इकाई द्वारा बनाए जाने वाले प्रत्याशित नौकरियों की संख्या की विशेष उल्लिखन करें।</td>
                        </tr>
                        <tr>
                            <td>(18)</td>
                            <td><strong>Area Type / क्षेत्र प्रकार:</strong> Select the type of area where the unit is located, whether it's rural or urban / चुनें कि इकाई किस प्रकार के क्षेत्र में स्थित है, क्या यह ग्रामीण या शहरी है। 
                                (i)<strong>Pincode / पिनकोड:</strong> Enter the pincode of the unit's location / इकाई के स्थान का पिनकोड दर्ज करें।

                                (ii)<strong>District / जिला:</strong> Select the district where the unit is located / चुनें कि इकाई किस जिले में स्थित है।
                                
                                (iii)<strong>Constituency / संसदीय क्षेत्र:</strong> Select the parliamentary constituency where the unit is located / चुनें कि इकाई किस संसदीय क्षेत्र में स्थित है।
                                
                                (iv)<strong>Tehsil / तहसील:</strong> Select the tehsil where the unit is located / चुनें कि इकाई किस तहसील में स्थित है।
                                
                                (v)<strong>Block / ब्लॉक:</strong> Select the block where the unit is located / चुनें कि इकाई किस ब्लॉक में स्थित है।
                                
                                (vi)<strong>Panchayat/Town / पंचायत/नगर:</strong> Select the panchayat or town where the unit is located / चुनें कि इकाई किस पंचायत या नगर में स्थित है।</td>
                        </tr>
                        <tr>
                            <td>(19)</td>
                            <td><strong>Land Status / भूमि की स्थिति:</strong> Specify whether information regarding land status is required or not / यह स्पष्ट करें कि भूमि की स्थिति की जानकारी की आवश्यकता है या नहीं। (i) <strong>Cost of Land / भूमि का लागत:</strong> Enter the cost of the land for the proposed unit, if applicable / यदि लागू हो, तो प्रस्तावित इकाई की भूमि की लागत दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(20)</td>
                            <td><strong>Building Status / इमारत की स्थिति:</strong> Indicate whether the building is already constructed or not / इमारत पहले से ही निर्मित है या नहीं। (i) <strong>Cost of Building Construction / इमारत निर्माण की लागत:</strong> Enter the cost of constructing the building, if applicable / यदि लागू हो, तो इमारत निर्माण की लागत दर्ज करें।  (ii)<strong>Estimated Buildup Area (in Square Feet) / पूर्वानुमानित बिल्डअप क्षेत्र (वर्ग फीट में):</strong> Provide an estimate of the buildup area in square feet for the proposed unit / प्रस्तावित इकाई के लिए वर्ग फीट में बिल्डअप क्षेत्र का अनुमान दें।</td>
                        </tr>
                        <tr>
                            <td>(21)</td>
                            <td><strong>Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets Cost / फर्नीचर, फिक्स्चर, आईटी संबंधित आइटम, नवाचार, आंतरिक काम और अन्य स्थिर संपत्ति लागत:</strong> Enter the cost associated with furniture, fixtures, IT-related items, renovation, interior work, and other fixed assets / फर्नीचर, फिक्स्चर, आईटी संबंधित आइटम, नवाचार, आंतरिक काम, और अन्य स्थिर संपत्ति से संबंधित लागत दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(22)</td>
                            <td><strong>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets / फर्नीचर, फिक्स्चर, आईटी संबंधित आइटम, नवाचार, आंतरिक काम और अन्य स्थिर संपत्ति का विवरण:</strong> Provide a detailed description of furniture, fixtures, IT-related items, renovation, interior work, and other fixed assets, if applicable / यदि लागू हो, तो फर्नीचर, फिक्स्चर, आईटी संबंधित आइटम, नवाचार, आंतरिक काम, और अन्य स्थिर संपत्ति का विस्तारपूर्ण विवरण प्रदान करें।</td>
                        </tr>
                        <tr>
                            <td>(23)</td>
                            <td><strong>Machinery/Equipments Cost / मशीनरी/उपकरण की लागत:</strong> Enter the cost of machinery and equipment for the unit / इकाई के लिए मशीनरी और उपकरण की लागत दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(24)</td>
                            <td><strong>Working Capital/CC Limit / कामकाज पूंजी/क्रेडिट लिमिट:</strong> Specify the working capital or credit limit required for the proposed unit, if applicable / यदि लागू हो, तो प्रस्तावित इकाई के लिए आवश्यक कामकाज पूंजी या क्रेडिट सीमा को निर्दिष्ट करें।</td>
                        </tr>
                        <tr>
                            <td>(25)</td>
                            <td><strong>Details of Machinery/Equipments / मशीनरी/उपकरण का विवरण:</strong> Provide a detailed description of the machinery and equipment to be used in the unit, if applicable / यदि लागू हो, तो इकाई में उपयोग के लिए मशीनरी और उपकरण का विस्तारपूर्ण विवरण प्रदान करें। (i) <strong>Total Project Cost (Calculated) / कुल प्रोजेक्ट लागत (गणना की गई):</strong> Enter the calculated total cost of the project / परियोजना की गणना की गई कुल लागत दर्ज करें।</td>
                        </tr>
                        <tr>
                            <td>(26)</td>
                            <td><strong>Own Contribution Percentage (10% of Capital Expenditure) / स्वयं सहायता प्रतिशत (पूंजी व्यय का 10%):</strong> Ensure that your own contribution is at least 10% of the total capital expenditure / सुनिश्चित करें कि आपका स्वयं सहायता कुल पूंजी व्यय का कम से कम 10% है।</td>
                        </tr>
                        <tr>
                            <td>(27)</td>
                            <td><strong>Name of the Loan Financing Bank / ऋण वित्तपोषण बैंक का नाम:</strong> Select the name of the bank from which you wish to obtain the loan / चुनें उस बैंक का नाम जिससे आपको ऋण प्राप्त करना है। (i) <strong>Name of the Loan Financing Branch / ऋण वित्तपोषण शाखा का नाम:</strong> Specify the name of the branch of the chosen bank / चुने गए बैंक की शाखा का नाम निर्दिष्ट करें।</td>
                        </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Add any submit button or additional form elements here -->
        <div id="myModal" class="modal bank-modal">
            <div class="modal-content">
                <span class="close" id="closeModalBtn">&times;</span>
                <h2>Select a Branch</h2>
                <input type="text" id="ifscSearch" placeholder="Search by IFSC code & Branch Name">
                <table id="optionsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>IFSC Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>Branch 1</td>
                            <td>123 Main St</td>
                            <td>IFSC001</td>
                            <td><button type="button" class="select-branch">Select</button></td>
                        </tr>
                        <tr>
                            <td>Branch 2</td>
                            <td>456 Elm St</td>
                            <td>IFSC002</td>
                            <td><button type="button" class="select-branch">Select</button></td>
                        </tr> -->
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <script>
    // When the page is ready
    $(document).ready(function() {
        // Get a reference to the first select element
        $('.select2').select2({
        // Add any additional options you need here
         });
        const activityTypeSelect = $('#activity_type_id');
        const districtTypeSelect = $('#district_id');
        const blockTypeSelect = $('#block_id');
        const ownerdistrictTypeSelect = $('#owner_district_id');
        const ownerblockTypeSelect = $('#owner_block_id');
        const bankTypeSelect = $('#bank_id');
        const constitutionTypeSelect = $('#constitution_type_id');
        const bankid = $(bankTypeSelect).val()
        const constitutionId = $(constitutionTypeSelect).val()
         console.log(constitutionId)
        
        // Get a reference to the second select element
        const activitySelect = $('#activity_id');
        const constituencySelect = $('#constituency_id');
        const tehsilSelect = $('#tehsil_id');
        const blockSelect = $('#block_id');
        const panchayatSelect = $('#panchayat_id');
        const ownerconstituencySelect = $('#owner_constituency_id');
        const ownertehsilSelect = $('#owner_tehsil_id');
        const ownerblockSelect = $('#owner_block_id');
        const ownerpanchayatSelect = $('#owner_panchayat_id');
        const branchSelect = $('#bank_branch_id');

        // Function to load options into the second select element
        function loadActivityOptions(selectedActivityTypeId) {
            // Clear existing options
            activitySelect.empty();

            // Add a default option
            activitySelect.append($('<option>', {
                value: '-1',
                text: '--Select Unit--'
            }));

            if(constitutionId != 101){
                $('#viewButton').css('display', 'inline');
            }
            $("#viewButton").click(function () {
                $('#ConstitutionModal').modal('show');
            });

            constitutionTypeSelect.on('change', function() {
                const Id = $(this).val();
                if(Id == 101 ){
                    $('#viewButton').css('display', 'none');
                }else{
                    $('#viewButton').css('display', 'inline');
                }

            });
            // Load options based on the selected activity type ID
            // console.log('dadsa',selectedActivityTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
                
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    activity_type_id: selectedActivityTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        let selectedConstituencyId = '{{ old('activity_id', $application ? $application->data->enterprise->activity_id : '') }}';
                        data.forEach(function(option) {
                            activitySelect.append($('<option>', {
                                value: option.id,
                                text: option.name,
                                selected: option.id == selectedConstituencyId  // Set selected based on the condition
                            }));
                        });

                    },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }
        function loadPanchayatOptions(selectedBlockTypeId) {
            // Clear existing options
            panchayatSelect.empty();

            // Add a default option
            panchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));

            // Load options based on the selected activity type ID
            // console.log('dadsa',selectedBlockTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
                
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    block_type_id: selectedBlockTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        data.forEach(function(option) {
                            panchayatSelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });

                    },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }
        function loadBranchOptions(selectedBankTypeId) {
            // Clear existing options
            branchSelect.empty();

            // Add a default option
            branchSelect.append($('<option>', {
                value: '-1',
                text: '--Select Branch--'
            }));
            let branchid = '{{ old('bank_branch_id', $application ? $application->data->finance->bank_branch_id : '') }}';
            // Load options based on the selected activity type ID
            // console.log('dadsa',selectedBankTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
            
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    bank_id: selectedBankTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        data.forEach(function (option) {
                            // Create a new table row for each option
                            var newRow = '<tr>' +
                                '<td>' + option.name + '</td>' +
                                '<td>' + option.address + '</td>' +
                                '<td>' + option.ifsc + '</td>' +
                                '<td><button type="button" class="select-branch" data-ifsc="' + option.ifsc + '" data-id="' + option.id + '">Select</button></td>' +
                                '</tr>';

                            // Append the new row to the table
                            $('#optionsTable tbody').append(newRow);
                            if(branchid == option.id){
                                $('#branch').val(option.ifsc)
                            }
                        });

                        // Add event listeners for branch selection
                        $('.select-branch').click(function () {
                            var ifscCode = $(this).data('ifsc'); // Get the IFSC code from the button's data attribute
                            var id = $(this).data('id'); // Get the IFSC code from the button's data attribute
                            $('#bank_branch_id').val(id); // Set the IFSC code in your input field
                            $('#branch').val(ifscCode); // Set the IFSC code in your input field
                            $('#myModal').css('display', 'none'); // Close the modal
                        });
                    },
                    error: function () {
                        // Handle error
                    }
                });
                
            // }
        }
        function loadownerPanchayatOptions(ownerselectedBlockTypeId) {
            // Clear existing options
            ownerpanchayatSelect.empty();

            // Add a default option
            ownerpanchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));

            // Load options based on the selected activity type ID
            // console.log('dadsa',ownerselectedBlockTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
                
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    block_type_id: ownerselectedBlockTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        data.forEach(function(option) {
                        var $option = $('<option>', {
                            value: option.id,
                            text: option.name
                        });
                        
                        // Create a hidden input element to store the IFS code
                        var $hiddenInput = $('<input>', {
                            type: 'hidden',
                            value: option.ifsc, // Assuming you have an 'ifs_code' field in your data
                            class: 'ifs-code'
                        });
                        
                        // Append the hidden input element to the option
                        $option.append($hiddenInput);
                        
                        // Append the option to the select element
                        ownerpanchayatSelect.append($option);
                    });
                    
                    // After adding the options, trigger the Select2 update
                    ownerpanchayatSelect.trigger('change');
                },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }
        function loadConOptions(selectedDistrictTypeId) {
            // Clear existing options
            constituencySelect.empty();
            tehsilSelect.empty();
            blockSelect.empty();

            // Add a default option
            constituencySelect.append($('<option>', {
                value: '-1',
                text: '--Select Constituency--'
            }));
            tehsilSelect.append($('<option>', {
                value: '-1',
                text: '--Select Tehsil--'
            }));
            blockSelect.append($('<option>', {
                value: '-1',
                text: '--Select Block--'
            }));

            // Load options based on the selected activity type ID
            // console.log('dadsa',selectedDistrictTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
                
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    district_type_id: selectedDistrictTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        console.log('dada',data.block)
                        var block = data.block
                        var cons = data.cons
                        var teh = data.teh
                        cons.forEach(function(option) {
                            
                            constituencySelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });
                        block.forEach(function(option) {
                            
                            blockSelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });
                        teh.forEach(function(option) {
                            
                            tehsilSelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });

                    },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }
        function loadownerConOptions(ownerselectedDistrictTypeId) {
            // Clear existing options
            ownerconstituencySelect.empty();
            ownertehsilSelect.empty();
            ownerblockSelect.empty();

            // Add a default option
            ownerconstituencySelect.append($('<option>', {
                value: '-1',
                text: '--Select Constituency--'
            }));
            ownertehsilSelect.append($('<option>', {
                value: '-1',
                text: '--Select Tehsil--'
            }));
            ownerblockSelect.append($('<option>', {
                value: '-1',
                text: '--Select Block--'
            }));

            // Load options based on the selected activity type ID
            // console.log('dadsa',ownerselectedDistrictTypeId)
            // if (selectedActivityTypeId === '202' || selectedActivityTypeId === '203' || selectedActivityTypeId === '201') {
                // Load options dynamically based on your logic here
                // You can make an AJAX request to fetch data from the server and populate the options
                // Example:
                
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    district_type_id: ownerselectedDistrictTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        console.log('dada',data.block)
                        var block = data.block
                        var cons = data.cons
                        var teh = data.teh
                        cons.forEach(function(option) {
                            
                            ownerconstituencySelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });
                        block.forEach(function(option) {
                            
                            ownerblockSelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });
                        teh.forEach(function(option) {
                            
                            ownertehsilSelect.append($('<option>', {
                                value: option.id,
                                text: option.name
                            }));
                        });

                    },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }

        // Event handler for the change event on the first select element
        activityTypeSelect.on('change', function() {
            const selectedActivityTypeId = $(this).val();
            loadActivityOptions(selectedActivityTypeId);
        });
        districtTypeSelect.on('change', function() {
            const selectedDistrictTypeId = $(this).val();
            loadConOptions(selectedDistrictTypeId);
        });
        blockTypeSelect.on('change', function() {
            const selectedBlockTypeId = $(this).val();
            loadPanchayatOptions(selectedBlockTypeId);
        });
        bankTypeSelect.on('change', function() {
            const selectedBankTypeId = $(this).val();
            console.log('bankid',selectedBankTypeId)
            $('#optionsTable tbody').empty();
            $('#branch').val(null)
            $('#bank_branch_id').val(null)
            loadBranchOptions(selectedBankTypeId);
        });
        ownerdistrictTypeSelect.on('change', function() {
            const ownerselectedDistrictTypeId = $(this).val();
            loadownerConOptions(ownerselectedDistrictTypeId);
        });
        ownerblockTypeSelect.on('change', function() {
            const ownerselectedBlockTypeId = $(this).val();
            console.log(ownerselectedBlockTypeId)
            loadownerPanchayatOptions(ownerselectedBlockTypeId);
        });

        // Trigger the change event on page load if a value is pre-selected
        const preSelectedActivityTypeId = activityTypeSelect.val();
        if (preSelectedActivityTypeId) {
            loadActivityOptions(preSelectedActivityTypeId);
        }

        $("#openModalBtn").click(function () {
            
        $("#myModal").css("display", "block");
        // console.log('dadsad')
    });

    // Close modal
    $("#closeModalBtn").click(function () {
        $("#myModal").css("display", "none");
    });

    // Handle branch selection
    $(".select-branch").click(function () {
        var ifscCode = $(this).closest("tr").find("td:nth-child(3)").text();
        $("#bank_branch_id").val(ifscCode);
        $("#myModal").css("display", "none");
    });
    $("#ifscSearch").on("input", function () {
        var searchTerm = $(this).val().toUpperCase();
        filterTableRows(searchTerm);
    });

    // Function to filter table rows
    function filterTableRows(searchTerm) {
        $("#optionsTable tbody tr").each(function () {
            var row = $(this);
            var nameCell = row.find("td:nth-child(1)");
            var ifscCell = row.find("td:nth-child(3)");
            var nameText = nameCell.text().toUpperCase();
            var ifscText = ifscCell.text().toUpperCase();
            if (nameText.indexOf(searchTerm) > -1 || ifscText.indexOf(searchTerm) > -1) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    var selectedDistrictId = '{{ old('owner_district_id', $application ? $application->data->owner->district_id : '') }}';
    $('#owner_district_id').val(selectedDistrictId);

    // Function to load and populate the dependent select elements
    function loadAndPopulateDependentSelects() {
        var selectedDistrictId = $('#owner_district_id').val();
        // console.log('dads')
            ownerconstituencySelect.empty();
            ownertehsilSelect.empty();
            ownerblockSelect.empty();

            // Add a default option
            ownerconstituencySelect.append($('<option>', {
                value: '-1',
                text: '--Select Constituency--'
            }));
            ownertehsilSelect.append($('<option>', {
                value: '-1',
                text: '--Select Tehsil--'
            }));
            ownerblockSelect.append($('<option>', {
                value: '-1',
                text: '--Select Block--'
            }));
            var selectedConstituencyId = '{{ old('owner_constituency_id', $application ? $application->data->owner->constituency_id : '') }}';
            var selectedBlockId = '{{ old('owner_block_id', $application ? $application->data->owner->block_id : '') }}';
            var selectedTehId = '{{ old('owner_block_id', $application ? $application->data->owner->tehsil_id : '') }}';
        // Make an AJAX request to load and populate the dependent select elements
                $.ajax({
                url: '/application/get-data/', // Adjust the URL to your endpoint
                method: 'GET',
                data: {
                district_type_id: selectedDistrictId
            },
            success: function (data) {
                // Populate the dependent select elements based on the data received
                // Example:
                // console.log('dada',data.block)
                        var block = data.block
                        var cons = data.cons
                        var teh = data.teh
                        cons.forEach(function(option) {
                            
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedConstituencyId) {
                                optionElement.attr('selected', 'selected');
                            }
                            ownerconstituencySelect.append(optionElement);
                        });
                        block.forEach(function(option) {
                            
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedBlockId) {
                                optionElement.attr('selected', 'selected');
                                const ownerblock = option.id
                            }
                            ownerblockSelect.append(optionElement);
                        });
                        teh.forEach(function(option) {
                           
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });
                                                    // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedTehId) {
                                optionElement.attr('selected', 'selected');
                                console.log('teh',selectedTehId)
                            }
                            ownertehsilSelect.append(optionElement);
                        });
            },
            error: function () {
                // Handle error
            }
        });
    }
    function loadAndPopulateDependentSelectsEnterprise() {
        var selectedDistrictId = $('#owner_district_id').val();
        console.log('dads',selectedDistrictId)
            constituencySelect.empty();
            tehsilSelect.empty();
            blockSelect.empty();

            // Add a default option
            constituencySelect.append($('<option>', {
                value: '-1',
                text: '--Select Constituency--'
            }));
            tehsilSelect.append($('<option>', {
                value: '-1',
                text: '--Select Tehsil--'
            }));
            blockSelect.append($('<option>', {
                value: '-1',
                text: '--Select Block--'
            }));
            let selectedConstituencyId = '{{ old('owner_constituency_id', $application ? $application->data->enterprise->constituency_id : '') }}';
            let selectedBlockId = '{{ old('owner_block_id', $application ? $application->data->enterprise->block_id : '') }}';
            let selectedTehId = '{{ old('owner_tehsil_id', $application ? $application->data->enterprise->tehsil_id : '') }}';
        // Make an AJAX request to load and populate the dependent select elements
        $.ajax({
            url: '/application/get-data/', // Adjust the URL to your endpoint
            method: 'GET',
            data: {
                district_type_id: selectedDistrictId
            },
            success: function (data) {
                // Populate the dependent select elements based on the data received
                // Example:
                // console.log('dada',data.block)
                        var block = data.block
                        var cons = data.cons
                        var teh = data.teh
                        cons.forEach(function(option) {
                            
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedConstituencyId) {
                                optionElement.attr('selected', 'selected');
                            }
                            constituencySelect.append(optionElement);
                        });
                        block.forEach(function(option) {
                            
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedBlockId) {
                                optionElement.attr('selected', 'selected');
                                const block = option.id
                            }
                            blockSelect.append(optionElement);
                        });
                        teh.forEach(function(option) {
                            
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedTehId) {
                                optionElement.attr('selected', 'selected');
                            }
                            tehsilSelect.append(optionElement);
                        });
            },
            error: function () {
                // Handle error
            }
        });
    }
    function loadAndPopulateDependentSelectsPanchayat() {
            // var selectedBlockId = $('#owner_block_id').val();
            // console.log('dads',ownerblock)
            var selectedBlockId = '{{ old('owner_block_id', $application ? $application->data->owner->block_id : '') }}';
            var BlockId = '{{ old('owner_block_id', $application ? $application->data->enterprise->block_id : '') }}';
            ownerpanchayatSelect.empty();
            panchayatSelect.empty();

            // Add a default option
            panchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));
            ownerpanchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));
            let selectedPanchayatId = '{{ old('owner_panchayat_id', $application ? $application->data->owner->panchayat_id : '') }}';
            let PanchayatId = '{{ old('owner_panchayat_id', $application ? $application->data->enterprise->panchayat_id : '') }}';
        // Make an AJAX request to load and populate the dependent select elements
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    block_type_id: selectedBlockId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        data.forEach(function(option) {
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == selectedPanchayatId) {
                                optionElement.attr('selected', 'selected');
                            }
                        
                        // Append the option to the select element
                        ownerpanchayatSelect.append(optionElement);
                    });
                    
                    // After adding the options, trigger the Select2 update
                    ownerpanchayatSelect.trigger('change');
                },
                    error: function() {
                        // Handle error
                    }
                });
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    block_type_id: BlockId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        data.forEach(function(option) {
                            var optionElement = $('<option>', {
                                value: option.id,
                                text: option.name
                            });

                        // Set the 'selected' attribute if the option's value matches the selectedConstituencyId
                            if (option.id == PanchayatId) {
                                optionElement.attr('selected', 'selected');
                            }
                        
                        // Append the option to the select element
                        panchayatSelect.append(optionElement);
                    });
                    
                    // After adding the options, trigger the Select2 update
                    ownerpanchayatSelect.trigger('change');
                },
                    error: function() {
                        // Handle error
                    }
                });
        
    }

    // Call the function to load and populate the dependent select elements on page load
    loadAndPopulateDependentSelects();
    loadAndPopulateDependentSelectsEnterprise();
    loadAndPopulateDependentSelectsPanchayat();
    loadBranchOptions(bankid)

    

    });
</script>

<style>
    .bank-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1;
    }

 .bank-modal .modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    width: 60%;
    position: relative;
}

.bank-modal .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

</style>