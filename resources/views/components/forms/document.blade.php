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
                        <tr>
                            <th>Category</th>
                            <th>Data</th>
                        </tr>
                        <!-- Cost Section -->
                        <tr>
                            <td>Cost</td>
                            <td>
                                <strong>Land Cost:</strong> {{ $application->data->cost->land_cost }}<br>
                                <strong>Assets Cost:</strong> {{ $application->data->cost->assets_cost }}<br>
                                <strong>Land Status:</strong> {{ $application->data->cost->land_status }}<br>
                                <strong>Assets Detail:</strong> {{ $application->data->cost->assets_detail }}<br>
                                <strong>Building Area:</strong> {{ $application->data->cost->building_area }}<br>
                                <strong>Building Cost:</strong> {{ $application->data->cost->building_cost }}<br>
                                <strong>Machinery Cost:</strong> {{ $application->data->cost->machinery_cost }}<br>
                                <strong>Building Status:</strong> {{ $application->data->cost->building_status }}<br>
                                <strong>Working Capital:</strong> {{ $application->data->cost->working_capital }}<br>
                                <strong>Machinery Detail:</strong> {{ $application->data->cost->machinery_detail }}<br>
                            </td>
                        </tr>
                        <!-- Owner Section -->
                        <tr>
                            <td>Owner</td>
                            <td>
                                <strong>PAN:</strong> {{ $application->data->owner->pan }}<br>
                                <strong>Name:</strong> {{ $application->data->owner->name }}<br>
                                <strong>Email:</strong> {{ $application->data->owner->email }}<br>
                                <strong>Gender:</strong> {{ $application->data->owner->gender }}<br>
                                <strong>Mobile:</strong> {{ $application->data->owner->mobile }}<br>
                                <strong>Aadhaar:</strong> {{ $application->data->owner->aadhaar }}<br>
                                <strong>Address:</strong> {{ $application->data->owner->address }}<br>
                                <strong>Pincode:</strong> {{ $application->data->owner->pincode }}<br>
                                <strong>Block ID:</strong> {{ $application->data->owner->block_id }}<br>
                                <strong>Guardian:</strong> {{ $application->data->owner->guardian }}<br>
                                <strong>Tehsil ID:</strong> {{ $application->data->owner->tehsil_id }}<br>
                                <strong>Birth Date:</strong> {{ $application->data->owner->birth_date }}<br>
                                <strong>District ID:</strong> {{ $application->data->owner->district_id }}<br>
                                <strong>Panchayat ID:</strong> {{ $application->data->owner->panchayat_id }}<br>
                                <strong>Partner Name:</strong> {{ implode(', ', $application->data->owner->partner_name) }}<br>
                                <strong>Marital Status:</strong> {{ $application->data->owner->marital_status }}<br>
                                <strong>Partner Gender:</strong> {{ implode(', ', $application->data->owner->partner_gender) }}<br>
                                <strong>Partner Mobile:</strong> {{ implode(', ', $application->data->owner->partner_mobile) }}<br>
                                <strong>Spouse Aadhaar:</strong> {{ $application->data->owner->spouse_aadhaar }}<br>
                                <strong>Constituency ID:</strong> {{ $application->data->owner->constituency_id }}<br>
                                <strong>Guardian Prefix:</strong> {{ $application->data->owner->guardian_prefix }}<br>
                                <strong>Partner Aadhaar:</strong> {{ implode(', ', $application->data->owner->partner_aadhaar) }}<br>
                                <strong>Is Specially Abled:</strong> {{ $application->data->owner->is_specially_abled }}<br>
                                <strong>Partner Birth Date:</strong> {{ implode(', ', $application->data->owner->partner_birth_date) }}<br>
                                <strong>Social Category ID:</strong> {{ $application->data->owner->social_category_id }}<br>
                                <strong>Belongs to Minority:</strong> {{ $application->data->owner->belongs_to_minority }}<br>
                                <strong>Partner Is Specially Abled:</strong> {{ implode(', ', $application->data->owner->partner_is_specially_abled) }}<br>
                                <strong>Partner Social Category ID:</strong> {{ implode(', ', $application->data->owner->partner_social_category_id) }}<br>
                            </td>
                        </tr>
                        <!-- Finance Section -->
                        <tr>
                            <td>Finance</td>
                            <td>
                                <strong>Bank Branch ID:</strong> {{ $application->data->finance->bank_branch_id }}<br>
                                <strong>Own Contribution:</strong> {{ $application->data->finance->own_contribution }}<br>
                            </td>
                        </tr>
                        <!-- Enterprise Section -->
                        <tr>
                            <td>Enterprise</td>
                            <td>
                                <strong>Name:</strong> {{ $application->data->enterprise->name }}<br>
                                <strong>Address:</strong> {{ $application->data->enterprise->address }}<br>
                                <strong>Pincode:</strong> {{ $application->data->enterprise->pincode }}<br>
                                <strong>Block ID:</strong> {{ $application->data->enterprise->block_id }}<br>
                                <strong>Area Type:</strong> {{ $application->data->enterprise->area_type }}<br>
                                <strong>Tehsil ID:</strong> {{ $application->data->enterprise->tehsil_id }}<br>
                                <strong>Employment:</strong> {{ $application->data->enterprise->employment }}<br>
                                <strong>Activity ID:</strong> {{ $application->data->enterprise->activity_id }}<br>
                                <strong>District ID:</strong> {{ $application->data->enterprise->district_id }}<br>
                                <strong>Panchayat ID:</strong> {{ $application->data->enterprise->panchayat_id }}<br>
                                <strong>Constituency ID:</strong> {{ $application->data->enterprise->constituency_id }}<br>
                                <strong>Activity Details:</strong> {{ $application->data->enterprise->activity_details }}<br>
                                <strong>Activity Type ID:</strong> {{ $application->data->enterprise->activity_type_id }}<br>
                                <strong>Constitution Type ID:</strong> {{ $application->data->enterprise->constitution_type_id }}<br>
                            </td>
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
    


