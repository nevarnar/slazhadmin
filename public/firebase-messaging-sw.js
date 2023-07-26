importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');


//server
firebase.initializeApp({
    apiKey: "AIzaSyDQzEz3WPCdScs2AWanYem3Ay-G4lCgsZ4",
    authDomain: "slazh-68944.firebaseapp.com",
    projectId: "slazh-68944",
    storageBucket: "slazh-68944.appspot.com",
    messagingSenderId: "162667308297",
    appId: "1:162667308297:web:e656bc777fad48592a1fd8",
    measurementId: "G-THQLE5YNQ5"
});

//local
// firebase.initializeApp({
//     apiKey: "AIzaSyA0Y4Q_w32Dt8zbC0vGGE9wCcPa3tKqEgQ",
//       authDomain: "test-notification-app-2215e.firebaseapp.com",
//       projectId: "test-notification-app-2215e",
//       storageBucket: "test-notification-app-2215e.appspot.com",
//       messagingSenderId: "456826605627",
//       appId: "1:456826605627:web:c546982834735166d7cc1e",
//       measurementId: "G-YN7WR0BVKZ"
// });



const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] received Background Message',payload);
    var notificationTitle='Background Message Title';
    var notificationOptions={
        body:'Backgound Message Body',
        icon:'/firebase-logo.png',
    }
    return self.registration.showNotification(notificationTitle,notificationOptions);
});
