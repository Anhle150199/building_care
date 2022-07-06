@extends('page-customer.layout.app')
@section('title', 'Hỗ trợ')

@push('css')
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .fs-11px {
            font-size: 11px;
        }
        .string-2 {
            overflow: hidden;
            line-height: 24px;
            -webkit-line-clamp: 1;
            height: 22px;
            display: -webkit-box;
            /* width: 136px; */
            -webkit-box-orient: vertical;
        }

    </style>
@endpush
<?php
 function getTimeAgo($carbonObject) {
    return str_ireplace(
        [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
        ['giây', 'giây', 'phút', 'phút', 'giờ', 'giờ', 'ngày', 'ngày', 'tuần', 'tuần'],
        $carbonObject->diffForHumans()
    );
}
?>
@section('content')

    <div class="page-content-wrapper py-3">

        {{-- Add new contact modal --}}
        <div class="add-new-contact-modal modal fade px-0" id="addnewcontact" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="modal-title" id="addnewcontactlabel">New message</h6>
                            <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal" id="btn-close-modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="form-support" data-action="{{ route('user.support.create') }}">
                            @csrf
                            <div class="input-group fv-row mb-3">
                                <span class="input-group-text" id="to">To</span>
                                <select class="form-control" name="to" id="to-select">
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}">Phòng {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group fv-row mb-3">
                                <span class="input-group-text">Chủ đề</span>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="Chủ đề">
                            </div>
                            <div class="form-group fv-row">
                                <label class="form-label" for="message">Nội dung</label>
                                <textarea class="form-control" id="message" name="message" cols="3" rows="7" placeholder="Nội dung"
                                    style="min-height: 150px;"></textarea>
                            </div>

                            <div class=" input-group mb-3 w-100" id="show-upload">
                            </div>
                            <div class=" mb-3">
                                <span id="btn-image" class="btn btn-icon">
                                    <i class="bi bi-images"></i>
                                </span>
                                <button type="submit" id="btn_submit" class="btn btn-danger float-end">
                                    <span class="indicator-label">Gửi</span>
                                    <span class="indicator-progress">Đang tải...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>

                                <input type="file" multiple id="input-image" hidden accept="image/*">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add New Contact --}}
        <div class="add-new-contact-wrap"><a class="shadow bg-danger" href="#" data-bs-toggle="modal"
                data-bs-target="#addnewcontact"><i class="bi bi-plus-lg"></i></a></div>
        <div class="container">
            <div class="element-heading">
                <h6 class="ps-1">Hỗ trợ gần đây</h6>
            </div>
            <ul class="ps-0 chat-user-list">
                @if (sizeof($list) > 0)
                @foreach ($list as $item)
                    <li class="p-3 @if($item->status != 'processed')chat-unread @endif">
                        <a class="d-flex" href="{{ route('user.support.show-detail', ['id'=>$item->id]) }}">
                            <!-- Info -->
                            <div class="chat-user-info">
                                <h6 class="text-truncate mb-0"><i class="bi bi-box-arrow-in-right"></i> Phòng {{$item->name}}
                                </h6>
                                <div class="last-chat">
                                    <p class="mb-0 string-2"><i class="bi bi-caret-right-fill"></i>  {{$item->title}}</p>
                                </div>
                            </div>

                        <div class="dropstart ">
                            @if($item->status != 'processed')
                            <span class="badge rounded-pill bg-danger ms-2">Đang xử lý</span>
                            @else
                            <span class="badge rounded-pill bg-success ms-2">Đã xử lý</span>
                            @endif
                            <p class="fs-11px text-end">{{$item->created_at->diffForHumans()}}</p>
                        </div>
                        </a>
                    </li>
                @endforeach
                @else
                <li class="p-3">
                    <span>Không có dữ liệu!</span>
                </li>
                @endif
            </ul>
        </div>
    </div>

@endsection

@push('js')
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>

    <script>
        $("#btn-image").click(() => {
            $("#input-image").click()
        })
        $('#input-image').on('change', function() {
            if (this.files) {
                var filesAmount = this.files.length;

                for (i = 0; i < filesAmount; i++) {

                    var reader = new FileReader();
                    let name = this.files[i].name;

                    if (!/\.(jpe?g|png|gif)$/i.test(name)) {
                        return showToast('warning', name + " không phải hình ảnh");
                    }

                    reader.onload = function(event) {
                        let show =
                            `<span class="w-100 fs-11px border rounded p-1 mb-1 span-show" src= "${event.target.result}">${name}<i class="bi bi-x-circle-fill float-end text-danger" onclick="removeFunc(this)"></i></span>`;
                        $('#show-upload').append(show);
                    }

                    reader.readAsDataURL(this.files[i]);
                    console.log(this.files[i]);
                }
            }
        });
        const removeFunc = e => {
            $(e).parent().remove();
        }
        const addToList = (department, title)=>{
            $(".chat-user-list").prepend(
            `<li class="p-3 chat-unread">
                <a class="d-flex" href="page-chat.html">
                    <div class="chat-user-info">
                        <h6 class="text-truncate mb-0"> <i class="bi bi-caret-right-fill"></i> Phòng ${department}</h6>
                        <div class="last-chat">
                            <p class="mb-0 string-2"><i class="bi bi-caret-right-fill"></i> ${title}</p>
                        </div>
                    </div>

                    <div class="dropstart ">
                        <span class="badge rounded-pill bg-danger ms-2">Đang xử lý</span>
                        <p class="fs-11px text-end">0 phút trước</p>
                    </div>
                </a>
            </li>`)
        };
        var form = document.querySelector('#form-support');
        var notEmptyMessage = 'Trường này không được để trống';

        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'title': {
                        validators: {
                            notEmpty: {
                                message: notEmptyMessage
                            },
                        }
                    },

                    'message': {
                        validators: {
                            notEmpty: {
                                message: notEmptyMessage
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );
        $('#btn_submit').click(function(e) {
            e.preventDefault();
            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    toggleBtnSubmit();
                    let token = $('input[name=_token]').val();
                    let to = $('#to-select').val();
                    let title = $('#title').val();
                    let content = '<p>' + $('#message').val().replace(/\n/g, "</p><p>") + '</p>';
                    let image = [];
                    $(".span-show").each(function() {
                        image.push($(this).attr('src'))
                    })
                    let data = {
                        _token: token,
                        to: to,
                        title: title,
                        content: content,
                        images: image,
                    }
                    console.log(data);
                    $.ajax({
                        url: $('#form-support').data('action'),
                        type: 'post',
                        data: data,
                        typeData: 'json',
                        success: function(data) {
                            console.log(data);
                            showToast('success');
                            toggleBtnSubmit();
                            addToList($("#to-select option:selected").text(),title)
                            $('#form-support').trigger("reset");
                            $(".span-show").remove();
                            $('#btn-close-modal').click();

                        },
                        error: function(data) {
                            console.log(data);
                            showToast('danger');
                            toggleBtnSubmit();
                        }
                    })

                } else {
                    showToast('warning');
                }
            });
        });
    </script>
@endpush
