<?php
//Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';
//Gösterim Türü Kayıt Seti

$gosterimTuruSor=$db->prepare("SELECT * FROM urun_gosterim_turu where GosterimTuruID=:gosterimTuruID");
$gosterimTuruSor->execute(array(
  	'gosterimTuruID' => $_GET['GosterimTuruID']
  	));

$gosterimTuruCek=$gosterimTuruSor->fetch(PDO::FETCH_ASSOC);


// Form Gönderildiğinde

if(isset($_POST['gosterimTuruDuzenleSubmit']))
{

    if(!empty($_POST['GosterimTuru']))
    {
	$duzenle=$db->prepare("UPDATE urun_gosterim_turu SET
	GosterimTuru=:gosterimTuru
	WHERE GosterimTuruID={$_POST['GosterimTuruID']}");
	$update=$duzenle->execute(array(
	'gosterimTuru' => $_POST['GosterimTuru']
	));
	$gosterimTuruID=$_POST['GosterimTuruID'];
        
        
        if($duzenle)
        {
            header("Location:index.php?durum=ok");
        } else {
            header("Location:index.php?durum?no");
        }

}else{
    header("Location:duzenle.php?GosterimTuruID=$gosterimTuruID&Hata=AlanBos");
}
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Gösterim Türü Düzenle</title>
    <style>
        
        label {
            display: block;
            font-size: 1em;
            font-family: verdana;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Gösterim Türü Düzenle</h1>
    <?php
    // put your code here
    ?>
    
    <form action="" method="post">
        <input type="hidden" name="GosterimTuruID" value="<?= $gosterimTuruCek['GosterimTuruID'] ?>" />
        <fieldset>
            <legend>Gösterim Türü</legend>
            <label for="GosterimTuru">Gösterim Türü</label>
            <input type="text" name="GosterimTuru" id="GosterimTuru" value="<?= $gosterimTuruCek['GosterimTuru']?>"/>
            <br><br>
            <input type="submit" name="gosterimTuruDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
    </form>
</body>
</html>
