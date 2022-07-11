importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBaI5e-ab33imAYOAjWRzpJXePls6N-FkA",
    authDomain: "datn-megacare.firebaseapp.com",
    projectId: "datn-megacare",
    storageBucket: "datn-megacare.appspot.com",
    messagingSenderId: "379787159816",
    appId: "1:379787159816:web:2c12d2a5988e28e467e4bd",
    measurementId: "G-B28M0Y4RFG"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.onBackgroundMessage(function (payload) {
    console.log("Message received.", payload);
    const title = payload.data.title;
    const options = {
        body: payload.data.body,
        icon: '/assets/media/logos/favicon.ico',
        data:{
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action,
        }
    };
    return self.registration.showNotification(title,options);
});
self.addEventListener('notificationclick', event => {
    var action_click = event.notification.data.click_action;
    event.notification.close();
    event.waitUntil(clients.openWindow(action_click));
});
