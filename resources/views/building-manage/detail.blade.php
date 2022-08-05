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
                        @if (@$typePage == 'new')
                        Thêm mới toà nhà
                        @else
                        Chi tiết toà nhà
                        @endif
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
                        <li class="breadcrumb-item text-muted">Quản lý toà nhà</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            @if (@$typePage == 'new')
                            Thêm mới toà nhà
                            @else
                            Chi tiết toà nhà
                            @endif
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
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
                    data-action="{{$routeAjax}}" data-method="{{$methodAjax}}" data-id="{{@$building->id}}"
                    data-kt-redirect="{{ route('admin.building.building-list') }}">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Trạng thái</h2>
                                </div>
                                <div class="card-toolbar">
                                    <div class="rounded-circle
                                        @if (@$building->status == 'prepare') bg-warning
                                        @elseif(@$building->status == 'lock') bg-danger
                                        @else bg-success @endif() w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <select class="form-select mb-2" data-control="select2" data-hide-search="true" name = "status"
                                    data-placeholder="Chọn trạng thái" id="kt_ecommerce_add_product_status_select">
                                    <option value="active" @if (@$building->status == 'active') selected="selected" @endif>Kích hoạt</option>
                                    <option value="prepare" @if (@$building->status == 'prepare') selected="selected" @endif> Chuẩn bị</option>
                                    <option value="lock" @if (@$building->status == 'lock') selected="selected" @endif>Khoá</option>
                                </select>
                                <div class="text-muted fs-7">Chọn trạng thái của toà nhà.</div>
                                {{-- <div class="d-none mt-10">
                                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select
                                        publishing date and time</label>
                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker"
                                        placeholder="Pick date &amp; time" />
                                </div>ss="d-none mt-10">
                                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select
                                        publishing date and time</label>
                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker"
                                        placeholder="Pick date &amp; time" />
                                </div> --}}
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Thông số toà nhà</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <label class="form-label">Chiều cao (m)</label>
                                <div class="gap-3 fv-row">
                                    <input type="number" name="height" class="form-control mb-2" placeholder="Chiều cao" value="{{@$building->height}}"/>
                                </div>

                                <label class="form-label required">Số tầng</label>
                                <div class="gap-3 fv-row">
                                    <input type="number" name="floors_number" class="form-control mb-2" placeholder="Số tầng" value="{{@$building->floors_number}}"/>
                                </div>

                                <label class="form-label required">Số phòng</label>
                                <div class=" gap-3 fv-row">
                                    <input type="number" name="apartment_number" class="form-control mb-2" placeholder="Số phòng" value="{{@$building->apartment_number}}"/>
                                </div>
                                <div class="text-muted fs-7 mb-7">Các thông số cơ bản của toà nhà.</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Thông tin chung</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Tên toà nhà</label>
                                                <input type="text" name="product_name" class="form-control mb-2"
                                                    placeholder="Tên toà nhà" value="{{@$building->name}}" />
                                                <div class="text-muted fs-7">Tên toà nhà là bắt buộc và duy nhất.</div>
                                            </div>
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Mã toà nhà</label>
                                                <input type="text" name="building_code" class="form-control mb-2"
                                                    placeholder="Mã toà nhà" value="{{@$building->building_code}}" />
                                                <div class="text-muted fs-7">Mã toà nhà là bắt buộc và duy nhất.</div>
                                            </div>
                                            <div class="mb-10 fv-row">
                                                <label class=" form-label">Địa chỉ</label>
                                                <input type="text" name="address" class="form-control mb-2"
                                                    placeholder="Địa chỉ toà nhà" value="{{@$building->address}}" />
                                            </div>
                                            <div class="mb-10  row">
                                                <div class="col-6 fv-row">
                                                    <label class="required form-label">Email</label>
                                                    <input type="text" name="email" class="form-control mb-2"
                                                        placeholder="Địa chỉ email toà nhà" value="{{@$building->email}}" />
                                                </div>
                                                <div class="col-6 fv-row">
                                                    <label class=" form-label">Số điện thoại</label>
                                                    <input type="text" name="phone" class="form-control mb-2"
                                                        placeholder="Số điện thoại toà nhà" value="{{@$building->phone}}" />
                                                </div>
                                            </div>
                                            <div>
                                                <label class="form-label">Mô tả</label>
                                                <div id="kt_ecommerce_add_product_description"
                                                    name="kt_ecommerce_add_product_description" class="min-h-200px mb-2">

                                                </div>
                                                <div class="text-muted fs-7">Mô tả về toà nhà.</div>
                                                <div class="d-none" id="descriptionBuilding">
                                                     {{@$building->description}}
                                                </div>
                                            </div>
                                        </div>
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
        var description =  $('#descriptionBuilding').text().trim();
    </script>
    {{-- <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/building/save-product.js"></script>
    <script>
        let quill = new Quill("#kt_ecommerce_add_product_description", {});
        quill.root.innerHTML = description;
    </script>
@endpush
