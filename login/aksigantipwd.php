<?php
	include ("../koneksi/koneksi.php");
	session_start();
	if(!isset($_SESSION['username'])) 
	{
		include("../login.php");
		exit;
	}
		
		$pwd_lama=md5($_POST['pass_lama']);
		$pwd_baru=md5($_POST['pass_baru']);
		$pwd_baru2=md5($_POST['pass_baru2']);
		
		$sql="select * from user where username='$_SESSION[username]'";
		$query=mysqli_query($con,$sql);
		$data=mysql_fetch_array($query);
		
		
		if($pwd_lama==$data['password'])
		{
		
			if($pwd_baru==md5(''))
			{
				echo '<script>alert(\'Password baru tidak boleh kosong!\')
				setTimeout(\'location.href="../ganti-password.php"\' ,0);</script>';
				exit;
			}
			
			if ($pwd_baru==$pwd_baru2)
			{	
					
				mysql_query("UPDATE user SET 
				password = '".md5($_POST['pass_baru'])."'
				where username='$_SESSION[username]'");
				echo '<script>alert(\'Password berhasil di ubah\')
				setTimeout(\'location.href="../index.php"\' ,0);</script>';
			}
			else
			{
				echo '<script>alert(\'Password baru tidak sama!\')
				setTimeout(\'location.href="../ganti-password.php"\' ,0);</script>';
			}
		}
		else
		{
			echo '<script>alert(\'Password lama salah!\')
				setTimeout(\'location.href="../ganti-password.php"\' ,0);</script>';
		}
?>