<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
$pseudo = $_POST['pseudo'];
$age    = $_POST['age'];
$sexe   = $_POST['sexe'];
$ville  = $_POST['ville'];

if ($sexe === 'M') {
    $channels = "Accueil,Gay,Entre-Mecs";
}
if ($sexe === 'F') {
    $channels = "Accueil,Lesbiennes,Entre-filles";
}

// Nettoyage du département
$ville = preg_replace("/\D/", "", $ville);

// URL avec channels obligatoirement
$url = "https://partners.chaat.fr/?nick=".$pseudo
     ."&age=".$age
     ."&sexe=".$sexe
     ."&ville=".$ville
     ."&channel=".$channels
     ."&chatnow=1";

header('Location: '.$url);
exit();
?>

