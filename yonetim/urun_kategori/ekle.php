<?php
//mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

//Eğer Kategori ID gelirse ParentID değeri alır, yoksa ParentID=0 olur

if(isset($_GET['KategoriID']))
{
    $parentID = $_GET['KategoriID'];
   
    
    $kategoriSor=$db->prepare("SELECT * FROM urun_kategori WHERE KategoriID=:parentID");
    $kategoriSor->execute(array(
  	'parentID' => $_GET['KategoriID']
  	));
     $kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);
    
}else{
    $parentID=0;
    
}

//form gönderildi ise

if(isset($_POST['KategoriResimEkle']))
{
    
    //Formdan genel değerlerin alınması
    if(!empty($_POST['Kategori'])){
        
        
  
       $uploads_dir = '../../_uploads/resim/urun-kategori'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['KategoriResim']['tmp_name'];
	@$name = $_FILES['KategoriResim']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

   
	$kaydet=$db->prepare("INSERT INTO urun_kategori SET
	Kategori=:Kategori,
        ParentID=:ParentID,
	KategoriResim=:KategoriResim");
	$insert=$kaydet->execute(array(
	'Kategori' => $_POST['Kategori'],
	'ParentID' => $parentID,
	'KategoriResim' => $benzersizad.$name
        ));

     	if($insert)	{
	

		Header("Location:index.php?KategoriID=$KategoriID&durum=ok");
	}else{

		Header("Location:index.php?durum=no");
	}
	



        
    } else {
        echo '<br> Kategori ismi boş olamaz.';    
    }
    //yönlendirme yapıldı
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Kategori Ekle</title>
    
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
    
    <h1>Kategori Ekle</h1>
    <?php
    if($parentID!=0){
    echo 'Kategorinin Parenti : '.$kategoriCek['Kategori'];}
    else
       echo "Kategori Ana kategoridir.";
    ?>
    
    <form method="post" action="" enctype="multipart/form-data">
        <fieldset>  
            <legend>Kategori Bilgileri</legend>
            <label for="Kategori">Kategori Adı</label>
            <input type="hidden" name="parentGizli" id="parentGizli" value="<?= $kategoriCek['KategoriID']?>" />
            <input type="text" name="Kategori" id="Kategori" />
            
            <label for="KategoriResim">Kategori Resmi</label>
            <input type="file" name="KategoriResim" id="KategoriResim" />
            <br><hr>
            <input type="submit" name="KategoriResimEkle" value="Kategori Ekle"  />
        </fieldset>
    </form>
</body>
</html>
