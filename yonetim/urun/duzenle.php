<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//1.Kayıt Seti: KDV

$kdvSor= $db->prepare("SELECT * FROM urun_kdv");
$kdvSor->execute();
$kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC);

//2.Kayıt Seti : kategori

$kategoriSor=$db->prepare("SELECT * FROM urun_kategori");
$kategoriSor->execute();
$kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);

//urunID değerinin alınması

$urunID=$_GET['UrunID'];

//echo "Gelen Urun ID : $urunID";

//3.Kayıt Seti : Ürünün Kendisi
$urunSor=$db->prepare("SELECT * FROM urun WHERE UrunID =:urunID");
$urunSor->execute(array(
    'urunID'=>$_GET['UrunID']
));
$urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);

/*
echo '<pre>';
print_r($urunCek);
*/

//Form Gönderildiğinde

if(isset($_POST['urunDuzenleSubmit']))
{
    /*
    echo 'Form Gönderildi';
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
     
     */
    
    //Formdan gelen veriler alındı
    $kdvID=$_POST['KdvID'];
    $kategoriID=$_POST['KategoriID'];
    
    $urunAdi=$_POST['UrunAdi'];
    $urunFiyat=$_POST['UrunFiyat'];
    
  
    echo "Ürün aktif değeri $urunAktif";
    
    $urunResim = $_FILES['UrunResim']['name'];
    
   
    
    $aktif= $_POST['UrunAktif'];
     print_r($aktif);

    
    //boş alan kabul edilmeyecek.
    //boş değilse devam edecek.
    
  
    if($_FILES['UrunResim']["size"] > 0) {

	$uploads_dir = '../../_uploads/resim/urun'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['UrunResim']['tmp_name'];
	@$name = $_FILES['UrunResim']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$duzenle=$db->prepare("UPDATE urun SET
	KategoriID=:kategoriID,
	KdvID=:kdvID,
	UrunAdi=:urunAdi,
	UrunFiyat=:urunFiyat,
        UrunAktif=:urunAktif,
	UrunResim=:urunResim
	WHERE UrunID={$_POST['UrunID']}");
        
	$update=$duzenle->execute(array(
	'kategoriID' => $_POST['KategoriID'],
	'kdvID' => $_POST['KdvID'],
	'urunAdi' => $_POST['UrunAdi'],
	'urunFiyat' => $_POST['UrunFiyat'],
        'urunAktif' => $aktif,
	'urunResim' => $refimgyol
	
	));
	$UrunID=$_POST['UrunID'];
        if($update)
        {
            $resimsilunlink=$_POST['eski_yol'];
	    unlink("../../$resimsilunlink");
            header("Location:index.php?UrunID=$urunID&Durum=ok");
        }
        else {
            header("Location:index.php?UrunID=$urunID&Durum=no");
        }
	




} else {
    
    $duzenle=$db->prepare("UPDATE urun SET
	KategoriID=:kategoriID,
	KdvID=:kdvID,
	UrunAdi=:urunAdi,
	UrunFiyat=:urunFiyat,
        UrunAktif=:urunAktif
	WHERE UrunID={$_POST['UrunID']}");
        
	$update=$duzenle->execute(array(
	'kategoriID' => $_POST['KategoriID'],
	'kdvID' => $_POST['KdvID'],
	'urunAdi' => $_POST['UrunAdi'],
	'urunFiyat' => $_POST['UrunFiyat'],
        'urunAktif' => $aktif
	));
	$UrunID=$_POST['UrunID'];
        
        if($update)
        {
            
            header("Location:index.php?UrunID=$urunID&Durum=ok");
        }
        else {
            header("Location:index.php?UrunID=$urunID&Durum=no");
        }
    
}
 
}


//Veritabanındaki veriler güncellenecek

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
      <title>Ürün > Düzenle</title>
    
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
     <h1>Ürün Düzenle</h1>
    <?php
 
    if (isset($_GET['Hata']))
    {
        echo '<p>Ürün Adı veya Ürün Fiyatı boş bırakılamaz.</p>';
    }
    ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="UrunID" value="<?= $urunCek['UrunID'] ?>" />
        <input type="hidden" name="UrunResim" value="<?= $urunCek['UrunResim'] ?>" />
         <input type="hidden" name="eski_yol" value="<?= $urunCek['UrunResim'] ?>" />
        
        
        <fieldset>
            <legend>Kategori ve KDV Bilgileri</legend>
            <label for="KategoriID">Kategori</label>
            <select name="KategoriID" id="KategoriID">
    
                <?php do{ ?>
                <option value="<?= $kategoriCek['KategoriID']?>"<?php if($kategoriCek['KategoriID']== $urunCek['KategoriID']):?> selected="selected"<?php endif; ?>><?= $kategoriCek['Kategori'] ?></option>
                <?php }while ($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) ?>
            
            </select> 
            <label for="KdvID">KDV Değeri</label>
            <select name="KdvID" id="KdvID">
              <?php do{ ?>
                <option value="<?= $kdvCek['KdvID']?>" <?php if ($kdvCek['KdvID']== $urunCek['KdvID']) :?> selected="selected"<?php endif;?>><?= $kdvCek['KdvTip'] ?></option>
                <?php }while ($kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC)) ?>
           
            </select>
        </fieldset>
        
      
        <fieldset>
            <legend>Ürün Temel Bilgileri</legend>
            <label for="UrunAdi">Ürün Adı</label>
            <input type="text" name="UrunAdi" id="UrunAdi" value="<?= $urunCek['UrunAdi']?> " size="50" />
            <label for="UrunFiyat">Ürün Fiyat</label>
            <input type="text" name="UrunFiyat" id="UrunFiyat" value="<?= $urunCek['UrunFiyat']?>" />
            <p>
            <img id="urunResim2" src="../../<?= $urunCek['UrunResim'] ?>" />
            </p>
            <label for="UrunResim">Yeni Resim</label>
            <input type="file" name="UrunResim" id="UrunResim"/><br><br>
            <label for="UrunAktif">Ürün Aktif mi?</label>
            <select id="UrunAktif" name="UrunAktif">
            <?php if ($urunCek['UrunAktif']==0):?>
            
            <option value="0">Pasif</option>
            <option value="1">Aktif</option>
            
            <?php else: ?>
            
            <option value="1">Aktif</option>
            <option value="0">Pasif</option>
            
            <?php endif; ?>
            </select>
            <hr>
            <input type="submit" name="urunDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
    </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
