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

if ($sexe === 'H') {
    $sexe = 'M';
}

$url = "https://app.chat-caramail.fr/?nick=".urlencode($pseudo).
       "&age=".urlencode($age).
       "&sexe=".urlencode($sexe).
       "&ville=".urlencode($ville).
       "&channel=Accueil&chatnow=1";

header('Location: ' . $url, true, 302);
exit;
?>
