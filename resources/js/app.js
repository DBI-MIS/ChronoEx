import './bootstrap';


if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { scope: '/' }).then(function (registration) {
        console.log(`SW registered successfully!`);
    }).catch(function (registrationError) {
        console.log(`SW registration failed`);
    });
}
  

// if ("geolocation" in navigator) {
//     navigator.permissions.query({ name: "geolocation" }).then((result) => {
//         if (result.state === "granted") {
//             getCurrentLocation();
//         } else if (result.state === "prompt") {
//             requestLocationAccess();  // Will prompt user
//         } else {
//             alert("Location access denied. Enable it in your browser settings.");
//         }
//     });
// } else {
//     alert("Geolocation is not supported by your browser.");
// }

// function requestLocationAccess() {
//     navigator.geolocation.getCurrentPosition(
//         (position) => {
//             const latitude = position.coords.latitude;
//             const longitude = position.coords.longitude;
//             console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);

//             // Optional: Send data to service worker
//             if (navigator.serviceWorker) {
//                 navigator.serviceWorker.ready.then(registration => {
//                     registration.active.postMessage({
//                         type: "GEOLOCATION",
//                         latitude,
//                         longitude,
//                     });
//                 });
//             }

//             sendLocationToBackend(latitude, longitude);
//         },
//         (error) => {
//             if (error.code === error.PERMISSION_DENIED) {
//                 alert("Location access denied. Please allow location access for the best experience.");
//             }
//         },
//         {
//             enableHighAccuracy: true,
//             timeout: 5000,
//             maximumAge: 0
//         }
//     );
// }

// function sendLocationToBackend(latitude, longitude) {
//     fetch('/api/save-location', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({ latitude, longitude })
//     })
//     .then(response => response.json())
//     .then(data => console.log("Location saved:", data))
//     .catch(error => console.error("Error saving location:", error));
// }


