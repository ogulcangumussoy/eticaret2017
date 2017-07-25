<?php
//Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';


    $sil=$db->prepare('DELETE FROM urun_gosterim_turu WHERE GosterimTuruID=:gosterimTuruID');
    $kontrol=$sil->execute(array(
        'gosterimTuruID' => $_GET['GosterimTuruID']
    ));

if($kontrol)
{
    Header("Location:index.php?durum=ok");
}
else{
    header("Location:index.php?durum=no");
}

?>

