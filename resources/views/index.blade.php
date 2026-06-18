<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ECO-VERT — bulletins météo et alertes pour agriculteurs</title>
<meta name="description" content="ECO-VERT envoie des bulletins météo et des alertes climatiques aux agriculteurs et éleveurs par SMS, app et WhatsApp.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&family=Work+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('files/style.css') }}">

<!-- Web App Configuration -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<link rel="apple-touch-icon" href="{{ asset('images/logo.svg') }}">
<meta name="theme-color" content="#2B6E5C">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="ECO-VERT">
</head>
<body>

<!-- toast d'alerte, repli si l'utilisateur refuse les notifications -->
<div id="alert-toast" class="alert-toast" role="status" aria-live="polite">
  <div class="alert-toast__icon" aria-hidden="true">⚠</div>
  <div class="alert-toast__body">
    <p class="alert-toast__label">ALERTE CLIMATIQUE</p>
    <p class="alert-toast__message" id="alert-toast-message">Fortes pluies attendues dans les 48h. Préparez le drainage des parcelles basses.</p>
  </div>
  <button class="alert-toast__close" id="alert-toast-close" aria-label="Fermer l'alerte">×</button>
</div>

<header class="nav" id="nav">
  <div class="nav__inner">
    <a href="{{ route('index') }}" class="nav__logo">
      <img src="{{ asset('images/logo.svg') }}" alt="ECO-VERT Logo" class="nav__logo-img">
      ECO-VERT
    </a>

    <nav class="nav__links" aria-label="Navigation principale">
      <a href="#mission">Mission</a>
      <a href="#comment-ca-marche">Comment ça marche</a>
      <a href="#impact">Impact</a>
      <a href="#partenaires">Partenaires</a>
    </nav>

    <div class="nav__auth">
      @auth
        <span style="margin-right: 16px; font-size: 0.9rem;">{{ auth()->user()->name }}</span>
        <a href="{{ route('user.dashboard') }}" class="btn btn--ghost btn--small">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn--accent btn--small" style="margin-left: 8px;">Déconnexion</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn--accent btn--small">Se connecter</a>
        <a href="{{ route('register') }}" class="btn btn--accent btn--small nav__cta">Devenir partenaire</a>
      @endauth
    </div>

    <button class="nav__burger" id="nav-burger" aria-label="Ouvrir le menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>

  <nav class="nav__mobile" id="nav-mobile" aria-label="Navigation mobile">
    <a href="#mission">Mission</a>
    <a href="#comment-ca-marche">Comment ça marche</a>
    <a href="#impact">Impact</a>
    <a href="#partenaires">Partenaires</a>
    @auth
      <a href="{{ route('user.dashboard') }}" class="btn btn--ghost btn--small" style="display: block; margin-top: 12px;">Dashboard</a>
      <form method="POST" action="{{ route('logout') }}" style="display: block; margin-top: 8px;">
        @csrf
        <button type="submit" class="btn btn--accent btn--small" style="width: 100%;">Déconnexion</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="btn btn--ghost btn--small" style="display: block; margin-top: 12px;">Se connecter</a>
      <a href="{{ route('register') }}" class="btn btn--accent btn--small" style="display: block; margin-top: 8px;">Devenir partenaire</a>
    @endauth
  </nav>
</header>

<main id="top">

  <section class="hero" id="hero">
    <div class="hero__inner">

      <div class="hero__text">
        <p class="eyebrow eyebrow--light">Météo de terrain</p>
        <h1 class="hero__title">
          ECO-VERT envoie des alertes météo aux agriculteurs et éleveurs.
        </h1>
        <p class="hero__lede">
          On reçoit les prévisions, on les transforme en bulletin simple avec
          un conseil concret, et on l'envoie par SMS, application ou WhatsApp.
        </p>

        <div class="hero__ctas">
          <a href="#partenaires" class="btn btn--accent">Devenir partenaire</a>
          <a href="#comment-ca-marche" class="btn btn--ghost">Voir comment ça marche</a>
        </div>

        <div class="hero__trust">
          <div class="trust-stat">
            <span class="trust-stat__value">3</span>
            <span class="trust-stat__label">Canaux de diffusion</span>
          </div>
          <div class="trust-stat">
            <span class="trust-stat__value">24/7</span>
            <span class="trust-stat__label">Alertes temps réel</span>
          </div>
          <div class="trust-stat">
            <span class="trust-stat__value">100%</span>
            <span class="trust-stat__label">Conseils localisés</span>
          </div>
        </div>
      </div>

      <div class="hero__visual">

        <div class="bulletin-card" id="bulletin-card">
          <div class="bulletin-card__top">
            <span class="bulletin-card__badge">Bulletin du jour</span>
            <span class="bulletin-card__alert-badge">Alerte vent</span>
          </div>

          <div class="bulletin-card__temp-row">
            <span class="bulletin-card__temp">29°</span>
            <span class="bulletin-card__temp-desc">Ciel voilé,<br>vent soutenu</span>
          </div>

          <div class="bulletin-card__stats">
            <div class="bulletin-card__stat">
              <span class="bulletin-card__stat-value">12<span class="bulletin-card__stat-unit">mm</span></span>
              <span class="bulletin-card__stat-label">Pluviométrie</span>
            </div>
            <div class="bulletin-card__stat">
              <span class="bulletin-card__stat-value">38<span class="bulletin-card__stat-unit">km/h</span></span>
              <span class="bulletin-card__stat-label">Vent</span>
            </div>
            <div class="bulletin-card__stat">
              <span class="bulletin-card__stat-value">64<span class="bulletin-card__stat-unit">%</span></span>
              <span class="bulletin-card__stat-label">Humidité</span>
            </div>
          </div>

          <div class="bulletin-card__advice">
            <span class="bulletin-card__advice-label">Conseil du jour</span>
            <p class="bulletin-card__advice-text">Reportez les traitements foliaires : le vent annoncé réduira leur efficacité de moitié.</p>
          </div>
        </div>

        <div class="float-card float-card--notif" id="float-notif">
          <span class="float-card__dot" aria-hidden="true"></span>
          Alerte envoyée à 1 240 producteurs
        </div>

        <div class="float-card float-card--channels">
          <span class="float-card__channels-label">Diffusion</span>
          <span class="float-card__channels-list">SMS · App · WhatsApp</span>
        </div>
      </div>

    </div>
  </section>

  <section class="problem" id="probleme">
    <div class="section-inner">
      <p class="eyebrow">Le constat</p>
      <h2 class="section-title">
        Les agriculteurs ont rarement une météo fiable et utile.
      </h2>

      <div class="problem__grid">
        <div class="problem__stat">
          <span class="problem__stat-value">-30%</span>
          <p class="problem__stat-text">de rendement estimé sur les parcelles touchées par un épisode climatique non anticipé.</p>
        </div>
        <div class="problem__stat">
          <span class="problem__stat-value">2 sur 3</span>
          <p class="problem__stat-text">producteurs ruraux n'ont pas accès à une prévision météo qu'ils jugent fiable et compréhensible.</p>
        </div>
        <div class="problem__stat">
          <span class="problem__stat-value">+</span>
          <p class="problem__stat-text">de pertes de bétail lors des vagues de chaleur ou des inondations soudaines, faute d'alerte précoce.</p>
        </div>
        <div class="problem__stat">
          <span class="problem__stat-value">0</span>
          <p class="problem__stat-text">conseil pratique associé aux bulletins météo classiques, pensés pour le grand public, pas pour le champ.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="pillars" id="mission">
    <div class="section-inner">
      <p class="eyebrow">Ce que fait ECO-VERT</p>
      <h2 class="section-title">Ce qu'on envoie aux producteurs.</h2>

      <div class="pillars__layout">
        <article class="pillar-card pillar-card--lg">
          <span class="pillar-card__data">01</span>
          <h3 class="pillar-card__title">Bulletins météo localisés</h3>
          <p class="pillar-card__text">
            Des prévisions converties en langage de terrain : pas seulement
            "il va pleuvoir", mais combien, quand, et ce que ça change pour
            vos semis ou votre récolte en cours.
          </p>
        </article>

        <article class="pillar-card pillar-card--sm pillar-card--accent">
          <span class="pillar-card__data">02</span>
          <h3 class="pillar-card__title">Alertes climatiques précoces</h3>
          <p class="pillar-card__text">
            Sécheresse, inondation, vent violent : une notification dès que
            le risque est détecté, assez tôt pour protéger récoltes et bétail.
          </p>
        </article>

        <article class="pillar-card pillar-card--sm">
          <span class="pillar-card__data">03</span>
          <h3 class="pillar-card__title">Conseils techniques adaptés</h3>
          <p class="pillar-card__text">
            Chaque bulletin s'accompagne d'une recommandation concrète :
            traiter, semer, abriter le troupeau, attendre.
          </p>
        </article>
      </div>
    </div>
  </section>

  <section class="flow" id="comment-ca-marche">
    <div class="section-inner">
      <p class="eyebrow eyebrow--light">Le parcours d'une alerte</p>
      <h2 class="section-title section-title--light">Comment l'information arrive jusqu'au terrain.</h2>

      <div class="flow__steps">
        <div class="flow__step">
          <span class="flow__step-num">01</span>
          <h3 class="flow__step-title">Collecte des données</h3>
          <p class="flow__step-text">Sources météorologiques locales et régionales, agrégées en continu.</p>
        </div>
        <div class="flow__arrow" aria-hidden="true"></div>
        <div class="flow__step">
          <span class="flow__step-num">02</span>
          <h3 class="flow__step-title">Traitement et analyse</h3>
          <p class="flow__step-text">Les données brutes sont converties en risques et conseils concrets.</p>
        </div>
        <div class="flow__arrow" aria-hidden="true"></div>
        <div class="flow__step">
          <span class="flow__step-num">03</span>
          <h3 class="flow__step-title">Diffusion</h3>
          <p class="flow__step-text">SMS, application mobile et WhatsApp — le canal que le producteur utilise déjà.</p>
        </div>
        <div class="flow__arrow" aria-hidden="true"></div>
        <div class="flow__step">
          <span class="flow__step-num">04</span>
          <h3 class="flow__step-title">Action sur le terrain</h3>
          <p class="flow__step-text">Semer, traiter, abriter le bétail : une décision prise à temps.</p>
        </div>
      </div>

      <div class="flow__demo">
        <p class="flow__demo-text">Voir une alerte en conditions réelles :</p>
        <button class="btn btn--accent" id="simulate-alert-btn">Simuler une alerte météo</button>
      </div>
    </div>
  </section>

  <section class="impact" id="impact">
    <div class="section-inner">
      <p class="eyebrow">Pourquoi ça compte</p>
      <h2 class="section-title">L'impact qu'on vise.</h2>

      <div class="impact__grid">
        <article class="impact-card">
          <span class="impact-card__label">Économique</span>
          <div class="impact-card__data">
            <span class="impact-card__data-value">↓</span>
            <span class="impact-card__data-text">Pertes</span>
          </div>
          <p class="impact-card__text">
            Moins de récoltes perdues, de meilleurs rendements, et des revenus
            agricoles plus stables d'une saison à l'autre.
          </p>
        </article>

        <article class="impact-card">
          <span class="impact-card__label">Social</span>
          <div class="impact-card__data">
            <span class="impact-card__data-value">↑</span>
            <span class="impact-card__data-text">Sécurité</span>
          </div>
          <p class="impact-card__text">
            Sécurité alimentaire renforcée, meilleures conditions de vie, et
            création d'emplois numériques autour du service.
          </p>
        </article>

        <article class="impact-card">
          <span class="impact-card__label">Environnemental</span>
          <div class="impact-card__data">
            <span class="impact-card__data-value">↻</span>
            <span class="impact-card__data-text">Résilience</span>
          </div>
          <p class="impact-card__text">
            Des pratiques agricoles plus durables, une meilleure gestion des
            ressources en eau et sol, une résilience accrue face au climat.
          </p>
        </article>
      </div>
    </div>
  </section>

  <section class="limits" id="limites">
    <div class="section-inner">
      <p class="eyebrow">En toute franchise</p>
      <h2 class="section-title">Ce qu'on n'a pas encore résolu.</h2>
      <p class="limits__intro">
        ECO-VERT part d'un terrain réel, avec ses contraintes réelles. Voici
        les défis que nous assumons et travaillons à réduire, plutôt qu'à
        cacher.
      </p>

      <div class="limits__grid">
        <div class="limits__item">
          <h3 class="limits__item-title">Accès Internet en zone rurale</h3>
          <p class="limits__item-text">La connectivité reste limitée dans certaines zones. C'est pourquoi le SMS reste un canal central, pas une option secondaire.</p>
        </div>
        <div class="limits__item">
          <h3 class="limits__item-title">Fiabilité des données locales</h3>
          <p class="limits__item-text">La précision météo dépend de la densité des sources disponibles, qui varie selon les régions et s'améliore progressivement.</p>
        </div>
        <div class="limits__item">
          <h3 class="limits__item-title">Adoption numérique</h3>
          <p class="limits__item-text">Recevoir une alerte ne suffit pas : il faut accompagner les producteurs pour qu'ils s'approprient l'outil, d'où nos sessions de formation.</p>
        </div>
        <div class="limits__item">
          <h3 class="limits__item-title">Coût de maintenance</h3>
          <p class="limits__item-text">Maintenir un service fiable a un coût réel. C'est une des raisons pour lesquelles les partenariats sont essentiels à la pérennité du projet.</p>
        </div>
        <div class="limits__item">
          <h3 class="limits__item-title">Couverture linguistique</h3>
          <p class="limits__item-text">Chaque langue locale ajoutée prend du temps à intégrer correctement. La couverture s'étend progressivement, pas tout d'un coup.</p>
        </div>
      </div>
    </div>
  </section>

</main>

<section class="partners-cta" id="partenaires">
  <div class="section-inner partners-cta__inner">
    <p class="eyebrow eyebrow--light">Rejoindre le projet</p>
    <h2 class="partners-cta__title">
      On cherche des partenaires pour avancer plus vite.
    </h2>
    <p class="partners-cta__text">
      ECO-VERT cherche des partenaires techniques, institutionnels et des
      investisseurs. Que vous apportiez des données, des canaux de diffusion,
      ou un financement, on peut probablement travailler ensemble.
    </p>

    <div class="partners-cta__options">
      <div class="partners-cta__option">
        <span class="partners-cta__option-data">01</span>
        <h3 class="partners-cta__option-title">Partenaire institutionnel</h3>
        <p class="partners-cta__option-text">Ministères, ONG, coopératives : étendre la couverture et la confiance locale.</p>
      </div>
      <div class="partners-cta__option">
        <span class="partners-cta__option-data">02</span>
        <h3 class="partners-cta__option-title">Partenaire technique</h3>
        <p class="partners-cta__option-text">Données météo, infrastructures télécom, plateformes de messagerie.</p>
      </div>
      <div class="partners-cta__option">
        <span class="partners-cta__option-data">03</span>
        <h3 class="partners-cta__option-title">Investisseur</h3>
        <p class="partners-cta__option-text">Accompagner la croissance d'un service à impact mesurable dès le terrain.</p>
      </div>
    </div>

    <div class="partners-cta__ctas">
      <a href="{{ route('register') }}" class="btn btn--accent btn--lg">Devenir partenaire</a>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="section-inner footer__inner">
    <a href="#top" class="footer__logo">
      <img src="{{ asset('images/logo.svg') }}" alt="ECO-VERT Logo" class="footer__logo-img">
      ECO-VERT
    </a>
    <nav class="footer__links" aria-label="Navigation footer">
      <a href="#mission">Mission</a>
      <a href="#comment-ca-marche">Comment ça marche</a>
      <a href="#impact">Impact</a>
      <a href="#partenaires">Partenaires</a>
    </nav>
    <p class="footer__mention">ECO-VERT — startup en phase d'amorçage. Météo agricole et alertes climatiques pour le terrain.</p>
  </div>
</footer>

<!-- chatbot par mots-clés, pas d'IA générative (pas de backend pour cacher une clé API) -->
<div class="chatbot" id="chatbot">
  <button class="chatbot__toggle" id="chatbot-toggle" aria-label="Ouvrir l'assistant ECO-VERT" aria-expanded="false">
    <svg class="chatbot__toggle-icon" id="chatbot-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
  </button>

  <div class="chatbot__panel" id="chatbot-panel" role="dialog" aria-label="Assistant ECO-VERT" aria-hidden="true">
    <div class="chatbot__header">
      <div>
        <p class="chatbot__header-title">Assistant ECO-VERT</p>
        <p class="chatbot__header-subtitle">Réponses automatiques</p>
      </div>
      <button class="chatbot__close" id="chatbot-close" aria-label="Fermer l'assistant">×</button>
    </div>

    <div class="chatbot__messages" id="chatbot-messages">
      <div class="chatbot__message chatbot__message--bot">
        Bonjour  ! Bienvenue chez ECO-VERT. Je suis votre assistant et je suis ici pour vous aider. Comment puis-je vous assister aujourd'hui ?
      </div>
    </div>

    <div class="chatbot__quick-replies" id="chatbot-quick-replies">
      <button class="chatbot__quick-reply" data-question="Comment recevoir les alertes ?">Recevoir les alertes</button>
      <button class="chatbot__quick-reply" data-question="Est-ce gratuit ?">C'est gratuit ?</button>
      <button class="chatbot__quick-reply" data-question="Comment devenir partenaire ?">Devenir partenaire</button>
    </div>

    <form class="chatbot__input-row" id="chatbot-form">
      <input type="text" id="chatbot-input" class="chatbot__input" placeholder="Écrivez votre question…" aria-label="Votre question" autocomplete="off">
      <button type="submit" class="chatbot__send" aria-label="Envoyer">
        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
          <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H.75a.75.75 0 000 1.5h4.232l2.432 7.905a.75.75 0 00.926.94l19.5-13a.75.75 0 000-1.22l-19.5-13z"/>
        </svg>
      </button>
    </form>
  </div>
</div>

<script src="{{ asset('files/script.js') }}"></script>
</body>
</html>
