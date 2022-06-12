<?php
include("koneksi/koneksi.php");

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$id=$_POST['id'];
	$nama=$_POST['nama'];
	$jumlah=$_POST['jumlah'];
	$simpan=mysql_query("update barang set nama_barang='$nama', stok='$jumlah' where id_barang='$id'");
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
	$jumlah=$_POST['jumlah'];
	$simpan=mysql_query("insert into barang values ('','$nama','$jumlah')");
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
	$id=$_POST['id'];
	$simpan=mysql_query("delete from barang where id_barang='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Item gagal dihapus.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Item berhasil dihapus.\')
			setTimeout(\'location.href="barang.php"\' ,0);</script>';
			exit;
	}
}

?>
