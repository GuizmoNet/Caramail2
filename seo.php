<?php
require_once __DIR__ . '//layout.php';

$slug = basename(dirname($_SERVER['PHP_SELF']));
$content = isset($descriptions[$slug]) ? $descriptions[$slug] : null;

if ($content) {
    echo '<span style="display:block;max-width:600px;margin:0 auto 1em auto;text-align:center;font-weight:bold;">Tchat gratuit ' . ucfirst(str_replace('-', ' ', $slug)) . '</span>';
    foreach ($content as $section) {
        echo '<span style="display:block;max-width:850px;margin:0 auto 1.5em auto;text-align:center;color:#4a90d9;">' . $section . '</span>';
    }
}
?>
