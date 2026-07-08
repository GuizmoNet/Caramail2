<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
$pseudo = $_POST['pseudo'];
$age = $_POST['age'];
$sexe = $_POST['sexe'];
if ($sexe === 'H') { $sexe = 'M'; }
$ville = $_POST['ville'];
//$ville=ereg_replace("[^1-9]","",$ville);
$ville = $_POST['ville'];
$url = "https://partners.chaat.fr/?nick=".$pseudo."&age=".$age."&sexe=".$sexe."&ville=".$ville."&channel=Accueil&chatnow=1";
header('Location: '.$url.'');
exit();
?>
