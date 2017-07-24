<?php

//mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

//KdvID değerinin alınması

if($_GET['kdvsil']=="ok")
{
    $sil=$db->prepare('DELETE FROM urun_kdv WHERE KdvID=:KdvID');
    $kontrol=$sil->execute(array(
        'KdvID' => $_GET['KdvID']
    ));
}

if($kontrol)
{
    Header("Location:index.php?durum=ok");
}
else{
    header("Location:index.php?durum=no");
}
?>