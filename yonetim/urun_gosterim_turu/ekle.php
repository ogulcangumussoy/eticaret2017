<?php
//Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

//form Gönderildi
if(isset($_POST['gosterimTuruEkleSubmit']))
{
    //echo 'Form Gönderildi';
    
    if(!empty($_POST['GosterimTuru']))
    {
    $kaydet=$db->prepare("INSERT INTO urun_gosterim_turu SET
        GosterimTuru=:gosterimTuru
            ");
    $insert=$kaydet->execute(array(
        'gosterimTuru' => $_POST['GosterimTuru']
    ));
    
    if($insert)
    {
        header("Location:index.php?durum=ok");
    }
    }else{
        header("Location:ekle.php?Hata=AlanBos");
    }
    /*
    $kaydet=$db->prepare("INSERT INTO urun_kategori SET
	Kategori=:Kategori,
        ParentID=:ParentID,
	KategoriResim=:KategoriResim");
	$insert=$kaydet->execute(array(
	'Kategori' => $_POST['Kategori'],
	'ParentID' => $parentID,
	'KategoriResim' => $benzersizad.$name
        ));

     	if($insert)	{
	

		Header("Location:index.php?KategoriID=$KategoriID&durum=ok");
	}else{

		Header("Location:index.php?durum=no");
	}
     * 
     */
	
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Gösterim Türü Ekle</title>
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
    
    <h1>Ürün Gösterim Türü Ekle</h1>
    <?php
    if(isset($_GET['Hata']))
    {
        echo '<p>Lütfen Gösterim Türünü boş bırakmayınız.</p>';
    }
    ?>
    <form action="" method="post">
        
        <fieldset>
            
            <legend>Gösterim Türü</legend>
            <label for="GosterimTuru">Gösterim Türü</label>
            <input type="text" name="GosterimTuru" id="GosterimTuru" />
            <br>
            
            <input type="submit" name="gosterimTuruEkleSubmit" value="Gösterim Türü Ekle" />
        </fieldset>
    </form>
</body>
</html>
