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
     <h1>Gösterim Türü Düzenle</h1>
    <?php
    // put your code here
    ?>
    
    <form action="" method="post">
        <fieldset>
            <legend>Gösterim Türü</legend>
            <label for="GosterimTuru">Gösterim Türü</label>
            <input type="text" name="GosterimTuru" id="GosterimTuru" value="<?= $gosterimTuruCek['GosterimTuru']?>"/>
            <br><br>
            <input type="submit" name="gosterimTuruDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
    </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
