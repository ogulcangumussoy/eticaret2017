<?php
require_once '_inc/connection.php';

// Kayıt Setleri Oluşturulacak.
//Kdv Bilgilerini bulacağımız kayıt seti

/*
$query_Kdv=$db->prepare("select * from urun_kdv");
$query_Kdv->execute();
$rsKdv=$query_Kdv->fetch(PDO::FETCH_ASSOC);
$num_row_rsKdv=$query_Kdv->rowCount();
*/


//Kategori bilgiler için kayıt seti
$urunSor=$db->prepare("select * from urun_kategori");
$urunSor->execute();



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
        
    
    <section class='w800 mH500 fleft'>
  
        <div id='content' class='mH500 fleft w1000'>
           
                    <?php while ($urunCek2=$urunSor->fetch(PDO::FETCH_ASSOC)) {
              
                  ?>
           
            <div class="kategoriBox">
                  <a href="<?= $urunCek2['KategoriID'] ?>">
                <img width="80px" height="70px" id="kategoriResim" src="_uploads/resim/urun-kategori/<?= $urunCek2['KategoriResim'] ?>"></img>
                <center><span id="kategoriSpan"><?= $urunCek2['Kategori']?></span></center>
                  </a>
                
            </div>

            <?php }?>
        </div>

        
    </section>
</div>

<footer class="w1000 center h100 mTop20">
    Footer Alanı
</footer>
</body>
</html>
