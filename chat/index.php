<?php
/**
 * chat/index.php
 * Page de sélection de salon.
 *  - Reçoit pseudo/âge/sexe/ville depuis le formulaire d'accueil.
 *  - Affiche la liste des salons (API chaat.fr).
 *  - Au clic sur un salon, redirige vers l'appli de tchat avec
 *    &channel=Accueil,<salon> (l'utilisateur rejoint Accueil + le salon choisi).
 */

$pseudo = isset($_REQUEST['pseudo']) ? $_REQUEST['pseudo'] : '';
$age    = isset($_REQUEST['age'])    ? $_REQUEST['age']    : '';
$sexe   = isset($_REQUEST['sexe'])   ? $_REQUEST['sexe']   : '';
$ville  = isset($_REQUEST['ville'])  ? $_REQUEST['ville']  : '';

// --- Un salon a été choisi → on ouvre directement le tchat -------------------
if (isset($_REQUEST['channel']) && trim($_REQUEST['channel']) !== '') {
    $salon   = ltrim(trim($_REQUEST['channel']), '#');
    $sexeApp = ($sexe === 'H') ? 'M' : $sexe;

    // channel = Accueil,<salon> (et on évite de doubler Accueil)
    if ($salon === '' || strcasecmp($salon, 'Accueil') === 0) {
        $channelParam = 'Accueil';
    } else {
        $channelParam = 'Accueil,' . rawurlencode($salon);
    }

    $url = "https://app.chat-caramail.fr/?nick=".urlencode($pseudo).
           "&age=".urlencode($age).
           "&sexe=".urlencode($sexeApp).
           "&ville=".urlencode($ville).
           "&channel=".$channelParam.
           "&theme=Caramail".
           "&go=1";

    header('Location: ' . $url, true, 302);
    exit;
}

// --- Sinon → récupération et affichage des salons ----------------------------
$ctx = stream_context_create(['http' => ['timeout' => 6]]);
$raw = @file_get_contents("https://network.chaat.fr/rest/service.php/channels", false, $ctx);
$channels = $raw ? json_decode($raw, true) : array();
if (!is_array($channels)) {
    $channels = array();
}

// Tri par nombre de connectés décroissant (les plus actifs en premier)
usort($channels, function ($a, $b) {
    return ((int)(isset($b['users']) ? $b['users'] : 0))
         - ((int)(isset($a['users']) ? $a['users'] : 0));
});

// Paramètres transmis à chaque carte (clic = nouvelle requête GET)
$carry = array(
    'pseudo' => $pseudo,
    'age'    => $age,
    'sexe'   => $sexe,
    'ville'  => $ville,
);

// Majuscule sur la première lettre (compatible UTF-8)
function salon_ucfirst($s) {
    if ($s === '') {
        return $s;
    }
    if (function_exists('mb_strtoupper')) {
        return mb_strtoupper(mb_substr($s, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($s, 1, null, 'UTF-8');
    }
    return ucfirst($s);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noindex, nofollow" />
<title>Sélectionne ton salon préféré - Chat Caramail</title>
<meta name="description" content="Choisis ton salon de discussion préféré et rejoins la conversation en un clic, sans inscription." />
<link rel="shortcut icon" href="../assets/images/icons/favicon.ico?v=3">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<style>
    :root {
        --blue-1: #1d8cae;
        --blue-2: #0a5870;
        --ink:    #1f2a2e;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: 'Open Sans', Arial, sans-serif;
        background: #f6f8f7;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* En-tête sobre */
    .salon-header {
        text-align: center;
        padding: 34px 20px 6px;
    }
    .salon-header img { max-height: 46px; width: auto; }

    .salon-hero {
        text-align: center;
        padding: 18px 20px 6px;
    }
    .salon-hero h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        letter-spacing: -0.2px;
        color: var(--ink);
    }
    .salon-hero p {
        margin: 8px 0 0;
        font-size: 16px;
        color: #6b7872;
    }

    /* Grille de salons */
    .salon-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 28px 22px 60px;
    }
    .salon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 26px;
    }

    /* Carte salon */
    .salon-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 188px;
        padding: 26px 28px;
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(150deg, var(--blue-1) 0%, var(--blue-2) 100%);
        box-shadow: 0 10px 24px -14px rgba(10, 88, 112, 0.5);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .salon-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 34px -16px rgba(10, 88, 112, 0.65);
    }
    /* Bulle de chat en filigrane */
    .salon-card::after {
        content: "";
        position: absolute;
        right: -8px;
        top: 50%;
        transform: translateY(-50%);
        width: 150px;
        height: 150px;
        opacity: 0.10;
        background: no-repeat center/contain
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff'%3E%3Cpath d='M12 3C6.49 3 2 6.59 2 11c0 2.07.99 3.95 2.61 5.36-.13 1.27-.62 2.43-1.36 3.41-.22.29.02.71.38.66 1.74-.24 3.31-.95 4.57-1.97 1.04.33 2.16.54 3.2.54 5.51 0 10-3.59 10-8s-4.49-8-10-8z'/%3E%3C/svg%3E");
        pointer-events: none;
    }

    .salon-count {
        align-self: flex-start;
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1;
        padding: 6px 11px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.92);
    }
    .salon-name {
        margin-top: 26px;
        font-size: 28px;
        font-weight: 700;
        word-break: break-word;
    }
    .salon-join {
        margin-top: auto;
        padding-top: 18px;
        font-size: 15px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.95);
    }
    .salon-join .arrow {
        transition: transform 0.18s ease;
        display: inline-block;
    }
    .salon-card:hover .salon-join .arrow { transform: translateX(4px); }

    .salon-empty {
        text-align: center;
        color: #6b7872;
        padding: 50px 0;
        font-size: 16px;
    }

    /* Bloc contenu éditorial (bas de page) */
    .salon-content {
        max-width: 880px;
        margin: 0 auto;
        padding: 10px 22px 70px;
        color: #43524d;
        font-size: 15.5px;
        line-height: 1.7;
    }
    .salon-content h2 {
        font-size: 21px;
        font-weight: 700;
        color: var(--ink);
        margin: 34px 0 10px;
        letter-spacing: -0.2px;
    }
    .salon-content h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--ink);
        margin: 22px 0 4px;
    }
    .salon-content p { margin: 0 0 14px; }
    .salon-content ul { margin: 0 0 14px; padding-left: 20px; }
    .salon-content li { margin-bottom: 6px; }
    .salon-content a { color: var(--blue-1); }

    .salon-foot {
        max-width: 880px;
        margin: 0 auto;
        padding: 0 22px 50px;
        text-align: center;
        font-size: 13px;
        color: #8a958f;
    }
    .salon-foot a {
        color: #8a958f;
        margin: 0 8px;
        text-decoration: none;
    }
    .salon-foot a:hover { text-decoration: underline; }

    @media (max-width: 600px) {
        .salon-hero h1 { font-size: 24px; }
        .salon-grid { gap: 18px; }
        .salon-content { font-size: 15px; }
    }
</style>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7316954709847555"
     crossorigin="anonymous"></script>
</head>
<body>

<div class="salon-header">
    <a href="https://chat-caramail.fr"><img src="../assets/images/logo_black.png" alt="Chat Caramail"></a>
</div>

<div class="salon-hero">
    <h1>Sélectionne ton salon préféré</h1>
    <p>Choisis un salon et rejoins la discussion en un clic.</p>
</div>

<div class="salon-wrap">
<?php if (empty($channels)): ?>
    <div class="salon-empty">Les salons sont momentanément indisponibles. Merci de réessayer dans quelques instants.</div>
<?php else: ?>
    <div class="salon-grid">
    <?php foreach ($channels as $chan):
        if (empty($chan['channel'])) {
            continue;
        }
        $label = ltrim($chan['channel'], '#');            // ex: accueil
        // On retire les salons par tranche d'âge (#18-30ans, #50ans-et-plus, ...)
        if (preg_match('/[0-9]+\s*ans/i', $label)) {
            continue;
        }
        $label   = salon_ucfirst($label);                 // ex: Accueil
        $name    = '#' . $label;                           // ex: #Accueil
        $users = isset($chan['users']) ? (int)$chan['users'] : 0;
        $href  = 'index.php?' . http_build_query(array_merge(array('channel' => $label), $carry));
    ?>
        <a class="salon-card" href="<?= htmlspecialchars($href, ENT_QUOTES) ?>">
            <span class="salon-count"><?= number_format($users, 0, ',', ' ') ?> connecté<?= $users > 1 ? 's' : '' ?></span>
            <span class="salon-name"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></span>
            <span class="salon-join">Rejoindre le salon <span class="arrow">&rsaquo;</span></span>
        </a>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

<div class="salon-content">

    <h2>Le tchat gratuit sans inscription de Chat Caramail</h2>
    <p>
        Chaque carte ci-dessus correspond à un salon de discussion ouvert en
        temps réel. Il suffit de cliquer sur celui qui t'intéresse pour rejoindre
        la conversation : aucune inscription, aucun e-mail à renseigner, aucune
        application à installer. Tu choisis un pseudo au moment d'entrer et tu
        discutes immédiatement avec les autres personnes connectées. Le nombre de
        membres présents est affiché sur chaque salon, pour te permettre de
        repérer d'un coup d'œil les pièces les plus animées et de te diriger
        directement là où la discussion bat son plein.
    </p>
    <p>
        Chat Caramail perpétue l'esprit du tchat français d'origine : un lieu
        simple et convivial où l'on vient parler, faire des rencontres amicales
        et passer un bon moment, sans contrainte et sans formalité. Tout
        fonctionne directement dans ton navigateur, aussi bien sur ordinateur que
        sur smartphone ou tablette, sans rien télécharger et sans configuration
        particulière.
    </p>

    <h2>Des salons pour tous les goûts</h2>
    <p>
        La liste des salons couvre une grande variété d'univers. Certains sont
        consacrés aux discussions générales et à la rencontre amicale, d'autres
        rassemblent les membres par tranche d'âge, ce qui permet à chacun de
        retrouver des personnes de sa génération et des sujets qui lui
        ressemblent. Les salons régionaux réunissent quant à eux les habitants
        d'une même zone géographique et facilitent les échanges de proximité,
        entre voisins de département ou de région.
    </p>
    <p>
        À côté de ces espaces, de nombreux salons thématiques sont dédiés à des
        centres d'intérêt précis : musique, jeux, culture, détente ou simples
        discussions entre passionnés. Les pièces les plus fréquentées apparaissent
        en tête de liste, mais rien ne t'empêche de rejoindre un salon plus calme
        et de contribuer à le faire vivre. Comme la liste est mise à jour en
        continu, tu y retrouves à chaque visite les salons réellement actifs au
        moment où tu te connectes.
    </p>

    <h2>Une discussion immédiate, où que tu sois</h2>
    <p>
        L'intérêt d'un tchat sans inscription, c'est la spontanéité : pas de
        compte à créer, pas d'attente, pas de mot de passe à retenir. Tu cliques
        sur un salon, tu choisis ton pseudo et tu participes aussitôt à la
        conversation. Tu peux passer d'un salon à l'autre librement, suivre
        plusieurs sujets dans la même session et revenir quand tu veux sous le
        pseudo de ton choix.
    </p>
    <p>
        Que tu cherches à discuter quelques minutes pendant une pause ou à passer
        une soirée entière à échanger, le principe reste le même : un accès
        direct, gratuit et ouvert à tous. Choisis simplement le salon qui te
        correspond dans la liste ci-dessus et rejoins la discussion.
    </p>

</div>

<div class="salon-foot">
    <a href="https://chat-caramail.fr/mentions/">Mentions légales</a>
    <a href="https://chat-caramail.fr/cgu/">CGU</a>
    <a href="https://chat-caramail.fr/confidentialite/">Confidentialité</a>
</div>

</body>
</html>
