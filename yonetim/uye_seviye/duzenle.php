<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//Üye seviye kayıt setinin yapılması

$seviyeID= $_GET['SeviyeID'];
$uyeSeviyeSor=$db->prepare("SELECT * FROM uye_seviye WHERE SeviyeID=:seviyeID ");
$uyeSeviyeSor->execute(array(
        'seviyeID' => $seviyeID));
$uyeSeviyeCek=$uyeSeviyeSor->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['uyeSeviyeDuzenleSubmit']))
{
 
     //echo 'Form Gönderildi';
    $seviye=$_POST['Seviye'];
    $seviyeID=$_POST['SeviyeID'];
    $seviyeIcon=$_FILES['SeviyeIcon']['name'];
    
if($_FILES['SeviyeIcon']["size"] > 0 && !empty($_POST['Seviye'])) {

	$uploads_dir = '../../_uploads/resim/uye/seviye'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['SeviyeIcon']['tmp_name'];
	@$name = $_FILES['SeviyeIcon']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$duzenle=$db->prepare("UPDATE uye_seviye SET
	Seviye=:seviye,
	SeviyeID=:seviyeID,
	SeviyeIcon=:seviyeIcon
	WHERE SeviyeID={$_POST['SeviyeID']}");
        
	$update=$duzenle->execute(array(
	'seviye' => $_POST['Seviye'],
	'seviyeID' => $_POST['SeviyeID'],
	'seviyeIcon' => $refimgyol
	
	));
	
        if($update)
        {
            $resimsilunlink=$_POST['eski_yol'];
	    unlink("../../_uploads/resim/uye/seviye/$resimsilunlink");
            header("Location:index.php?SeviyeID=$seviyeID&Durum=ok");
        }
        else {
            header("Location:index.php?SeviyeID=$seviyeID&Durum=no");
        }
	

} elseif(empty ($_FILES['SeviyeIcon']['name']) && !empty ($seviye)) {
$duzenle=$db->prepare("UPDATE uye_seviye SET
	Seviye=:seviye,
	SeviyeID=:seviyeID
	WHERE SeviyeID={$_POST['SeviyeID']}");
        
	$update=$duzenle->execute(array(
	'seviye' => $_POST['Seviye'],
	'seviyeID' => $_POST['SeviyeID']
	));
	
        if($update)
        {
            header("Location:index.php?SeviyeID=$seviyeID&Durum=ok");
        }
        else {
            header("Location:index.php?SeviyeID=$seviyeID&Durum=no");
        }
    
}
else{

    header("Location:duzenle.php?SeviyeID=$seviyeID&Hata=AlanBos");
}
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Üye > Seviye Düzenle</title>
    
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
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_gosterim_turu/index.php">Düzenle</a></td>
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
        
    <h1>Üye Seviye Düzenle</h1>
              <?php
    if(isset($_GET['Hata']))
    {
        echo "<div class='formHataAlanBos'>";
        echo "<p>Lütfen Kategori Adını Boş Bırakmayınız</p>";
        echo "</div>";
    }
    ?>
    
    
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="SeviyeID" value="<?= $seviyeID ?>" />
        <input type="hidden" name="eski_yol" value="<?= $uyeSeviyeCek['SeviyeIcon'] ?>"  />
        <fieldset>
            <legend>Üye Seviye</legend>
            <label for="Seviye">Seviye</label>
            <input type="text" name="Seviye"  id="Seviye" value="<?= $uyeSeviyeCek['Seviye'] ?>" />
            <p>Şu anki Resim</p>
            <img src="../../_uploads/resim/uye/seviye/<?= $uyeSeviyeCek['SeviyeIcon'] ?>" />
            <label for="SeviyeIcon">Yeni Seviye İkon</label>
            <input type="file" name="SeviyeIcon" id="SeviyeIcon"/>
            <input type="submit" name="uyeSeviyeDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
    </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
