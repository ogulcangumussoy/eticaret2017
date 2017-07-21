<?php

    // Mysql Sunucu Bağlantısı burada yapıldı.

try {
    
    //Türkçe karakter sorunun çözümü için içeriye charset eklemesi yapmak gerekiyor.
	$db=new PDO("mysql:host=localhost;dbname=eticaret2017;charset=utf8",'root','');
	//echo "Veritabanı bağlantısı başarılı";
} 
catch (PDOException $e){
	echo $e->getMessage();
}




?>