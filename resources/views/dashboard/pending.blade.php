@extends('layouts.admin')

@section('title', $title ?? __("DIC - DH"))

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dic-dh.index') }}">{{ __("Dic - DH") }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('Pending Applications') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Pending Applications') }}</h6>
    </nav>
@endsection

@section('content')
    <div class="d-sm-flex justify-content-end">
        <div>
            <a href="{{ route('dic-dh.create') }}" class="btn btn-icon bg-gradient-primary">
                New application
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-card.card>
                <x-card.card-body>
                    <x-table.table class="table align-items-center mb-0">
                        <x-table.head>
                            <x-table.tr>
                                <x-table.th>Profile</x-table.th>
                                <x-table.th>Position</x-table.th>
                                <x-table.th>Availability</x-table.th>
                                <x-table.th>Date Of Joining</x-table.th>
                                <x-table.th>Settings</x-table.th>
                            </x-table.tr>
                        </x-table.head>
                        <x-table.body>
                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">John Michael</h6>
                                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Manager</p>
                                    <p class="text-xs text-secondary mb-0">Organization</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-success text-success">Online</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">23/04/18</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="javascript:;" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>
                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-3.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">Alexa Liras</h6>
                                            <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Programator</p>
                                    <p class="text-xs text-secondary mb-0">Developer</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-danger text-danger">Offline</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">11/01/19</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="#!" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>

                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-4.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">Laurent Perrier</h6>
                                            <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Executive</p>
                                    <p class="text-xs text-secondary mb-0">Projects</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-success text-success">Online</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">19/09/17</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="#!" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>

                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-3.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">Michael Levi</h6>
                                            <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Programator</p>
                                    <p class="text-xs text-secondary mb-0">Developer</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-success text-success">Online</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">24/12/08</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="#!" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>

                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">Richard Gran</h6>
                                            <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Manager</p>
                                    <p class="text-xs text-secondary mb-0">Executive</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-danger text-danger">Offline</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">04/10/21</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="#!" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>

                            <x-table.tr>
                                <x-table.td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-4.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">Miriam Eric</h6>
                                            <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>
                                        </div>
                                    </div>
                                </x-table.td>
                                <x-table.td>
                                    <p class="text-xs font-weight-bold mb-0">Programtor</p>
                                    <p class="text-xs text-secondary mb-0">Developer</p>
                                </x-table.td>
                                <x-table.td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm badge-danger text-danger">Offline</span>
                                </x-table.td>
                                <x-table.td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">14/09/20</span>
                                </x-table.td>
                                <x-table.td class="align-middle">
                                    <a href="#!" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </x-table.td>
                            </x-table.tr>
                        </x-table.body>
                    </x-table.table>
                </x-card.card-body>
                <x-card.card-footer>
                    <p class="text-secondary text-sm">Showing 1 to 10 of 57 entries</p>
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </x-card.card-footer>
            </x-card.card>
        </div>

        <div class="col-md-12 my-4">
            <x-card.card>
                <x-card.card-header>
                    <h6 class="mb-1">Mark application</h6>
                    <p class="text-sm mb-0">Here you can update application.</p>
                </x-card.card-header>
                <x-card.card-body>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="px-lg-3 px-2 pt-3">
                                <label class="form-label mb-0">Application Status</label>
                                <select class="form-control" name="choices-app-status" id="choices-app-status">
                                    <option selected value="">--Choose--</option>
                                    <option value="Question 1">Revert</option>
                                    <option value="Question 2">Pending for bank approval</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-4 px-lg-3">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" id="remark" placeholder="You can enter comment here"></textarea>
                            </div>
                            <button class="btn bg-gradient-dark mb-0 float-end m-2">Update password</button>
                        </div>
                    </div>
                </x-card.card-body>
            </x-card.card>
        </div>
    </div>
@endsection
