
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.9.0/firebase-analytics.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.9.0/firebase-messaging.js";

    // TODO: Replace the following with your app's Firebase project configuration
    // See: https://firebase.google.com/docs/web/learn-more#config-object
    const firebaseConfig = {
        apiKey: "AIzaSyBaI5e-ab33imAYOAjWRzpJXePls6N-FkA",
        authDomain: "datn-megacare.firebaseapp.com",
        projectId: "datn-megacare",
        storageBucket: "datn-megacare.appspot.com",
        messagingSenderId: "379787159816",
        appId: "1:379787159816:web:2c12d2a5988e28e467e4bd",
        measurementId: "G-B28M0Y4RFG"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);


    // Initialize Firebase Cloud Messaging and get a reference to the service
    const messaging = getMessaging();

    function requestPermission() {
        console.log('Requesting permission...');
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
            console.log('Notification permission granted.');
            getToken(messaging, { vapidKey: 'BIz_RR4vvfPX7U7d7p41VEOVePDZnQ9oV4qad8Ixa8P7OOABanXs_jJjP0_HLPNQFekYvBptfYL1pqefML8T_TA' }).then((token) => {
                if (token) {
                    axios.post("{{ route('user.update-token') }}", {
                        _method: "PATCH",
                        token
                    }).then(({
                        data
                    }) => {
                        console.log(data)
                    }).catch(({
                        response: {
                            data
                        }
                    }) => {
                        console.error(data)
                    })
                } else {
                    // Show permission request UI
                    console.log('No registration token available. Request permission to generate one.');
                    // ...
                }
                }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
                // ...
                });

            }
        })
    }
    requestPermission();
    onMessage(messaging, (payload) => {
        console.log(payload);
        const title = payload.data.title;
        const body = payload.data.body;
        const click_action = payload.data.click_action;
        $("#toast_custom_link").data("action", click_action);
        showToast("custom-notify", title);
        const itemNotify= `<a href="${click_action}">
          <div class="alert unread custom-alert-3 alert-primary" role="alert">
            ${payload.data.image}
            <div class="alert-text w-75">
              <h6 class="text-truncate">${title}</h6><span class="text-truncate">${body}</span>
            </div>
          </div>
        </a>
        `
        $("#body_list_push_notification").prepend(itemNotify);
    });
    $("#toast_custom_link").on('click', ()=>{
        location.href=$("#toast_custom_link").data("action");
    })
</script>

