<?php 
$fich = 'https://www.chat-caramail.fr/users-inconnu.php'; 
$tabFich = file($fich); 
$nbLignes = count($tabFich); 
//echo 'le fichier fait '.$nbLignes.' ligne(s).'; 
$fp = fopen('count-inconnu.txt', 'w');
fwrite($fp, $nbLignes);
fclose($fp);
?> 
