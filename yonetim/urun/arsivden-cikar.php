<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

$urunID = $_GET['UrunID'];
//echo "$UrunID";


$arsivKaydet=$db->prepare("UPDATE urun SET 
        UrunArsiv = 0
        WHERE UrunID= '$urunID'
        ");
$sonuc=$arsivKaydet->execute();
if($sonuc)
{
    header("Location:index.php?arsiv=ok");
}
 else {
        header("Location:index.php?arsiv=no");
}


?>

