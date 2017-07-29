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
        <meta charset="UTF-8">
     <title>Kdv > Ekle</title>
    
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
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
