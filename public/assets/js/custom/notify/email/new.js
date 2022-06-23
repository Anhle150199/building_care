"use strict";

// Class definition
var KTAppInboxCompose = (function () {
    var dataUser, token = $('input[name=_token]').val();
    // Private functions
    // Init reply form
    const initForm = () => {
        // Set variables
        const form = document.querySelector("#kt_inbox_compose_form");
        const allTagify = form.querySelectorAll(
            '[data-kt-inbox-form="tagify"]'
        );
        // Handle CC and BCC
        handleCCandBCC(form);

        // Handle submit form
        handleSubmit(form);

        // Init tagify
        allTagify.forEach((tagify) => {
            initTagify(tagify);
        });

        // Init quill editor
        initQuill(form);

        // Init dropzone
        initDropzone(form);
    };

    // Handle CC and BCC toggle
    const handleCCandBCC = (el) => {
        // Get elements
        const ccElement = el.querySelector('[data-kt-inbox-form="cc"]');
        const ccButton = el.querySelector('[data-kt-inbox-form="cc_button"]');
        const ccClose = el.querySelector('[data-kt-inbox-form="cc_close"]');
        const bccElement = el.querySelector('[data-kt-inbox-form="bcc"]');
        const bccButton = el.querySelector('[data-kt-inbox-form="bcc_button"]');
        const bccClose = el.querySelector('[data-kt-inbox-form="bcc_close"]');

        // Handle CC button click
        ccButton.addEventListener("click", (e) => {
            e.preventDefault();

            ccElement.classList.remove("d-none");
            ccElement.classList.add("d-flex");
        });

        // Handle CC close button click
        ccClose.addEventListener("click", (e) => {
            e.preventDefault();

            ccElement.classList.add("d-none");
            ccElement.classList.remove("d-flex");
        });

        // Handle BCC button click
        bccButton.addEventListener("click", (e) => {
            e.preventDefault();

            bccElement.classList.remove("d-none");
            bccElement.classList.add("d-flex");
        });

        // Handle CC close button click
        bccClose.addEventListener("click", (e) => {
            e.preventDefault();

            bccElement.classList.add("d-none");
            bccElement.classList.remove("d-flex");
        });
    };

    // Handle submit form
    const handleSubmit = (el) => {
        const submitButton = el.querySelector('[data-kt-inbox-form="send"]');
        // Handle button click event
        submitButton.addEventListener("click", function () {
            submitButton.setAttribute('data-kt-indicator', 'on');
            let to = $('input[name=compose_to]').val();
            let cc = $('input[name=compose_cc]').val();
            let bcc = $('input[name=compose_bcc]').val();
            let subject = $('input[name=compose_subject]').val();

            let quill = new Quill("#kt_inbox_form_editor", {});
            let content = quill.root.innerHTML;
            let ok = true;
            if(to == '' || content == '<p><br></p>') ok = false;

            if (ok == true) {
                let data={
                    to: to,
                    cc: cc,
                    bcc: bcc,
                    subject: subject,
                    content: content,
                    _token: token
                }
                console.log(data);
                $.ajax({
                    url: $(el).data('create'),
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        Swal.fire({
                            text: "Đã gửi!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Chấp nhận!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    },
                    error: function(error){
                        console.log(error);
                        Swal.fire({
                            html: "Có lỗi xảy ra. <br/> Thử lại sau",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Chấp nhận!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });

            } else {
                Swal.fire({
                    html: "Có lỗi xảy ra. <br/> Xem lại địa chỉ đến và nội dung",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Chấp nhận!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }

            submitButton.removeAttribute("data-kt-indicator");
        });
    };
    const getUers = async () =>{
        await $.ajax({
            url:`${location.origin}/admin/customers/customer/get-users`,
            type: 'post',
            data: {
                _token:token
            },
            typeData: 'json',
            success: function(data){
                console.log(data);
                dataUser = [];
                data.forEach((e)=>{
                    dataUser.push({
                        value: parseInt(e.value),
                        name: e.name,
                        email: e.email
                    });
                });
                console.log(dataUser);
            }
        });
    };
    // Init tagify
    const initTagify = async (el) => {

        var inputElm = el;
        // const usersList = [
        //     {
        //         value: 1,
        //         name: "Emma Smith",
                //  avatar: "avatars/300-6.jpg",
        //         email: "e.smith@kpmg.com.au",
        //     },
        // ];
        // console.log(usersList);
        const usersList = dataUser;
        console.log(usersList);
        function tagTemplate(tagData) {
            return `
                <tag title="${tagData.title || tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="${this.settings.classNames.tag} ${
                tagData.class ? tagData.class : ""
            }"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div class="d-flex align-items-center">

                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `;
        }

        function suggestionItemTemplate(tagData) {
            return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item d-flex align-items-center ${
                        tagData.class ? tagData.class : ""
                    }'
                    tabindex="0" role="option">

                    ${
                        tagData.avatar
                            ? `
                            <div class='tagify__dropdown__item__avatar-wrap me-2'>
                                <img onerror="this.style.visibility='hidden'"  class="rounded-circle w-50px me-2" src="${hostUrl}media/${tagData.avatar}">
                            </div>`
                            : ""
                    }

                    <div class="d-flex flex-column">
                        <strong>${tagData.name}</strong>
                        <span>${tagData.email}</span>
                    </div>
                </div>
            `;
        }

        // initialize Tagify on the above input node reference
        var tagify = new Tagify(inputElm, {
            tagTextProp: "name", // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: "users-list",
                searchKeys: ["name", "email"], // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate,
            },
            whitelist: usersList,
        });

        tagify.on("dropdown:show dropdown:updated", onDropdownShow);
        tagify.on("dropdown:select", onSelectSuggestion);

        var addAllSuggestionsElm;

        function onDropdownShow(e) {
            var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

            if (tagify.suggestedListItems.length > 1) {
                addAllSuggestionsElm = getAddAllSuggestionsElm();

                // insert "addAllSuggestionsElm" as the first element in the suggestions list
                dropdownContentElm.insertBefore(
                    addAllSuggestionsElm,
                    dropdownContentElm.firstChild
                );
            }
        }

        function onSelectSuggestion(e) {
            if (e.detail.elm == addAllSuggestionsElm)
                tagify.dropdown.selectAll.call(tagify);
        }

        // create a "add all" custom suggestion element every time the dropdown changes
        function getAddAllSuggestionsElm() {
            // suggestions items should be based on "dropdownItem" template
            return tagify.parseTemplate("dropdownItem", [
                {
                    class: "addAll",
                    name: "Add all",
                    email:
                        tagify.settings.whitelist.reduce(function (
                            remainingSuggestions,
                            item
                        ) {
                            return tagify.isTagDuplicate(item.value)
                                ? remainingSuggestions
                                : remainingSuggestions + 1;
                        },
                        0) + " Members",
                },
            ]);
        }
    };

    // Init quill editor
    const initQuill = (el) => {
        var toolbarOptions = [
            [{ font: [] }],
            // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ size: ["small", false, "large", "huge"] }], // custom dropdown
            ["bold", "italic", "underline", "strike"], // toggled buttons

            [{ color: [] }, { background: [] }], // dropdown with defaults from theme
            [{ align: [] }],
            ["blockquote"],

            [{ header: 1 }, { header: 2 }], // custom button values
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }], // superscript/subscript
            [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
            // [{ 'direction': 'rtl' }],                         // text direction
            ["link"],
            ["clean"], // remove formatting button
        ];

        var quill = new Quill("#kt_inbox_form_editor", {
            modules: {
                toolbar: toolbarOptions,
            },
            placeholder: "Type your text here...",
            theme: "snow", // or 'bubble'
        });

        // Customize editor
        const toolbar = el.querySelector(".ql-toolbar");

        if (toolbar) {
            const classes = [
                "px-5",
                "border-top-0",
                "border-start-0",
                "border-end-0",
            ];
            toolbar.classList.add(...classes);
        }
    };

    // Init dropzone
    const initDropzone = (el) => {
        // set the dropzone container id
        const id = '[data-kt-inbox-form="dropzone"]';
        const dropzone = el.querySelector(id);
        const uploadButton = el.querySelector(
            '[data-kt-inbox-form="dropzone_upload"]'
        );

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, {
            // Make the whole body a dropzone
            url: "https://preview.keenthemes.com/api/dropzone/void.php", // Set the url for your upload script location
            parallelUploads: 20,
            maxFilesize: 1, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: uploadButton, // Define the element that should be used as click trigger to select files.
        });

        myDropzone.on("addedfile", function (file) {
            // Hookup the start button
            const dropzoneItems = dropzone.querySelectorAll(".dropzone-item");
            dropzoneItems.forEach((dropzoneItem) => {
                dropzoneItem.style.display = "";
            });
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function (progress) {
            const progressBars = dropzone.querySelectorAll(".progress-bar");
            progressBars.forEach((progressBar) => {
                progressBar.style.width = progress + "%";
            });
        });

        myDropzone.on("sending", function (file) {
            // Show the total progress bar when upload starts
            const progressBars = dropzone.querySelectorAll(".progress-bar");
            progressBars.forEach((progressBar) => {
                progressBar.style.opacity = "1";
            });
        });

        // Hide the total progress bar when nothing"s uploading anymore
        myDropzone.on("complete", function (progress) {
            const progressBars = dropzone.querySelectorAll(".dz-complete");

            setTimeout(function () {
                progressBars.forEach((progressBar) => {
                    progressBar.querySelector(".progress-bar").style.opacity =
                        "0";
                    progressBar.querySelector(".progress").style.opacity = "0";
                });
            }, 300);
        });
    };

    // Public methods
    return {
        init: async function () {
            await getUers();
            initForm();
        },

    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    // KTAppInboxCompose.getUers();
    KTAppInboxCompose.init();
});
