<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//form gönderildiğinde

if(isset($_POST['uyeSeviyeEkleSubmit']))
{
    $seviye = $_POST['Seviye'];
    $seviyeIcon= $_FILES['SeviyeIcon']['name'];
    
    if(!empty($seviye) && !empty($seviyeIcon))
    {
        //boş değilse işlemlere devam et.
        $uploads_dir = '../../_uploads/resim/uye/seviye'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['SeviyeIcon']['tmp_name'];
	@$name = $_FILES['SeviyeIcon']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");


 $kaydet=$db->prepare("INSERT INTO uye_seviye SET
                Seviye=:seviye,
                SeviyeIcon=:seviyeIcon
                    ");
        $insert=$kaydet->execute(array(
                'seviye' => $seviye,
                'seviyeIcon'=> $refimgyol));

	if($insert)	{

		Header("Location:index.php?durum=ok");
	}else{

		Header("Location:index.php?durum=no");
	}	
            
        
    }elseif (empty($seviye)) {
        header("Location:ekle.php?Hata=AlanBos");
    }
    elseif (!empty($seviye) && empty($seviyeIcon)) {
        
 $kaydet=$db->prepare("INSERT INTO uye_seviye SET
                Seviye=:seviye,
                SeviyeIcon=:seviyeIcon
                    ");
        $insert=$kaydet->execute(array(
                'seviye' => $seviye,
                'seviyeIcon'=> $seviyeIcon));

	if($insert)	{

		Header("Location:index.php?durum=ok");
	}else{

		Header("Location:index.php?durum=no");
	}
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Üye > Seviye Ekle</title>
    
    <link href="../css/tema/rcpanel/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
    <script src="../js/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
    
    <!--Jquery Tab Başlangıcı -->
    
    <style>

    </style>
    
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

        <h1>Üye Seviye Ekle</h1>
        
        
            <?php 
            if (isset($_GET['Hata']))
            {
                echo "<div class='formHataAlanBos'>";
                echo "<p>Lütfen Seviye Adını Giriniz.</p>";
                echo "</div>";
            }
            
            ?>
        
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <fieldset>
                <legend>Üye Seviye Bilgileri</legend>
               
                <label for="Seviye">Seviye</label>
                <input type="text" name="Seviye" id="Seviye" />
                <label for="SeviyeIcon">Seviye İkon</label>
                <input type="file" name="SeviyeIcon" id="SeviyeIcon" />
                <input type="submit" name="uyeSeviyeEkleSubmit" value="Üye Seviye Ekle" />
            </fieldset>
            
        </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
