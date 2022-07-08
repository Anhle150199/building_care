@extends('page-customer.layout.app-detail')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .chat-footer {
            position: fixed;
            width: 100%;
            height: auto;
            background-color: #ffffff;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .item img {
            height: auto;
            max-width: 100px;
            max-height: 100px;
        }

        #show-upload {
            overflow-x: auto;
            display: flex;
        }

        textarea.form-control {
            min-height: 50px;
        }

        .chat-footer form .form-control {
            background-color: #f1f2fb;
            border-color: #f1f2fb;
            color: #000000;
            border-radius: 9px;
        }
    </style>
@endpush
@section('back', route('user.support.show-list'))
@section('title', 'Hỗ trợ | ' . $title)
@section('page', 'support')
@section('content')

    <div class="page-content-wrapper py-3" id="chat-wrapper">
        <div class="container">
            <div class="chat-content-wrap" id="chat-body">
                <!-- Single Chat Item -->
                <div class="single-chat-item ">
                    <div class="user-avatar mt-1 ">
                        <img
                            src="{{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', Auth::user()->avatar) }}">
                    </div>
                    <div class="user-message" style="max-width: 85%">
                        <div class="message-time-status">
                            <span class="sent-time">Tôi</span>
                            <div class="sent-time">{{ $feedback->created_at->format('H:s d-m-Y') }}</div>
                        </div>
                        <div class="message-content">
                            <div class="single-message bg-danger rounded p-2">
                                <?php echo $feedback->content; ?>
                            </div>

                        </div>
                        <?php $images = json_decode($feedback->image); ?>
                        <div class="message-content ">
                            <div class="single-message d-flex flex-wrap align-items-center">
                                @foreach ($images as $img)
                                    <img class="p-1 cursor-pointer" src="{{ url('/images/feedback/') . '/' . $img }}">
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                @foreach ($reply as $item)
                    <div class="single-chat-item @if ($item->user_type == 1)  @endif">
                        <div class="user-avatar mt-1">
                            <span class="name-first-letter">A</span>
                            @if ($item->user_type == 1)
                                <img
                                    src="{{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', Auth::user()->avatar) }}">
                            @else
                                <img src="{{ url('/') }}/assets/media/avatars/avatar-1.png">
                            @endif
                        </div>
                        <div class="user-message" style="max-width: 85%">
                            <div class="message-time-status">
                                @if ($item->user_type == 1)
                                    <div class="sent-time">Tôi</div>
                                @else
                                    <div class="sent-time">Admin</div>
                                @endif
                                <div class="sent-time">{{ $item->created_at->format('H:s d-m-Y') }}</div>

                            </div>
                            <div class="message-content">
                                <div
                                    class="single-message @if ($item->user_type == 1) bg-danger @else bg-info @endif rounded p-2">
                                    <?php echo $item->content; ?>
                                </div>
                            </div>

                            <?php $images = json_decode($item->image); ?>
                            <div class="message-content ">
                                <div class="single-message d-flex flex-wrap align-items-center">
                                    @foreach ($images as $img)
                                        <img class="p-1 cursor-pointer" src="{{ url('/images/feedback/') . '/' . $img }}">
                                    @endforeach
                                </div>

                            </div>

                            {{-- <div class="message-time-status">
                                <div class="sent-time">{{ $item->created_at->format('H:s d-m-Y') }}</div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="chat-footer py-1">
        <div class="container h-100">
            <div class="" id="show-upload">
            </div>
            <div class="chat-footer-content h-100 d-flex align-items-center">
                <form data-action="{{ route('user.support.reply') }}">
                    @csrf
                    <button class="btn btn-emoji mx-2" type="button" id="btn-image">
                        <i class="bi bi-images"></i>
                    </button>
                    <!-- Message -->
                    <input type="hidden" name="feecback_id" id="feecback_id" value="{{ $feedback->id }}">
                    <input type="file" multiple id="input-image" hidden accept="image/*">
                    <textarea class="form-control mx-1" id="content"></textarea>

                    <button class="btn btn-submit bg-danger" type="submit">
                        <i class="bi bi-cursor"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- modal show images --}}
    <div class="modal fade " id="imagesShow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="imagesShowLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent">
                <div class="modal-header border-0">
                    <button class="btn btn-close p-1 ms-auto text-white" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center p-0 justify-content-center">
                    <span id="pre" class="cursor-pointer p-3 h-25 d-flex align-items-center"
                        style="position: fixed;left: 0;"><i
                            class="bi bi-chevron-compact-left text-white fs-4 fw-normal"></i></span>

                    <img>
                    <span id="next" class="cursor-pointer p-3 h-25 d-flex align-items-center"
                        style="position: fixed;right: 0;"><i
                            class="bi bi-chevron-compact-right text-white fs-4 fw-normal"></i></span>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).scrollTop(9999999);
    </script>
    <script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script>
        $(function() {
            const scrollToBottom = () => {
                $(document).scrollTop(99999999);
            }
            const addMess = (avatarUser, content, time, images) => {
                let host = location.origin;
                const image = () => {
                    let x = '';
                    images.forEach(img => {
                        x += `<img class="p-1 cursor-pointer" src="${host}/images/feedback/${img}">`
                    });
                    return x;
                }
                $("#chat-body").append(`<div class="single-chat-item">
                    <div class="user-avatar mt-1">
                        <span class="name-first-letter">A</span>
                        <img src="${avatarUser}">
                    </div>
                    <div class="user-message" style="max-width: 85%">
                        <div class="message-time-status">
                            <span class="sent-time">Tôi</span>
                            <div class="sent-time">${time}</div>
                        </div>
                        <div class="message-content">
                            <div class="single-message bg-danger rounded p-2">
                                ${content}
                            </div>
                        </div>
                        <div class="message-content ">
                            <div class="single-message d-flex flex-wrap align-items-center">
                                ${image()}
                            </div>
                        </div>
                    </div>
                </div>`);
            }
            scrollToBottom();

            $('.btn-submit').click(function(e) {
                e.preventDefault();
                let content = $("#content").val();
                if (content == '') {
                    showToast('warning', "Bạn chưa nhập nội dung");
                    return
                }

                let token = $("input[name=_token]").val()
                let feecback_id = $("#feecback_id").val();
                content = '<p>' + content.replace(/\n/g, "</p><p>") + '</p>';

                let image = [];
                $(".span-show").each(function() {
                    image.push($(this).attr('src'))
                })
                let data = {
                    _token: token,
                    feecback_id: feecback_id,
                    content: content,
                    images: image,
                }

                console.log(data);


                $.ajax({
                    url: $('form').data('action'),
                    type: 'post',
                    data: data,
                    typeData: 'json',
                    success: function(response) {
                        showToast('success')
                        console.log(response);
                        let avatar = $(".user-avatar img").attr("src");
                        addMess(avatar, response.content, response.time, response.image);
                        $('form').trigger("reset");
                        $(".item").remove();
                        scrollToBottom();
                    },
                    error: function() {
                        showToast('danger')
                    }
                })
            })

            // modal show images
            var images, index;
            $(".single-message").on("click", "img", function() {
                console.log("show image");
                images = $(".single-message img").get();
                console.log(images);
                console.log($(".single-message img").index(this));
                index = $(".single-message img").index(this);
                $("#imagesShow .modal-body img").attr('src', $(images[index]).attr("src"));
                $("#imagesShow").modal("show");
            })
            $("#pre").click(() => {
                if (index == 0) return
                index -= 1;
                console.log(images);

                $("#imagesShow .modal-body img").attr('src', $(images[index]).attr("src"));
            })
            $("#next").click(() => {
                if (index == (images.length - 1)) return
                index += 1;
                console.log(images);

                $("#imagesShow .modal-body img").attr('src', $(images[index]).attr("src"));
            })

            // upload images
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
                        $(".item").remove();
                        reader.onload = function(event) {
                            let show = `<div class="item border rounded my-2 me-1 position-relative d-flex align-items-center">
                                <span class="position-absolute top-0 end-0 border border-light rounded-circle bg-danger d-flex align-items-center justify-content-center cursor-pointer" onclick="removeFunc(this)" style="width: 20px; height: 20px;">
                                    <i class="bi bi-x text-white" ></i>
                                </span>
                                <img class="span-show" src="${event.target.result}">
                            </div>`;
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

        })
    </script>
@endpush
