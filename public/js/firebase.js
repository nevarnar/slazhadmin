// const firebaseConfig = {
//     apiKey: "AIzaSyA0Y4Q_w32Dt8zbC0vGGE9wCcPa3tKqEgQ",
//     authDomain: "test-notification-app-2215e.firebaseapp.com",
//     projectId: "test-notification-app-2215e",
//     storageBucket: "test-notification-app-2215e.appspot.com",
//     messagingSenderId: "456826605627",
//     appId: "1:456826605627:web:c546982834735166d7cc1e",
//     measurementId: "G-YN7WR0BVKZ"
//   };
  const firebaseConfig = {
    apiKey: "AIzaSyDQzEz3WPCdScs2AWanYem3Ay-G4lCgsZ4",
    authDomain: "slazh-68944.firebaseapp.com",
    projectId: "slazh-68944",
    storageBucket: "slazh-68944.appspot.com",
    messagingSenderId: "162667308297",
    appId: "1:162667308297:web:e656bc777fad48592a1fd8",
    measurementId: "G-THQLE5YNQ5"
  };
//senderId 103953800507
  firebase.initializeApp(firebaseConfig);

//   --------------------------------------

const messaging = firebase.messaging();

// function initFirebaseMessagingRegistration() {
    messaging.requestPermission().then(function () {
        console.log('Notification permission granted');
        return messaging.getToken()
    }).then(function(token) {
        $('#device_token').val(token);
        console.log(token);
    }).catch(function (err) {
        console.log(`Enable to get permission to notify :: ${err}`);
    });
// }

// initFirebaseMessagingRegistration();

// --------------------------------------------

messaging.onMessage((payload)=>{
    console.log(payload);
    // const title = payload.notification.title;
    // const options = {
    //     body: payload.notification.body,
    //     icon: payload.notification.icon,
    // };
    // new Notification(title, options);
});
