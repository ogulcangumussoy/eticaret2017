<?php
require_once '../../_inc/connection.php';


$kategoriID= $_GET['KategoriID'];
//Düzenlenecek Olan Kategori Seti
$kategoriSor=$db->prepare("SELECT * FROM urun_kategori WHERE KategoriID=:kategoriID");
$kategoriSor->execute(
        array( 'kategoriID' => $_GET['KategoriID']));
$kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);

        
//Parent Kayıt Seti

$parentSor=$db->prepare("SELECT * FROM urun_kategori");
$parentSor->execute();
$parentCek=$parentSor->fetch(PDO::FETCH_ASSOC);

//Form Gönderildiyse

if(isset($_POST['kategoriDuzenleSubmit']))
{
    //echo 'Form Gönderildi';
    $kategori=$_POST['Kategori'];
    $parentID=$_POST['ParentID'];
    $kategoriResim=$_FILES['KategoriResim']['name'];
    
if($_FILES['KategoriResim']["size"] > 0) {

	$uploads_dir = '../../_uploads/resim/urun-kategori'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['KategoriResim']['tmp_name'];
	@$name = $_FILES['KategoriResim']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$duzenle=$db->prepare("UPDATE urun_kategori SET
	Kategori=:kategori,
	ParentID=:parentID,
	KategoriResim=:kategoriResim
	WHERE KategoriID={$_POST['KategoriID']}");
        
	$update=$duzenle->execute(array(
	'kategori' => $_POST['Kategori'],
	'parentID' => $_POST['ParentID'],
	'kategoriResim' => $refimgyol
	
	));
	$KategoriID=$_POST['KategoriID'];
        if($update)
        {
            $resimsilunlink=$_POST['eski_yol'];
	    unlink("../../_uploads/resim/urun-kategori/$resimsilunlink");
            header("Location:index.php?KategoriID=$kategoriID&Durum=ok");
        }
        else {
            header("Location:index.php?KategoriID=$kategoriID&Durum=no");
        }
	




} else {
   $duzenle=$db->prepare("UPDATE urun_kategori SET
	Kategori=:kategori,
	ParentID=:parentID
	WHERE KategoriID={$_POST['KategoriID']}");
        
	$update=$duzenle->execute(array(
	'kategori' => $_POST['Kategori'],
	'parentID' => $_POST['ParentID']
	));
	$KategoriID=$_POST['KategoriID'];
        if($update)
        {
            $resimsilunlink=$_POST['eski_yol'];
	    unlink("../../$resimsilunlink");
            header("Location:index.php?KategoriID=$kategoriID&Durum=ok");
        }
        else {
            header("Location:index.php?KategoriID=$kategoriID&Durum=no");
        }
    
}
 

}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Kategori > Düzenle</title>
</head>

 <style>
        
        label {
            display: block;
            font-size: 1em;
            font-family: verdana;
            font-weight: bold;
            margin: 10px 0;
        }
        
       
           
      
    </style>
<body>
    <?php
    if(isset($_GET['Hata']))
    {
        echo '<p>Lütfen Kategori Adını Boş Bırakmayınız</p>';
    }
    ?>
    <h1>Kategori Düzenle</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="KategoriID" value="<?= $kategoriID ?>"  />
        <input type="hidden" name="eski_yol" value="<?= $kategoriCek['KategoriResim'] ?>"  />
     
       
        <fieldset>
            <legend>Kategori Bilgileri</legend>
             <label for="ParentID">Parent Kategorisi</label>
             <select name="ParentID" id="ParentID">
                 
                 <?php do {?>
                 
                 <?php if ($kategoriCek['ParentID']==0) {?>
                 
                 <option value="0" selected="selected">Parent Kategorisi Yok</option>
                 
                 <?php } else {?>
                        <option value="<?= $parentCek['KategoriID']?>"<?php if($parentCek['KategoriID']== $kategoriCek['ParentID']) echo 'selected="selected";' ?>><?= $parentCek['Kategori'] ?></option>  
                 <?php } ?>        
                 
                 <?php } while ($parentCek=$parentSor->fetch(PDO::FETCH_ASSOC)) ?>
             </select>
            <label for="Kategori">Kategori</label>
            <input type="text" name="Kategori" id="Kategori" value="<?= $kategoriCek['Kategori']?>" />
            <br>
            <b><p>Şu anki Resim</p><b>
             <img src="../../_uploads/resim/urun-kategori/<?= $kategoriCek['KategoriResim']?>" width="75px" />
             <label for="KategoriResim">Kategori Resim</label>
             <input type="file" name="KategoriResim" id="KategoriResim" /><br>
            <input type="submit" name="kategoriDuzenleSubmit" value="Değişiklikleri Kaydet" />
           
        </fieldset>
    </form>
</body>
</html>
