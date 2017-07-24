<?php

//mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

//Form Gönderildiğinde

if (isset($_POST['kdvEkleSubmit'])) {
    //Kdv Ekle form Gönderildi.

    if (!empty($_POST['kdvTip']) && !empty($_POST['kdv'])) {//Kdv ve Kdv tipi boş değilse işlem yapılacak.
    
        $kaydet = $db->prepare("INSERT INTO urun_kdv SET
	kdvTip=:KdvTip,
	kdv=:Kdv");
        $insert = $kaydet->execute(array(
            'KdvTip' => $_POST['kdvTip'],
            'Kdv' => $_POST['kdv']
        ));


        if ($insert) {

            header("Location:index.php?durum=ok");
        }       
    }
 else {
        header("Location:ekle.php?Hata=AlanBos");
    }// Hata varsa buraya gelecek
 
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type"content="text/html;charset=UTF-8">
    <title>Kdv > Ekle</title>
    
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

    <h1>KDV Ekle</h1>
    
    <div>
    <?php if(isset($_GET['Hata'])) :?>
        <p>Lütfen Kdv Tipini ve Kdv Değerini Boş bırakmayınız.</p>
    <?php endif;?>
    </div>    
    <form action="" method="post">
    
        <fieldset>
            <legend>KDV Bilgileri</legend>
            
            <label for="kdvTip">KDV Tipi</label>
            <input type="text" name="kdvTip" id="kdvTip" />
            
            <label for="kdv">KDV Değeri</label>
            <input type="text" name="kdv" id="kdv" />
            
            <br>
            <input type="submit" name="kdvEkleSubmit" value="Kdv Ekle" />
        </fieldset>
    </form>
</body>
</html>
