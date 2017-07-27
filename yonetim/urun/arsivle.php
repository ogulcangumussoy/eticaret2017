<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

$urunID = $_GET['UrunID'];
//echo "$UrunID";


$arsivKaydet=$db->prepare("UPDATE urun SET 
        UrunArsiv = 1
        WHERE UrunID= '$urunID'
        ");
$sonuc=$arsivKaydet->execute();
if($sonuc)
{
    header("Location:arsiv.php?arsiv=ok");
}
 else {
    header("Location:index.php?arsiv=no");
}


?>

