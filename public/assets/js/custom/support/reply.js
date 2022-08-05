$(function(){
    $("#btn-image").click(()=>{$("#input-image").click()})

    scroolButtom();
    $('#input-image').on('change', function() {
        if (this.files) {
            var filesAmount = this.files.length;

            for (i = 0; i < filesAmount; i++) {

                var reader = new FileReader();
                let name = this.files[i].name;

                if (!/\.(jpe?g|png|gif)$/i.test(name)) {
                    return showToast('warning', name + " không phải hình ảnh");
                }
                $(".span-show").remove();
                reader.onload = function(event) {
                    let show =
                        `<span class="border rounded p-1 m-1 mx-1 span-show" src= "${event.target.result}">${name}<i class="bi bi-x-circle-fill text-danger cursor-pointer px-1" onclick="removeFunc(this)"></i></span>`;
                    $('#show-upload').append(show);
                }

                reader.readAsDataURL(this.files[i]);
                console.log(this.files[i]);
            }
        }
    });

    $("#btn_submit").click((e)=>{
        e.preventDefault();
        let content = $("#content").val()
        if(content != ''){
            $("#btn_submit").attr({"data-kt-indicator": 'on', 'disable': 'true'});
            let token = $('input[name=_token]').val();
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
                url: $('#kt_inbox_reply_form').data('action'),
                type: 'post',
                data: data,
                typeData: 'json',
                success: function(response) {
                    console.log(response);
                    $("#btn_submit").attr("data-kt-indicator", 'off');
                    addToList(response.avatar,response.admin, response.content, response.time, response.image)
                    $('#kt_inbox_reply_form').trigger("reset");
                    $(".span-show").remove();
                    scroolButtom();
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        text: "Có lỗi xảy ra. Thử lại sau.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Chấp nhận!",
                        customClass: { confirmButton: "btn btn-primary"},
                    });
                    $("#btn_submit").attr("data-kt-indicator", 'off');
                }
            })
        }else{
            Swal.fire({
                text: "Bạn chưa nhập nội dung trả lời.",
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: "Chấp nhận!",
                customClass: { confirmButton: "btn btn-primary"},
            });
        }
    })
});

const removeFunc = e => {
    $(e).parent().remove();
}
const addToList=(avatarAdmin, nameAdmin, content, time, images, type=null)=>{
    let host =location.origin;
    const image = ()=>{
        let x='';
        images.forEach(img => {
            x+=`<a href="${host}/images/feedback/${img}" class="p-2 m-1 border rounded" target="_blank" rel="noopener noreferrer"> ${ img }</a>`
        });
        return x;
    }
    let avatar;
    if(type == null){
        avatar = `${host}/assets/media/avatars/${ avatarAdmin.replace(' ', '%20',) }`;
    }else{
        avatar = `${host}/images/avatar-user/${avatarAdmin}`;
    }
    
    $("#kt_mess_body").append(
    `<div data-kt-inbox-message="message_wrapper">
        <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-50 me-4">
                    <span class="symbol-label" style="background-image:url(${avatar});"></span>
                </div>
                <div class="pe-5">
                    <div class="d-flex align-items-center flex-wrap gap-1">
                        <a href="#"
                            class="fw-bolder text-dark text-hover-primary">${ nameAdmin }</a>
                    </div>
                    <div class="text-muted fw-bold mw-450px string-2 d-none" data-kt-inbox-message="preview">
                        ${content}
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span
                    class="fw-bold text-muted text-end me-3">${time}</span>
            </div>
        </div>
        <div class="collapse fade show" data-kt-inbox-message="message">
            <div class="py-5">
            ${content}
            </div>
            <div class="d-flex flex-wrap align-items-center">
            ${image()}
            </div>
        </div>
    </div>
    <div class="separator my-6"></div>`);
}

function scroolButtom() {
    var element = document.getElementsByClassName("separator");
    element[element.length-1].scrollIntoView();
}
