<?php
include("koneksi/koneksi.php");

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$id=$_POST['id'];
	$nama=$_POST['nama'];
	
	$simpan=mysqli_query($con,"update satuan set nama_satuan='$nama' where id_satuan='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Update data gagal.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update data berhasil.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="add")
{
	$nama=$_POST['nama'];
	
	$cek=mysqli_query($con,"select nama_satuan from satuan where nama_satuan='$nama'");
	$ada=mysqli_num_rows($cek);
	if($ada>0)
	{
		echo '<script>alert(\'Item barang sudah ada, silahkan masukkan item yang lain\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
	
	$simpan=mysqli_query($con,"insert into satuan(nama_satuan) values ('$nama')");
	if(!($simpan))
	{
		echo '<script>alert(\'Item baru gagal disimpan.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Item baru berhasil disimpan.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="delete")
{
	$id=$_GET['id'];
	$simpan=mysqli_query($con,"delete from satuan where id_satuan='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Item gagal dihapus.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Item berhasil dihapus.\')
			setTimeout(\'location.href="satuan.php"\' ,0);</script>';
			exit;
	}
}

?>
