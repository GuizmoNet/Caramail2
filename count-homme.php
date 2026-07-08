<?php
// Exécuter la commande PHP et capturer la sortie
$output = shell_exec('php /var/www/chat-caramail.fr/web/users-homme.php');

if ($output !== null) {
    // Compter les lignes de la sortie
    $nbLignes = substr_count($output, "\n");
    
    // Si la dernière ligne n'a pas de \n, l'ajouter au compte
    if (!empty($output) && substr($output, -1) !== "\n") {
        $nbLignes++;
    }
    
    // Écrire le nombre de lignes dans le fichier
    file_put_contents('/var/www/chat-caramail.fr/web/count-homme.txt', $nbLignes);
    
    echo "Nombre de lignes: $nbLignes\n";
} else {
    echo "Erreur lors de l'exécution de la commande\n";
}
?>
