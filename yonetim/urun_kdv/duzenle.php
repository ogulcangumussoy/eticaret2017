<?php
// Mysql sunucu bağlantısı ve veritabanı seçimi
require_once '../../_inc/connection.php';

// KdvID değerinin alınması


//KDV Kayıt Seti

$kdvSor=$db->prepare("SELECT * FROM urun_kdv where KdvID=:KdvID");
$kdvSor->execute(array(
  	'KdvID' => $_GET['KdvID']
  	));
$kdvCek=$kdvSor->fetch(PDO::FETCH_ASSOC);


// Form Gönderildiğinde

if(isset($_POST['kdvDuzenleSubmit']))
{

	$duzenle=$db->prepare("UPDATE urun_kdv SET
	KdvTip=:KdvTip,
	Kdv=:Kdv
	WHERE KdvID={$_POST['KdvID']}");
	$update=$duzenle->execute(array(
	'KdvTip' => $_POST['KdvTip'],
	'Kdv' => $_POST['Kdv']
	));
	$kdvID=$_POST['KdvID'];
        
        
        if($duzenle)
        {
            header("Location:index.php");
        }

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <title>KDV > Düzenle</title>
    
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
   
    <form action="" method="post">
        
        <fieldset>
            
            <legend>KDV Bilgileri</legend>
            <input type="hidden" name="KdvID" value="<?php echo $kdvCek['KdvID']; ?>" />
            <label for="KdvTip">KDV Tipi</label>
            <input type="text" name="KdvTip" id="KdvTip" value="<?= $kdvCek['KdvTip'] ?>" />
            <label for="Kdv">KDV</label>
            <input type="text" name="Kdv" id="Kdv" value="<?= $kdvCek['Kdv'] ?>" /><br>
            <input type="submit" name="kdvDuzenleSubmit" value="Değişiklikleri Kaydet" />
        </fieldset>
        
    </form>
    
    
    

    
    
</body>
</html>
