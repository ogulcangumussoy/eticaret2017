<?php
//mysql sunucu bağlantısı 
require_once '../../_inc/connection.php';

//Seviye kayıt setinin oluşturulması

$uyeSeviyeSor=$db->prepare("SELECT * FROM uye_seviye");
$uyeSeviyeSor->execute();
$uyeSeviyeCek=$uyeSeviyeSor->fetch(PDO::FETCH_ASSOC);

        
//form gönderildiğinde
if(isset($_POST['uyeEkleSubmit']))
{
    //form verilerinin alınması
   
    $seviyeID=$_POST['SeviyeID'];
    $kullaniciAdi=$_POST['KullaniciAdi'];
    $eposta=$_POST['Eposta'];
    $parola=$_POST['Parola'];
    $parolaTekrar=$_POST['ParolaTekrar'];
    
    if (isset($_POST['Aktif']))
        $aktif=1;
    else
        $aktif=0;
    
    $kayitIp=$_SERVER['REMOTE_ADDR']; //İp adresini alıyoruz.
    
    //formda boş alan kontrolü
    
    if (!empty($kullaniciAdi) && !empty($eposta) && !empty($parola))
    {
        //parola farklı ise
        if ($parola != $parolaTekrar)
        {
            header("Location:ekle.php?Hata=ParolaTekrar&KullaniciAdi=$kullaniciAdi&Eposta=$eposta");
            
        } else {
            
            $parola= md5($parola);
            
        
            //üye ekleme işlemi devam ettir.
            
            $kaydet=$db->prepare("INSERT INTO uye_giris SET
                SeviyeID=:seviyeID,
                KullaniciAdi=:kullaniciAdi,
                Eposta=:eposta,
                Parola=:parola,
                Aktif=:aktif,
                KayitIP=:kayitIP
                ");
            $insert=$kaydet->execute(array(
                'seviyeID'=> $seviyeID,
                'kullaniciAdi'=>$kullaniciAdi,
                'eposta'=>$eposta,
                'parola'=>$parola,
                'aktif'=>$aktif,
                'kayitIP'=>$kayitIp
            ));
            
            if($insert)
            {
                header("Location:index.php?durum=ok");
            } else {
                header("Location:index.php?durum=no");
            }
            
        }
        
    }else{
        header("Location:ekle.php?Hata=AlanBos");
    }
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
    
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
                                <td><img width="30px" src="../_img/layout/_duzenle.png" /> <a href="../urun_gosterim_turu/index.php">Düzenle</a></td>
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
        <h1>Üye Ekle</h1>
        
        <?php  if (isset($_GET['Hata']) && $_GET['Hata']=='AlanBos') : ?>
        
        <div class="formHataAlanBos">
            <p>Lütfen Tüm Alanları Doldurunuz</p>
        </div>
        
        <?php   elseif(isset($_GET['Hata']) && $_GET['Hata']=='ParolaTekrar'): ?>
        
        <div class="formHataAlanBos">
            <p>Lütfen Parola Alanlarının Aynı Olmasına Dikkat Ediniz</p>
        </div>
        
        <?php endif; ?>
        
        <form action="" method="post">
            <fieldset>
                <legend>Seviye Bilgileri</legend>
                
                <label for="SeviyeID">Üyenin Seviyesi</label>
                <select name="SeviyeID" id="SeviyeID" />
                
                <?php do{ ?>
                <option value="<?= $uyeSeviyeCek['SeviyeID'] ?>" <?php if ($uyeSeviyeCek['SeviyeID']==5) echo " selected=selected "; ?>><?= $uyeSeviyeCek['Seviye'] ?></option>
                <?php }while ($uyeSeviyeCek=$uyeSeviyeSor->fetch(PDO::FETCH_ASSOC))?>
            </select>
            </fieldset>
            
            <fieldset>
                <legend>Giriş Bilgileri</legend>
                <label for="KullaniciAdi">Kullanıcı Adı</label>
                <input type="text" name="KullaniciAdi" id="KullaniciAdi" 
                    <?php if (isset($_GET['KullaniciAdi']))
                    {
                        echo "value=". $_GET['KullaniciAdi']; 
                    }
                    ?> 
                       />
                
                <label for="Eposta">E-Posta</label>
                <input type="text" name="Eposta" id="Eposta" 
                       <?php if (isset($_GET['Eposta']))
                    {
                        echo "value=". $_GET['Eposta']; 
                    }
                       ?>
                       
                       
                       />
                
                <label for="Aktif">Aktif</label>
                <input type="checkbox" name="Aktif" id="Aktif" />
            </fieldset>
            
            <fieldset>
                        <legend>Parola</legend>
                        <label for="Parola">Parola</label>
                        <input type="password" name="Parola" id="Parola" />
                        <label for="ParolaTekrar">Parola Tekrarı</label>
                        <input type="password" name="ParolaTekrar" id="ParolaTekrar" />
            </fieldset>
            
            <input type="submit" name="uyeEkleSubmit" value="Üye Ekle" />
        </form>
        
    </section>

    <footer>
        <p>RCPanel Eticaret Yönetim Paneli 2017 © </p>
    </footer>
</body>
</html>
