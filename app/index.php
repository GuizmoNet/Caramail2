<?php
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$age    = isset($_POST['age']) ? $_POST['age'] : '';
$sexe   = isset($_POST['sexe']) ? $_POST['sexe'] : '';
$ville  = isset($_POST['ville']) ? $_POST['ville'] : '';

if ($sexe === 'H') {
    $sexe = 'M';
}

$url = "https://kiwi.chat-caramai.fr:4040/?nick=".urlencode($pseudo).
       "&age=".urlencode($age).
       "&sexe=".urlencode($sexe).
       "&ville=".urlencode($ville).
       "&channel=Accueil&chatnow=1";
?>
<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
html,body{
    margin:0;
    padding:0;
    width:100%;
    height:100%;
}
iframe{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    border:0;
}
</style>
</head>
<body>
<iframe src="<?= htmlspecialchars($url) ?>"></iframe>
</body>
</html>
