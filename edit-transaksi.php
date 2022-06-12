<?php
include ("koneksi/koneksi.php");
session_start();
if(!isset($_SESSION['username'])) 
{
	include("login.php");
	exit;
}
$pengguna=$_SESSION['username'];
function antiInjections($link,$string) {
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysqli_real_escape_string($link,$string);
    return $string;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aplikasi Stok Barang</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-signal"></span> E-Stock<span></span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>
						<!-- ====================================================LOGIN -->
						<?php
						echo " $pengguna";
						?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="ganti-password.html"><span class="glyphicon glyphicon-user"></span> Ganti password</a></li>
							<!--<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>-->
							<li><a href="login/aksilogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<!--	
	==================================================== MENU
	-->
	<?php
	include("menu.php");
	?>	
	
	<!--	
	==================================================== MENU
	-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">History Transaksi</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Edit Keterangan</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<!--<div class="panel-heading">Stok Masuk</div>-->
					<div class="panel-body">
						<div class="col-md-6">
							<form role="form" action="update-transaksi.php" method="post">

								<?php
//-----------------------------------------GET DATA TRANSAKSI---------------------------------------------------------
								
								$idb=antiInjections($con,$_GET['idb']);
								$sqlbrg="select * from barang where id_barang='$idb'";
								$qrbrg=mysqli_query($con,$sqlbrg);
								$dtbrg=mysqli_fetch_array($qrbrg);
								
								$idt=$_GET['idt'];
								$sqltrx="select * from transaksi where id_transaksi='$idt'";
								$qrtrx=mysqli_query($con,$sqltrx);
								$dttrx=mysqli_fetch_array($qrtrx);
								
								echo '
								<input type="hidden" name="idtransaksi" value="'.$idt.'">															
								<div class="form-group">
									<label>Nama Barang</label>
									<input class="form-control" name="barang" value="'.$dtbrg['nama_barang'].'" readonly>
								</div>
															
								<div class="form-group">
									<label>Alur Transaksi</label>
									<input class="form-control" name="alur" value="'.$dttrx['jenis_transaksi'].'" readonly>
								</div>
								
								<div class="form-group">
									<label>Jumlah</label>
									<input class="form-control" name="jumlah" value="'.$dttrx['jumlah'].'" readonly>
								</div>
								
								<div class="form-group">
									<label>Keterangan (Optional)</label>
									<textarea class="form-control" rows="3" name="ket">'.$dttrx['keterangan'].'</textarea>
								</div>';
								
//------------------------------------------GET DATA TRANSAKSI--------------------------------------------------------
								?>
																
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-default">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
