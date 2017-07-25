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
    <title></title>
</head>
<body>
    
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
</body>
</html>
