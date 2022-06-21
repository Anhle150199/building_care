@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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
                        {{ $title }}
                    </h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>

                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Thông báo, Tin tức</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            {{ $title }}
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
                    data-action="{{ $routeAjax }}" data-method="{{ $methodAjax }}" data-id="{{ @$item->id }}"
                    data-kt-redirect="{{ route('admin.building.building-list') }}">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Thông tin</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <label class="form-label required">Trạng thái</label>
                                <div class="gap-3 fv-row">
                                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                        name="status" data-placeholder="Chọn trạng thái"
                                        id="status_select">
                                        <option value="public" @if (@$item->status == 'public') selected="selected" @endif>
                                            Công khai</option>
                                        <option value="private"
                                            @if (@$item->status == 'private') selected="selected" @endif>Riêng tư</option>
                                    </select>
                                </div>
                                <label class="form-label required">Danh mục</label>
                                <div class="gap-3 fv-row">
                                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                        name="category" id="category_select">
                                        <option value="notify" @if (@$item->category == 'notify') selected="selected" @endif>
                                            Thông báo</option>
                                        <option value="event" @if (@$item->category == 'event') selected="selected" @endif>
                                            Tin tức</option>
                                    </select>
                                </div>
                                <label class="form-label required">Đối tượng</label>
                                <div class="d-flex fv-row row mb-2">
                                    <div class="form-check form-check-custom col-6 form-check-solid">
                                        <input class="form-check-input me-3" name="sent_type" type="radio" value="1"
                                        @if ($typePage == 'new' || @$item->sent_type == 1)
                                            checked
                                        @endif
                                             id="kt_object_1" />
                                        <label class="form-check-label" for="kt_object_1">
                                            <div class="fw-bolder text-gray-800">Tất cả</div>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid col-6">
                                        <input class="form-check-input me-3" name="sent_type" type="radio" value="0"
                                        @isset($item->sent_type)
                                            @if ( @$item->sent_type == 0)
                                                checked
                                            @endif
                                        @endisset
                                            id="kt_object_2" />
                                        <label class="form-check-label" for="kt_object_2">
                                            <div class="fw-bolder text-gray-800">Toà nhà</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="gap-3 fv-row"

                                @if ($typePage == 'new' || @$item->sent_type == 1)
                                style="display: none;"
                                @endif
                                >
                                    <select class="form-select form-select-solid mb-2 " data-control="select2" multiple="multiple"
                                        name="building_select" id="building_select" data-placeholder="Chọn toà nhà">
                                        <option value=""></option>
                                        @foreach ($buildingList as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                                <h2>Tổng quan</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Tiêu đề</label>
                                                <input type="text" name="title" class="form-control mb-2"
                                                    placeholder="Tiêu đề" value="{{ @$item->title }}" />
                                            </div>

                                            <div class="mb-10 fv-row">
                                                <label class="form-label required">Hình ảnh</label>
                                                <input type="file" hidden name="image" onchange="loadFile(event)"  />

                                                <div class="input-group mb-3" id='btn-image' style="cursor: pointer;">
                                                    <button class="input-group-text" type="button" id="inputGroup-sizing-default">Chọn file</button>
                                                    <span class="form-control" disabled aria-describedby="inputGroup-sizing-default" >
                                                        @if ($typePage == 'new')
                                                        Chấp nhận các file ảnh jpg, jpeg, png, gif, webp.
                                                        @endif  {{@$item->image}}</span>
                                                  </div>

                                            </div>
                                            <div>
                                                <label class="required form-label">Nội dung</label>
                                                <div id="kt_description"
                                                    name="kt_description" class="min-h-200px mb-2">
                                                </div>
                                                <div class="d-none" id="descriptionBuilding">
                                                    {{ @$item->description }}
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
        var description = $('#descriptionBuilding').text().trim();
    </script>
    {{-- <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/notify/save-nnotify.js"></script>
    <script>
        let quill = new Quill("#kt_description", {});
        quill.root.innerHTML = description;
        $(function () {
            $("input:radio[name=sent_type]").on("change", function() {
                $('#building_select').parent().toggle();
            })
            $('#btn-image').click(function(){
                $('input[name=image]').click();
            })
            $('input[name=image]').change(function(){

            })
        })
        var loadFile = function(event) {
            $('#btn-image span').text(event.target.files[0].name);
        };

    </script>
@endpush
