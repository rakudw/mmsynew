<form action="your_form_processing_script.php" class="form application-form" method="post">
        <table>
            <tbody>
                <tr>
                    <td class="td-1">
                        <table class="table">
                            <tbody>
                                <tr bgcolor="#D1A476">
                                    <td colspan="6">
                                        <div align="center" class="style1">
                                            <h3>Application For The Approval Under Mukhya Mantri Swavlamban Yojana/मुख्यमंत्री स्वावलंबन योजना के अंतर्गत मंजूरी के लिए आवेदन</h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(A)</th>
                                    <th nowrap=""><strong>Enterprise / उद्यम*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Fill Enterprise Information / उद्यम जानकारी भरें</th>
                                </tr>
                                <tr>
                                    <th>(1)</th>
                                    <th nowrap=""><strong>Name of Proposed Unit:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="name" name="name" required autofocus>
                                        <small>The name of the unit you want to set.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th nowrap="">(2)</th>
                                    <th nowrap=""><strong>Mobile Number of the Owner:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="mobile" name="mobile" required>
                                        <small>Mobile Number of the Owner</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(3)</th>
                                    <th nowrap=""><strong>Type of Activity:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_type_id" name="activity_type_id" required data-changes="activity_id" class="button"
                                            data-options="dbase:enum(id,name)[type:ACTIVITY_TYPE]">
                                            <option value="-1">--Select Activity--</option>
                                            <option value="KV">KVIC</option>
                                            <option value="KB">KVIB</option>
                                            <option value="DI">DIC</option>
                                            <option value="CB">COIR BOARD</option>
                                        </select>
                                        <small>Activity type of the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(4)</th>
                                    <th nowrap=""><strong>Activity of the unit:</strong></th>
                                    <td colspan="4">
                                        <select id="activity_id" name="activity_id" required data-condition="activity_type_id:202,203" class="button"
                                            data-depends="activity_type_id"
                                            data-options="dbase:activity(id,name)[type_id:$activity_type_id]">
                                            <option value="-1">--Select Unit--</option>
                                            <option value="KV">KVIC</option>
                                            <option value="KB">KVIB</option>
                                            <option value="DI">DIC</option>
                                            <option value="CB">COIR BOARD</option>
                                        </select>
                                        <small>Activity of the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(5)</th>
                                    <th nowrap=""><strong>Description of Activity in Brief:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="activity_details" name="activity_details" required
                                            data-condition="activity_type_id:202,203">
                                        <small>Description of the activity to be done by the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(6)</th>
                                    <th nowrap=""><strong>Products to be manufactured:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="products" name="products" required data-condition="activity_type_id:201">
                                        <small>List of all the products to be manufactured by the unit.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(7)</th>
                                    <th nowrap=""><strong>Constitution Type:</strong></th>
                                    <td colspan="4">
                                        <select id="constitution_type_id" name="constitution_type_id" required class="button"
                                            data-options="dbase:enum(id,name)[type:CONSTITUTION_TYPE]">
                                            <option value="-1">--Select Constitution--</option>
                                            <option value="KV">KVIC</option>
                                            <option value="KB">KVIB</option>
                                            <option value="DI">DIC</option>
                                            <option value="CB">COIR BOARD</option>
                                           
                                        </select>
                                        <small> Constitution Type</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(8)</th>
                                    <th nowrap=""><strong>Proposed Employment Generation:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="employment" name="employment" min="1" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(9)</th>
                                    <th nowrap=""><strong>Area Type:</strong></th>
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
                                    <th nowrap=""><strong>Pincode:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="pincode" name="pincode" min="170000" max="179999" required>
                                        <small>Pincode</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(11)</th>
                                    <th nowrap=""><strong>District:</strong></th>
                                    <td colspan="4">
                                        <select id="district_id" name="district_id" class="button" required>
                                        <option value="-1">--Select District--</option>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>District</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(12)</th>
                                    <th nowrap=""><strong>Constituency:</strong></th>
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
                                    <th nowrap=""><strong>Tehsil:</strong></th>
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
                                    <th nowrap=""><strong>Block:</strong></th>
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
                                    <th nowrap=""><strong>Panchayat/Town:</strong></th>
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
                                    <th nowrap=""><strong>House Number/Street/Landmark/Village name:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="address" name="address" required>
                                        <small>House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(B)</th>
                                    <th nowrap=""><strong>Legal Type/कानूनी  प्रकार*
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Enter the details of major partner below / मुख्य साथी की विवरण नीचे दर्ज करें।</th>
                                </tr>
                                <!-- (17) -->
                                <tr>
                                    <th>(17)</th>
                                    <th nowrap=""><strong>Mobile Number:</strong><br><small>Mobile Number of the Owner</small></th>
                                    <td colspan="4">
                                        <input type="tel" id="mobile" name="mobile" pattern="[1-9]{1}[0-9]{9}" required>
                                        <small>Enter Mobile Number</small>
                                    </td>
                                </tr>

                                <!-- (18) -->
                                <tr>
                                    <th>(18)</th>
                                    <th nowrap=""><strong>Email:</strong></th>
                                    <td colspan="4">
                                        <input type="email" id="email" name="email">
                                        <small>Enter Email Address</small>
                                    </td>
                                </tr>

                                <!-- (19) -->
                                <tr>
                                    <th>(19)</th>
                                    <th nowrap=""><strong>Pincode:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="pincode" name="pincode" min="170000" max="179999" required>
                                        <small>Enter Pincode</small>
                                    </td>
                                </tr>

                                <!-- (20) -->
                                <tr>
                                    <th>(20)</th>
                                    <th nowrap=""><strong>District:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="district_id" name="district_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select District</small>
                                    </td>
                                </tr>

                                <!-- (21) -->
                                <tr>
                                    <th>(21)</th>
                                    <th nowrap=""><strong>Constituency:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="constituency_id" name="constituency_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select Constituency</small>
                                    </td>
                                </tr>

                                <!-- (22) -->
                                <tr>
                                    <th>(22)</th>
                                    <th nowrap=""><strong>Tehsil:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="tehsil_id" name="tehsil_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select Tehsil</small>
                                    </td>
                                </tr>

                                <!-- (23) -->
                                <tr>
                                    <th>(23)</th>
                                    <th nowrap=""><strong>Block:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="block_id" name="block_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select Block</small>
                                    </td>
                                </tr>

                                <!-- (24) -->
                                <tr>
                                    <th>(24)</th>
                                    <th nowrap=""><strong>Panchayat/Town:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="panchayat_id" name="panchayat_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select Panchayat/Town</small>
                                    </td>
                                </tr>

                                <!-- (25) -->
                                <tr>
                                    <th>(25)</th>
                                    <th nowrap=""><strong>House Number/Street/Landmark/Village name:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="address" name="address" required>
                                        <small>Enter House Number/Street/Landmark/Village name</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(26)</th>
                                    <th nowrap=""><strong>Aadhaar Number:</strong></th>
                                    <td colspan="4">
                                        <input type="tel" id="aadhaar" name="aadhaar" required pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$">
                                        <small>Enter Aadhaar Number</small>
                                    </td>
                                </tr>

                                <!-- (27) -->
                                <tr>
                                    <th>(27)</th>
                                    <th nowrap=""><strong>PAN Number:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="pan" name="pan" pattern="^([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([a-zA-Z]([0-9]([0-9]([0-9]([0-9]([a-zA-Z])?)?)?)?)?)?)?)?)?)?$">
                                        <small>Enter PAN Number</small>
                                    </td>
                                </tr>

                                <!-- (28) -->
                                <tr>
                                    <th>(28)</th>
                                    <th nowrap=""><strong>Gender:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="gender" name="gender" required data-limit-age="birth_date">
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <small>Select Gender</small>
                                    </td>
                                </tr>

                                <!-- (29) -->
                                <tr>
                                    <th>(29)</th>
                                    <th nowrap=""><strong>Marital Status:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="marital_status" name="marital_status" required>
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
                                    <th>(30)</th>
                                    <th nowrap=""><strong>Spouse's Aadhaar Number:</strong></th>
                                    <td colspan="4">
                                        <input type="tel" id="spouse_aadhaar" name="spouse_aadhaar" required data-condition="marital_status:Married" pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$">
                                        <small>Enter Spouse's Aadhaar Number (if Married)</small>
                                    </td>
                                </tr>

                                <!-- (31) -->
                                <tr>
                                    <th>(31)</th>
                                    <th nowrap=""><strong>Date of Birth:</strong></th>
                                    <td colspan="4">
                                        <input type="date" id="birth_date" name="birth_date" required pattern="\d\d\d\d-(\d)?\d-(\d)?\d" data-age="true" data-datepicker-xformat="yyyy-mm-dd" data-datepicker-xmax-date="-18">
                                        <span id="birth_date_age" class="badge badge-info bg-dark"></span>
                                        <small>Enter Date of Birth</small>
                                    </td>
                                </tr>

                                <!-- (32) -->
                                <tr>
                                    <th>(32)</th>
                                    <th nowrap=""><strong>Specially Abled (दिव्यांग):</strong></th>
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
                                    <th>(33)</th>
                                    <th nowrap=""><strong>Category:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="social_category_id" name="social_category_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Select Category</small>
                                    </td>
                                </tr>

                                <!-- (34) -->
                                <tr>
                                    <th>(34)</th>
                                    <th nowrap=""><strong>Belongs to Minority:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="belongs_to_minority" name="belongs_to_minority" required>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>Do you belong to a Minority?</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(C)</th>
                                    <th nowrap=""><strong>Project Cost / परियोजना की लागतण
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Project Cost / परियोजना की लागतण</th>
                                </tr>
                                <tr>
                                    <th>(34)</th>
                                    <th nowrap=""><strong>Belongs to Minority:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="belongs_to_minority" name="belongs_to_minority" required>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>Belongs to Minority</small>
                                    </td>
                                </tr>

                                <!-- Land Status -->
                                <tr>
                                    <th>(35)</th>
                                    <th nowrap=""><strong>Land Status:</strong></th>
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
                                    <th>(36)</th>
                                    <th nowrap=""><strong>Cost of Land:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="land_cost" name="land_cost" min="0" data-condition="land_status:To be Purchased,To be Taken on Lease" required>
                                        <small>Cost of Land</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(37)</th>
                                    <th nowrap=""><strong>Building Status:</strong></th>
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
                                    <th>(38)</th>
                                    <th nowrap=""><strong>Cost of Building Construction:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="building_cost" name="building_cost" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Cost of Building Construction</small>
                                    </td>
                                </tr>

                                <!-- (39) -->
                                <tr>
                                    <th>(39)</th>
                                    <th nowrap=""><strong>Estimated Buildup Area (in Square Feet):</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="building_area" name="building_area" min="0" data-condition="building_status:To be Constructed,To be Taken on Rent" required>
                                        <small>Estimated Buildup Area (in Square Feet)</small>
                                    </td>
                                </tr>

                                <!-- (40) -->
                                <tr>
                                    <th>(40)</th>
                                    <th nowrap=""><strong>Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets Cost:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="assets_cost" name="assets_cost" min="0" required>
                                        <small>Cost of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small>
                                    </td>
                                </tr>

                                <!-- (41) -->
                                <tr>
                                    <th>(41)</th>
                                    <th nowrap=""><strong>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="assets_detail" name="assets_detail" required>
                                        <small>Details of Furniture, Fixtures, IT related items, Renovation, Interior Work and Other Fixed Assets</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(42)</th>
                                    <th nowrap=""><strong>Machinery/Equipments Cost:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="machinery_cost" name="machinery_cost" min="0" required>
                                        <small>Machinery/Equipments Cost</small>
                                    </td>
                                </tr>

                                <!-- (43) -->
                                <tr>
                                    <th>(43)</th>
                                    <th nowrap=""><strong>Working Capital/CC Limit:</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="working_capital" name="working_capital" min="0" required>
                                        <small>Working Capital/CC Limit</small>
                                    </td>
                                </tr>

                                <!-- (44) -->
                                <tr>
                                    <th>(44)</th>
                                    <th nowrap=""><strong>Details of Machinery/Equipments:</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="machinery_detail" name="machinery_detail" required>
                                        <small>Details of Machinery/Equipments</small>
                                    </td>
                                </tr>

                                <!-- (45) -->
                                <tr>
                                    <th>(45)</th>
                                    <th nowrap=""><strong>Total Project Cost (Calculated):</strong></th>
                                    <td colspan="4">
                                        <input type="text" id="project_cost" name="project_cost" readonly required data-calculate="">
                                        <small>Total Project Cost (Calculated)</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(D)</th>
                                    <th nowrap=""><strong>Means of Finance / वित्त प्राधिकृति
                                            <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                            <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                    </strong></th>
                                    <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                    Means of Finance / वित्त प्राधिकृति</th>
                                </tr>
                                <tr>
                                    <th>(46)</th>
                                    <th nowrap=""><strong>Own Contribution Percentage (% of Capital Expenditure):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution" name="own_contribution" min="10" max="95" step="any" required autofocus>
                                        <small>Should be at least 10%.</small>
                                    </td>
                                </tr>

                                <!-- (47) -->
                                <tr>
                                    <th>(47)</th>
                                    <th nowrap=""><strong>Own Contribution Amount (Readonly):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="own_contribution_amount" name="own_contribution_amount" min="0" required readonly>
                                        <small>Own Contribution Amount</small>
                                    </td>
                                </tr>

                                <!-- (48) -->
                                <tr>
                                    <th>(48)</th>
                                    <th nowrap=""><strong>Term Loan (Readonly):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="term_loan" name="term_loan" min="0" required readonly>
                                        <small>Term Loan</small>
                                    </td>
                                </tr>

                                <!-- (49) -->
                                <tr>
                                    <th>(49)</th>
                                    <th nowrap=""><strong>CC Limit (Disabled):</strong></th>
                                    <td colspan="4">
                                        <input type="number" id="cc_limit" name="cc_limit" min="0" disabled required>
                                        <small>CC Limit</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>(50)</th>
                                    <th nowrap=""><strong>Name of the Loan Financing Bank:</strong></th>
                                    <td colspan="4">
                                        <select class="button" id="bank_branch_id" name="bank_branch_id" required>
                                            <!-- Populate options dynamically using JavaScript or your backend -->
                                        </select>
                                        <small>Name of the bank from which the applicant wants to get the loan. Select the bank by searching for IFS code, branch, or bank name.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                                        <td>
                                            <table class="CSSTableGenerator">
                                                <tbody>
                                                <tr bgcolor="#D1A476">
                        <td colspan="2"><h3 align="center" class="style1"> Guidelines for Filling the Online PMEGP Application /
                            ऑनलाइन पीएमईजीपी  आवेदन भरने हेतु दिशानिर्देश
                            </h3></td>
                        </tr>
                        <tr>
                        <td>(1)</td>
                        <td><strong>Aadhaar Number/आधार  नंबर</strong> : 12 digit Aadhar number of the applicant should be filled in./आधार  नंबर: आवेदन को 12 अंकों का आधार नंबर भरना चाहिए </td>
                        </tr>
                        <tr>
                        <td>(A)</td>
                        <td>The EID is displayed on the top of your enrolment/update acknowledgement slip and contains 14 digit enrolment number (1234/12345/12345) and the 14 digit date and time (yyyy/mm/dd hh:mm:ss) of enrolment. These 28 digits together form your Enrolment ID (EID)./
                        <strong>    ईआईडी आपके नामांकन/अपडेट पावती पर्ची के शीर्ष पर प्रदर्शित होता है और इसमें 14 अंकों की नामांकन संख्या (1234/12345/12345) और नामांकन की 14 अंकों की तारीख और समय (yyyy/mm/dd hh:mm:ss) होता है। ये 28 अंक मिलकर आपकी नामांकन आईडी (ईआईडी) बनाते हैं।	 </strong>
                        </td>
                        </tr>
                        <tr>
                        <td>(2)</td>
                        <td><strong>Name of Applicant/आवेदक  का नाम : (i) </strong>Select prefix of name from the list/सूची  से नाम का सम्बोधन चुने, (ii) The applicant should fill his/her name exactly as it appears in the Aadhaar Card. In case of any mismatch in the name entered, the applicant will not be able to fill the form further/आवेदक  को अपना नाम ठीक उसी तरह भरना चाहिए जैसे आधार कार्ड मे दर्ज किया गया है | दर्ज किए गए नाम मेँ किसी भी प्रकार  से बेमेल होने के मामले में,आवेदक आगे फॉर्म नहीं भर पाएगा |. </td>
                        </tr>
                        <tr>
                        <td>(3) </td>
                        <td><p><strong>Sponsoring Agency</strong>/प्रायोजक  एजेंसी :  Select Agency  (KVIC, KVIB, DIC) in which you want to submit the application form/उस एजेंसी (KVIC, KVIB, DIC) का चयन करें, जिसमें आप आवेदन पत्र जमा करना चाहते हैं |. </p></td>
                        </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Add any submit button or additional form elements here -->
    </form>