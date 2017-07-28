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
WHERE UrunArsiv !=1
");
$urunSor->execute();
$urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);
$urunSayisi=$urunSor->rowCount();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürünler</title>
    <style>
        
        
        table td{
            font-family: verdana;
            font-size: 10px;
            padding:5px;
            background-color: #c7e0e3;
            text-align: center;
        }
        table th{
            font-size: 14px;
            font-family: verdana;
            background-color: #f00;
            color:#fff;
            padding: 5px;
        }
        
        table img .UrunResim{
            border: 1px solid #666;
            border-radius: 3px;
            padding:3px;
            background-color: #ccc;
        }
        
        
        
        table td a:link,table td a:visited
        {
            background-color:#ccc;
            color:#f00;
            padding:5px;
            margin:0 5px;
            text-decoration: none; 
            
        }
        table td a:hover
        {
             color:#fff;
             background-color: #f00;
        }
    </style>
</head>
<body>
    
    <h1>Ürünler</h1>
    <?php
    echo "<p>Kayıtlı ürün sayısı $urunSayisi</p>";
    ?>
    <p><a href="ekle.php">Ürün Ekle</a> | <a href="arsiv.php">Arşivi Göster</a></p>
   
    <table>
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
        
            <td><img class="UrunResim" height="75" src="../../<?= $urunCek['UrunResim'] ?>" /></td>
            <td  style="width: 300px; "><?= $urunCek['UrunAdi'] ?></td>
            <td><?= $urunCek['Kategori'] ?></td> 
            <td><?= $urunCek['UrunFiyat']  ?></td>
            <td><?= $urunCek['Kdv'] ?></td>
            <td>
                <?php
                
                if($urunCek['UrunAktif']==1) : ?>
                
            <img  src="../_img/aktif-icon.png" height="25" />
                
                <?php else: ?>
             <img  src="../_img/pasif-icon.png" height="25" />
                <?php endif; ?>
                
            </td>
            <td style="width: 125px; "><?= date("d/m/Y H:i", strtotime($urunCek['UrunTarih'])) ?></td>
            <td>
                
                <a href="duzenle.php?UrunID=<?=$urunCek['UrunID'] ?>">Düzenle</a>
                <hr>
                <a href="arsivle.php?UrunID=<?= $urunCek['UrunID'] ?>">Arşivle</a>
            
            </td>
            
        </tr>
        <?php } while ($urunCek=$urunSor->fetch(PDO::FETCH_ASSOC))?>
    </table>
    <p><a href="ekle.php">Ürün Ekle</a></p>
</body>
</html>
