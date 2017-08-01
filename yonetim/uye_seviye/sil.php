<?php
//Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';


$sil=$db->prepare("DELETE FROM uye_seviye WHERE SeviyeID=:seviyeID");
$sonuc=$sil->execute(array(
    'seviyeID' => $_GET['SeviyeID']));

if ($sonuc)
{
    header("Location:index.php");
}
?>
