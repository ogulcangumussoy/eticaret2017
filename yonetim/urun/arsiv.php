<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//Ürün kayıt setinin oluşturulması

$urunSor=$db->prepare("
SELECT
urun.UrunResim,
urun.UrunAdi,
urun_kategori.Kategori,
urun.UrunFiyat,
urun_kdv.Kdv,
urun.UrunAktif,
urun.UrunTarih,
urun_kdv.KdvID,
urun.UrunID,
urun.KategoriID
FROM
urun
INNER JOIN urun_kdv ON urun.KdvID = urun_kdv.KdvID
INNER JOIN urun_kategori ON urun.KategoriID = urun_kategori.KategoriID
WHERE UrunArsiv =1
");
$urunSor->execute();
$urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);
$urunSayisi=$urunSor->rowCount();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürünler > Arşiv</title>
    
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
       <h1>Ürünler</h1>
    <?php
    echo "<p>Kayıtlı ürün sayısı $urunSayisi</p>";
    ?>
    <p><a href="ekle.php">Ürün Ekle</a> | <a href="index.php">Ürünleri Göster</a></p>
   
    <table id="urunListe">
        <tr>
        <th>Ürün Resim</th>
        <th>Ürün Adı</th>
        <th>Kategori</th>
        <th>Ürün Fiyat</th>
        <th>Kdv</th>
        <th>Aktif</th>
        <th>Tarih</th>
        <th>Düzenle</th>
        </tr>
        
        <?php do{ ?>
        <tr>
        
            <td width="80"><img class="UrunResim" width="75" height="65" src="../../<?= $urunCek['UrunResim'] ?>" /></td>
            <td width="200"><?= $urunCek['UrunAdi'] ?></td>
            <td width="150"><?= $urunCek['Kategori'] ?></td> 
            <td width="80"><?= $urunCek['UrunFiyat']  ?></td>
            <td><?= $urunCek['Kdv'] ?></td>
            <td>
                <?php
                
                if($urunCek['UrunAktif']==1) : ?>
                
            <img  src="../_img/aktif-icon.png" height="25" />
                
                <?php else: ?>
             <img  src="../_img/pasif-icon.png" height="25" />
                <?php endif; ?>
                
            </td>
            <td width="100"><?= date("d/m/Y H:i", strtotime($urunCek['UrunTarih'])) ?></td>
            <td>
                
                <a href="duzenle.php?UrunID=<?=$urunCek['UrunID'] ?>">Düzenle</a>
                <hr><br>
                <a href="arsivden-cikar.php?UrunID=<?= $urunCek['UrunID'] ?>">Arşivden Çıkar</a>
            
            </td>
            
        </tr>
        <?php } while ($urunCek=$urunSor->fetch(PDO::FETCH_ASSOC))?>
    </table>
    <p><a href="ekle.php">Ürün Ekle</a></p>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
