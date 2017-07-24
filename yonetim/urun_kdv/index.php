<?php 
//mysql sunucu bağlantısı ve veri tabanı seçimi

require_once '../../_inc/connection.php';

//KDV Kayıt Seti
$kdvSor=$db->prepare('SELECT * FROM urun_kdv');
$kdvSor->execute();
$kdvCount=$kdvSor->rowCount();


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > KDV Tipleri</title>
</head>
<body>
   
    
    <h1>KDV Tipleri</h1>
    
    <p><a href="ekle.php">KDV Ekle</a></p>
    <?php
    echo "KDV Tipi Sayısı : $kdvCount";
    ?>
    
    <table>
        <tr>
            <th>KDV Tipi</th>
            <th>KDV Oranı</th>
            <th>Düzenle</th>
        </tr>
        
        <?php while($kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC)){ ?>
        <tr>
             <td><?= $kdvCek['KdvTip'] ?> Oran</td>
             <td><?= $kdvCek['Kdv'] ?></td>
             <td>
                 
                 <a href="duzenle.php?KdvID=<?=$kdvCek['KdvID'] ?>">Düzenle</a> 
                 
                 |
                 
                 <a href="sil.php?kdvsil=ok&KdvID=<?php echo $kdvCek['KdvID']; ?>">Sil</a>
             
             </td>
            
        </tr>
        
        <?php } ?>
       
    </table>
</body>
</html>
