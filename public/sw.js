const CACHE = "offline-page";
importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

const offlineFallbackPage = "/offline.html";

// Handle the SKIP_WAITING message
self.addEventListener("message", (event) => {
  if (event.data) {
    if (event.data.type === "SKIP_WAITING") {
      self.skipWaiting();
    } else if (event.data.type === "GEOLOCATION") {
      const { latitude, longitude } = event.data;
      console.log(`Received geolocation - Latitude: ${latitude}, Longitude: ${longitude}`);
      
      // You can store the geolocation data in IndexedDB or perform any other operation
      // For example, storing it in a cache or syncing later
    }
  }
});

// Install event - cache the offline fallback page
self.addEventListener('install', async (event) => {
  event.waitUntil(
    caches.open(CACHE)
      .then((cache) => cache.add(offlineFallbackPage))
  );
});

// Enable navigation preload if supported
if (workbox.navigationPreload.isSupported()) {
  workbox.navigationPreload.enable();
}

// Register route for caching responses
workbox.routing.registerRoute(
  ({ request }) => request.destination === 'script' || request.destination === 'style',
  new workbox.strategies.CacheFirst({
    cacheName: CACHE,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 50, // Limit the number of entries in the cache
        maxAgeSeconds: 30 * 24 * 60 * 60, // Cache for 30 days
      }),
    ],
  })
);

// Handle visibility change to refresh app when it becomes visible
self.addEventListener('visibilitychange', function() {
  if (self.document.visibilityState === 'visible') { // Use 'self' to refer to the service worker
    console.log('APP resumed');
    self.clients.matchAll().then(clients => {
      clients.forEach(client => client.navigate(client.url)); // Reload all clients
    });
  }
});

// Fetch event to handle navigation requests
self.addEventListener('fetch', (event) => {
  if (event.request.mode === 'navigate') {
    event.respondWith((async () => {
      try {
        // Try to get the response from the network
        const preloadResp = await event.preloadResponse;
        if (preloadResp) {
          return preloadResp;
        }

        const networkResp = await fetch(event.request);
        return networkResp;
      } catch (error) {
        // If the network request fails, return the offline fallback page
        const cache = await caches.open(CACHE);
        const cachedResp = await cache.match(offlineFallbackPage);
        return cachedResp || Response.error(); // Return an error response if there's no cached page
      }
    })());
  }
});

self.addEventListener('sync', event => {
  if (event.tag === 'database-sync') {
    event.waitUntil(
      clients.matchAll().then(clients => {
        clients.forEach(client => {
          client.navigate('/');
        });
      })
    );
  }
});

