<?php
session_start();
include("koneksi/koneksi.php");

$mode=$_GET['mode'];
	
if($mode=="edit")
{
	$id=$_POST['id'];
	$status=$_POST['status'];
	$ket=$_POST['ket'];

	$simpan=mysqli_query($con,"update request set status='$status', keterangan='$ket' where id_request='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Update request gagal.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Update request berhasil.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="add")
{
	$tgl=$_POST['tgl'];
	$user=$_SESSION['username'];
	$ket=$_POST['ket'];
	
	$simpan=mysqli_query($con,"insert into request(tgl_request,username,status,keterangan) values ('$tgl','$user','open','$ket')");
	if(!($simpan))
	{
		echo '<script>alert(\'Request gagal dikirim.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Request telah dikirim.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
}
else if($mode=="delete")
{
	$id=$_GET['id'];
	$simpan=mysqli_query($con,"delete from request where id_request='$id'");
	if(!($simpan))
	{
		echo '<script>alert(\'Request gagal dihapus.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
	else
	{
		echo '<script>alert(\'Request telah dihapus.\')
			setTimeout(\'location.href="request.php"\' ,0);</script>';
			exit;
	}
}

?>
