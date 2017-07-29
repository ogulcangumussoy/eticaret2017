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

		Header("Location:index.php?durum=ok");
	}else{

		Header("Location:index.php?durum=no");
	}	


}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün Ekle</title>
    
    <link href="../css/tema/rcpanel/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
    <script src="../js/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
    
    <!--Jquery Tab Başlangıcı -->
    
    <script type="text/javascript">
			$(function(){
				// Tabs
				$('#tabs').tabs();
			});
		</script>
<!--Jquery Tab Sonu -->
    
    
</head>
<body>
    
    <header>
        <h1>RCPanel</h1>
        
        <div id="kullaniciLogin">
            <img width="30px" src="../_img/layout/_kullanici.png" /> Kullanıcı Adı
            <img width="30px" src="../_img/layout/logout.png" /> Çıkış
        </div>
        
    </header>
    
    <nav>
      
        <!-- Tabs -->
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Ürün Temel</a></li>
				<li><a href="#tabs-2">Ürün Detay</a></li>
				<li><a href="#tabs-3">Üyelik</a></li>
			</ul>
                    <div id="tabs-1">
                        
                        <table>
                            <tr>
                                <td><h3>Ürün</h3></td>
                                <td></td>
                                <td></td>
                                <td id="mesafe"><h3>Gösterim Türü</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /><a href="../urun/index.php">Düzenle</a></td>
                                <td>&nbsp;</td>
                                <td id="mesafe"><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_gosterim_turu/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_gosterim_turu//index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><h3>Ürün Kategori</h3></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td ><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_kategori/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /><a href="../urun_kategori/index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><h3>Ürün KDV</h3></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_kdv/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_kdv/index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            
                        </table>

                    </div>
			
		</div>


        
    </nav>
    
    <section>
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
      <select id="UrunAktif" name="UrunAktif">
            <option value="0">Pasif</option>
            <option value="1">Aktif</option>
      </select>
      <label for="UrunResim">Ürün Resim</label>
      <input type="file" name="UrunResim" id="UrunResim" />
  </fieldset>
  <br>
  <input type='submit' name='urunEkleSubmit' value="Urun Ekle" />
  
 
    
    </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
