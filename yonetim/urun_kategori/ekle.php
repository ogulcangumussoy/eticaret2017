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
    
    <link href="../css/tema/rcpanel/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
    <script src="../js/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
    
    <!--Jquery Tab Başlangıcı -->
    
    <script type="text/javascript">
			$(function(){
				// Tabs
				$('#tabs').tabs();
			});
		</script>
<!--Jquery Tab Sonu -->
    
    
</head>
<body>
    
    <header>
        <h1>RCPanel</h1>
        
        <div id="kullaniciLogin">
            <img width="30px" src="../_img/layout/_kullanici.png" /> Kullanıcı Adı
            <img width="30px" src="../_img/layout/logout.png" /> Çıkış
        </div>
        
    </header>
    
    <nav>
      
        <!-- Tabs -->
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Ürün Temel</a></li>
				<li><a href="#tabs-2">Ürün Detay</a></li>
				<li><a href="#tabs-3">Üyelik</a></li>
			</ul>
                    <div id="tabs-1">
                        
                        <table>
                            <tr>
                                <td><h3>Ürün</h3></td>
                                <td></td>
                                <td></td>
                                <td id="mesafe"><h3>Gösterim Türü</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /><a href="../urun/index.php">Düzenle</a></td>
                                <td>&nbsp;</td>
                                <td id="mesafe"><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_gosterim_turu/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_gosterim_turu//index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><h3>Ürün Kategori</h3></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td ><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_kategori/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /><a href="../urun_kategori/index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><h3>Ürün KDV</h3></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td><img width="30px" src="../_img/layout/_ekle.png" /><a href="../urun_kdv/ekle.php">Ekle</a></td>
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_kdv/index.php">Düzenle</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            
                        </table>

                    </div>
			
		</div>


        
    </nav>
    
    <section>
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
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
