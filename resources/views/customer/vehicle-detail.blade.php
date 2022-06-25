@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('title', $title)
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Header --}}
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">
                        {{$title}}
                    </h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Căn hộ cư dân</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            {{$title}}
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                </div>
            </div>
        </div>
        {{-- Body chi tiet --}}
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column justify-content-center flex-lg-row"
                    data-action="{{$routeAjax}}" data-method="{{$methodAjax}}" data-id="{{@$item->id}}"
                    data-kt-redirect="{{ route('admin.customers.vehicle-list') }}">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-75 mb-7 me-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title ">
                                    <h2>Thông tin chung</h2>
                                </div>
                                <div class="card-toolbar">
                                </div>

                            </div>
                            <div class="card-body pt-0">

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Căn hộ </label>
                                    <select data-control="select2" data-placeholder="Chọn căn hộ" data-hide-search="false"
                                        name="apartment" id="apartment_select"
                                        class="btn btn-custom btn-primary w-100 form-select form-select-solid">
                                        <option value=""></option>
                                        @foreach ($apartments as $value)
                                            <option value="{{ $value->id }}" @if ($value->id == @$item->apartment_id) selected=true @endif>{{ $value->apartment_code}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Loại phương tiện </label>
                                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" name = "category"
                                        data-placeholder="Chọn loại phương tiện" id="category_select">
                                        <option ></option>
                                        <option value="car" @if (@$item->category == 'car') selected="selected" @endif>Ô tô</option>
                                        <option value="motorbike" @if (@$item->category == 'motorbike') selected="selected" @endif>Xe máy</option>
                                        <option value="electric_motorbike" @if (@$item->category == 'electric_motorbike') selected="selected" @endif> Xe điện</option>
                                    </select>
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Model</label>
                                    <input type="text" name="model" class="form-control mb-2"
                                        placeholder="Model" value="{{@$item->model}}" />
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Biển số xe</label>
                                    <input type="text" name="license_plate_number" class="form-control mb-2"
                                        placeholder="Biển số xe" value="{{@$item->license_plate_number}}"/>
                                </div>

                                <div>
                                    <label class="form-label">Mô tả</label>
                                    <div id="kt_ecommerce_add_product_description"
                                        name="kt_ecommerce_add_product_description" class="min-h-200px mb-2">
                                    </div>
                                    <div class="d-none" id="descriptionVehicle">
                                         {{@$item->description}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                <span class="indicator-label">Lưu</span>
                                <span class="indicator-progress">Đang lưu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var description =  $('#descriptionVehicle').text().trim();
    </script>
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/custommer/vehicle/save-detail.js"></script>
    <script>
        let quill = new Quill("#kt_ecommerce_add_product_description", {});
        quill.root.innerHTML = description;
        $(function(){

        })
    </script>
@endpush
