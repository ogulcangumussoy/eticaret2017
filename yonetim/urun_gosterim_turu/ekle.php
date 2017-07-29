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
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
