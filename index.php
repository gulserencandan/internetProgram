<?php 
include_once ('ayarlar.php');
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html:charset=UTF-8"/>
    <title>Üyeler</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<a href="index.php?go=giris">Giriş Yap</a> |
<a href="index.php?go=kayit"> Kayıt ol</a>
<?php
if(!isset($_SESSION["oturum"]))
{

$id=$_GET["go"];
switch ($id)
{
	default;
	case 'giris';
	echo '<div id="genel">
		<form action="" method="post">
    	<table cellpadding="3" cellspacing="3">
        	<tr>
            	<td> <label for="kullaniciadi">Kullanıcı adı:</label> </td>
                <td> <input type="text" class="i1" name="kullaniciadi" id="kullaniciadi" />  </td>
            </tr>
        	<tr>
            	<td> <label for="sifre">Şifre:</label> </td>
                <td> <input type="password" class="i1" name="sifre" id="sifre" />  </td>
            </tr>
        		<tr>
            	<td> </td>
                <td> <input type="submit" name="girisyap" value="Giriş Yap" class="s1"  </td>
            </tr>
         </table>
		 </form>';
    	if(@$_POST["girisyap"])
		{
			$kadi=$_POST["kullaniciadi"];
			$sifre=sha1(md5($_POST["sifre"]));
			if(empty ($kadi) or empty ($sifre))
			{ 
			echo '<font style="color:red"> Formda boş alanlar mevcut </form>';
			}
			else
			{
				$query=mysql_query("SELECT * FROM uyeler WHERE kadi='$kadi' and sifre='$sifre'");
				$say=mysql_num_rows($query);
				$cek=mysql_fetch_array($query);
				if($say>0)
				{
					header("Refresh:0;");
					$_SESSION["oturum"]=true;
					$_SESSION["kadi"]=$cek["kadi"];
					$_SESSION ["id"]=$cek["id"];
				}
				else
				{
					echo '<font style="color:red"> Kullanıcı adı ve(ya) şifre hatalı </form>';
		
				}
			}
		}
	echo '</div>';
	break;
	
	case 'kayit';
	echo '<div id="genel">
		<form action="" method="post">
    	<table cellpadding="3" cellspacing="3">
        	<tr>
            	<td> <label for="kullaniciadi">Kullanıcı adı:</label> </td>
                <td> <input type="text" class="i1" name="kullaniciadi" id="kullaniciadi" />  </td>
            </tr>
        	<tr>
            	<td> <label for="sifre">Şifre:</label> </td>
                <td> <input type="password" class="i1" name="sifre" id="sifre" />  </td>
            </tr>
			<tr>
            	<td> <label for="sifre">Şifre Tekrar:</label> </td>
                <td> <input type="password" class="i1" name="sifre2" id="sifre" />  </td>
            </tr>
        		
				<tr>
            	<td> <label for="eposta">E-Posta:</label> </td>
                <td> <input type="text" class="i1" name="eposta" id="eposta" />  </td>
            </tr>
			<tr>
            	<td> </td>
                <td> <input type="submit" name="kayitol" value="Kayıt Ol" class="s1"  </td>
            </tr>
         </table>
		 </form>';
    if($_POST ["kayitol"])
	{
		$kadi=$_POST["kullaniciadi"];
		$sifre=sha1(md5($_POST["sifre"]));
		$sifre2=sha1(md5($_POST["sifre2"]));
		$eposta=$_POST["eposta"];
		if(empty($kadi) or empty ($sifre) or empty ($sifre2) or empty ($eposta))
		{
			echo '<font style="color:red"> Formda boş alanlar mevcut </form>';
		}
		elseif($sifre !=$sifre2)
		{
			echo '<font style="color:red"> Şifreler uyuşmuyor!! </form>';
		}
		else
		{
			$kaydet= mysql_query ("INSERT INTO uyeler (kadi,sifre,eposta) VALUES ('$kadi','$sifre','$eposta')");
			if($kaydet)
			{
			 echo '<font style="color:green"> Başarıyla kayıt oldunuz </form>';
			 header ("Refresh:1.5;url= index.php?go=giris");
			}
			
		}
	}
	echo '</div>';
	
	break;
}
}
else
{
echo '<a href="index.php?go=profil">Profil</a> | <a href="index.php?go=cikis">Çıkış Yap </a> | Hoşgeldiniz.' .$_SESSION["kadi"];
$id=$_GET["go"];
switch ($id)
{
	case 'profil';
	$query2=mysql_query("SELECT * FROM uyeler WHERE id='$_SESSION[id]'");
	$cek2=mysql_fetch_array($query2);
	echo '<div id="genel"><h1 style="margin:0px;"> Profil </h1>
		<form action="" method="post">
    	<table cellpadding="3" cellspacing="3">
        	<tr>
            	<td> <label for="adsoyad">Ad & Soyad</label> </td>
                <td> <input type="text" class="i1" name="adsoyad" id="adsoyad" />  </td>
            </tr>
        	<tr>
            	<td> <label for="cinsiyet">Cinsiyet</label> </td>
                <td> <select name="cinsiyet" >
						<option value="0"'; if($cek2["cinsiyet"] == "0"){echo "selected";} echo'> Seçiniz..</option>
						<option value="E"'; if($cek2["cinsiyet"] == "E"){echo "selected";} echo'> >Erkek</option>
						<option value="K"'; if($cek2["cinsiyet"] == "K"){echo "selected";} echo'> >Kadın</option>
					</select> </td>
            </tr>
        		<tr>
            	<td> </td>
                <td> <input type="submit" name="profil" value="Güncelle" class="s1"  </td>
            </tr>
         </table>
		 </form>';
		 
		 if($_POST["profil"])
		 {
			$adsoyad=$_POST["adsoyad"];
			$cinsiyet=$_POST["cinsiyet"];
			$guncelle= mysql_query("UPDATE uyeler SET adsoyad='$adsoyad';cinsiyet='$cinsiyet' WHERE id='$_SESSION[id]'");
			if($guncelle)
			{
				echo '<font style="color:green"> Güncelleme Başarılı </font>';	
			} 
			else
			{
				echo '<font style="color:red"> Hata oluştu </font>';	
			}
		 }
		 echo '</div>';	
		 break;
		 case 'cikis';
		 session_destroy();
		 header("Location:index.php");
		 break;
}	
}
?>
</body>
<html>