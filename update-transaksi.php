<?php
include("koneksi/koneksi.php");


	$id=$_POST['idtransaksi'];
	$ket=$_POST['ket'];

	$simpan=mysqli_query($con,"update transaksi set keterangan='$ket' where id_transaksi='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Update keterangan gagal.\')
			setTimeout(\'location.href="history1.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update keterangan berhasil.\')
			setTimeout(\'location.href="history1.php"\' ,0);</script>';
			exit;
	}


?>
