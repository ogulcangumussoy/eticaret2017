<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//1.Kayıt Seti: KDV

$kdvSor= $db->prepare("SELECT * FROM urun_kdv");
$kdvSor->execute();
$kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC);

//2.Kayıt Seti : kategori

$kategoriSor=$db->prepare("SELECT * FROM urun_kategori");
$kategoriSor->execute();
$kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);

//urunID değerinin alınması

$urunID=$_GET['UrunID'];

//echo "Gelen Urun ID : $urunID";

//3.Kayıt Seti : Ürünün Kendisi
$urunSor=$db->prepare("SELECT * FROM urun WHERE UrunID =:urunID");
$urunSor->execute(array(
    'urunID'=>$_GET['UrunID']
));
$urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);

/*
echo '<pre>';
print_r($urunCek);
*/

//Form Gönderildiğinde

if(isset($_POST['urunDuzenleSubmit']))
{
    /*
    echo 'Form Gönderildi';
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
     
     */
    
    //Formdan gelen veriler alındı
    $kdvID=$_POST['KdvID'];
    $kategoriID=$_POST['KategoriID'];
    
    $urunAdi=$_POST['UrunAdi'];
    $urunFiyat=$_POST['UrunFiyat'];
    
    if(isset($_POST['UrunAktif']))
    {
        $urunAktif=1;
    } else {
        $urunAktif=0;
    }
    echo "Ürün aktif değeri $urunAktif";
    
    $urunResim = $_FILES['UrunResim']['name'];
    
    if (empty($urunResim)){
        $urunResim=$urunCek['UrunResim'];
    }
    
    //boş alan kabul edilmeyecek.
    //boş değilse devam edecek.
    
  
    if(!empty($urunAdi) && !empty($urunFiyat)) {

	$uploads_dir = '../../_uploads/resim/urun'; // karşı taraftan gelen resmin nereye kaydedileceğini belirtir.
	@$tmp_name = $_FILES['UrunResim']['tmp_name'];
	@$name = $_FILES['UrunResim']["name"];
	$benzersizsayi=rand(20000,32000);
	$benzersizad=$benzersizsayi;
	$refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$duzenle=$db->prepare("UPDATE urun SET
	KategoriID=:kategoriID,
	KdvID=:kdvID,
	UrunAdi=:urunAdi,
	UrunFiyat=:urunFiyat,
        UrunAktif=:urunAktif,
	UrunResim=:urunResim
	WHERE UrunID={$_POST['UrunID']}");
	$update=$duzenle->execute(array(
	'kategoriID' => $_POST['KategoriID'],
	'kdvID' => $_POST['KdvID'],
	'urunAdi' => $_POST['UrunAdi'],
	'urunFiyat' => $_POST['UrunFiyat'],
        'urunAktif' => $_POST['UrunAktif'],
	'urunResim' => $refimgyol
	
	));
	$UrunID=$_POST['UrunID'];

	if($update)	{
		$resimsilunlink=$_POST['UrunResim'];
		unlink("../../$resimsilunlink");

		Header("Location:duzenle.php?UrunID=$UrunID&durum=ok");
	}else{

		Header("Location:duzenle.php?durum=no");
	}




}else{
	header("Location:duzenle.php?UrunID=$urunID&Hata=AlanBos");

}
}


//Veritabanındaki veriler güncellenecek

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>Ürün > Düzenle</title>
</head>

<style>
    label {
            display: block;
            font-size: 1em;
            font-family: verdana;
            font-weight: bold;
            margin: 10px 0;
        }
        
     #urunResim2{
            border: 1px solid #666;
            border-radius: 3px;
            padding:3px;
            background-color: #ccc;
            width: 150px;
            height: 150px;
        }
</style>
<body>
    <h1>Ürün Düzenle</h1>
    <?php
 
    if (isset($_GET['Hata']))
    {
        echo '<p>Ürün Adı veya Ürün Fiyatı boş bırakılamaz.</p>';
    }
    ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="UrunID" value="<?= $urunCek['UrunID'] ?>" />
        <input type="hidden" name="UrunAktif" value="<?= $urunCek['UrunAktif'] ?>" />
        <input type="hidden" name="UrunResim" value="<?= $urunCek['UrunResim'] ?>" />
        
        
        <fieldset>
            <legend>Kategori ve KDV Bilgileri</legend>
            <label for="KategoriID">Kategori</label>
            <select name="KategoriID" id="KategoriID">
    
                <?php do{ ?>
                <option value="<?= $kategoriCek['KategoriID']?>"<?php if($kategoriCek['KategoriID']== $urunCek['KategoriID']):?> selected="selected"<?php endif; ?>><?= $kategoriCek['Kategori'] ?></option>
                <?php }while ($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) ?>
            
            </select> 
            <label for="KdvID">KDV Değeri</label>
            <select name="KdvID" id="KdvID">
              <?php do{ ?>
                <option value="<?= $kdvCek['KdvID']?>" <?php if ($kdvCek['KdvID']== $urunCek['KdvID']) :?> selected="selected"<?php endif;?>><?= $kdvCek['KdvTip'] ?></option>
                <?php }while ($kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC)) ?>
           
            </select>
        </fieldset>
        
      
        <fieldset>
            <legend>Ürün Temel Bilgileri</legend>
            <label for="UrunAdi">Ürün Adı</label>
            <input type="text" name="UrunAdi" id="UrunAdi" value="<?= $urunCek['UrunAdi']?> " size="50" />
            <label for="UrunFiyat">Ürün Fiyat</label>
            <input type="text" name="UrunFiyat" id="UrunFiyat" value="<?= $urunCek['UrunFiyat']?>" />
            <p>
            <img id="urunResim2" src="../../<?= $urunCek['UrunResim'] ?>" />
            </p>
            <label for="UrunResim">Yeni Resim</label>
            <input type="file" name="UrunResim" id="UrunResim"/><br><br>
            <label for="UrunAktif">Ürün Aktif mi?</label>
            <input type="checkbox" name="UrunAktif" value="<?= $urunCek['UrunAktif']?>" <?php if($urunCek['UrunAktif']==1)echo 'checked="checked"';?>/>
            <hr>
            <input type="submit" name="urunDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
    </form>
</body>
</html>
