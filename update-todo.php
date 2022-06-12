<?php
include("koneksi/koneksi.php");
session_start();
$pengguna=$_SESSION['username'];
$mode=$_GET['mode'];
$id=$_GET['id'];


if($mode=="coret")
{
	$query=mysqli_query($con,"select mark from todo where todo_id='$id'");
	$data=mysqli_fetch_array($query);
	
	if($data['mark']=="no")
	{
		$update=mysqli_query($con,"update todo set mark='yes' where todo_id='$id'");
		#echo $update;
	}
	else
	{
		$update=mysqli_query($con,"update todo set mark='no' where todo_id='$id'");
	}
	
	if(!($update))
	{
		echo '<script>alert(\'Tanda coret tidak bisa di simpan.\')
			setTimeout(\'location.href="index.php"\' ,0);</script>';
		exit;	
	}
	header('Location: index.php');
}

else if($mode=="hapus")
{
	$hapus=mysqli_query($con,"delete from todo where todo_id='$id'");
	if(!($hapus))
	{
		echo '<script>alert(\'Data tidak bisa di hapus.\')
			setTimeout(\'location.href="index.php"\' ,0);</script>';
		exit;	
	}
	header('Location: index.php');
}
else if($mode=="baru")
{
	$input=mysqli_query($con,"insert into todo(todo_name,mark,input_by) values('$_POST[pekerjaan]','no','$pengguna')");
	if(!($input))
	{
		echo '<script>alert(\'Input gagal.\')
			setTimeout(\'location.href="index.php"\' ,0);</script>';
		exit;	
	}
	header('Location: index.php');
}


?>
