// self.addEventListener('install', function(e) {
//   e.waitUntil(
//     caches.open('anaxi').then(function(cache) {
//       return cache.addAll([
//         '/',
//         '/css/app.css',
//         '/css/styles.css',
//         '/img/logo/anaxi_logomarker.png'
//       ]);
//     })
//   );
// });
//
// self.addEventListener('fetch', function(event) {
//
//   // console.log(event.request.url);
//
//   event.respondWith(
//
//     caches.match(event.request).then(function(response) {
//
//       return response || fetch(event.request);
//
//     })
//
//   );
//
// });