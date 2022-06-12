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
							<li><a href="ganti-password.php"><span class="glyphicon glyphicon-user"></span> Ganti password</a></li>
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
				<li class="active">Barang</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Add/Edit Items</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<!--<div class="panel-heading">Stok Masuk</div>-->
					<div class="panel-body">
						<div class="col-md-6">
							<form role="form" action="save-barang.php?mode=edit" method="post">
								<?php
//-----------------------------------------GET DATA BARANG---------------------------------------------------------

								$id=antiInjections($con,$_GET['id']);
								$sqlbrg="select * from barang where id_barang='$id'";
								$qrbrg=mysqli_query($con,$sqlbrg);
								$dtbrg=mysqli_fetch_array($qrbrg);							
								echo '
								<input type="hidden" name="id" value="'.$id.'">
								<div class="form-group">
									<label>Nama Barang</label>
									<input class="form-control" name="nama" value="'.$dtbrg['nama_barang'].'">
								</div>
								
								<div class="form-group">
									<label>Satuan</label>
									<select name="satuan" class="form-control">
										<option value="'.$dtbrg['satuan'].'">'.$dtbrg['satuan'].'</option>';
									
										$sqlsat=mysqli_query($con,"select nama_satuan from satuan");
										while($dtsat=mysqli_fetch_array($sqlsat))
										{
											echo '<option value="'.$dtsat['nama_satuan'].'">'.$dtsat['nama_satuan'].'</option>';
										}
									
								echo'
									</select>
								</div>
								<div class="form-group">
									<label>Harga Beli</label>
									<input class="form-control" name="hbeli" value="'.$dtbrg['harga_beli'].'">
								</div>
								<div class="form-group">
									<label>Harga Jual</label>
									<input class="form-control" name="hjual" value="'.$dtbrg['harga_jual'].'">
								</div>
								';
								
//-----------------------------------------GET DATA BARANG---------------------------------------------------------
								?>
								<br><br>
								<button type="submit" class="btn btn-primary">Save</button>
								<button type="reset" class="btn btn-default">Cancel</button>
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
