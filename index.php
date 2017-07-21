<?php
require_once '_inc/connection.php';

// Kayıt Setleri Oluşturulacak.
//Kdv Bilgilerini bulacağımız kayıt seti

$urunSor=$db->prepare("select * from urun ORDER BY UrunID DESC LIMIT 5");
$urunSor->execute();


//Kategori bilgiler için kayıt seti
$kategoriSor=$db->prepare("select * from urun_kategori");
$kategoriSor->execute();



?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Teknoyel E-Ticaret Sitesi</title>
    <link rel="stylesheet" type="text/css" href="_css/style.css"/>
</head>
<body>
    
    <header class="w1000 h100 center bradius3">
        <h1>Header İçeriği</h1>
    </header>
    <nav class="w1000 h40 center mTop20 bradius3">
        Menü Öğeleri
    </nav>
<div id='wrapper' class='w1000 center mTop20'>
        
    <aside id="kategori" class='w200 fleft mH500'>
         
        <a href="tum-kategoriler.php"><img src="_img/layout/tum-kategoriler.png"></img></a>
            
            <ul>
              <?php while ($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) {
              
                  ?>
                <a id="aKategori" href="<?= $kategoriCek['Kategori'] ?>"><li id="liKategori"><?= $kategoriCek['Kategori'] ?></li></a>
            </ul>
              <?php }?>
    </aside>
    <section class='w800 mH500 fleft'>
  
        <div id='content' class='mH500 fleft w600'>
            <?php while($urunCek=$urunSor->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="urunBox">
        
            <img width="100px" src="<?= $urunCek['UrunResim'] ?>" />
            <br>
                <?= $urunCek['UrunAdi'] ?><br>
                <?= $urunCek['UrunFiyat'] ?> + KDV
             
            </div>
            <?php }?>
        </div>
        
        <aside id="gundem" class="w200 mH500 fleft bradius3">
            Gündem Alanı
        </aside>
        
    </section>
</div>

<footer class="w1000 center h100 mTop20">
    Footer Alanı
</footer>
</body>
</html>
