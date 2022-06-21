@extends('layout.app')
@push('css')
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('title', 'Dashboard')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Trang chủ
                        <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
                        <span class="text-muted fs-7 fw-bold mt-2"></span>
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="m-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-10">
                    <div class="col-xl-12 mb-xl-12">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-200px" style="background-color:#ee4957">
                                <h3 class="card-title align-items-start flex-column text-white pt-15">
                                    <span class="fw-bolder fs-2x mb-3">Thống kê {{$buildingActiveInfo->name}}</span>
                                    {{-- <div class="fs-4 text-white mb-3">
                                        <span class="opacity-75">You have</span>
                                    </div> --}}
                                </h3>

                            </div>
                            <div class="card-body mt-n20">
                                <div class="mt-n20 position-relative">
                                    <div class="row g-3 g-lg-6">
                                        <div class="col-4">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="nav-icon mb-3">
                                                    <i class="fonticon-home fs-1 p-0"></i>
                                                </div>
                                                <div class="m-0">
                                                    <span class="text-gray-700 fw-boldest d-block fs-2qx lh-1 ls-n1 mb-1">{{$apartmentCount}}</span>
                                                    <span class="text-gray-500 fw-bold fs-6">Căn hộ</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="nav-icon mb-3">
                                                    <i class="fonticon-user fs-1 p-0"></i>
                                                </div>
                                                <div class="m-0">
                                                    <span class="text-gray-700 fw-boldest d-block fs-2qx lh-1 ls-n1 mb-1">{{$customerCount}}</span>
                                                    <span class="text-gray-500 fw-bold fs-6">Tài khoản</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="nav-icon mb-3">
                                                    <i class="fonticon-bicycle fs-1 p-0"></i>
                                                </div>
                                                <div class="m-0">
                                                    <span class="text-gray-700 fw-boldest d-block fs-2qx lh-1 ls-n1 mb-1">{{$vehicleCount}}</span>
                                                    <span class="text-gray-500 fw-bold fs-6">Phương tiện</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bolder text-dark">Lịch bảo trì</h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1 "
                                                href="{{ route('admin.building.maintenance_schedule.show') }}">Tất cả</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="card-body pt-2">
                                @foreach ($maintenance_schedule as $item)
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="flex-grow-1 bg-gray-100 bg-opacity-60 rounded-2 px-6 py-5">
                                            <a href="{{ route('admin.building.maintenance_schedule.show') }}" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$item->title}}</a>
                                            <span class="text-muted fw-bold d-block">{{$item->start_at.' ~ '.$item->end_at}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card card-xxl-stretch mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1">Thông báo cư dân</span>
                                    <span class="text-muted mt-1 fw-bold fs-7"></span>
                                </h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1 "
                                                href="">Tất cả</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
                                        <div class="table-responsive">
                                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                                <thead>
                                                    <tr class="border-0">
                                                        <th class="p-0 w-50px"></th>
                                                        <th class="p-0 min-w-150px"></th>
                                                        <th class="p-0 min-w-140px"></th>
                                                        <th class="p-0 min-w-110px"></th>
                                                        <th class="p-0 min-w-50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="symbol symbol-45px me-2">
                                                                <span class="symbol-label">
                                                                    <img src="assets/media/svg/brand-logos/plurk.svg"
                                                                        class="h-50 align-self-center" alt="" />
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="#"
                                                                class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Brad
                                                                Simmons</a>
                                                            <span class="text-muted fw-bold d-block">Movie
                                                                Creator</span>
                                                        </td>
                                                        <td class="text-end text-muted fw-bold">React,
                                                            HTML
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="badge badge-light-success">Approved</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#"
                                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                                        <rect opacity="0.5" x="18" y="13" width="13"
                                                                            height="2" rx="1" transform="rotate(-180 18 13)"
                                                                            fill="currentColor" />
                                                                        <path
                                                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
@endpush
