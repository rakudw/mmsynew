<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<?php
function getRegionNameFromId($typeId, $id) {
    $name = DB::table('regions')
        ->where('type_id', $typeId)
        ->where('id', $id)
        ->value('name');

    if ($name === null) {
        Log::error("No region found with type_id: $typeId and id: $id");
    }

    return $name;
}

function getNameFromId($table, $id, $nameColumn = 'name') {
    $name = DB::table($table)
        ->where('id', $id)
        ->value($nameColumn);

    if ($name === null) {
        Log::error("No record found in $table with id: $id");
    }

    return $name;
}
?>
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
                                            <h5>Your application ({{$application->name}}) has been created successfully. Please note the application number ({{ $application->id }}) for reference. You can now proceed with the documentation process</h5>
                                        </div>
                                        <div align="center" class="style1">
                                            <h5>आपका आवेदन ({{$application->name}}) सफलतापूर्वक बनाया गया है। संदर्भ के लिए कृपया आवेदन संख्या ({{ $application->id }}) का ध्यान रखें। अब आप दस्तावेज़ीकरण प्रक्रिया के साथ आगे बढ़ सकते हैं।</h5>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Applicant ID:</th>
                                    <td>MMSY-{{ $application->id }}</td>
                                    <th>Applicant Name:</th>
                                    <td>{{ $application->data->owner->name }}</td>
                                    <th>Pan No:</th>
                                    <td>{{ $application->data->owner->pan }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth:</th>
                                    <td>{{ $application->data->owner->birth_date }}</td>
                                    <th>Mobile No:</th>
                                    <td>{{ $application->data->owner->mobile }}</td>
                                    <th>Gender:</th>
                                    <td>{{ $application->data->owner->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Industry Type:</th>
                                    <td>{{ $application->data->enterprise->activity_type_id }}</td>
                                    <th>Aadhar No:</th>
                                    <td>{{ $application->data->owner->aadhaar }}</td>
                                    <th>Project Cost:</th>
                                    <td>{{ $application->getProjectCostAttribute() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                    </td>
                                </tr>
                                <tr bgcolor="#E36E2C">
                                    <td colspan="6">
                                        <div align="center" class="style1">
                                            <h6>Upload Documents</h6>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $order = [1,2,3,9,5,4,6,7,8,10,11,12];
                                    $doctype = collect($doctype)->sortBy(function($doc) use ($order) {
                                    return array_search($doc->id, $order);
                                });
                            @endphp
                            @foreach($doctype as $doc)
                                    <tr>
                                        <th>{{$doc->id}}</th>
                                        <th>
                                            <strong id="{{$doc->id}}">
                                            {{$doc->name}} @if($doc->isRequired) <span style="color:red;">* (Required)</span> @endif
                                            </strong></br>
                                            @if($doc->id == 4)
                                                <p style="padding-top:5px; color: red; font-size: 15px !important">Please <a href="/application/project-report/{{$application->id}}"> Download the linked file here</a>, sign and upload the scanned PDF.</p>
                                            @endif
                                        </th>
                                        <td colspan="6" style="display: flex; justify-content: end;">
                                            <form action="{{ route('application.upload', ['application' => $application ,'documentType' => $doc->id]) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="newDoc">
                                                <input type="hidden" name="doc_id" value="{{ $doc->id }}">
                                                @php
                                                    $uploadedDocument = $application->applicationDocuments()->where('document_type_id', $doc->id)->first();
                                                @endphp
                                                @if ($uploadedDocument)
                                                    <span class="text-success">Document already uploaded</span>
                                                    <a class="btn btn-sm btn-success" target="_blank"
                                                    href="{{ route('application.document', ['document' => $uploadedDocument->document_id]) }}">View</a>
                                                    <a class="btn btn-sm btn-danger" data-confirm="true" data-confirm-title="Are you sure you want to delete the document?"
                                                    href="{{ route('application.document-remove', ['application' => $application->id, 'document' => $uploadedDocument->document_id]) }}?type='newDoc'">Remove Document</a>
                                                    @else
                                                        @if($doc->id == 4)
                                                        <p style="padding-top: 15px"></p>
                                                        @endif
                                                        @if($doc->id == 7)
                                                            <input type="file" name="file" @if ($application->data->owner->social_category_id == '602' || $application->data->owner->social_category_id == '603') {{'required'}} @endif>
                                                        @elseif($doc->id == 9)
                                                            <input type="file" name="file" id="{{$doc->id}}">
                                                        @else
                                                            <input type="file" name="file" id="{{$doc->id}}" @if($doc->isRequired) required @endif>
                                                        @endif
                                                        <button class="btn btn-sm btn-primary" type="submit">Upload</button>
                                                        <span id="upload-message"></span>
                                                    @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                    <tr >
                                        <td colspan="3">
                                            <div align="right" class="style1">
                                                <form action="{{ route('application.submit', ['application' => $application]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="newDoc"/>
                                                    <button class="btn btn-primary" type="button" id="previewButton" >Preview</button>
                                                    <button class="btn btn-success" type="submit" id="finalSubmissionButton" disabled>Final Submission</button>
                                                    <!-- <a class="btn btn-primary "style="margin-left: 5px;" 
                                                    href="{{ route('application.details', ['application' => $application->id]) }}"
                                                    download="Application-Details-{{ $application->id }}.pdf"><em class="fa fa-download"></em> Print / Download</a> -->
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade modal-lg" id="applicationModal" style="z-index: 9999999;" tabindex="-1" aria-labelledby="applicationModalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicationModalLabel">Application Data</h5>
                    <!-- <a class="btn btn-primary text-white btn-sm"style="margin-left: 30px;" 
                                href="{{ route('application.details', ['application' => $application->id]) }}"
                                download="Application-Details-{{ $application->id }}.pdf"><em class="fa fa-download"></em> Print / Download</a> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Application data table -->
                    <table class="table">
                          <!-- Owner Section -->
                          <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Owner Section</strong></td>
                        </tr>
                        <tr>
                            <td><strong>PAN:</strong></td>
                            <td>{{ $application->data->owner->pan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $application->data->owner->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $application->data->owner->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Gender:</strong></td>
                            <td>{{ $application->data->owner->gender }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mobile:</strong></td>
                            <td>{{ $application->data->owner->mobile }}</td>
                        </tr>
                        <tr>
                            <td><strong>Aadhaar:</strong></td>
                            <td>{{ $application->data->owner->aadhaar }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $application->data->owner->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pincode:</strong></td>
                            <td>{{ $application->data->owner->pincode }}</td>
                        </tr>
                        <tr>
                            <td><strong>Block:</strong></td>
                            <td>{{ getRegionNameFromId(407, $application->data->owner->block_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Guardian:</strong></td>
                            <td>{{ $application->data->owner->guardian }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tehsil:</strong></td>
                            <td>{{ getRegionNameFromId(406, $application->data->owner->tehsil_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Birth Date:</strong></td>
                            <td>{{ $application->data->owner->birth_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>District:</strong></td>
                            <td>{{ getRegionNameFromId(404, $application->data->owner->district_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Panchayat:</strong></td>
                            <td>{{ getRegionNameFromId(408, $application->data->owner->panchayat_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Social Category:</strong></td>
                            <td>{{ getNameFromId('enums', $application->data->owner->social_category_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Belongs to Minority:</strong></td>
                            <td>{{ $application->data->owner->belongs_to_minority }}</td>
                        </tr>
                        {{-- <tr>
                            <td><strong>Spouse Aadhaar:</strong></td>
                            <td>{{ $application->data->owner->spouse_aadhaar }}</td>
                        </tr> --}}
                        <tr>
                            <td><strong>Constituency:</strong></td>
                              <td>{{ getRegionNameFromId(405, $application->data->owner->constituency_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Guardian Prefix:</strong></td>
                            <td>{{ $application->data->owner->guardian_prefix }}</td>
                        </tr>
                        <tr>
                            <td><strong>Is Specially Abled:</strong></td>
                            <td>{{ $application->data->owner->is_specially_abled }}</td>
                        </tr>
                       
                        
                        <!-- Enterprise Section -->
                        <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Enterprise Section</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $application->data->enterprise->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $application->data->enterprise->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pincode:</strong></td>
                            <td>{{ $application->data->enterprise->pincode }}</td>
                        </tr>
                         <tr>
                            <td><strong>Block:</strong></td>
                            <td>{{ getRegionNameFromId(407, $application->data->enterprise->block_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Area Type:</strong></td>
                            <td>{{ $application->data->enterprise->area_type }}</td>
                        </tr>
                            <tr>
                            <td><strong>Tehsil:</strong></td>
                            <td>{{ getRegionNameFromId(406, $application->data->enterprise->tehsil_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Employment:</strong></td>
                            <td>{{ $application->data->enterprise->employment }}</td>
                        </tr>
                        <tr>
                            <td><strong>Activity:</strong></td>
                            <td>{{ getNameFromId('activities', $application->data->enterprise->activity_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>District:</strong></td>
                            <td>{{ getRegionNameFromId(404, $application->data->enterprise->district_id) }}</td>
                        </tr>
                         <tr>
                            <td><strong>Panchayat:</strong></td>
                            <td>{{ getRegionNameFromId(408, $application->data->enterprise->panchayat_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Constituency:</strong></td>
                              <td>{{ getRegionNameFromId(405, $application->data->enterprise->constituency_id) }}</td>
                        </tr>
                        @if(isset($application->data->enterprise->activity_details))
                            <tr>
                                <td><strong>Activity Details:</strong></td>
                                <td>{{ $application->data->enterprise->activity_details }}</td>
                            </tr>
                        @endif
                        @if(isset($application->data->enterprise->products))
                            <tr>
                                <td><strong>Product Details:</strong></td>
                                <td>{{ $application->data->enterprise->products }}</td>
                            </tr>
                        @endif
                        <!-- Cost Section -->
                        <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Cost Section</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Land Cost:</strong></td>
                            <td>{{ $application->data->cost->land_cost }}</td>
                        </tr>
                        <tr>
                            <td><strong>Assets Cost:</strong></td>
                            <td>{{ $application->data->cost->assets_cost }}</td>
                        </tr>
                        <tr>
                            <td><strong>Land Status:</strong></td>
                            <td>{{ $application->data->cost->land_status }}</td>
                        </tr>
                        <tr>
                            <td><strong>Assets Detail:</strong></td>
                            <td>{{ $application->data->cost->assets_detail }}</td>
                        </tr>
                        <tr>
                            <td><strong>Building Area:</strong></td>
                            <td>{{ $application->data->cost->building_area }}</td>
                        </tr>
                        <tr>
                            <td><strong>Building Cost:</strong></td>
                            <td>{{ $application->data->cost->building_cost }}</td>
                        </tr>
                        <tr>
                            <td><strong>Machinery Cost:</strong></td>
                            <td>{{ $application->data->cost->machinery_cost }}</td>
                        </tr>
                        <tr>
                            <td><strong>Building Status:</strong></td>
                            <td>{{ $application->data->cost->building_status }}</td>
                        </tr>
                        <tr>
                            <td><strong>Working Capital:</strong></td>
                            <td>{{ $application->data->cost->working_capital }}</td>
                        </tr>
                        <tr>
                            <td><strong>Machinery Detail:</strong></td>
                            <td>{{ $application->data->cost->machinery_detail }}</td>
                        </tr>
                      
                        <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Partner Section</strong></td>
                        </tr>
                        <!-- Check if partner details are available before using implode -->
                        @if(is_array($application->data->owner->partner_gender))
                        <tr>
                            <td><strong>Partner Gender:</strong></td>
                            <td>{{ implode(', ', $application->data->owner->partner_gender) }}</td>
                        </tr>
                        @endif
                    
                        <!-- Check if partner mobile details are available before using implode -->
                        @if(is_array($application->data->owner->partner_mobile) && count($application->data->owner->partner_mobile) > 1)
                        <tr>
                            <td><strong>Partner Mobile:</strong></td>
                            <td>{{ implode(', ', $application->data->owner->partner_mobile) }}</td>
                        </tr>
                        @endif
                    
                        <!-- Check if partner Aadhaar details are available before using implode -->
                        @if(is_array($application->data->owner->partner_aadhaar)&& count($application->data->owner->partner_aadhaar) > 1)
                        <tr>
                            <td><strong>Partner Aadhaar:</strong></td>
                            <td>{{ implode(', ', $application->data->owner->partner_aadhaar) }}</td>
                        </tr>
                        @endif
                    
                      
                    
                        <!-- Check if partner birth date details are available before using implode -->
                        @if(is_array($application->data->owner->partner_birth_date)&& count($application->data->owner->partner_birth_date) > 1)
                        <tr>
                            <td><strong>Partner Birth Date:</strong></td>
                            <td>{{ implode(', ', $application->data->owner->partner_birth_date) }}</td>
                        </tr>
                        @endif
                    
                      
                    
                        <!-- Check if partner is specially abled details are available before using implode -->
                        @if(is_array($application->data->owner->partner_is_specially_abled))
                        <tr>
                            <td><strong>Partner Is Specially Abled:</strong></td>
                            <td>{{ implode(', ', $application->data->owner->partner_is_specially_abled) }}</td>
                        </tr>
                        @endif
                    
                        <!-- Check if partner social category ID details are available before using implode -->
                        @if(is_array($application->data->owner->partner_social_category_id))
                        <tr>
                            <td><strong>Partner Social Category ID:</strong></td>
                            <td>{{ getNameFromId('enums', implode(', ', $application->data->owner->partner_social_category_id)) }}</td>
                        </tr>
                        @endif
                        <!-- Finance Section -->
                        <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Finance Section</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Bank Branch ID:</strong></td>
                            <td>{{ getNameFromId('bank_branches', $application->data->finance->bank_branch_id) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Own Contribution:</strong></td>
                            <td>{{ $application->data->finance->own_contribution }}</td>
                        </tr>
                    </table>
                <table>
                    <tr bgcolor="#E36E2C">
                        <td colspan="2"><strong>Documents Section</strong></td>
                    </tr>
                </table>
                      <!-- Documents section -->
                      @foreach($allApplicationDocuments as $document)
                        <div class="document-container">
                            <h6>{{ $document->document_name }}</h6>
                            <iframe src="{{ route('application.document', ['document' => $document->document_id]) }}" sandbox="allow-downloads" frameborder="0" style="width: 100%; height: 20%;"></iframe>
                        </div>
                      @endforeach

                </div>
                <div class="modal-footer">
                    <!-- Download button -->
                    {{-- <a href="#" class="btn btn-primary" id="downloadPdfButton">Download PDF</a> --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
            
            var docId = 3; // ID of the <strong> element you want to update
            var newValue = 'Age Proof :- 10th /Passport/Birth Certificate ';
            newValue += '<span style="color:red;">* (Required)</span>';
            // Find the <strong> element by its ID and update its content
            $('#' + docId).html(newValue);
            $('#finalSubmissionButton').prop('disabled', true);
                $('input[type=file]').change(function() {
                    // Check if all required file inputs have files attached
                    var allFilesUploaded = true;
                    $('input[type=file][required]').each(function() {
                        if ($(this).get(0).files.length === 0) {
                            allFilesUploaded = false;
                            return false; // Exit loop if any input has no file attached
                        }
                    });
                    // Enable/disable final submission button based on document upload status
                    if (allFilesUploaded) {
                        $('#finalSubmissionButton').prop('disabled', false);
                    } else {
                        $('#finalSubmissionButton').prop('disabled', true);
                    }
                });
                function checkRequiredInputs() {
                    var requiredInputs = $('input[required]');
                    for (var i = 0; i < requiredInputs.length; i++) {
                        if (!requiredInputs[i].value) {
                            return false;
                        }
                    }
                    return true;
                }
                // Disable the final submission button by default
                var finalSubmissionButton = $('#finalSubmissionButton');
                finalSubmissionButton.prop('disabled', true);
                // Check required inputs when the page loads
                finalSubmissionButton.prop('disabled', !checkRequiredInputs());
                // Check required inputs whenever an input changes
                $('input').on('input', function() {
                    finalSubmissionButton.prop('disabled', !checkRequiredInputs());
                });


            function loadActivityOptions() {
            
                var selectedActivityTypeId = {{ $application->data->enterprise->activity_id }}
                $.ajax({
                    url: '/application/get-data/',
                    method: 'GET',
                    data: {
                    activity_type_id: selectedActivityTypeId
                    },
                    success: function(data) {
                        // Add the retrieved options to the select element
                        
                        data.forEach(function(option) {
                            let activityTd = $('td.activity');

                            // Create the HTML content you want to append (e.g., a list)
                            let htmlContent = '<ul>';
                            data.forEach(function(option) {
                                htmlContent += '<li>' + option.name + '</li>';
                            });
                            htmlContent += '</ul';

                            // Set the HTML content of the <td>
                            activityTd.html(htmlContent);
                        });

                    },
                    error: function() {
                        // Handle error
                    }
                });
                
            // }
        }
        loadActivityOptions()
        });
    </script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
    
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    
        th {
            background-color: #f2f2f2;
        }
    
        td strong {
            font-weight: bold;
        }
    
        .title {
            font-weight: bold;
        }
    
        .value {
            font-style: italic;
        }
    </style>
    

