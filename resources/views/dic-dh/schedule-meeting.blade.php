@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex justify-content-between">
        <div>
            <a href="{{ route('dic-dh.create') }}" class="btn btn-icon bg-gradient-primary">
                New application
            </a>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline">
                <a href="javascript:;" class="btn btn-outline-dark dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                    Filters
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="navbarDropdownMenuLink2" data-popper-placement="left-start">
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Pending</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Verified</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Reverted</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Rejected</a></li>
                    <li>
                        <hr class="horizontal dark my-2">
                    </li>
                    <li><a class="dropdown-item border-radius-md text-danger" href="javascript:;">Remove Filter</a></li>
                </ul>
            </div>
            <button class="btn btn-icon btn-outline-dark ms-2 export" data-type="csv" type="button">
                <i class="material-icons text-xs position-relative">archive</i>
                Export CSV
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @php($items = array(
                                0   => array('name' => 'Pending', 'icon' => 'check_circle'),
                                1   => array('name' => 'Completed', 'icon' => 'check'),
                                2   => array('name' => 'Incomplete', 'icon' => 'view_in_ar'),
                                3   => array('name' => 'Processed', 'icon' => 'close'),
                                4   => array('name' => 'Reverted', 'icon' => 'notifications')
                                ))
            <x-card.card class="shadow-sm" :items="$items">
                <x-card.card-header>
                    <x-slot:heading class="font-bold"></x-slot>
                        @foreach($items as $item)
                            <x-card.card-tablist :title="$item['name']" :icon="$item['icon']" :loop="$loop"></x-card.card-tablist>
                    @endforeach
                </x-card.card-header>
                <x-card.card-body>
                    <x-card.tabpane-list :title="'Pending'" :isActive="true">
                        <x-table.table>
                            <x-table.head>
                                <x-table.tr>
                                    <x-table.th>Id</x-table.th>
                                    <x-table.th>Date</x-table.th>
                                    <x-table.th>Status</x-table.th>
                                    <x-table.th>Customer</x-table.th>
                                    <x-table.th>Project</x-table.th>
                                    <x-table.th>Project Cost</x-table.th>
                                    <x-table.th>Settings</x-table.th>
                                </x-table.tr>
                            </x-table.head>
                            <x-table.body>
                                <x-table.tr>
                                    <x-table.td class="">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck1">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10421</p>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 10:20 AM</span>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <img src="https://picsum.photos/200/200?random=102" class="avatar avatar-xs me-2" alt="user image">
                                            <span>Orlando Imieto</span>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">Nike Sport V2</span>
                                    </x-table.td>
                                    <x-table.td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$140,20</span>
                                    </x-table.td>
                                    <x-table.td class="text-sm">
                                        <a href="{{ route('dic-dh.show', 1) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="{{ route('dic-dh.edit', 1) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </x-table.td>
                                </x-table.tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check pt-0">
                                                <input class="form-check-input" type="checkbox" id="customCheck2">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10422</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 10:53 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <img src="https://picsum.photos/200/200?random=103" class="avatar avatar-xs me-2" alt="user image">
                                            <span>Alice Murinho</span>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">Valvet T-shirt</span>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">$42,00</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck4">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10424</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 12:20 PM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://picsum.photos/200/200?random=104" class="avatar avatar-xs me-2" alt="user image">
                                                <span>Andrew Nichel</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Bracelet Onu-Lino
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$19,40</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck6">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10426</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 2:19 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-primary">
                                                <span>L</span>
                                            </div>
                                            <span>Laur Gilbert</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Backpack Niver
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$112,50</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck7">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10427</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 3:42 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-dark">
                                                <span>I</span>
                                            </div>
                                            <span>Iryna Innda</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Adidas Vio
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$200,00</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck8">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10428</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">2 Nov, 9:32 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-dark">
                                                <span>A</span>
                                            </div>
                                            <span>Arrias Liunda</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Airpods 2 Gen
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$350,00</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck9">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10429</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">2 Nov, 10:14 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://picsum.photos/200/200?random=101" class="avatar avatar-xs me-2" alt="user image">
                                                <span>Rugna Ilpio</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Bracelet Warret
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$15,00</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck11">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10431</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">2 Nov, 3:12 PM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-dark">
                                                <span>K</span>
                                            </div>
                                            <span>Karl Innas</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Kitchen Gadgets
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$164,90</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck12">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10432</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">2 Nov, 5:12 PM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">done</i></button>
                                            <span>Verified</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-info">
                                                <span>O</span>
                                            </div>
                                            <span>Oana Kilas</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Office Papers
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$23,90</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                            </x-table.body>
                        </x-table.table>
                    </x-card.tabpane-list>
                    <x-card.tabpane-list :title="'Completed'" :isActive="false">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-search-reverted">
                                <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Project</th>
                                    <th>Project Cost</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck10">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10430</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">2 Nov, 12:56 PM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">refresh</i></button>
                                            <span>Reverted</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://picsum.photos/200/300?random=102" class="avatar avatar-xs me-2" alt="user image">
                                                <span>Anna Landa</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                      <span class="my-2 text-xs">
                                        Watter Bottle India
                                        <span class="text-secondary ms-2"> x 3 </span>
                                      </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$25,00</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="{{ route("application.view", 1) }}" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck3">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10423</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 11:13 AM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">refresh</i></button>
                                            <span>Reverted</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-dark">
                                                <span>M</span>
                                            </div>
                                            <span>Michael Mirra</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Leather Wallet
                                                <span class="text-secondary ms-2"> +1 more </span>
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$25,50</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </x-card.tabpane-list>
                    <x-card.tabpane-list :title="'Incomplete'" :isActive="false">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-search-rejected">
                                <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Project</th>
                                    <th>Project Cost</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheck5">
                                            </div>
                                            <p class="text-xs font-weight-normal ms-2 mb-0">#10425</p>
                                        </div>
                                    </td>
                                    <td class="font-weight-normal">
                                        <span class="my-2 text-xs">1 Nov, 1:40 PM</span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-sm" aria-hidden="true">clear</i></button>
                                            <span>Rejected</span>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://picsum.photos/200/200?random=301" class="avatar avatar-xs me-2" alt="user image">
                                                <span>Sebastian Koga</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                              <span class="my-2 text-xs">
                                                Phone Case Pink
                                                <span class="text-secondary ms-2"> x 2 </span>
                                              </span>
                                    </td>
                                    <td class="text-xs font-weight-normal">
                                        <span class="my-2 text-xs">$44,90</span>
                                    </td>
                                    <td class="text-sm">
                                        <a href="preview-application.html" data-bs-toggle="tooltip" data-bs-original-title="Preview Application">
                                            <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                        </a>
                                        <a href="application-edit-form.html" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Application">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete Application">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </x-card.tabpane-list>
                </x-card.card-body>
                <x-slot:footer class="text-sm">CArd Footer</x-slot>
            </x-card.card>
        </div>
    </div>
@endsection
