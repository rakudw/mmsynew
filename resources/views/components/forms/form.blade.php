<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<form class="form application-form" action="/application/save-data/" method="POST" id="applicant-form">
    @csrf
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
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(A)</th>
                                    <th class="section-heading" ><strong>Enterprise / उद्यम*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Fill Enterprise Information / उद्यम जानकारी भरें</th>
                                </tr>
                                <tr>
                                    <th>(1)</th>
                                    <th ><strong>Name of Proposed Unit / प्रस्तावित इकाई का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="name" name="name" required autofocus>
                                        <small>The name of the unit you want to set.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th >(2)</th>
                                    <th ><strong>Mobile Number of the Owner /इकाई के मालिक का मोबाइल नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="mobile" name="mobile" required>
                                        <small>Mobile Number of the Owner</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(3)</th>
                                    <th ><strong>Type of Activity / गतिविधि का प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_type_id" name="activity_type_id" required data-changes="activity_id" class="button"
                                            data-options="dbase:enum(id,name)[type:ACTIVITY_TYPE]">
                                            <option value="-1">--Select Activity--</option>
                                            @foreach($activities as $activity)
                                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Activity type of the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(4)</th>
                                    <th ><strong>Activity of the unit / इकाई की गतिविधि:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_id" name="activity_id" required data-condition="activity_type_id:202,203" class="button"
                                            data-depends="activity_type_id"
                                            data-options="dbase:activity(id,name)[type_id:$activity_type_id]">
                                            <option value="-1">--Select Unit--</option>
                                        </select>
                                        <small>Activity of the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(5)</th>
                                    <th ><strong>Description of Activity in Brief /संक्षेप में गतिविधि का विवरण :</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="activity_details" name="activity_details" required
                                            data-condition="activity_type_id:202,203">
                                        <small>Description of the activity to be done by the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(6)</th>
                                    <th ><strong>Products to be manufactured / उत्पाद जो निर्मित किए जाने हैं:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="products" name="products" required data-condition="activity_type_id:201">
                                        <small>List of all the products to be manufactured by the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(7)</th>
                                    <th ><strong>Constitution Type / संविधान प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="constitution_type_id" name="constitution_type_id" required class="button"
                                            data-options="dbase:enum(id,name)[type:CONSTITUTION_TYPE]">
                                            <option value="-1">--Select Constitution--</option>
                                            @foreach($cons as $con)
                                                <option value="{{ $con->id }}">{{ $con->name }}</option>
                                            @endforeach
                                        </select>
                                        <small> Constitution Type</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(8)</th>
                                    <th ><strong>Proposed Employment Generation / प्रस्तावित रोजगार उत्पन्न:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="employment" name="employment" min="1" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(9)</th>
                                    <th class="section-heading" ><strong>Unit Address / इकाई का पता
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Fill Unit Address / इकाई का पता भरें</th>
                                </tr>
                                <tr>
                                    <th>(9)</th>
                                    <th ><strong>Area Type / क्षेत्र प्रकार:</strong></th>
                                    <td colspan="4">
                                        <select id="area_type" name="area_type" class="button" required>
                                            <option value="-1">--Select Area--</option>
                                            <option value="Rural">Rural</option>
                                            <option value="Urban">Urban</option>
                                        </select>
                                        <small>Area Type</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(10)</th>
                                    <th ><strong>Pincode / पिनकोड:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="pincode" name="pincode" min="170000" max="179999" required>
                                        <small>Pincode</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(11)</th>
                                    <th ><strong>District / जिला:</strong></th>
                                    <td colspan="4">
                                        <select id="district_id" name="district_id" class="button" required>
                                        <option value="-1">--Select District--</option>
                                            @foreach($diss as $dis)
                                                <option value="{{ $dis->id }}">{{ $dis->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>District</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(12)</th>
                                    <th ><strong>Constituency / संसदीय क्षेत्र:</strong></th>
                                    <td colspan="4">
                                        <select id="constituency_id" name="constituency_id" class="button" required>
                                        <option value="-1">--Select Constituency--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Constituency</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(13)</th>
                                    <th ><strong>Tehsil / तहसील:</strong></th>
                                    <td colspan="4">
                                        <select id="tehsil_id" name="tehsil_id" class="button" required>
                                        <option value="-1">--Select Tehsil--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Tehsil</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(14)</th>
                                    <th ><strong>Block / ब्लॉक:</strong></th>
                                    <td colspan="4">
                                        <select id="block_id" name="block_id" class="button" required>
                                        <option value="-1">--Select Block--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Block</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(15)</th>
                                    <th ><strong>Panchayat/Town / पंचायत/नगर:</strong></th>
                                    <td colspan="4">
                                        <select id="panchayat_id" name="panchayat_id" class="button" required>
                                        <option value="-1">--Select Panchayat/Town--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Panchayat/Town</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(16)</th>
                                    <th ><strong>House Number/Street/Landmark/Village name /घर क्रमांक/सड़क/सूचना/गांव का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="address" name="address" required>
                                        <small>House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="section-heading">(B)</th>
                                    <th class="section-heading" ><strong>Legal Type/कानूनी  प्रकार*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Enter the details of major partner below / मुख्य साथी की विवरण नीचे दर्ज करें।</th>
                                </tr>
                                <!-- (17) -->
                                <tr>
                                    <th>(17)</th>
                                    <th ><strong>Name of Owner / मालिक का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="name" name="owner_name" required autofocus>
                                        <small>Name of Owner.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(18)</th>
                                    <th ><strong>Father/Husband/Mother Name /प्रतिरक्षक/माता-पिता/पति-पत्नी नाम:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="guardian_prefix" name="guardian_prefix" required>
                                            <option value="-1">--Select guardian/parent/spouse.--</option>
                                                <option value="S/O">S/O</option>
                                                <option value="W/O">W/O</option>
                                                <option value="D/O">D/O</option>
                                                <option value="C/O">C/O</option>
                                        </select>
                                        <input  type="text" name="guardian" required="required" autofocus="autofocus" data-prefix="S/O,W/O,D/O,C/O">
                                        <small>Name of the guardian/parent/spouse.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(19)</th>
                                    <th ><strong>Mobile Number / मोबाइल नंबर:</strong><br><small>Mobile Number of the Owner</small></th>
                                    <td colspan="4">
                                        <input type="tel" id="owner_mobile" name="owner_mobile" pattern="[1-9]{1}[0-9]{9}" required>
                                        <small>Enter Mobile Number</small>
                                    </td>
                                </tr>

                                <!-- (18) -->
                                <tr>
                                    <th>(20)</th>
                                    <th ><strong>Email / ईमेल:</strong></th>
                                    <td colspan="4">
                                        <input type="email" id="owner_email" name="owner_email">
                                        <small>Enter Email Address</small>
                                    </td>
                                </tr>

                                <!-- (19) -->
                                <tr>
                                    <th>(21)</th>
                                    <th ><strong>Pincode / पिनकोड:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="owner_pincode" name="owner_pincode" min="170000" max="179999" required>
                                        <small>Enter Pincode</small>
                                    </td>
                                </tr>

                                <!-- (20) -->
                                <tr>
                                    <th>(22)</th>
                                    <th ><strong>District / जिला:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_district_id" name="owner_district_id" required>
                                            <option value="-1">--Select District--</option>
                                            @foreach($diss as $dis)
                                                <option value="{{ $dis->id }}">{{ $dis->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select District</small>
                                    </td>
                                </tr>

                                <!-- (21) -->
                                <tr>
                                    <th>(23)</th>
                                    <th ><strong>Constituency / संसदीय क्षेत्र:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_constituency_id" name="owner_constituency_id" required>
                                        <option value="-1">--Select Constituency--</option>
                                        </select>
                                        <small>Select Constituency</small>
                                    </td>
                                </tr>

                                <!-- (22) -->
                                <tr>
                                    <th>(24)</th>
                                    <th ><strong>Tehsil / तहसील:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_tehsil_id" name="owner_tehsil_id" required>
                                        <option value="-1">--Select Tehsil--</option>
                                        </select>
                                        <small>Select Tehsil</small>
                                    </td>
                                </tr>

                                <!-- (23) -->
                                <tr>
                                    <th>(25)</th>
                                    <th ><strong>Block / ब्लॉक:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_block_id" name="owner_block_id" required>
                                        <option value="-1">--Select Block--</option>
                                        </select>
                                        <small>Select Block</small>
                                    </td>
                                </tr>

                                <!-- (24) -->
                                <tr>
                                    <th>(26)</th>
                                    <th ><strong>Panchayat/Town / पंचायत/नगर :</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="owner_panchayat_id" name="owner_panchayat_id" required>
                                        <option value="-1">--Select Panchayat/Town--</option>
                                        </select>
                                        <small>Select Panchayat/Town</small>
                                    </td>
                                </tr>

                                <!-- (25) -->
                                <tr>
                                    <th>(27)</th>
                                    <th ><strong>House Number/Street/Landmark/Village name /घर क्रमांक/सड़क/सूचना/गांव का नाम:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="owner_address" name="address" required>
                                        <small>Enter House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(28)</th>
                                    <th ><strong>Aadhaar Number / आधार नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="tel" id="aadhaar" name="aadhaar" required pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$">
                                        <small>Enter Aadhaar Number</small>
                                    </td>
                                </tr>

                                <!-- (27) -->
                                <tr>
                                    <th>(29)</th>
                                    <th ><strong>PAN Number / न नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="pan" name="pan" pattern="^([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([0-9]([0-9]([0-9]([0-9]([a-zA-Z])?)?)?)?)?)?)?)?)?)?$">
                                        <small>Enter PAN Number</small>
                                    </td>
                                </tr>

                                <!-- (28) -->
                                <tr>
                                    <th>(30)</th>
                                    <th ><strong>Gender / लिंग:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="gender" name="gender" required data-limit-age="birth_date">
                                            <option value="-1">--Select Gender--</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <small>Select Gender</small>
                                    </td>
                                </tr>

                                <!-- (29) -->
                                <tr>
                                    <th>(31)</th>
                                    <th ><strong>Marital Status / वैवाहिक स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="marital_status" name="marital_status" required>
                                            <option value="-1">--Select Marital Status--</option>
                                            <option value="Unmarried">Unmarried</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                        <small>Select Marital Status</small>
                                    </td>
                                </tr>

                                <!-- (30) -->
                                <tr>
                                    <th>(32)</th>
                                    <th ><strong>Spouse's Aadhaar Number / पति/पत्नी का आधार नंबर:</strong></th>
                                    <td colspan="4">
                                        <input type="tel" id="spouse_aadhaar" name="spouse_aadhaar" required data-condition="marital_status:Married" pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$">
                                        <small>Enter Spouse's Aadhaar Number (if Married)</small>
                                    </td>
                                </tr>

                                <!-- (31) -->
                                <tr>
                                    <th>(33)</th>
                                    <th ><strong>Date of Birth / जन्म तिथि:</strong></th>
                                    <td colspan="4">
                                        <input type="date" id="birth_date" name="birth_date" required pattern="\d\d\d\d-(\d)?\d-(\d)?\d" data-age="true" data-datepicker-xformat="yyyy-mm-dd" data-datepicker-xmax-date="-18">
                                        <span id="birth_date_age" class="badge badge-info bg-dark"></span>
                                        <small>Enter Date of Birth</small>
                                    </td>
                                </tr>

                                <!-- (32) -->
                                <tr>
                                    <th>(34)</th>
                                    <th ><strong>Specially Abled (दिव्यांग):</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="is_specially_abled" name="is_specially_abled" required>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>Are you Specially Abled?</small>
                                    </td>
                                </tr>

                                <!-- (33) -->
                                <tr>
                                    <th>(35)</th>
                                    <th ><strong>Category / श्रेणी:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="social_category_id" name="social_category_id" required>
                                            <option value="-1">--Select Category--</option>
                                        @foreach($cats as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select Category</small>
                                    </td>
                                </tr>

                                <!-- (34) -->
                                <tr>
                                    <th>(36)</th>
                                    <th ><strong>Belongs to Minority / अल्पसंख्यक है ?:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="belongs_to_minority" name="belongs_to_minority" required>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>Do you belong to a Minority?</small>
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
                                    <th>(37)</th>
                                    <th width="300" ><strong>Land Status / भूमि की स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="land_status" name="land_status" required>
                                            <option value="Not Required">Not Required</option>
                                            <option value="Owned">Owned</option>
                                            <option value="To be Purchased">To be Purchased</option>
                                            <option value="To be Taken on Lease">To be Taken on Lease</option>
                                        </select>
                                        <small>Land Status</small>
                                    </td>
                                </tr>

                                <!-- Cost of Land -->
                                <tr>
                                    <th>(38)</th>
                                    <th ><strong>Cost of Land / भूमि का लागत:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="land_cost" name="land_cost" min="0" data-condition="land_status:To be Purchased,To be Taken on Lease" required>
                                        <small>Cost of Land</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(39)</th>
                                    <th ><strong>Building Status / इमारत की स्थिति:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="building_status" name="building_status" required>
                                            <option value="Already Constructed">Already Constructed</option>
                                            <option value="Not Required">Not Required</option>
                                            <option value="To be Constructed">To be Constructed</option>
                                            <option value="To be Taken on Rent">To be Taken on Rent</option>
                                        </select>
                                        <small>Building Status</small>
                                    </td>
                                </tr>

                                <!-- (38) -->
                                <tr>
                                    <th>(40)</th>
                                    <th ><strong>Cost of Building Construction / इमारत निर्माण की लागत:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="building_cost" name="building_cost" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Cost of Building Construction</small>
                                    </td>
                                </tr>

                                <!-- (39) -->
                                <tr>
                                    <th>(41)</th>
                                    <th ><strong>Estimated Buildup Area (in Square Feet) पूर्वानुमानित बिल्डअप क्षेत्र (वर्ग फीट में)" :</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="building_area" name="building_area" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Estimated Buildup Area (in Square Feet)</small>
                                    </td>
                                </tr>

                                <!-- (40) -->
                                <tr>
                                    <th>(42)</th>
                                    <th ><strong>Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets Cost:</strong></th>
                                    <td colspan="4">
                                        <input  value="{{ old('assets_cost') }}" type="number" id="assets_cost" name="assets_cost" min="0" required>
                                        <small>Cost of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small>
                                    </td>
                                </tr>

                                <!-- (41) -->
                                <tr>
                                    <th>(43)</th>
                                    <th ><strong>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets:</strong></th>
                                    <td colspan="4">
                                        <input value="{{ old('assets_detail') }}" type="text" id="assets_detail" name="assets_detail" required>
                                        <small>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(44)</th>
                                    <th ><strong>Machinery/Equipments Cost / मशीनरी/उपकरण की लागत:</strong></th>
                                    <td colspan="4">
                                        <input  value="{{ old('machinery_cost') }}" type="number" id="machinery_cost" name="machinery_cost" min="0" required>
                                        <small>Machinery/Equipments Cost</small>
                                    </td>
                                </tr>

                                <!-- (43) -->
                                <tr>
                                    <th>(45)</th>
                                    <th ><strong>Working Capital/CC Limit / कामकाज पूंजी/क्रेडिट लिमिट:</strong></th>
                                    <td colspan="4">
                                        <input  type="number" id="working_capital" name="working_capital" min="0"  value="{{ old('working_capital') }}" required>
                                        <small>Working Capital/CC Limit</small>
                                    </td>
                                </tr>

                                <!-- (44) -->
                                <tr>
                                    <th>(46)</th>
                                    <th ><strong>Details of Machinery/Equipments / मशीनरी/उपकरण का विवरण:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="machinery_detail" name="machinery_detail" value="{{ old('machinery_detail') }}" required>
                                        <small>Details of Machinery/Equipments</small>
                                    </td>
                                </tr>

                                <!-- (45) -->
                                <tr>
                                    <th>(47)</th>
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
                                    <th>(48)</th>
                                    <th  ><strong>Own Contribution Percentage (10% of Capital Expenditure) / स्वयं सहायता प्रतिशत (पूंजी व्यय का 10%):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution" name="own_contribution" value="{{ old('own_contribution') }}" min="10" max="95" step="any" required autofocus>
                                        <small>Should be at least 10%.</small>
                                    </td>
                                </tr>

                                <!-- (47) -->
                                <tr>
                                    <th>(49)</th>
                                    <th ><strong>Own Contribution Amount (Readonly) / स्वयं सहायता राशि (केवल पठनीय):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution_amount" name="own_contribution_amount" min="0" required readonly>
                                        <small>Own Contribution Amount</small>
                                    </td>
                                </tr>

                                <!-- (48) -->
                                <tr>
                                    <th>(50)</th>
                                    <th ><strong>Term Loan (Readonly) / क़र्ज़ अवधि (केवल पठनीय):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="term_loan" name="term_loan" min="0" required readonly>
                                        <small>Term Loan</small>
                                    </td>
                                </tr>

                                <!-- (49) -->
                                <tr>
                                    <th width="50">(51)</th>
                                    <th ><strong>CC Limit (Disabled) / सीसी सीमा (अक्षम):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="cc_limit" name="cc_limit" min="0" disabled required>
                                        <small>CC Limit</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(52)</th>
                                    <th ><strong>Name of the Loan Financing Bank / ऋण वित्तपोषण बैंक का नाम:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="bank_id" name="bank_id" required>
                                            <option value="-1">--Select Bank--</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                        <small>Select name of the bank from which the applicant wants to get the loan.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(53)</th>
                                    <th ><strong>Name of the Loan Financing Branch / ऋण वित्तपोषण शाखा का नाम:</strong></th>
                                    <td colspan="4">
                                        <select class="button select2" id="bank_branch_id" name="bank_branch_id" required>
                                            <option value="-1">--Select Branch--</option>
                                        </select>
                                        <small>Name of the bank from which the applicant wants to get the loan. Select the bank by searching for IFS code, branch, or bank name.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input  type="button" class="button" id="submit-button" value="Save Applicant Data">
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
                        <td><strong>Name of Proposed Unit/प्रस्तावित इकाई का नाम:</strong> : Please type the name of your unit in this field./कृपया इस क्षेत्र में अपनी इकाई का नाम टाइप करें</td>
                        </tr>
                        <tr>
                        <td >(2)</td>
                        <td><strong>Mobile Number of the Owner/मालिक का मोबाइल नंबर::</strong> : Please type mobile number of unit's owner here./कृपया इस इकाई के मालिक का मोबाइल नंबर यहाँ टाइप करें</td>
                        </tr>
                        <tr>
                            <td>(3)</td>
                            <td><strong>Type of Activity / गतिविधि का प्रकार:</strong> : Please select the type of activity for your unit from the options provided./कृपया प्रदान किए गए विकल्पों से अपनी इकाई के लिए गतिविधि का प्रकार चुनें</td>
                        </tr>
                        <tr>
                            <td>(4)</td>
                            <td><strong>Activity of the unit / इकाई की गतिविधि:</strong> :Please select the specific activity for your unit from the options provided. कृपया प्रदान किए गए विकल्पों से अपनी इकाई के लिए विशेष गतिविधि का चयन करें।</td>
                        </tr>
                        <tr>
                            <td>(5)</td>
                            <td><strong>Description of Activity in Brief / गतिविधि का संक्षेप में विवरण:</strong>:Please provide a brief description of the activity that your unit will be engaged in. कृपया बताएं कि आपकी इकाई किस गतिविधि में लगी होगी, इसका संक्षेप में विवरण दें।</td>
                        </tr>
                        <tr>
                            <td>(6)</td>
                            <td><strong>Products to be manufactured / निर्मित किए जाने वाले उत्पाद:</strong>:Please provide a list of all the products that your unit will manufacture. कृपया बताएं कि आपकी इकाई किन-किन उत्पादों का निर्माण करेगी।</td>
                        </tr>
                        <tr>
                            <td>(7)</td>
                            <td><strong>Constitution Type / संविधान प्रकार:</strong>:Please select the type of constitution for your unit from the options provided. कृपया प्रदान किए गए विकल्पों से अपनी इकाई के लिए संविधान प्रकार का चयन करें।</td>
                        </tr>
                        <tr>
                            <td>(8)</td>
                            <td><strong>Proposed Employment Generation / प्रस्तावित रोजगार सृजन:</strong>:Please enter the number of employment opportunities that your unit is expected to generate. कृपया दर्ज करें कि आपकी इकाई से कितने रोजगार के अवसर उत्पन्न होने की उम्मीद है।</td>
                        </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Add any submit button or additional form elements here -->
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

            // Load options based on the selected activity type ID
            console.log('dadsa',selectedActivityTypeId)
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
                        data.forEach(function(option) {
                            activitySelect.append($('<option>', {
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
        function loadPanchayatOptions(selectedBlockTypeId) {
            // Clear existing options
            panchayatSelect.empty();

            // Add a default option
            panchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));

            // Load options based on the selected activity type ID
            console.log('dadsa',selectedBlockTypeId)
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

            // Load options based on the selected activity type ID
            console.log('dadsa',selectedBankTypeId)
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
                        data.forEach(function(option) {
                            branchSelect.append($('<option>', {
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
        function loadownerPanchayatOptions(ownerselectedBlockTypeId) {
            // Clear existing options
            ownerpanchayatSelect.empty();

            // Add a default option
            ownerpanchayatSelect.append($('<option>', {
                value: '-1',
                text: '--Select Panchayat--'
            }));

            // Load options based on the selected activity type ID
            console.log('dadsa',ownerselectedBlockTypeId)
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
            branchSelect.append($option);
        });
        
        // After adding the options, trigger the Select2 update
        branchSelect.trigger('change');
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
            console.log('dadsa',selectedDistrictTypeId)
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
                        var teh = data.cons
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
            console.log('dadsa',ownerselectedDistrictTypeId)
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
                        var teh = data.cons
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
            loadBranchOptions(selectedBankTypeId);
        });
        ownerdistrictTypeSelect.on('change', function() {
            const ownerselectedDistrictTypeId = $(this).val();
            loadownerConOptions(ownerselectedDistrictTypeId);
        });
        ownerblockTypeSelect.on('change', function() {
            const ownerselectedBlockTypeId = $(this).val();
            loadownerPanchayatOptions(ownerselectedBlockTypeId);
        });

        // Trigger the change event on page load if a value is pre-selected
        const preSelectedActivityTypeId = activityTypeSelect.val();
        if (preSelectedActivityTypeId) {
            loadActivityOptions(preSelectedActivityTypeId);
        }


    });
</script>


