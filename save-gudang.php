<?php
include("koneksi/koneksi.php");
session_start();
$pengguna=$_SESSION['username'];
if($pengguna=="demo")
{
	echo '<script>alert(\'User demo tidak diperkenankan untuk update/delete database.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
}

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$id=$_POST['id'];
	$kode=$_POST['kode'];
	$nama=$_POST['nama'];
	
	$simpan=mysqli_query($con,"update gudang set kode_gudang='$kode', nama_gudang='$nama' where id_gudang='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Update data gagal.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update data berhasil.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="add")
{
	$kode=$_POST['kode'];
	$nama=$_POST['nama'];
	$cek=mysqli_query($con,"select kode_gudang from gudang where kode_gudang='$kode'");
	$ada=mysqli_num_rows($cek);
	if($ada>0)
	{
		echo '<script>alert(\'Kode gudang sudah ada, silahkan masukkan kode yang lain\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
	
	$simpan=mysqli_query($con,"insert into gudang(kode_gudang,nama_gudang) values ('$kode','$nama')");
	if(!($simpan))
	{
		echo '<script>alert(\'Input Gagal!.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Gudang baru telah dibuat.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="delete")
{
	$id=$_GET['id'];
	$simpan=mysqli_query($con,"delete from gudang where id_gudang='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Gudang tidak berhasil dihapus.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Gudang telah dihapus.\')
			setTimeout(\'location.href="gudang.php"\' ,0);</script>';
			exit;
	}
}

?>
