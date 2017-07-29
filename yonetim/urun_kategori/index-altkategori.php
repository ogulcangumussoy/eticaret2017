<?php
require_once '../../_inc/connection.php';


//parentID değerinin alınması



$kategoriSor=$db->prepare("SELECT * FROM urun_kategori WHERE ParentID=:parentIDDegeri");
 $kategoriSor->execute(array(
    'parentIDDegeri' => $_GET['ParentID']));
$kategoriCount=$kategoriSor->rowCount();
$kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);


//parent bul Fonksiyonu

function parent_bul($db,$parentID)
{
    //Kategori tablosundan veri almak
    
    $parentSor=$db->prepare("SELECT Kategori FROM urun_kategori WHERE KategoriID= $parentID");
    $parentSor->execute();
    $parentCek=$parentSor->fetch(PDO::FETCH_ASSOC);
    
    return $parentCek['Kategori'];
}

function altkategori_bul($db,$parentID)
{
    $parentSor=$db->prepare("SELECT Kategori FROM urun_kategori WHERE ParentID= $parentID");
    $parentSor->execute();
    $parentCek=$parentSor->fetch(PDO::FETCH_ASSOC);
    $num_row_parenSor=$parentSor->rowCount();
    return $num_row_parenSor;
}




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Alt Kategoriler</title>
    
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
     <h1>Kategoriler</h1>
    <a href="ekle.php">Kategori Ekle</a><hr>
    <?php
    $parentAdi= parent_bul($db, $kategoriCek['ParentID']);
    echo "Bulunduğunuz Kategori : ".$parentAdi;
    echo "<p>Toplam Kategori Sayısı : <strong>$kategoriCount </strong></p>";
    ?>
    
    <table>
        <tr>
            <th>Kategori Resim</th>
            <th>Kategori Adı</th>
            <th>Alt Kategori Sayısı</th>
            <th>Alt Kategori</th>
            
            <th>Düzenle</th>
        </tr>
        
        <?php do{?>
        <tr>
            <td><img width="50" height="30" src="../../_uploads/resim/urun-kategori/<?= $kategoriCek['KategoriResim']?>"></img></td>
            <td>
                <?php
                $altKategoriSayisi= altkategori_bul($db,$kategoriCek['KategoriID']);
                
                if($altKategoriSayisi!=0): ?>
                <a href="index-altkategori.php?ParentID=<?= $kategoriCek['KategoriID'] ?>"><?= $kategoriCek['Kategori'] ?></a>
                <?php else:?>
                <?= $kategoriCek['Kategori']; ?>
                <?php endif;?>
                
            </td>
            <td><?= $altKategoriSayisi ;?></td>
            <td><a href="ekle.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>"><img width="25" src="../_img/ekle-icon.png" /></a></td>
            <td>
                
                <a href="duzenle.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>">Düzenle</a> 
                
                |
                
                <a href="sil.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>">Sil</a></td>
        </tr>
        <?php } while($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC))?>
    </table>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
