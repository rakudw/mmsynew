@extends('layouts.admin')

@section('title', $title ?? __("DIC - Update Application"))

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="{{ route('dic-dh.index') }}">{{ __("Dic - DH") }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title ?? __('DIC - Update Application') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('DIC - Update Application') }}</h6>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h4>Make the changes below</h4>
            <p>We’re constantly trying to express ourselves and actualize our dreams. If you have the opportunity to play.</p>
        </div>
        <div class="col-lg-6 text-right d-flex flex-column justify-content-center">
            <button type="button" class="btn bg-gradient-primary mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2">Save</button>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card mt-4" data-animation="true">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <a class="d-block blur-shadow-image">
                        <img src="https://picsum.photos/200/300?random=1" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                    </a>
                    <div class="colored-shadow" style="background-image: url(https://picsum.photos/600/600?random=101);"></div>
                </div>
                <div class="card-body text-center">
                    <div class="mt-n6 mx-auto">
                        <button class="btn bg-gradient-primary btn-sm mb-0 me-2" type="button" name="button">Edit</button>
                        <button class="btn btn-outline-dark btn-sm mb-0" type="button" name="button">Remove</button>
                    </div>
                    <h5 class="font-weight-normal mt-4">
                        Application Image
                    </h5>
                    <p class="mb-0">
                        The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Barcelona.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bolder">Product Information</h5>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6">
                            <div class="input-group input-group-dynamic">
                                <label class="form-label">Name</label>
                                <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-dynamic">
                                <label class="form-label">Weight</label>
                                <input type="email" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3">
                            <div class="input-group input-group-dynamic">
                                <label class="form-label">Collection</label>
                                <input type="email" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-dynamic">
                                <label class="form-label">Price</label>
                                <input type="email" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-dynamic">
                                <label class="form-label">Quantity</label>
                                <input type="email" class="form-control w-100" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="mt-4">Description</label>
                            <p class="form-text text-muted text-xs ms-1 d-inline">
                                (optional)
                            </p>
                            <div id="edit-deschiption-edit" class="h-50">
                                Long sleeves black denim jacket with a twisted design. Contrast stitching. Button up closure. White arrow prints on the back.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="mt-4 ms-0">Category</label>
                            <select class="form-control" name="choices-category" id="choices-category-edit">
                                <option value="Choice 1" selected="">Furniture</option>
                                <option value="Choice 2">Real Estate</option>
                                <option value="Choice 3">Electronics</option>
                                <option value="Choice 4">Clothing</option>
                                <option value="Choice 5">Others</option>
                            </select>
                            <label class="ms-0">Color</label>
                            <select class="form-control" name="choices-color" id="choices-color-edit">
                                <option value="Choice 1" selected="">Black</option>
                                <option value="Choice 2">White</option>
                                <option value="Choice 3">Blue</option>
                                <option value="Choice 4">Orange</option>
                                <option value="Choice 5">Green</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bolder">Socials</h5>
                    <div class="input-group input-group-dynamic mt-3">
                        <label class="form-label">Shoppify Handle</label>
                        <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                    <div class="input-group input-group-dynamic my-3">
                        <label class="form-label">Facebook Account</label>
                        <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                    <div class="input-group input-group-dynamic">
                        <label class="form-label">Instagram Account</label>
                        <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 mt-sm-0 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="font-weight-bolder mb-3">Pricing</h5>
                        <div class="col-3"">
                        <div class=" input-group input-group-dynamic">
                            <label class="form-label">Price</label>
                            <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="choices-sizes" id="choices-currency-edit">
                            <option value="Choice 1" selected="">USD</option>
                            <option value="Choice 2">EUR</option>
                            <option value="Choice 3">GBP</option>
                            <option value="Choice 4">CNY</option>
                            <option value="Choice 5">INR</option>
                            <option value="Choice 6">BTC</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <div class="input-group input-group-dynamic">
                            <label class="form-label">SKU</label>
                            <input type="email" class="form-control w-100" aria-describedby="emailHelp" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="mt-4">Tags</label>
                        <select class="form-control" name="choices-tags" id="choices-tags-edit" multiple>
                            <option value="Choice 1" selected>In Stock</option>
                            <option value="Choice 2">Out of Stock</option>
                            <option value="Choice 3">Sale</option>
                            <option value="Choice 4">Black Friday</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/assets/css/admin-pro.css") }}">
@endsection
@section('scripts')
    <script src="{{ asset("admin/assets/js/plugins/choices.js") }}"></script>
    <script src="{{ asset("admin/assets/js/plugins/multistep-form.js") }}"></script>
    <script>
        if (document.getElementById('choices-tags')) {
            var tags = document.getElementById('choices-tags');
            const examples = new Choices(tags, {
                removeItemButton: true
            });

            examples.setChoices(
                [{
                    value: 'One',
                    label: 'Expired',
                    disabled: true
                },
                    {
                        value: 'Two',
                        label: 'Out of Stock',
                        selected: true
                    }
                ],
                'value',
                'label',
                false,
            );
        }
    </script>
@endsection
