<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<iframe src="<?= htmlspecialchars($url) ?>"></iframe>
</body>
</html>

<?php
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$age    = isset($_POST['age'])    ? $_POST['age']    : '';
$sexe   = isset($_POST['sexe'])   ? $_POST['sexe']   : '';
$ville  = isset($_POST['ville'])  ? $_POST['ville']  : '';

// Normalise le sexe : H (homme) -> M
if ($sexe === 'H') {
    $sexe = 'M';
}

// Salons rejoints selon le sexe
if ($sexe === 'M') {
    $channels = "Accueil,Gay,Entre-Mecs";
} elseif ($sexe === 'F') {
    $channels = "Accueil,Lesbiennes,Entre-filles";
} else {
    $channels = "Accueil";
}

$url = "https://app.chat-caramail.fr/?nick=".urlencode($pseudo).
       "&age=".urlencode($age).
       "&sexe=".urlencode($sexe).
       "&ville=".urlencode($ville).
       "&channel=".urlencode($channels).
       "&chatnow=1";

header('X-Robots-Tag: noindex, nofollow', true);
header('Location: ' . $url, true, 302);
exit;
?>
