<?php
// Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

// KdvID değerinin alınması


//KDV Kayıt Seti

$kdvSor=$db->prepare("SELECT * FROM urun_kdv where KdvID=:KdvID");
$kdvSor->execute(array(
  	'KdvID' => $_GET['KdvID']
  	));
$kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC);


// Form Gönderildiğinde

if(isset($_POST['kdvDuzenleSubmit']))
{

	$duzenle=$db->prepare("UPDATE urun_kdv SET
	KdvTip=:KdvTip,
	Kdv=:Kdv
	WHERE KdvID={$_POST['KdvID']}");
	$update=$duzenle->execute(array(
	'KdvTip' => $_POST['KdvTip'],
	'Kdv' => $_POST['Kdv']
	));
	$kdvID=$_POST['KdvID'];
        
        
        if($duzenle)
        {
            header("Location:index.php");
        }

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
     <title>KDV > Düzenle</title>
    
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
   
    <form action="" method="post">
        
        <fieldset>
            
            <legend>KDV Bilgileri</legend>
            <input type="hidden" name="KdvID" value="<?php echo $kdvCek['KdvID']; ?>" />
            <label for="KdvTip">KDV Tipi</label>
            <input type="text" name="KdvTip" id="KdvTip" value="<?= $kdvCek['KdvTip'] ?>" />
            <label for="Kdv">KDV</label>
            <input type="text" name="Kdv" id="Kdv" value="<?= $kdvCek['Kdv'] ?>" /><br>
            <input type="submit" name="kdvDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
        
    </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
