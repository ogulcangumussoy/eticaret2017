<?php
//Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

$gosterimTuruSor=$db->prepare("SELECT * FROM urun_gosterim_turu");
$gosterimTuruSor->execute();
$gosterimTuruCek=$gosterimTuruSor->fetch(PDO::FETCH_ASSOC);
$gosterimTuruSayisi=$gosterimTuruSor->rowCount();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Gösterim Türleri</title>
    <style>
        
        label {
            display: block;
            font-size: 1em;
            font-family: verdana;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    
    <h1>Ürün Gösterim Türleri</h1>
    <p><a href="ekle.php">Ürün Gösterim Türü Ekle</a></p>
    <?php
    echo "Gösterim Türü Sayısı : $gosterimTuruSayisi";
    ?>
    
    <table>
        <tr>
            <th>Gösterim Türü</th>
            <th>Düzenle</th>
        </tr>
        
        <?php do {?>
        <tr>
            <td><?=$gosterimTuruCek['GosterimTuru']?></td>
            <td>
                
                <a href="duzenle.php?GosterimTuruID=<?=$gosterimTuruCek['GosterimTuruID']?>">Düzenle</a>
                <a href="sil.php?GosterimTuruID=<?=$gosterimTuruCek['GosterimTuruID'] ?>">Sil</a>
                
            </td>
        </tr>
        <?php } while ($gosterimTuruCek=$gosterimTuruSor->fetch(PDO::FETCH_ASSOC)) ?>
    </table>
</body>
</html>
