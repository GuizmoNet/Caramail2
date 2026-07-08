<meta name="robots" content="noindex, nofollow" />
<?php
/**
 * Redirige vers la page de sélection des salons (chat/index.php)
 * en conservant les variables saisies (pseudo, âge, sexe, ville).
 */
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$age    = isset($_POST['age'])    ? $_POST['age']    : '';
$sexe   = isset($_POST['sexe'])   ? $_POST['sexe']   : '';
$ville  = isset($_POST['ville'])  ? $_POST['ville']  : '';

// Normalise le sexe : H (homme) -> M
if ($sexe === 'H') {
    $sexe = 'M';
}

// Variables conservées et transmises à la page de sélection
$query = http_build_query(array(
    'pseudo' => $pseudo,
    'age'    => $age,
    'sexe'   => $sexe,
    'ville'  => $ville,
));

header('X-Robots-Tag: noindex, nofollow', true);
header('Location: index.php?' . $query, true, 302);
exit;
?>