const STATIC_CACHE = "static-cache-v1";
const APP_SHELL = [
    "/",
    "MenuPrincipal.html",
    "productos.php",
    "main.js",
    "imge/maqui.jpg" // Asegúrate de que esta sea la ruta correcta
];

self.addEventListener("fetch", (e) => {
    const requestURL = new URL(e.request.url);

    // Filtra las solicitudes que no son HTTP o HTTPS
    if (requestURL.protocol === "http:" || requestURL.protocol === "https:") {
        e.respondWith(
            caches.match(e.request)
                .then((response) => {
                    // Devuelve el recurso del caché si está disponible
                    if (response) {
                        return response;
                    }
                    // De lo contrario, realiza la solicitud de red y almacena en caché la respuesta
                    return fetch(e.request).then((networkResponse) => {
                        return caches.open(STATIC_CACHE).then((cache) => {
                            cache.put(e.request, networkResponse.clone());
                            return networkResponse;
                        });
                    });
                })
                .catch((error) => console.error("Error fetching resource:", error))
        );
    } else {
        console.warn("Request no compatible con el cache del Service Worker:", e.request.url);
    }
});
