<?php
require_once '../../_inc/connection.php';

$kategoriSor=$db->prepare("SELECT * from urun_kategori");
$kategoriSor->execute();
$kategoriCount=$kategoriSor->rowCount();


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
</head>
<body>
    
    <h1>Kategoriler</h1>
    <a href="ekle.php">Kategori Ekle</a>
    <?php
    echo "<p>Toplam Kategori Sayısı : <strong>$kategoriCount </strong></p>";
    ?>
    
    <table>
        <tr>
            <th>Kategori Resim</th>
            <th>Kategori Adı</th>
            <th>Parent</th>
            <th>Alt Kategori</th>
            
            <th>Düzenle</th>
        </tr>
        
        <?php while($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) {?>
        <tr>
            <td><img src="../../_uploads/resim/urun-kategori/<?= $kategoriCek['KategoriResim']?>"></img></td>
            <td><?= $kategoriCek['Kategori'] ?></td>
            <td>
                <?php if ($kategoriCek['ParentID']==0) :?>
                <img width="25" src="../_img/uyari-icon.png" />
                <?php endif;?>
            </td>
            <td><a href="ekle.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>"><img width="25" src="../_img/ekle-icon.png" /></a></td>
            <td>
                
                <a href="duzenle.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>">Düzenle</a> 
                
                |
                
                <a href="sil.php?KategoriID=<?= $kategoriCek['KategoriID'] ?>">Sil</a></td>
        </tr>
        <?php }?>
    </table>
</body>
</html>
