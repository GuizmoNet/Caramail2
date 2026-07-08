<?php
$url    = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$part   = explode("/", $url);
$lien   = $part[4];
$second = explode("?", $lien);
$finale = $second[0];                          // slug brut : "coquine"

$nom = ucwords(str_replace('-', ' ', $finale));
?>
<?php include("up.php"); ?>
<title>Chat gratuit <?php echo ucfirst($finale); ?> et site de rencontre <?php echo ucfirst($finale); ?></title>
<?php include("up2.php"); ?>
            <p class="lead text-resize">- <strong>TChat <?php echo ucfirst($finale); ?></strong> -<br>Rejoindre les <strong><font color="#e6e6e6"><?php echo "$users"; ?></font></strong> t'chatteurs<br><strong><font color="#e6e6e6">Rencontre gratuite</font></strong> & <strong><font color="#e6e6e6">sans inscription</font></strong></p>
<?php include("up3.php"); ?>
<h1 class="section-title">Chat gratuit <?php echo ucfirst($finale); ?></h1>
<h2 class="section-title">Rencontre <?php echo ucfirst($finale); ?></h2>
<?php include("up4.php"); ?>
	        <br>
<div class="content-text"><br>
<?php include(__DIR__ . '/../../seo.php'); ?>
			</div>
<?php include("down.php"); ?>