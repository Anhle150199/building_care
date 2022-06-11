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
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
                    data-action="{{$routeAjax}}" data-method="{{$methodAjax}}" data-id="{{@$apartment->id}}"
                    data-kt-redirect="{{ route('admin.customers.apartment-list') }}">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100
                    @if ($typePage != 'new')
                     w-lg-50
                    @endif mb-7 me-lg-10">
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
                                    <label class="required form-label">Tên căn hộ</label>
                                    <input type="text" name="product_name" class="form-control mb-2"
                                        placeholder="Tên căn hộ" value="{{@$apartment->name}}" />
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Mã căn hộ</label>
                                    <input type="text" name="apartment_code" class="form-control mb-2"
                                        placeholder="Mã căn hộ"
                                        @if (@$typePage == 'new')
                                        value="{{$buildingActiveInfo->building_code.'-'}}"
                                        @else
                                        value="{{$apartment->apartment_code}}"
                                        @endif/>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Toà nhà</label>
                                    <input type="text" name="building" data-id="{{$buildingActiveInfo->id}}"class="form-control mb-2" value='{{$buildingActiveInfo->name}}' disabled="disabled"/>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Tầng</label>
                                    <input type="number" name="floor" class="form-control mb-2" data-floor="{{$buildingActiveInfo->floors_number}}"
                                        placeholder="Số tầng" value="{{@$apartment->floor}}" />
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Trạng thái </label>
                                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" name = "status"
                                        data-placeholder="Chọn trạng thái" id="status_select">
                                        <option value="using" @if (@$apartment->status == 'using') selected="selected" @endif>Đang ở</option>
                                        <option value="absent" @if (@$apartment->status == 'absent') selected="selected" @endif>Vắng</option>
                                        <option value="empty" @if (@$apartment->status == 'empty') selected="selected" @endif> Để trống</option>
                                    </select>
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Chủ căn hộ </label>
                                    <select class="form-select mb-2" data-control="select2" name = "owner" id="owner_select"
                                        data-placeholder="Chọn chủ căn hộ">
                                        <option value=""></option>
                                        @foreach($customers as $value)
                                        <option value="{{$value->id}}" @if (@$apartment->owner_id == $value->id) selected="selected" @endif>{{$value->customer_code}} - {{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Mô tả</label>
                                    <div id="kt_ecommerce_add_product_description"
                                        name="kt_ecommerce_add_product_description" class="min-h-200px mb-2">
                                    </div>
                                    <div class="d-none" id="descriptionBuilding">
                                         {{@$apartment->description}}
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
                    @if ($typePage != 'new')
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                    <div class="d-flex flex-column gap-7 gap-lg-10">
                                        <div class="card card-xl-stretch mb-5 ">
                                            <div class="card-header border-0 pt-5">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bolder fs-3 mb-1">Cư dân</span>
                                                </h3>
                                                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" >
                                                    <a href="{{ route('admin.customers.show-customer-create') }}" class="btn btn-sm btn-light btn-active-primary" >
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    Thêm mới</a>
                                                </div>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                        <thead>
                                                            <tr class="fw-bolder text-muted">
                                                                <th class="min-w-100px">Họ tên</th>
                                                                <th class="min-w-100px">Liên hệ</th>
                                                                <th class="min-w-100px text-end">Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ( @$apartmentCustomer as $item )
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex justify-content-start flex-column">
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{$item->name}}</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$item->phone}}</a>
                                                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->email}}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                                        <a href="{{ route('admin.customers.show-customer-update', ['id'=>$item->id]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                                            <span class="svg-icon svg-icon-3">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                                                </svg>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                                            <div class="card-header border-0 pt-5">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bolder fs-3 mb-1">Phương tiện</span>
                                                </h3>
                                                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    Thêm mới</a>
                                                </div>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                        <thead>
                                                            <tr class="fw-bolder text-muted">
                                                                <th class="min-w-100px">Phương tiện</th>
                                                                <th class="min-w-100px">Trạng thái</th>
                                                                <th class="min-w-100px text-end">Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ( @$apartmentVehicle as $item )
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex justify-content-start flex-column">
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                                                                @if ($item->category == 'motorbike')
                                                                                    {{"Xe máy"}}
                                                                                @elseif ($item->category == 'car')
                                                                                    {{"Ô tô "}}
                                                                                @else
                                                                                    {{"Xe máy điện "}}
                                                                                @endif
                                                                                {{$item->model}}</a>
                                                                                <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->license_plate_number}}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{$item->status}}</td>
                                                                <td>
                                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                                            <span class="svg-icon svg-icon-3">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                                                </svg>
                                                                            </span>
                                                                        </a>
                                                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                                            <span class="svg-icon svg-icon-3">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                                                </svg>
                                                                            </span>
                                                                            </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var description =  $('#descriptionBuilding').text().trim();
    </script>
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/custommer/apartment/save-detail.js"></script>
    <script>
        let quill = new Quill("#kt_ecommerce_add_product_description", {});
        quill.root.innerHTML = description;
        $(function(){
            if($('#status_select').val() == 'empty'){
                $('#owner_select').parent().hide();
            }
            $('#status_select').change(function(){
                if($('#status_select').val()=='empty'){
                    $('#owner_select').parent().hide();
                } else{
                    $('#owner_select').parent().show();
                }
            })
        })
    </script>
@endpush
