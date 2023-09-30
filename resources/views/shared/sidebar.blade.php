@php($request = request()->path())
<x-sidebar.aside>
    <x-slot:brand>
        <x-sidebar.navbar-brand :src="asset('images/mmsy.png')" :name="config('app.name')"></x-sidebar.navbar-brand>
    </x-slot:brand>
    @if (auth()->user())
        @if (!auth()->user()->isApplicant())
            <x-sidebar.nav-item>
                <x-sidebar.nav-link href="/dashboard" :active="request()->routeIs('dashboard')">
                    <x-slot:icon><em class="material-icons opacity-10">dashboard</em></x-slot:icon>
                    <x-slot:title>{{ __('Dashboard') }}</x-slot:title>
                </x-sidebar.nav-link>
            </x-sidebar.nav-item>

            <x-sidebar.nav-item>
                <x-sidebar.sub-menu :active="request()->routeIs('dashboard.*') || request()->routeIs('application.view')" :menuId="'applicationPending'">
                    <x-slot:icon><em class="material-icons opacity-10">dns</em></x-slot:icon>
                    <x-slot:title :title="__('Workspace')">{{ __('Workspace') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="'applicationPending'">
                            @if(auth()->user()->isBankManager() || auth()->user()->isNodalDIC() || auth()->user()->isGm() || auth()->user()->isNodalBank() || auth()->user()->isEO())
                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('dashboard.pendency') }}" :active="request()->routeIs('dashboard.pendency')">
                                        <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                        <x-slot:title>{{ __('Pendency') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>
                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('dashboard.approved') }}" :active="request()->routeIs('dashboard.approved')">
                                        <x-slot:icon><em class="material-icons opacity-10">check_box</em></x-slot:icon>
                                        <x-slot:title>{{ __('Approved') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>
                            @endif
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('dashboard.reports') }}" :active="request()->routeIs('dashboard.reports') || request()->routeIs('application.view')">
                                    <x-slot:icon><em class="material-icons opacity-10">menu_book</em></i></x-slot:icon>
                                    <x-slot:title>{{ __('All Applications') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            @if(auth()->user()->canScheduleMeeting())
                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('dashboard.meetings') }}" :active="request()->routeIs('dashboard.meetings')">
                                        <x-slot:icon><em class="fas fa-users"></em></x-slot:icon>
                                        <x-slot:title>{{ __('Meetings') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>
                            @endif
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item>

            {{-- <x-sidebar.nav-item>
                <x-sidebar.sub-menu :active="request()->routeIs('reports.*')" :menuId="__('reports')">
                    <x-slot:icon><i class="material-icons opacity-10">receipt_long</i></x-slot:icon>
                    <x-slot:title :title="__('Reports')">{{ __('Reports') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="__('reports')">
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('dashboard.reports') }}" :active="request()->routeIs('dashboard.reports')">
                                    <x-slot:icon><i class="fas fa-book-open"></i></x-slot:icon>
                                    <x-slot:title>{{ __('All Applications') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            @if(auth()->user()->isGm() || auth()->user()->isNodalDIC() || auth()->user()->isNodalBank() || auth()->user()->isSuperAdmin())
                                @php($userDistricts = \App\Models\Region::userBasedDistricts()->get())
                                @if($userDistricts->count() > 1)
                                    <x-sidebar.nav-item>
                                        <x-sidebar.sub-menu :active="request()->routeIs('reports.district')" :menuId="__('districtSubMenu')">
                                            <x-slot:icon><em class="fas fa-folder"></em></x-slot:icon>
                                            <x-slot:title :title="__('By District')">{{ __('By District') }}</x-slot:title>
                                            <x-slot:collapse>
                                                <x-sidebar.collapse-show :menuId="__('districtSubMenu')">
                                                    @foreach($userDistricts as $district)
                                                        <x-sidebar.nav-item>
                                                            <x-sidebar.nav-link href="{{ route('reports.district', $district->id) }}" :active='\Illuminate\Support\Str::endsWith(request()->path(), "district/{$district->id}")'>
                                                                <x-slot:icon><em class="fas fa-folder-tree"></em></x-slot:icon>
                                                                <x-slot:title>{{ $district->name ?? __('By District') }} ({{ \App\Models\Application::where('data->enterprise->district_id', $district->id)->count() }})</x-slot:title>
                                                            </x-sidebar.nav-link>
                                                        </x-sidebar.nav-item>
                                                    @endforeach
                                                </x-sidebar.collapse-show>
                                            </x-slot:collapse>
                                        </x-sidebar.sub-menu>
                                    </x-sidebar.nav-item>
                                @endif
                                <x-sidebar.nav-item>
                                    <x-sidebar.sub-menu :active="request()->routeIs('reports.constituency')" :menuId="__('constituencySubMenu')">
                                        <x-slot:icon><em class="fas fa-trowel"></em></x-slot:icon>
                                        <x-slot:title :title="__('By Constituency')">{{ __('By Constituency') }}</x-slot:title>
                                        <x-slot:collapse>
                                            <x-sidebar.collapse-show :menuId="__('constituencySubMenu')">
                                                @foreach(\App\Models\Region::userBasedChildOfDistrict()->ofType(\App\Enums\RegionTypeEnum::CONSTITUENCY->id())->get() as $constituency)
                                                    <x-sidebar.nav-item>
                                                        <x-sidebar.nav-link href="{{ route('reports.constituency', $constituency->id) }}" :active='\Illuminate\Support\Str::endsWith(request()->path(), "constituency/{$constituency->id}")'>
                                                            <x-slot:icon><em class="fas fa-trowel-bricks"></em></x-slot:icon>
                                                            <x-slot:title>{{ $constituency->name ?? __('By Constituency') }} ({{ \App\Models\Application::where('data->enterprise->constituency_id', $constituency->id)->count() }})</x-slot:title>
                                                        </x-sidebar.nav-link>
                                                    </x-sidebar.nav-item>
                                                @endforeach
                                            </x-sidebar.collapse-show>
                                        </x-slot:collapse>
                                    </x-sidebar.sub-menu>
                                </x-sidebar.nav-item>
                                <x-sidebar.nav-item>
                                    <x-sidebar.sub-menu :active="request()->routeIs('reports.block')" :menuId="__('blockSubMenu')">
                                        <x-slot:icon><em class="fas fa-bridge-lock"></em></x-slot:icon>
                                        <x-slot:title :title="__('By Block')">{{ __('By Block') }}</x-slot:title>
                                        <x-slot:collapse>
                                            <x-sidebar.collapse-show :menuId="__('blockSubMenu')">
                                                @foreach(\App\Models\Region::ofType(\App\Enums\RegionTypeEnum::BLOCK_TOWN->id())->userBasedChildOfDistrict()->orderBy('name')->get() as $block)
                                                    <x-sidebar.nav-item>
                                                        <x-sidebar.nav-link href="{{ route('reports.block', $block->id) }}" :active='\Illuminate\Support\Str::endsWith(request()->path(), "block/{$block->id}")'>
                                                            <x-slot:icon><i class="fas fa-shop-lock"></i></x-slot:icon>
                                                            <x-slot:title>{{ $block->name ?? __('By Block') }}({{ \App\Models\Application::where('data->enterprise->block_id', $block->id)->count() }})</x-slot:title>
                                                        </x-sidebar.nav-link>
                                                    </x-sidebar.nav-item>
                                                @endforeach
                                            </x-sidebar.collapse-show>
                                        </x-slot:collapse>
                                    </x-sidebar.sub-menu>
                                </x-sidebar.nav-item>
                            @endif
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item> --}}
        @endif

        @if(auth()->user()->isGm() || auth()->user()->isNodalDIC() || auth()->user()->isSuperAdmin())
            <x-sidebar.nav-item>
                <x-sidebar.sub-menu :active="request()->routeIs('regions.*')" :menuId="'regions'">
                    <x-slot:icon><em class="material-icons opacity-10">location_on</em></x-slot:icon>
                    <x-slot:title :title="__('Manage Regions')">{{ __('Manage Regions') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="'regions'">
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('regions.list', ['type' => 'constituency']) }}" :active="request()->routeIs('regions.*') && request()->route()->parameter('type') == 'constituency'">
                                    <x-slot:icon><em class="material-icons opacity-10">my_location</em></x-slot:icon>
                                    <x-slot:title>{{ __('Constituencies') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('regions.list', ['type' => 'tehsil']) }}" :active="request()->routeIs('regions.*') && request()->route()->parameter('type') == 'tehsil'">
                                    <x-slot:icon><em class="material-icons opacity-10">explore</em></x-slot:icon>
                                    <x-slot:title>{{ __('Tehsils') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('regions.list', ['type' => 'block-town']) }}" :active="request()->routeIs('regions.*') && request()->route()->parameter('type') == 'block-town'">
                                    <x-slot:icon><em class="material-icons opacity-10">location_on</em></x-slot:icon>
                                    <x-slot:title>{{ __('Blocks/Towns') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('regions.list', ['type' => 'panchayat-ward']) }}" :active="request()->routeIs('regions.*') && request()->route()->parameter('type') == 'panchayat-ward'">
                                    <x-slot:icon><em class="material-icons opacity-10">near_me</em></x-slot:icon>
                                    <x-slot:title>{{ __('Panchayats/Wards') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item>
            
                
                @if(auth()->user()->isSuperAdmin())
                <x-sidebar.nav-item>
                    <x-sidebar.sub-menu :active="request()->routeIs('crud.*')" :menuId="'crud'">
                    <x-slot:icon><em class="material-icons opacity-10">construction</em></x-slot:icon>
                    <x-slot:title :title="__('CMS')">{{ __('CMS') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="'crud'">
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('crud.list', ['class' => 'activity']) }}" :active="request()->routeIs('crud.*') && request()->route()->parameter('class') == 'activity'">
                                    <x-slot:icon><em class="material-icons opacity-10">construction</em></x-slot:icon>
                                    <x-slot:title>{{ __('Manage Activities') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                            <x-sidebar.nav-link href="{{ route('crud.list', ['class' => 'banner']) }}" :active="request()->routeIs('crud.*') && request()->route()->parameter('class') == 'banner'">
                                <x-slot:icon><em class="material-icons opacity-10">construction</em></x-slot:icon>
                                <x-slot:title>{{ __('Banner') }}</x-slot:title>
                            </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                            <x-sidebar.nav-link href="{{ route('crud.list', ['class' => 'usefultip']) }}" :active="request()->routeIs('crud.*') && request()->route()->parameter('class') == 'usefultip'">
                                <x-slot:icon><em class="material-icons opacity-10">construction</em></x-slot:icon>
                                <x-slot:title>{{ __('Useful Tips') }}</x-slot:title>
                            </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                            <x-sidebar.nav-link href="{{ route('crud.list', ['class' => 'dlcmeeting']) }}" :active="request()->routeIs('crud.*') && request()->route()->parameter('class') == 'dlcmeeting'">
                                <x-slot:icon><em class="material-icons opacity-10">construction</em></x-slot:icon>
                                <x-slot:title>{{ __('DLC Meeting') }}</x-slot:title>
                            </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('crud.list', ['class' => 'bank-branch']) }}" :active="request()->routeIs('crud.*') && request()->route()->parameter('class') == 'bank-branch'">
                                    <x-slot:icon><em class="material-icons opacity-10">account_balance</em></x-slot:icon>
                                    <x-slot:title>{{ __('Manage Bank Branches') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item>
            @endif
        @endif

        @if(!auth()->user()->isApplicant())
            <x-sidebar.nav-item>
                <x-sidebar.sub-menu :active="request()->routeIs('report.*')" :menuId="'reports'">
                    <x-slot:icon><em class="material-icons opacity-10">report</em></x-slot:icon>
                    <x-slot:title :title="__('Reports')">{{ __('Reports') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="'reports'">
                            @if(auth()->user()->isBankManager() || auth()->user()->isBankRO() || auth()->user()->isGm() || auth()->user()->isSuperAdmin() || auth()->user()->isNodalBank())
                                @if(auth()->user()->isBankManager())
                                    <x-sidebar.nav-item>
                                        <x-sidebar.nav-link href="{{ route('report.banks') }}" :active="request()->routeIs('report.banks')">
                                            <x-slot:icon><em class="material-icons opacity-10">description</em></x-slot:icon>
                                            <x-slot:title>{{ __('Bank Overview') }}</x-slot:title>
                                        </x-sidebar.nav-link>
                                    </x-sidebar.nav-item>
                                @endif

                                {{-- <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('report.applications', ['type' => 'pending']) }}" :active="request()->routeIs('report.applications') && request()->route()->parameter('type') == 'pending'">
                                        <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                        <x-slot:title>{{ __('Pending Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('report.applications', ['type' => 'sponsored']) }}" :active="request()->routeIs('report.applications') && request()->route()->parameter('type') == 'sponsored'">
                                        <x-slot:icon><em class="material-icons opacity-10">check_box</em></x-slot:icon>
                                        <x-slot:title>{{ __('Sponsored Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('report.applications', ['type' => 'sanctioned']) }}" :active="request()->routeIs('report.applications') && request()->route()->parameter('type') == 'sanctioned'">
                                        <x-slot:icon><em class="material-icons opacity-10">payments</em></x-slot:icon>
                                        <x-slot:title>{{ __('Sanctioned Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('report.applications', ['type' => 'rejected']) }}" :active="request()->routeIs('report.applications') && request()->route()->parameter('type') == 'rejected'">
                                        <x-slot:icon><em class="material-icons opacity-10">block</em></x-slot:icon>
                                        <x-slot:title>{{ __('Rejected Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item> --}}

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'pending', 'step' => '0']) }}" :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'pending' && request()->route()->parameter('step') == '0'">
                                        <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                        <x-slot:title>{{ __('Pending Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>
                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'sponsored', 'step' => '0']) }}" :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'sponsored'">
                                        <x-slot:icon><em class="material-icons opacity-10">check_box</em></x-slot:icon>
                                        <x-slot:title>{{ __('Sponsored Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.sub-menu :active="request()->routeIs('master_report.sanctioned.*')" :menuId="'sanctioned_reports'">
                                    <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                    <x-slot:title :title="__('Sanctioned Applications')">{{ __('Sanctioned Applications') }}</x-slot:title>
                                    <x-slot:collapse>
                                        <x-sidebar.collapse-show :menuId="'sanctioned_reports'">
                                            <x-sidebar.nav-item>
                                                <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'sanctioned', 'step' => '60']) }}" :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'sanctioned' && request()->route()->parameter('step') == '60'">
                                                    <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                                    <x-slot:title>{{ __('Sanctioned For 60%') }}</x-slot:title>
                                                </x-sidebar.nav-link>
                                            </x-sidebar.nav-item>
                                            <x-sidebar.nav-item>
                                                <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'sanctioned', 'step' => '40']) }}                                                       " :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'sanctioned' && request()->route()->parameter('step') == '40'">
                                                    <x-slot:icon><em class="material-icons opacity-10">pending</em></x-slot:icon>
                                                    <x-slot:title>{{ __('40% Request') }}</x-slot:title>
                                                </x-sidebar.nav-link>
                                            </x-sidebar.nav-item>
                                        </x-sidebar.collapse-show>
                                    </x-slot:collapse>
                                </x-sidebar.sub-menu>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'all', 'step' => '0']) }}" :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'all'">
                                        <x-slot:icon><em class="material-icons opacity-10">check_box</em></x-slot:icon>
                                        <x-slot:title>{{ __('All Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="{{ route('master_report.applications', ['type' => 'rejected', 'step' => '0']) }}" :active="request()->routeIs('master_report.applications') && request()->route()->parameter('type') == 'rejected' && request()->route()->parameter('step') == '0'">
                                        <x-slot:icon><em class="material-icons opacity-10">block</em></x-slot:icon>
                                        <x-slot:title>{{ __('Rejected Applications') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>

                                <x-sidebar.nav-item>
                                    <x-sidebar.nav-link href="https://mmsy.hp.gov.in/old-portal/page/report" target="_blank">
                                        <x-slot:icon><em class="material-icons opacity-10">list_alt</em></x-slot:icon>
                                        <x-slot:title>{{ __('Old Portal Status') }}</x-slot:title>
                                    </x-sidebar.nav-link>
                                </x-sidebar.nav-item>
                            @endif
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item>
        @endif

        @if(auth()->user()->isSuperAdmin())
            <x-sidebar.nav-item>
                <x-sidebar.sub-menu :active="request()->routeIs('numaric_report.*')" :menuId="'numaric_reports'">
                    <x-slot:icon><em class="material-icons opacity-10">report</em></x-slot:icon>
                    <x-slot:title :title="__('Numeric Reports')">{{ __('Numeric Reports') }}</x-slot:title>
                    <x-slot:collapse>
                        <x-sidebar.collapse-show :menuId="'numaric_reports'">
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('numaric_reports.recieved') }}" :active="request()->routeIs('numaric_reports.recieved')">
                                    <x-slot:icon><em class="material-icons opacity-10">description</em></x-slot:icon>
                                    <x-slot:title>{{ __('Application Recieved') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                            <x-sidebar.nav-item>
                                <x-sidebar.nav-link href="{{ route('numaric_reports.released') }}" :active="request()->routeIs('numaric_reports.released')">
                                    <x-slot:icon><em class="material-icons opacity-10">description</em></x-slot:icon>
                                    <x-slot:title>{{ __('All Status') }}</x-slot:title>
                                </x-sidebar.nav-link>
                            </x-sidebar.nav-item>
                        </x-sidebar.collapse-show>
                    </x-slot:collapse>
                </x-sidebar.sub-menu>
            </x-sidebar.nav-item>
        @endif

        @if(auth()->user()->isSuperAdmin())
            <x-sidebar.nav-item>
                <x-sidebar.nav-link href="{{ url('adminer') }}" target="_blank">
                    <x-slot:icon><em class="material-icons opacity-10">list_alt</em></x-slot:icon>
                    <x-slot:title>{{ __('Database Access') }}</x-slot:title>
                </x-sidebar.nav-link>
            </x-sidebar.nav-item>
            <x-sidebar.nav-item>
                <x-sidebar.nav-link href="{{ url('file-manager') }}" target="_blank">
                    <x-slot:icon><em class="material-icons opacity-10">save</em></x-slot:icon>
                    <x-slot:title>{{ __('File Manager') }}</x-slot:title>
                </x-sidebar.nav-link>
            </x-sidebar.nav-item>
            <x-sidebar.nav-item>
                <x-sidebar.nav-link href="{{ url('log-viewer') }}" target="_blank">
                    <x-slot:icon><em class="material-icons opacity-10">manage_search</em></x-slot:icon>
                    <x-slot:title>{{ __('Log Viewer') }}</x-slot:title>
                </x-sidebar.nav-link>
            </x-sidebar.nav-item>
        @endif

        @if(auth()->user()->isApplicant())
            <x-sidebar.nav-item>
                <x-sidebar.nav-link href="{{ route('applications.list') }}" :active="request()->routeIs('applications.list') || \Illuminate\Support\Str::startsWith($request, 'application/')">
                    <x-slot:icon><em class="material-icons opacity-10">list_alt</em></x-slot:icon>
                    <x-slot:title>{{ __('Applications') }}</x-slot:title>
                </x-sidebar.nav-link>
            </x-sidebar.nav-item>
        @endif

        {{-- <x-sidebar.nav-item>
            <x-sidebar.nav-link href="/notifications" :active="request()->routeIs('notifications')">
                <x-slot:icon><em class="material-icons opacity-10">notifications</em></x-slot:icon>
                <x-slot:title>{{ __('Notifications') }}</x-slot:title>
            </x-sidebar.nav-link>
        </x-sidebar.nav-item> --}}

        <x-sidebar.nav-item>
            <x-sidebar.nav-heading>
                {{ __('Account Pages') }}
            </x-sidebar.nav-heading>
        </x-sidebar.nav-item>
        <x-sidebar.nav-item>
            <x-sidebar.nav-link href="/profile" :active="request()->routeIs('profile')">
                <x-slot:icon><em class="material-icons opacity-10">person</em></x-slot:icon>
                <x-slot:title>{{ __('Profile') }}</x-slot:title>
            </x-sidebar.nav-link>
        </x-sidebar.nav-item>
        <x-sidebar.nav-item>
            <x-sidebar.nav-link href="{{ route('logout') }}" :active="request()->routeIs('login')">
                <x-slot:icon><em class="material-icons opacity-10">logout</em></x-slot:icon>
                <x-slot:title>{{ __('Sign Out') }}</x-slot:title>
            </x-sidebar.nav-link>
        </x-sidebar.nav-item>

        @if(userExistsInOldPortal())
            <x-sidebar.nav-item>
                <x-sidebar.nav-heading>
                    {{ __('Old Portal') }}
                </x-sidebar.nav-heading>
            </x-sidebar.nav-item>
            <x-sidebar.nav-item>
                <form method="post" target="_blank" action="{{ env('OLD_PORTAL_URL', 'https://mmsy.hp.gov.in/old-portal') }}/direct-portal-login">
                    <input type="hidden" value="{{ oldPortalLoginToken() }}" name="token" />
                    <button type="submit" class="mx-2 btn btn-primary btn-block"><em class="fa fa-info-circle"></em> Login to Old Portal</button>
                </form>
            </x-sidebar.nav-item>
        @endif
    @endif
</x-sidebar.aside>
