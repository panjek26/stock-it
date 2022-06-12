<?php
include("koneksi/koneksi.php");

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$id=$_POST['id'];
	$nama=$_POST['nama'];
	$satuan=$_POST['satuan'];
	$hbeli=$_POST['hbeli'];
	$hjual=$_POST['hjual'];

	$simpan=mysqli_query($con,"update barang set nama_barang='$nama', satuan='$satuan', harga_beli='$hbeli', harga_jual='$hjual' where id_barang='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Update data gagal.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update data berhasil.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="add")
{
	$nama=$_POST['nama'];
	$satuan=$_POST['satuan'];
	$hbeli=$_POST['hbeli'];
	$hjual=$_POST['hjual'];
	
	$cek=mysqli_query($con,"select nama_barang,satuan from barang where (nama_barang='$nama') and (satuan='$satuan')");
	$ada=mysqli_num_rows($cek);
	if($ada>0)
	{
		echo '<script>alert(\'Item barang sudah ada, silahkan masukkan item yang lain\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
	
	$simpan=mysqli_query($con,"insert into barang(nama_barang,satuan,harga_beli,harga_jual) values ('$nama','$satuan','$hbeli','$hjual')");
	if(!($simpan))
	{
		echo '<script>alert(\'Item baru gagal disimpan.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Item baru berhasil disimpan.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="delete")
{
	$id=$_GET['id'];
	$simpan=mysqli_query($con,"delete from barang where id_barang='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Item gagal dihapus.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
	header("Location: barang.php");
}

?>
