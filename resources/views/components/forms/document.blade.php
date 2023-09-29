<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

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
                                    <td>{{ $application->name }}</td>
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
                                @foreach($doctype as $doc)
                                <tr>
                                    <th>{{$doc->id}}</th>
                                    <th><strong>{{$doc->name}}</strong></th>
                                        <td colspan="6" style="display: flex;
                                        justify-content: end;">
                                            <form action="{{ route('application.upload', ['application' => $application ,'documentType' => $doc->id]) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="newDoc">
                                                <input type="hidden" name="doc_id" value="{{ $doc->id }}">
                                                {{-- <small>{{$doc->name}}</small> --}}
                                                @php
                                                    $uploadedDocument = $application->applicationDocuments()->where('document_type_id', $doc->id)->first();
                                                    @endphp
                                                @if ($uploadedDocument)
                                                {{-- @php dd($uploadedDocument); @endphp --}}
                                                    <span class="text-success">Document already uploaded</span>
                                                    <a class="btn btn-sm btn-success" target="_blank"
                                                    href="{{ route('application.document', ['document' => $uploadedDocument->document_id]) }}">View</a>
                                                    <a class="btn btn-sm btn-danger" data-confirm="true" data-confirm-title="Are you sure you want to delete the document?"
                                                    href="{{ route('application.document-remove', ['application' => $application->id, 'document' => $uploadedDocument->document_id]) }}?type='newDoc'">Remove Document</a>
                                                @else
                                                @if($doc->id == 7)
                                                    <input type="file" name="file" @if ($application->data->owner->social_category_id == '602' || $application->data->owner->social_category_id == '603') {{'required'}} @endif>
                                                @else
                                                    <input type="file" name="file" required>
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
                            <td><strong>Block ID:</strong></td>
                            <td>{{ $application->data->owner->block_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Guardian:</strong></td>
                            <td>{{ $application->data->owner->guardian }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tehsil ID:</strong></td>
                            <td>{{ $application->data->owner->tehsil_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Birth Date:</strong></td>
                            <td>{{ $application->data->owner->birth_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>District ID:</strong></td>
                            <td>{{ $application->data->owner->district_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Panchayat ID:</strong></td>
                            <td>{{ $application->data->owner->panchayat_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Social Category ID:</strong></td>
                            <td>{{ $application->data->owner->social_category_id }}</td>
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
                            <td><strong>Constituency ID:</strong></td>
                            <td>{{ $application->data->owner->constituency_id }}</td>
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
                            <td><strong>Block ID:</strong></td>
                            <td>{{ $application->data->enterprise->block_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Area Type:</strong></td>
                            <td>{{ $application->data->enterprise->area_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tehsil ID:</strong></td>
                            <td>{{ $application->data->enterprise->tehsil_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Employment:</strong></td>
                            <td>{{ $application->data->enterprise->employment }}</td>
                        </tr>
                        <tr>
                            <td><strong>Activity ID:</strong></td>
                            <td>{{ $application->data->enterprise->activity_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>District ID:</strong></td>
                            <td>{{ $application->data->enterprise->district_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Panchayat ID:</strong></td>
                            <td>{{ $application->data->enterprise->panchayat_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Constituency ID:</strong></td>
                            <td>{{ $application->data->enterprise->constituency_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Activity Details:</strong></td>
                            <td>{{ $application->data->enterprise->activity_details }}</td>
                        </tr>
                        <tr>
                            <td><strong>Activity Type ID:</strong></td>
                            <td>{{ $application->data->enterprise->activity_type_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Constitution Type ID:</strong></td>
                            <td>{{ $application->data->enterprise->constitution_type_id }}</td>
                        </tr>
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
                            <td>{{ implode(', ', $application->data->owner->partner_social_category_id) }}</td>
                        </tr>
                        @endif
                        <!-- Finance Section -->
                        <tr bgcolor="#E36E2C">
                            <td colspan="2"><strong>Finance Section</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Bank Branch ID:</strong></td>
                            <td>{{ $application->data->finance->bank_branch_id }}</td>
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
                          <iframe src="{{ route('application.document', ['document' => $document->document_id]) }}" sandbox="allow-downloads" frameborder="0" style="width: 100%; height: 200px;"></iframe>
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
    


