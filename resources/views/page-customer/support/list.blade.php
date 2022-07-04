@extends('page-customer.layout.app')
@section('title', 'Hỗ trợ')
@push('css')
@endpush
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
                            <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="#">
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
                            <div class="form-group">
                                <label class="form-label" for="message">Nội dung</label>
                                <textarea class="form-control" id="message" name="textarea" cols="3" rows="7" placeholder="Nội dung"></textarea>
                            </div>

                            <div class="input-group fv-row mb-3">
                                <label class="form-label" for="image">Hình ảnh</label> 
                                <input class="form-control" type="file" id="image" name="image" multiple />
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Gửi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Add New Contact --}}
        <div class="add-new-contact-wrap"><a class="shadow" href="#" data-bs-toggle="modal"
                data-bs-target="#addnewcontact"><i class="bi bi-plus-lg"></i></a></div>
        <div class="container">
            <div class="element-heading">
                <h6 class="ps-1">Hỗ trợ gần đây</h6>
            </div>
            <ul class="ps-0 chat-user-list">
                <!-- Single Chat User -->
                <li class="p-3 chat-unread"><a class="d-flex" href="page-chat.html">
                        <!-- Thumbnail -->
                        <div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="img/bg-img/user1.png"
                                alt=""><span class="active-status"></span></div>
                        <!-- Info -->
                        <div class="chat-user-info">
                            <h6 class="text-truncate mb-0">Designing World</h6>
                            <div class="last-chat">
                                <p class="mb-0 text-truncate">Hello, Are you there?<span
                                        class="badge rounded-pill bg-primary ms-2">2</span></p>
                            </div>
                        </div>
                    </a>
                    <!-- Options -->
                    <div class="dropstart chat-options-btn">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="bi bi-mic-mute"></i>Mute</a></li>
                            <li><a href="#"><i class="bi bi-slash-circle"></i>Ban</a></li>
                            <li><a href="#"><i class="bi bi-trash"></i>Remove</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

@endsection

@push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'name': {
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

        let x = '<p>' + $('textarea').val().replace(/\n/g, "</p><p>") + '</p>'
    </script>
@endpush
