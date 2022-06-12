<?php
$server   ="localhost" ;
$username ="root";
$password =""; // Apabila tidak ada password ganti "1234" menjadi ""
$database ="master_toko";

$con_toko = @mysqli_connect("$server", "$username", "$password", "$database");
//cek koneksi error atau tidak
if (!$con_toko) 
{
		echo "Error: " . mysqli_connect_error();
		exit();
}
?>