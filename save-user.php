<?php
include("koneksi/koneksi.php");

session_start();
$pengguna=$_SESSION['username'];
if($pengguna=="demo")
{
	echo '<script>alert(\'User demo tidak diperkenankan untuk update/delete database.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
}

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$email=$_POST['email'];
	$level=$_POST['level'];
	
	if(!empty($password))
	{
		$password=md5($_POST['password']);
		$simpan=mysqli_query($con,"update user set password='$password', email='$email', level='$level' where username='$username'");
	}
	else
	{
		$simpan=mysqli_query($con,"update user set email='$email', level='$level' where username='$username'");
	}
	
	if(!($simpan))
	{
		echo '<script>alert(\'Update data gagal.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update data berhasil.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="add")
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$email=$_POST['email'];
	$level=$_POST['level'];
	
	$cek=mysqli_query($con,"select * from user where username='$username'");
	$ada=mysqli_num_rows($cek);
	if($ada>0)
	{
		echo '<script>alert(\'Username sudah ada, silahkan masukkan username yang lain\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
	
	$simpan=mysqli_query($con,"insert into user values ('$username','$password','$email','$level')");
	if(!($simpan))
	{
		echo '<script>alert(\'User baru gagal disimpan.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'User baru berhasil disimpan.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="delete")
{
	$id=$_GET['id'];
	$simpan=mysqli_query($con,"delete from user where username='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Item gagal dihapus.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Item berhasil dihapus.\')
			setTimeout(\'location.href="users.php"\' ,0);</script>';
			exit;
	}
}

?>
