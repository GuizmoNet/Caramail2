<?php
//$data_user = file_get_contents("https://magirc.chaat.fr/rest/service.php/channels/%23accueil/users");
$data_user = file_get_contents("https://network.chaat.fr/rest/service.php/channels/%23accueil/users");
$decode_user = json_decode($data_user, true);
if(!empty($decode_user)) {
foreach($decode_user as $k=>$v) {
    if(preg_match_all("/^([0-9]{1,2}) ([fF])/", $v['realname'])) { // pour les femmes
    echo '<a href="#" data-toggle="tooltip" title="'.$v['realname'].'" style="color:#FF0097;font-weight:bold;">' . $v['nickname'] . '</a><br>' ;
    echo "\r\n"; 
    } else { }
}
}
?>
