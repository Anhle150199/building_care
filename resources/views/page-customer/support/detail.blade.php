@extends('page-customer.layout.app-detail')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('back', route('user.support.show-list'))
@section('content')

    <div class="page-content-wrapper py-3" id="chat-wrapper">
        <div class="container">
            <div class="chat-content-wrap">
                <!-- Single Chat Item -->
                <div class="single-chat-item outgoing ">
                    <div class="user-avatar mt-1">
                        <img
                            src="{{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', Auth::user()->avatar) }}">
                    </div>
                    <div class="user-message" style="max-width: 70%">
                        <div class="message-content">
                            <div class="single-message">
                                <?php echo $feedback->content; ?>
                            </div>

                        </div>
                        <?php $images = json_decode($feedback->image); ?>
                        <div class="message-content ">
                            <div class="single-message d-flex flex-wrap align-items-center">
                                @foreach ($images as $img)
                                    <img class="p-1" src="{{ url('/images/feedback/') . '/' . $img }}">
                                @endforeach
                            </div>
                        </div>

                        <div class="message-time-status">
                            <div class="sent-time">{{ $feedback->created_at->format('H:s d-m-Y') }}</div>
                        </div>
                    </div>
                </div>
                @foreach ($reply as $item)
                    <div class="single-chat-item @if ($item->user_type == 1) outgoing @endif">
                        <div class="user-avatar mt-1">
                            <span class="name-first-letter">A</span>
                            @if ($item->user_type == 1)
                                <img
                                    src="{{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', Auth::user()->avatar) }}">
                            @else
                                <img src="{{ url('/') }}/assets/media/avatars/avatar-1.png">
                            @endif
                        </div>
                        <div class="user-message" style="max-width: 70%">
                            <div class="message-content">
                                <div class="single-message">
                                    <?php echo $item->content; ?>
                                </div>
                            </div>

                            <?php $images = json_decode($item->image); ?>
                            <div class="message-content ">
                                <div class="single-message d-flex flex-wrap align-items-center">
                                    @foreach ($images as $img)
                                        <img class="p-1" src="{{ url('/images/feedback/') . '/' . $img }}">
                                    @endforeach
                                </div>

                            </div>

                            <div class="message-time-status">
                                <div class="sent-time">{{ $item->created_at->format('H:s d-m-Y') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="chat-footer">
        <div class="container h-100">
            <div class="chat-footer-content h-100 d-flex align-items-center">
                <form action="#">
                    <button class="btn btn-emoji mx-2" type="button">
                        <i class="bi bi-images"></i>
                    </button>
                    <!-- Message -->
                    <input class="form-control" type="text" placeholder="Type here...">
                    <!-- Emoji -->
                    <button class="btn btn-submit" type="submit">
                        <i class="bi bi-cursor"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="imagesShow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="imagesShowLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent">
                <div class="modal-header border-0">
                    <button class="btn btn-close p-1 ms-auto text-white" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center p-0 justify-content-center">
                    <span id="pre" class="p-3 h-25 d-flex align-items-center" style="position: fixed;left: 0;"><i class="bi bi-chevron-compact-left text-white fs-4 fw-normal"></i></span>

                    <img >
                    <span id="next" class="p-3 h-25 d-flex align-items-center" style="position: fixed;right: 0;"><i class="bi bi-chevron-compact-right text-white fs-4 fw-normal"></i></span>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>
    {{-- <script src="{{ url('/') }}/assets/js/scripts.bundle.js"></script> --}}

    {{-- <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script> --}}
    <script>

        $('#btn_submit').click(function(e) {
            e.preventDefault();
            (function(status) {
                if (status == 'Valid') {
                    toggleBtnSubmit();
                    let token = $('input[name=_token]').val();
                    let apartment = $("#apartment").val();
                    let category = $("#category").val();
                    let model = $("#model").val();
                    let number = $("#number").val();
                    let description = $('#description').val();

                    let data = {
                        _token: token,
                        apartment_id: apartment,
                        category: category,
                        model: model,
                        license_plate_number: number,
                        description: description
                    }

                    $.ajax({
                        url: $('form').data('action'),
                        type: 'post',
                        data: data,
                        typeData: 'json',
                        success: function() {
                            showToast('success')
                            setTimeout(() => {
                                location.href = $('form').data('redirect')
                            }, 50);
                        },
                        error: function() {
                            showToast('danger')
                        }
                    })
                } else {
                    showToast('warning');
                }
            })

        })
        var images, index;
        $(".single-message img").click(function(){
             images = $(".single-message img").get();
            console.log(images);
            console.log($(".single-message img").index(this));
            index =$(".single-message img").index(this);
            $("#imagesShow .modal-body img").attr('src',$(images[index]).attr("src"));
            $("#imagesShow").modal("show");
        })
        $("#pre").click(()=>{
            if(index ==0) return
            index -= 1;
            console.log(images);

            $("#imagesShow .modal-body img").attr('src',$(images[index]).attr("src"));
        })
        $("#next").click(()=>{
            if(index ==(images.length -1)) return
            index += 1;
            console.log(images);

            $("#imagesShow .modal-body img").attr('src',$(images[index]).attr("src"));
        })
    </script>
@endpush
