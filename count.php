<?php 
$fich = 'http://www.guizmo.net/caramail/users.php'; 
$tabFich = file($fich); 
$nbLignes = count($tabFich); 
echo 'le fichier fait '.$nbLignes.' ligne(s).'; 
?> 