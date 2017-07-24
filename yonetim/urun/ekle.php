<?php

//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//Kdv Bigileri için kayıt seti

$kdvSor=$db->prepare("select * from urun_kdv");
$kdvSor->execute();

$urunSor=$db->prepare("select * from urun");
$urunSor->execute();


//Kategori bilgiler için kayıt seti
$kategoriSor=$db->prepare("select * from urun_kategori");
$kategoriSor->execute();


//Form gönderildiğinde çalışacak

if(isset($_POST['urunEkleSubmit'])) {
	$uploads_dir = '../../_uploads/resim/urun'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['UrunResim']['tmp_name'];
	@$name = $_FILES['UrunResim']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");



	$kaydet=$db->prepare("INSERT INTO urun SET
	KategoriID=:kategoriID,
        KdvID=:kdvID,
	UrunAdi=:urunAdi,
	UrunFiyat=:urunFiyat,
	UrunAktif=:urunAktif,
	UrunResim=:urunResim");
	$insert=$kaydet->execute(array(
	'kategoriID' => $_POST['KategoriID'],
	'kdvID' => $_POST['KdvID'],
	'urunAdi' => $_POST['UrunAdi'],
	'urunFiyat' => $_POST['UrunFiyat'],
	'urunAktif' => $_POST['UrunAktif'],
	'urunResim' => $refimgyol
        ));

	if($insert)	{

		Header("Location:../../index.php?durum=ok");
	}else{

		Header("Location:../../index.php?durum=no");
	}	


}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün Ekle</title>
    
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
   

   <?php   
   /*
   echo 'KDV çeşiti sayısı:' .$num_row_rsKdv;
   echo '<br/>';
   echo 'Ürün Kategori Sayısı'. $num_row_rsUrunKategori;
   
    */
   ?>
    
    <h1>Ürün Ekle</h1>
    <form action="" method="post" enctype="multipart/form-data">
        
        <fieldset>
            <legend>Kategori ve KDV bilgisi</legend>
            <label for="KategoriID">Ürün Kategorisi</label>
            <select name="KategoriID" id='KategoriID'>
                
                <?php while ($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) { ?>
                 <option value="<?= $kategoriCek['KategoriID'] ?>"><?= $kategoriCek['Kategori'] ?></option>
                <?php } ?>
               
            </select>
            
            <label for="KdvID">KDV Tipi</label>
            <select name="KdvID" name='KdvID'>
                 <?php while($kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $kdvCek['KdvID'] ?>"><?= $kdvCek['KdvTip'] ?></option>
                <?php }  ?>
            </select>
        </fieldset>
        
  <!--Ürün Bilgisi Bölümü -->
  
  <fieldset>
  
      <legend>Ürün Bilgisi</legend>
      <label for="UrunAdi">Ürün Adı</label>
      <input type="text" name="UrunAdi" id="UrunAdi"/>
      <label for="UrunFiyat">Ürün Fiyat</label>
      <input type="text" name="UrunFiyat" id="UrunFiyat"/>
      <label for="UrunAktif">Ürün Yayınlansın mı?</label>
      <input type="checkbox" name="UrunAktif" id="UrunAktif"/>
      <label for="UrunResim">Ürün Resim</label>
      <input type="file" name="UrunResim" id="UrunResim" />
  </fieldset>
  
  <input type='submit' name='urunEkleSubmit' value="Urun Ekle" />
  
 
    
    </form>
    
</body>
</html>
