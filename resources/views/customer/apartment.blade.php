@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Danh sách căn hộ toà nhà ')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Header --}}
        <div class="toolbar" id="kt_toolbar" data-route-delete="{{ route('admin.customers.apartment-delete') }}">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Quản lý căn hộ</h1>

                    <span class="h-20px border-gray-300 border-start mx-4"></span>

                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Căn hộ, cư dân</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Quản lý căn hộ</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                </div>
            </div>
        </div>
        {{-- Body List --}}
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" data-kt-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Tìm kiếm" />
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-table-toolbar="base">

                                {{-- Export --}}
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_export_modal">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-download"></i>
                                    </span>Export
                                </button>
                                {{-- Inport --}}
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_import_modal">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-upload"></i>
                                    </span>Tải lên file Excel
                                </button>
                                {{-- Thêm mới --}}
                                <a href="{{ route('admin.customers.show-apartment-new') }}" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    Thêm mới
                                </a>
                            </div>
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-table-toolbar="selected">
                                <div class="fw-bolder me-5">Đã chọn
                                    <span class="me-2" data-kt-table-select="selected_count"></span>
                                </div>
                                <button type="button" class="btn btn-danger"
                                    data-kt-table-select="delete_selected">Xoá</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_table .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-100px">Căn hộ</th>
                                    <th class="min-w-75px">Chủ hộ</th>
                                    <th class="min-w-100px">Trạng thái</th>
                                    <th></th>
                                    <th class="min-w-100px">Số phương tiện</th>
                                    <th class="text-center min-w-70px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($apartmentList as $item)
                                    <tr data-id={{ $item->id }} id="row_{{ $item->id }}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $item->id }}" />
                                            </div>
                                        </td>
                                        <td data-order="{{ $item->floor }}">
                                            <a href="{{ route('admin.customers.show-apartment-update', ['id' => $item->id]) }}"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $item->name }}</a>
                                            <span
                                                class="text-muted fw-bold text-muted d-block fs-7">{{ $item->apartment_code }}</span>
                                        </td>
                                        <td>
                                            @isset($item->owner)
                                                {{ $item->owner }}
                                            @endisset()
                                        </td>
                                        <td>
                                            @if ($item->status == 'using')
                                                <div class="badge badge-light-success">Đang ở</div>
                                            @elseif ($item->status == 'empty')
                                                <div class="badge badge-light-danger">Để trống</div>
                                            @elseif ($item->status == 'absent')
                                                <div class="badge badge-light-warning">Vắng</div>
                                            @endif
                                        </td>
                                        <td></td>
                                        <td>{{ $item->vehicle_number }}</td>
                                        <td class="text-center">
                                            <a href="#"
                                                class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect x="10" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                        <rect x="17" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                        <rect x="3" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('admin.customers.show-apartment-update', ['id' => $item->id]) }}"
                                                        class="menu-link px-3">Chỉnh sửa</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" data-kt-table-filter="delete_row"
                                                        class="menu-link px-3">Xoá</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal Export --}}
                <div class="modal fade" id="kt_export_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h2 class="fw-bolder">Xuất danh sách</h2>
                                <div id="kt_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <form id="kt_export_form" class="form" action="#">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-5">Chọn định dạng:</label>
                                        <select data-control="select2" data-placeholder="Chọn định dạng"
                                            data-hide-search="true" name="format" class="form-select form-select-solid">
                                            <option value="excel">Excel</option>
                                            <option value="pdf">PDF</option>
                                            <option value="csv">CSV</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="reset" id="kt_export_cancel"
                                            class="btn btn-light me-3">Huỷ</button>
                                        <button type="submit" id="kt_export_submit" class="btn btn-primary">
                                            <span class="indicator-label">Xuất</span>
                                            <span class="indicator-progress">Đang xuất...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modal Import --}}
                <div class="modal fade " id="kt_import_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-850px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="fw-bolder">Nhập dữ liệu file excel</h2>

                                <div id="kt_export_close" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <span class="svg-icon svg-icon-1">
                                        <i class="bi bi-x-lg"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                {{-- <form id="kt_export_form" class="form" action="#"> --}}
                                <div class="fv-row mb-10 text-center w-100">
                                    <button class="btn btn-primary" id="btn_upload_file">Tải lên</button>
                                    <input type="file" name="file_import" id="file_import" hidden
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div>
                                <div class="show_data" style="display: none;">
                                    <div class="show_data text-center" id="show_import">

                                    </div>
                                </div>
                                {{-- </form> --}}
                            </div>
                            <div class="modal-footer show_data" style="display: none;">
                                <div class="text-center">
                                    <button type="reset" data-bs-dismiss="modal" aria-label="Close"
                                        class="btn btn-light me-3">Huỷ</button>
                                    <button type="submit" id="kt_import_submit" class="btn btn-primary" >
                                        <span class="indicator-label">Lưu</span>
                                        <span class="indicator-progress">Đang lưu...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>

    <script src="{{ url('/') }}/assets/js/custom/building/list/export.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/custommer/apartment/list.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js"></script>
    <style>
        #kt_table_filter {
            display: none;
        }
    </style>
    <script>
        var dataAjax = [];
        var process = `<span class="spinner-border text-primary ms-2" style="font-size: 20px;"></span>`;
        $("#btn_upload_file").on("click", () => {
            $("#file_import").click()
        })
        $("#file_import").on("change", function() {
            $(".show_data").show();
            $("#show_import").html(process)
            upload();
        })

        $('#kt_import_modal').on('hidden.bs.modal', function() {
            $(".show_data").hide();
            $("#show_import").html('');
            $("#file_import").val('');
        })

        function upload() {
            var files = document.getElementById('file_import').files;
            if (files.length == 0) {
                alert("Please choose any file...");
                return;
            }
            var filename = files[0].name;
            var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
            if (extension == '.XLS' || extension == '.XLSX') {
                //Here calling another method to read excel file into json
                excelFileToJSON(files[0]);
            } else {
                alert("Please select a valid excel file.");
            }
        }
        //Method to read excel file and convert it into JSON
        function excelFileToJSON(file) {
            try {
                var reader = new FileReader();
                let xxx;
                reader.readAsBinaryString(file);
                reader.onload = function(e) {
                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type: 'binary'
                    });
                    var result = {};
                    var firstSheetName = workbook.SheetNames[0];
                    //reading only first sheet data
                    var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName]);
                    //displaying the json result into HTML table
                    displayJsonToHtmlTable(jsonData);
                }
            } catch (e) {
                console.error(e);
            }
        }
        //Method to display the data in HTML Table
        function displayJsonToHtmlTable(jsonData) {
            if (jsonData.length > 0 && jsonData.length <= 30) {
                let element = `<table class="table table-striped">
                    <thead class="thead-primary">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">building_id</th>
                        <th scope="col">owner_id</th>
                        <th scope="col">name</th>
                        <th scope="col">apartment_code</th>
                        <th scope="col">floor</th>
                        <th scope="col">status</th>
                        </tr>
                    </thead>
                    <tbody>`;
                jsonData.forEach((e, key) => {
                    // console.log(e);
                    element += `<tr>
                        <th scope="row">${key+1}</th>
                        <td>${e.building_id}</td>
                        <td>${e.owner_id?e.owner_id:''}</td>
                        <td>${e.name}</td>
                        <td>${e.apartment_code}</td>
                        <td>${e.floor}</td>
                        <td>${e.status}</td>
                        </tr>`
                    dataAjax.push(e);
                });

                element += `</tbody></table>`
                $("#show_import").html(element);
                // console.log(jsonData);
                $("#kt_import_submit").attr('disabled', false);
            } else {
                $("#show_import").html('<span>File không thuộc dang Excel hoặc quá 30 dòng.</span>')
                $("#kt_import_submit").attr('disabled', true);
                $("#show_import").html('');

            }
        }

        $("#kt_import_submit").click(e => {
            console.log(JSON.stringify(dataAjax));
            $("#kt_import_submit").attr('disabled', true);
            $(".indicator-label").hide();
            $(".indicator-progress").show()
            $.ajax({
                url: "{{route('admin.customers.apartment-import-excel')}}",
                type: "post",
                data: {
                    data: JSON.stringify(dataAjax),
                    _token: "{{csrf_token()}}"
                },
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        text: "Thành công!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(e){
                        $("#kt_import_modal").modal("hide")
                        location.reload();
                    })
                },
                error: function(data){
                    console.log(data);
                    let text = "Có lỗi khi import dữ liệu!";
                    if(data.responseJSON.codeDataError){
                        text = "Các căn hộ: ";
                        data.responseJSON.codeDataError.forEach(element => {
                            text+=" "+element+" ";
                        });
                        text+= " bị lỗi hoặc trùng mã căn hộ."
                    }
                    Swal.fire({
                        text: text,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(e){
                        $("#kt_import_modal").modal("hide")
                        location.reload();
                    })
                }
            })
        })
    </script>
@endpush
