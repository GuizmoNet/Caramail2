<?php
/**
 * app.chat-caramail.fr — Sélecteur de salons (v2)
 *
 * Structure :
 *   1. "Plus qu'une étape" (hero d'entrée vers le chat)
 *   2. Grille de salons (style Chaat : compteur + nom + "Rejoindre le salon", sans description)
 *   3. Contenu SEO riche tout en bas (conformité + référencement)
 *
 * Chaque salon mène au live chat KiwiIRC (/chat/index.php) qui ne doit
 * JAMAIS contenir de code AdSense (politique "Ads in private communications").
 *
 * AdSense : commenté pour le moment. noindex/nofollow pour le moment.
 */

$docroot = $_SERVER['DOCUMENT_ROOT'];
function lire_compteur($chemin, $defaut = 0) {
    return is_readable($chemin) ? (int) trim(file_get_contents($chemin)) : $defaut;
}
$total_connectes = lire_compteur($docroot . '/count-total.txt', 4621);

// Salons (style Chaat). 'channel' = canal IRC, 'accent' = bleu|rose
$salons = [
    ['nom' => '#accueil',       'channel' => 'accueil',      'connectes' => lire_compteur($docroot.'/count-accueil.txt', 2046),     'accent' => 'bleu'],
    ['nom' => '#adultes',       'channel' => 'adultes',      'connectes' => lire_compteur($docroot.'/count-adultes.txt', 611),      'accent' => 'rose'],
    ['nom' => '#50ans-et-plus', 'channel' => '50ans-et-plus','connectes' => lire_compteur($docroot.'/count-50ans.txt', 556),        'accent' => 'bleu'],
    ['nom' => '#tentation',     'channel' => 'tentation',    'connectes' => lire_compteur($docroot.'/count-tentation.txt', 530),    'accent' => 'rose'],
    ['nom' => '#40ans-et-plus', 'channel' => '40ans-et-plus','connectes' => lire_compteur($docroot.'/count-40ans.txt', 447),        'accent' => 'bleu'],
    ['nom' => '#30ans-et-plus', 'channel' => '30ans-et-plus','connectes' => lire_compteur($docroot.'/count-30ans.txt', 431),        'accent' => 'rose'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Choisir un salon — Chat Caramail</title>
<meta name="description" content="Choisissez votre salon de discussion et rejoignez le chat gratuit sans inscription : accueil, adultes, 30, 40, 50 ans et plus.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<link rel="canonical" href="https://app.chat-caramail.fr/">
<link rel="shortcut icon" href="https://chat-caramail.fr/assets/images/icons/favicon.ico">

<!-- AdSense : present UNIQUEMENT sur cette page (contenu), JAMAIS sur le live chat -->
<!-- Desactive pour le moment :
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7316954709847555" crossorigin="anonymous"></script>
-->

<style>
  :root{
    --bleu:#1f8fc4;
    --bleu-fonce:#15678f;
    --rose:#e0467f;
    --encre:#1c2733;
    --gris:#5a6b78;
    --trait:#e4ebf0;
    --fond:#f5f8fa;
    --carte:#ffffff;
    --radius:14px;
    --ombre:0 1px 3px rgba(20,40,60,.06), 0 8px 24px rgba(20,40,60,.06);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{
    font-family:'Segoe UI',system-ui,-apple-system,Roboto,Helvetica,Arial,sans-serif;
    color:var(--encre); background:var(--fond); line-height:1.6;
    -webkit-font-smoothing:antialiased;
  }
  a{color:inherit;text-decoration:none}
  .wrap{max-width:1040px;margin:0 auto;padding:0 20px}

  /* 1. HERO "Plus qu'une etape" */
  header.hero{
    background:linear-gradient(135deg,var(--bleu),var(--bleu-fonce));
    color:#fff; padding:38px 0 34px; text-align:center;
  }
  header.hero .logo{
    font-size:13px; letter-spacing:.14em; text-transform:uppercase;
    opacity:.85; margin-bottom:12px;
  }
  header.hero .etape{
    display:inline-block; background:rgba(255,255,255,.16);
    padding:5px 14px; border-radius:999px; font-size:13px; font-weight:600;
    letter-spacing:.03em; margin-bottom:14px;
  }
  header.hero h1{font-size:clamp(24px,5vw,34px); font-weight:700; line-height:1.2}
  header.hero p{
    margin-top:10px; font-size:16px; opacity:.92;
    max-width:560px; margin-left:auto; margin-right:auto;
  }
  .live{
    display:inline-flex; align-items:center; gap:8px; margin-top:18px;
    background:rgba(255,255,255,.15); padding:7px 15px; border-radius:999px;
    font-size:14px; font-weight:600;
  }
  .dot{width:9px;height:9px;border-radius:50%;background:#46e08a;
    box-shadow:0 0 0 0 rgba(70,224,138,.6); animation:pulse 2s infinite}
  @keyframes pulse{
    0%{box-shadow:0 0 0 0 rgba(70,224,138,.5)}
    70%{box-shadow:0 0 0 9px rgba(70,224,138,0)}
    100%{box-shadow:0 0 0 0 rgba(70,224,138,0)}
  }
  @media (prefers-reduced-motion:reduce){ .dot{animation:none} }

  /* 2. GRILLE DE SALONS (style Chaat, sans description) */
  .salons{padding:34px 0 10px}
  .salons .titre{text-align:center;margin-bottom:22px}
  .salons .titre h2{font-size:22px}
  .salons .titre p{color:var(--gris);font-size:15px;margin-top:4px}

  .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
  @media (max-width:880px){ .grid{grid-template-columns:repeat(2,1fr)} }
  @media (max-width:560px){ .grid{grid-template-columns:1fr} }

  .salon{
    position:relative; overflow:hidden; min-height:150px;
    border-radius:var(--radius); padding:20px; color:#fff;
    display:flex; flex-direction:column; justify-content:space-between;
    box-shadow:var(--ombre);
    transition:transform .15s ease, box-shadow .15s ease;
  }
  .salon:hover{transform:translateY(-3px);
    box-shadow:0 4px 10px rgba(20,40,60,.10),0 18px 40px rgba(20,40,60,.14)}
  .salon.bleu{background:linear-gradient(140deg,var(--bleu),var(--bleu-fonce))}
  .salon.rose{background:linear-gradient(140deg,var(--rose),#b32f63)}

  .salon .badge{
    align-self:flex-start; background:rgba(0,0,0,.18);
    padding:4px 11px; border-radius:999px; font-size:12px; font-weight:600;
    display:inline-flex; align-items:center; gap:6px;
  }
  .salon .badge .dot{width:7px;height:7px;animation:none;background:#9fffce}
  .salon h3{font-size:24px;font-weight:700;margin:14px 0 0}
  .salon .rejoindre{
    margin-top:14px; font-size:15px; font-weight:600;
    display:inline-flex; align-items:center; gap:7px;
  }
  .salon .rejoindre svg{transition:transform .15s ease}
  .salon:hover .rejoindre svg{transform:translateX(4px)}
  .salon a.cover{position:absolute;inset:0;z-index:1}
  .salon a.cover:focus-visible{outline:3px solid #ffd34d;outline-offset:-3px}

  /* 3. CONTENU SEO (tout en bas) */
  .seo{background:var(--carte);border-top:1px solid var(--trait);margin-top:36px;padding:40px 0}
  .seo h2{font-size:22px;margin-bottom:14px}
  .seo h3{font-size:18px;margin:22px 0 8px}
  .seo p{color:var(--gris);margin-bottom:12px;font-size:15px}
  .seo strong{color:var(--encre)}

  /* Footer */
  footer.site{padding:24px 0;border-top:1px solid var(--trait);
    text-align:center;color:var(--gris);font-size:13px;background:var(--fond)}
  footer.site a{color:var(--bleu-fonce);text-decoration:underline}
  footer.site .links{margin-bottom:10px}
  footer.site .links a{margin:0 8px}
</style>
</head>
<body>

<!-- 1. HERO "Plus qu'une etape" -->
<header class="hero">
  <div class="wrap">
    <div class="logo">Chat Caramail</div>
    <div class="etape">Plus qu'une &eacute;tape</div>
    <h1>Choisissez votre salon pour entrer dans le chat</h1>
    <p>S&eacute;lectionnez un salon ci-dessous : vous serez connect&eacute; imm&eacute;diatement, sans inscription.</p>
    <span class="live"><span class="dot"></span><?php echo number_format($total_connectes,0,',',' '); ?> personnes connect&eacute;es</span>
  </div>
</header>

<!-- 2. GRILLE DE SALONS -->
<main>
<section class="salons">
  <div class="wrap">
    <div class="titre">
      <h2>Salons de discussion</h2>
      <p>Cliquez sur un salon pour rejoindre la conversation en direct.</p>
    </div>
    <div class="grid">
      <?php foreach ($salons as $s): ?>
      <article class="salon <?php echo $s['accent']; ?>">
        <a class="cover"
           href="/chat/index.php?channel=<?php echo urlencode($s['channel']); ?>"
           aria-label="Rejoindre le salon <?php echo htmlspecialchars($s['nom']); ?>"></a>
        <span class="badge"><span class="dot"></span><?php echo number_format($s['connectes'],0,',',' '); ?> connect&eacute;s</span>
        <h3><?php echo htmlspecialchars($s['nom']); ?></h3>
        <span class="rejoindre">
          Rejoindre le salon
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 3. CONTENU SEO (tout en bas) -->
<section class="seo">
  <div class="wrap">
    <h2>Chat gratuit sans inscription</h2>
    <p>Bienvenue sur les salons de discussion de <strong>Chat Caramail</strong>, dans l'esprit des anciens services de tchat comme Caramail. Ici, pas de compte &agrave; cr&eacute;er ni d'e-mail &agrave; fournir : vous choisissez un salon, un pseudo, et vous entrez directement dans la conversation. Le <strong>chat est enti&egrave;rement gratuit</strong> et accessible &agrave; toute heure, depuis votre ordinateur comme depuis votre t&eacute;l&eacute;phone.</p>

    <h3>Des salons pour chaque envie</h3>
    <p>Chaque salon r&eacute;unit des personnes qui partagent un m&ecirc;me cadre de discussion. Le salon <strong>#accueil</strong> est le point de rendez-vous g&eacute;n&eacute;ral, id&eacute;al pour une premi&egrave;re visite et pour faire connaissance avec les habitu&eacute;s. Les salons par tranche d'&acirc;ge &mdash; <strong>#30ans-et-plus</strong>, <strong>#40ans-et-plus</strong>, <strong>#50ans-et-plus</strong> &mdash; rassemblent des personnes de g&eacute;n&eacute;rations proches, ce qui facilite les &eacute;changes et les centres d'int&eacute;r&ecirc;t communs. Le salon <strong>#adultes</strong> est r&eacute;serv&eacute; &agrave; un public majeur souhaitant discuter librement entre adultes.</p>

    <h3>Discuter en direct, simplement</h3>
    <p>La discussion se d&eacute;roule en temps r&eacute;el avec les autres membres connect&eacute;s. Vous voyez qui est pr&eacute;sent, vous suivez les conversations et vous participez quand vous le souhaitez. Le nombre de personnes connect&eacute;es est indiqu&eacute; pour chaque salon, afin de choisir l'espace le plus anim&eacute; au moment de votre visite.</p>

    <h3>Rencontres et convivialit&eacute;</h3>
    <p>Au-del&agrave; de la simple discussion, ces salons permettent de faire des <strong>rencontres</strong> amicales ou amoureuses, pr&egrave;s de chez vous ou ailleurs. Beaucoup de conversations commencent par un simple bonjour et se prolongent au fil des affinit&eacute;s. Pour que l'exp&eacute;rience reste agr&eacute;able et s&ucirc;re pour tous, ne communiquez jamais d'informations personnelles trop rapidement et signalez tout comportement d&eacute;plac&eacute; &agrave; la mod&eacute;ration.</p>

    <h3>Un service respectueux et mod&eacute;r&eacute;</h3>
    <p>Les salons sont des espaces conviviaux o&ugrave; le respect de chacun est la r&egrave;gle. Les propos haineux, le harc&egrave;lement et les contenus interdits n'y ont pas leur place. Le service de discussion est assur&eacute; par un prestataire tiers ind&eacute;pendant ; ce site agit comme interface technique d'acc&egrave;s au chat. Bonne discussion sur Chat Caramail !</p>
  </div>
</section>
</main>

<footer class="site">
  <div class="wrap">
    <div class="links">
      <a href="https://chat-caramail.fr/">Accueil</a>
      <a href="https://chat-caramail.fr/cgu/">CGU</a>
      <a href="https://chat-caramail.fr/confidentialite/">Confidentialit&eacute;</a>
      <a href="https://chat-caramail.fr/mentions-legales/">Mentions l&eacute;gales</a>
    </div>
    <p>2016 - <?php echo date('Y'); ?> &copy; chat-caramail.fr &mdash; Le service de discussion est assur&eacute; par un prestataire tiers ind&eacute;pendant.</p>
  </div>
</footer>

</body>
</html>
