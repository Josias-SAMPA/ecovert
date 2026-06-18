// nav mobile, chatbot par mots-clés, simulation d'alerte

document.addEventListener('DOMContentLoaded', () => {

  // --- nav mobile ---
  const navEl = document.getElementById('nav');
  const burgerBtn = document.getElementById('nav-burger');

  if (burgerBtn && navEl) {
    burgerBtn.addEventListener('click', () => {
      const isOpen = navEl.classList.toggle('is-open');
      burgerBtn.setAttribute('aria-expanded', String(isOpen));
    });

    // ferme le menu quand on clique un lien
    document.querySelectorAll('.nav__mobile a').forEach((link) => {
      link.addEventListener('click', () => {
        navEl.classList.remove('is-open');
        burgerBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }


  // --- chatbot ---
  // pas d'IA générative ici, juste un matching par mots-clés.
  // on n'a pas de backend donc pas de moyen sûr de cacher une clé API.
  // si on ajoute un backend plus tard, remplacer findBotResponse() par
  // un fetch() vers une route qui appelle l'API IA côté serveur.

  // mots-clés -> réponse. la première entrée qui matche gagne.
  const knowledgeBase = [
    {
      keywords: ['c\'est quoi', 'cest quoi', 'qu\'est-ce', 'quest ce', 'eco-vert', 'ecovert', 'qui êtes', 'qui etes', 'présentation', 'presentation'],
      response: "ECO-VERT transforme les données météo brutes en bulletins et conseils pratiques pour les agriculteurs et éleveurs : alertes climatiques précoces, prévisions localisées et recommandations concrètes, diffusés par SMS, application mobile et WhatsApp."
    },
    {
      keywords: ['recevoir', 'alerte', 'alertes', 'm\'inscrire', 'inscrire', 'inscription', 'comment ça marche', 'comment ca marche'],
      response: "Pour recevoir les alertes, vous vous inscrivez via l'application mobile ou en envoyant votre localisation par SMS. Une fois inscrit, vous recevez automatiquement les bulletins et alertes qui concernent votre zone."
    },
    {
      keywords: ['canal', 'canaux', 'sms', 'whatsapp', 'application', 'app', 'diffusion'],
      response: "Les bulletins et alertes sont diffusés sur 3 canaux : SMS (fonctionne sans connexion Internet), application mobile, et WhatsApp. Vous choisissez celui qui vous convient le mieux."
    },
    {
      keywords: ['gratuit', 'prix', 'tarif', 'tarifs', 'coût', 'cout', 'payant', 'combien'],
      response: "Les bulletins de base et les alertes climatiques sont accessibles à coût réduit pour les producteurs, avec un objectif d'accès le plus large possible. Les modalités précises dépendent de votre zone et du canal choisi. L'équipe partenaires peut vous donner le détail exact."
    },
    {
      keywords: ['partenaire', 'partenariat', 'investir', 'investisseur', 'soutenir', 'rejoindre', 'collaborer'],
      response: "Pour devenir partenaire ou investisseur, le plus simple est de cliquer sur \"Devenir partenaire\" en haut de la page, ou de vous rendre directement à la section Partenaires en bas de page. Vous pourrez nous contacter pour discuter de la collaboration."
    },
    {
      keywords: ['région', 'regions', 'zone', 'zones', 'où', 'disponible', 'couverture', 'pays'],
      response: "La couverture s'étend progressivement zone par zone, en fonction de la disponibilité des données météo locales. Contactez l'équipe via la section Partenaires pour savoir si votre zone est déjà couverte ou en cours d'intégration."
    },
    {
      keywords: ['formation', 'former', 'apprendre', 'utiliser'],
      response: "ECO-VERT propose des sessions de formation pour aider les producteurs à comprendre et utiliser les bulletins météo et les conseils techniques associés. Ces formations sont organisées localement avec nos partenaires."
    },
    {
      keywords: ['conseil', 'conseils', 'technique', 'recommandation'],
      response: "Chaque bulletin météo s'accompagne d'un conseil technique concret : quand semer, quand traiter, quand mettre le bétail à l'abri. L'objectif est que l'information soit directement exploitable sur le terrain."
    },
    {
      keywords: ['bétail', 'betail', 'élevage', 'elevage', 'animaux', 'troupeau'],
      response: "ECO-VERT couvre aussi le volet pastoral : alertes sur les vagues de chaleur, sécheresse ou inondations, avec des conseils adaptés pour protéger le bétail à temps."
    },
    {
      keywords: ['contact', 'email', 'téléphone', 'telephone', 'joindre'],
      response: "Le moyen le plus direct est le bouton \"Discuter du partenariat\" dans la section Partenaires, en bas de page, qui ouvre un email directement adressé à l'équipe."
    }
  ];

  const defaultResponse = `Merci pour votre question . Je ne suis pas certain d'avoir une réponse précise à ce sujet. 

N'hésitez pas à contacter notre équipe directement sur WhatsApp, elle se fera un plaisir de vous aider :
 <a href="https://wa.me/237698290191" target="_blank" style="color: var(--crop-green); text-decoration: none; font-weight: 600;">+237 698 290 191</a>
 <a href="https://wa.me/237656856090" target="_blank" style="color: var(--crop-green); text-decoration: none; font-weight: 600;">+237 656 865 090</a>

Vous pouvez également explorer les sections "Comment ça marche" ou "Impact" plus haut sur la page.`;

  function normalize(text) {
    return text
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, ''); // retire les accents pour une comparaison plus robuste
  }

  function findBotResponse(userText) {
    const normalized = normalize(userText);
    for (const entry of knowledgeBase) {
      if (entry.keywords.some((kw) => normalized.includes(normalize(kw)))) {
        return entry.response;
      }
    }
    return defaultResponse;
  }

  // --- UI du chatbot ---
  const chatbotToggle = document.getElementById('chatbot-toggle');
  const chatbotPanel = document.getElementById('chatbot-panel');
  const chatbotClose = document.getElementById('chatbot-close');
  const chatbotMessages = document.getElementById('chatbot-messages');
  const chatbotForm = document.getElementById('chatbot-form');
  const chatbotInput = document.getElementById('chatbot-input');
  const chatbotQuickReplies = document.getElementById('chatbot-quick-replies');

  function openChatbot() {
    chatbotPanel.classList.add('is-open');
    chatbotPanel.setAttribute('aria-hidden', 'false');
    chatbotToggle.setAttribute('aria-expanded', 'true');
    chatbotInput.focus();
  }

  function closeChatbot() {
    chatbotPanel.classList.remove('is-open');
    chatbotPanel.setAttribute('aria-hidden', 'true');
    chatbotToggle.setAttribute('aria-expanded', 'false');
  }

  function toggleChatbot() {
    if (chatbotPanel.classList.contains('is-open')) {
      closeChatbot();
    } else {
      openChatbot();
    }
  }

  function appendMessage(text, sender) {
    const msgEl = document.createElement('div');
    msgEl.classList.add('chatbot__message', sender === 'user' ? 'chatbot__message--user' : 'chatbot__message--bot');
    
    // Pour les messages bot, utiliser innerHTML pour permettre les liens
    if (sender === 'bot') {
      msgEl.innerHTML = text;
    } else {
      msgEl.textContent = text;
    }
    
    chatbotMessages.appendChild(msgEl);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
  }

  function handleUserQuestion(question) {
    const trimmed = question.trim();
    if (!trimmed) return;

    appendMessage(trimmed, 'user');

    // Petit délai pour simuler une réponse, sans donner l'impression
    // d'un vrai traitement IA (juste un effet de lecture naturel).
    setTimeout(() => {
      const response = findBotResponse(trimmed);
      appendMessage(response, 'bot');
    }, 350);
  }

  if (chatbotToggle && chatbotPanel) {
    chatbotToggle.addEventListener('click', toggleChatbot);
    chatbotClose.addEventListener('click', closeChatbot);

    chatbotForm.addEventListener('submit', (e) => {
      e.preventDefault();
      handleUserQuestion(chatbotInput.value);
      chatbotInput.value = '';
    });

    chatbotQuickReplies.addEventListener('click', (e) => {
      const btn = e.target.closest('.chatbot__quick-reply');
      if (!btn) return;
      handleUserQuestion(btn.dataset.question);
    });

    // Ferme le chatbot avec la touche Échap
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && chatbotPanel.classList.contains('is-open')) {
        closeChatbot();
      }
    });
  }


  // --- notifications ---
  // sans backend pas de vraie notif push (faudrait un service worker +
  // un service de push genre FCM/OneSignal). ici on utilise juste la
  // Web Notifications API du navigateur, qui marche seulement tant que
  // l'onglet reste ouvert. en repli, un toast interne si la permission
  // est refusée ou l'API absente.

  const DEMO_ALERT_MESSAGE = "Fortes pluies attendues dans les 48h sur votre zone. Préparez le drainage des parcelles basses et sécurisez le bétail en zone basse.";
  const DEMO_ALERT_TITLE = "ECO-VERT — Alerte climatique";

  const alertToast = document.getElementById('alert-toast');
  const alertToastMessage = document.getElementById('alert-toast-message');
  const alertToastClose = document.getElementById('alert-toast-close');
  const simulateAlertBtn = document.getElementById('simulate-alert-btn');

  let toastTimeoutId = null;

  function showToast(message) {
    if (!alertToast) return;
    alertToastMessage.textContent = message;
    alertToast.classList.add('is-visible');

    // Auto-masquage après quelques secondes, sauf si l'utilisateur la ferme avant
    clearTimeout(toastTimeoutId);
    toastTimeoutId = setTimeout(() => {
      alertToast.classList.remove('is-visible');
    }, 8000);
  }

  function hideToast() {
    if (!alertToast) return;
    alertToast.classList.remove('is-visible');
    clearTimeout(toastTimeoutId);
  }

  function triggerDemoAlert() {
    // Tente d'abord une vraie notification navigateur (Web Notifications API).
    const canUseNativeNotifications = 'Notification' in window;

    if (canUseNativeNotifications && Notification.permission === 'granted') {
      new Notification(DEMO_ALERT_TITLE, {
        body: DEMO_ALERT_MESSAGE,
        // Pas d'icône externe pour rester autonome (pas de dépendance réseau)
      });
      // On affiche aussi le toast interne en complément, pour la cohérence
      // visuelle de la démo même quand la notification système fonctionne.
      showToast(DEMO_ALERT_MESSAGE);
      return;
    }

    if (canUseNativeNotifications && Notification.permission !== 'denied') {
      Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
          new Notification(DEMO_ALERT_TITLE, { body: DEMO_ALERT_MESSAGE });
        }
        // Que la permission soit accordée ou refusée, le toast interne
        // garantit que la démo reste visible dans tous les cas.
        showToast(DEMO_ALERT_MESSAGE);
      });
      return;
    }

    // Permission refusée ou API indisponible : repli total sur le toast interne.
    showToast(DEMO_ALERT_MESSAGE);
  }

  if (alertToastClose) {
    alertToastClose.addEventListener('click', hideToast);
  }

  if (simulateAlertBtn) {
    simulateAlertBtn.addEventListener('click', triggerDemoAlert);
  }

  // Déclenchement automatique d'une alerte de démonstration quelques
  // secondes après l'arrivée sur le site, pour montrer le système en
  // conditions réelles sans action requise de l'utilisateur.
  setTimeout(() => {
    triggerDemoAlert();
  }, 4000);

});
