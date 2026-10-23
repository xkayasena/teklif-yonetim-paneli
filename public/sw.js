
const CACHE_NAME = 'artline-pwa-v1';

self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        (async () => {
            await self.clients.claim();

            const cacheNames = await caches.keys();
            await Promise.all(
                cacheNames
                    .filter(name => name.startsWith('artline-pwa-') && name !== CACHE_NAME)
                    .map(name => caches.delete(name))
            );
        })()
    );
});

// Laravel sayfalarını ve oturum gerektiren yanıtları önbelleğe almıyoruz.
self.addEventListener('fetch', event => {
    const request = event.request;

    if (
        request.method !== 'GET' ||
        new URL(request.url).origin !== self.location.origin
    ) {
        return;
    }

    // Şimdilik sadece ağdan yükle; çevrimdışı önbellek kullanma.
});
