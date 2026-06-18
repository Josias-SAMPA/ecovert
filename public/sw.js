// Service Worker pour ECO-VERT PWA
// Gère les notifications, mise en cache, et fonctionnement hors ligne

const CACHE_VERSION = 'eco-vert-v1';
const CACHE_FILES = [
  '/',
  '/index.php',
  '/manifest.json',
  '/images/logo.svg',
  '/files/style.css',
  '/files/script.js'
];

// Installation du Service Worker
self.addEventListener('install', (event) => {
  console.log('[SW] Installing...');
  event.waitUntil(
    caches.open(CACHE_VERSION).then((cache) => {
      console.log('[SW] Cache opened');
      return cache.addAll(CACHE_FILES).catch((err) => {
        console.log('[SW] Some files failed to cache (might be external):', err);
        // On continue même si certains fichiers échouent
      });
    })
  );
  self.skipWaiting();
});

// Activation du Service Worker
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating...');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_VERSION) {
            console.log('[SW] Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Interception des requêtes (stratégie cache-first avec fallback réseau)
self.addEventListener('fetch', (event) => {
  // Pour les requêtes POST, on utilise la stratégie réseau
  if (event.request.method === 'POST') {
    return;
  }

  event.respondWith(
    caches.match(event.request).then((response) => {
      if (response) {
        return response;
      }
      return fetch(event.request)
        .then((response) => {
          // Clone la réponse car elle ne peut être utilisée qu'une fois
          const responseClone = response.clone();
          caches.open(CACHE_VERSION).then((cache) => {
            cache.put(event.request, responseClone);
          });
          return response;
        })
        .catch(() => {
          console.log('[SW] Network request failed for:', event.request.url);
          // Retour d'une page offline si disponible
          return caches.match('/');
        });
    })
  );
});

// Gestion des notifications push
self.addEventListener('push', (event) => {
  console.log('[SW] Push event received');
  
  let notificationData = {
    title: 'ECO-VERT — Alerte climatique',
    body: 'Nouvelle alerte métérologique pour votre zone',
    icon: '/images/logo.svg',
    badge: '/images/logo.svg',
    tag: 'eco-vert-alert',
    requireInteraction: true,
    actions: [
      { action: 'open', title: 'Voir les détails' },
      { action: 'close', title: 'Fermer' }
    ]
  };

  if (event.data) {
    try {
      const data = event.data.json();
      notificationData = { ...notificationData, ...data };
    } catch (e) {
      notificationData.body = event.data.text();
    }
  }

  event.waitUntil(
    self.registration.showNotification(notificationData.title, notificationData)
  );
});

// Gestion des clics sur les notifications
self.addEventListener('notificationclick', (event) => {
  console.log('[SW] Notification clicked:', event.action);
  event.notification.close();

  if (event.action === 'open' || !event.action) {
    event.waitUntil(
      clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
        // Si une fenêtre ECO-VERT est déjà ouverte, on la focus
        for (const client of clientList) {
          if (client.url.includes('ecovert') && 'focus' in client) {
            return client.focus();
          }
        }
        // Sinon on ouvre une nouvelle fenêtre
        if (clients.openWindow) {
          return clients.openWindow('/');
        }
      })
    );
  }
});

// Gestion de la fermeture des notifications
self.addEventListener('notificationclose', (event) => {
  console.log('[SW] Notification closed');
});

// Message handler pour les opérations personnalisées depuis la page
self.addEventListener('message', (event) => {
  console.log('[SW] Message received:', event.data);
  
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
