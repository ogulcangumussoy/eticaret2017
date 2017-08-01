<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//üyeler kayıt setinin yapılması

$uyeSor=$db->prepare("
SELECT
uye_seviye.SeviyeIcon,
uye_seviye.Seviye,
uye_giris.KullaniciAdi,
uye_giris.Eposta,
uye_giris.UyeID,
uye_giris.KayitIP,
uye_giris.Aktif,
uye_giris.KayitTarih
FROM
uye_giris
INNER JOIN uye_seviye ON uye_giris.SeviyeID = uye_seviye.SeviyeID
ORDER BY
uye_giris.UyeID DESC
     
");

$uyeSor->execute();
$uyeCek=$uyeSor->fetch(PDO::FETCH_ASSOC);
$say=$uyeSor->rowCount();



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
    
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
 <?php  if (isset($_GET['durum']) && $_GET['durum']=='ok') : ?>
        
        <div class="formHataAlanBos">
            <p>Ekleme İşlemi Gerçekleşti.</p>
        </div>
        
 <?php elseif(isset($_GET['durum']) && $_GET['durum']=='no'): ?>
         <div class="formHataAlanBos">
            <p>Ekleme İşlemi Başarısız.</p>
        </div>
        
<?php endif;?>
        
        <h1>Üyeler</h1>
        <p>Toplam Üye Sayısı <?= $say; ?></p>
        <a href="musteriler.php">Müşterileri Göster</a>
        
        <table id="urunListe">
            <tr>
               
                <th>Seviye</th>
                <th>Kullanıcı Adı</th>
                <th>E-Posta</th>
                <th>Kayıt IP</th>
                <th>Aktiflik</th>
                <th>Kayıt Tarih</th>
                <th>Düzenle</th>
            </tr>
            
            <?php do{ ?>
            <tr>
               
                <td><img width="40" src="../../_uploads/resim/uye/seviye/<?= $uyeCek['SeviyeIcon'] ?>" /><br><?= $uyeCek['Seviye'] ?></td>
                <td><strong><?= $uyeCek['KullaniciAdi'] ?></strong></td>
                <td><?= $uyeCek['Eposta'] ?></td>
                <td><?= $uyeCek['KayitIP'] ?></td>
                <td>
                    <?php if($uyeCek['Aktif'] == 1):?>
                    <img src="../_img/aktif-icon.png" width="25"/>
                     <?php else:?> 
                    <img src="../_img/pasif-icon.png" width="25"/>
                    <?php endif;?>
                </td>
                <td><?= date("d/m/Y H:i:s", strtotime($uyeCek['KayitTarih']))?></td>
                <td>
                    <a href="duzenle.php?UyeID=<?= $uyeCek['UyeID'] ?>"> Düzenle </a> 
                    
                    |
                    
                    <a href="arsivle.php?UyeID=<?= $uyeCek['UyeID'] ?>">Arşivle</a>
                
                </td>
            </tr>
            <?php }while ($uyeCek=$uyeSor->fetch(PDO::FETCH_ASSOC)) ?>
        </table>
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
