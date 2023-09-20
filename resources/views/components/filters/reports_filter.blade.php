<form>
    <div class="col-md-12 filter-top">
        <h6>Filters</h6>
            <button class="btn btn-primary text-center" type="submit">Apply</button>
    </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label class="form-label">Select Related Status</label>
            <select class="form-control" title="{{ request()->get('status_id') }}" name="status_id" id="status-id">
                <option value="">-- All --</option>
                @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                    @if(in_array($status->id(), $statusId))
                        <option value="{{ $status->id() }}" @selected(request()->get('status_id') == $status->id())>{{ $status->value }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Select FY</label>
            <select class="form-control fy" title="{{ request()->get('fy') }}" name="fy" id="status-id">
                <option value="All">-- All --</option>
                <option value="2023-2024" @selected(request()->get('fy') == '2023-2024')>2023-2024</option>
                <option value="2022-2023" @selected(request()->get('fy') == '2022-2023')>2022-2023</option>
                <option value="2021-2022" @selected(request()->get('fy') == '2021-2022')>2021-2022</option>
                <option value="2020-2021" @selected(request()->get('fy') == '2020-2021')>2020-2021</option>
            </select>
        </div>
        @if(auth()->user()->isSuperAdmin())
            <div class="col-md-2">
                <!-- District Dropdown -->
                <label class="form-label">Select District</label>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        District
                    </button>
                    <ul class="dropdown-menu" id="district-multiselect">
                        <li>
                            <label class="dropdown-item">
                                <input type="checkbox" id="select-all-districts-multiselect"> Select All
                            </label>
                        </li>
                        @foreach($districts as $district)
                            <li>
                                <label class="dropdown-item">
                                    <input type="checkbox" class="district-checkbox" value="{{ $district->id }}" {{ request()->has('district_id') &&  in_array($district->id, request('district_id')) ? 'checked' : '' }} name="district_id[]">
                                    {{ $district->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <div class="col-md-2">
            <label class="form-label">Select Constituency</label>
            <!-- Constituency Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Constituency
                </button>
                <ul class="dropdown-menu" id="constituency-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-constituency-multiselect"> Select All
                        </label>
                    </li>
                    @if($constituencies)
                        @foreach($constituencies as $constituency)
                            <li>
                                <label class="dropdown-item">
                                    <input name="constituency_id[]" type="checkbox" class="constituency-checkbox" {{ request()->has('constituency_id') && in_array($constituency->id, request('constituency_id')) ? 'checked' : '' }} value="{{ $constituency->id }}">
                                    {{ $constituency->name }}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Select Tehsil</label>
            <!-- Tehsil Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tehsil
                </button>
                <ul class="dropdown-menu" id="tehsil-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input name="tehsil_id[]" type="checkbox" id="select-all-tehsil-multiselect"> Select All
                        </label>
                    </li>
                    @if($tehsils)
                        @foreach($tehsils as $tehsil)
                            <li>
                                <label class="dropdown-item">
                                    <input name="tehsil_id[]" type="checkbox" class="tehsil-checkbox" {{ request()->has('tehsil_id') && in_array($tehsil->id, request('tehsil_id')) ? 'checked' : '' }} value="{{ $tehsil->id }}">
                                    {{ $tehsil->name }}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Select Block/Town</label>
            <!-- Block/Town Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Block/Town
                </button>
                <ul class="dropdown-menu" id="block-town-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-block-town-multiselect"> Select All
                        </label>
                    </li>
                    @if($blocks)
                        @foreach($blocks as $block)
                            <li>
                                <label class="dropdown-item">
                                    <input  name="block_id[]" type="checkbox" class="block-town-checkbox" {{ request()->has('block_id') && in_array($block->id, request('block_id')) ? 'checked' : '' }} value="{{ $block->id }}">
                                    {{ $block->name }}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Select Panchayat/Ward</label>
            <!-- Panchayat/Ward Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Panchayat/Ward
                </button>
                <ul class="dropdown-menu" id="panchayat-ward-multiselect">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-panchayat-ward-multiselect"> Select All
                        </label>
                    </li>
                    @if($panchayatWards)
                        @foreach($panchayatWards as $panchayatWard)
                            <li>
                                <label class="dropdown-item">
                                    <input name="panchayat_id[]" {{ request()->has('panchayat_id') &&  in_array($panchayatWard->id, request('panchayat_id')) ? 'checked' : '' }} type="checkbox" class="panchayat-ward-checkbox" value="{{ $panchayatWard->id }}">
                                    {{ $panchayatWard->name }}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        
    
    </div>
</form>