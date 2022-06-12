<?php
include ("koneksi/koneksi.php");
include ("koneksi/koneksi_toko.php");
session_start();
if(!isset($_SESSION['username']) or ($_SESSION['level']=='report')) 
{
	include("login.php");
	exit;
}
$pengguna=$_SESSION['username'];

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
				<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-signal"></span> Web Stock<span></span></a>
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
				<li class="active">Transaksi</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Keluar</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<!--<div class="panel-heading">Stok Masuk</div>-->
					<div class="panel-body">
						<div class="col-md-6">
							<form role="form" action="update-stok.php" method="post">
															
								<div class="form-group">
									<label>Nama Barang</label>
									<select  name="barang" class="form-control">
							<?php
								
//-------------------------LOOKUP DATA BARANG-------------------------------------------------------------
								
								if(substr($_SESSION[level],0,6)=='gudang')
								{
									$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
									$dtcari=mysqli_fetch_array($sqlcari);
									$idgudang=$dtcari['id_gudang'];
									$qrbrg=mysqli_query($con,"select b.id_barang, b.nama_barang,p.id_gudang,p.stok from barang b, posisi p where (b.id_barang=p.id_barang) and (p.id_gudang=$idgudang) and (p.stok > 0) order by b.nama_barang asc");
								}
								else
								{
									$qrbrg=mysqli_query($con,"select b.id_barang, b.nama_barang,p.stok from barang b, posisi p where (b.id_barang=p.id_barang) and (p.stok > 0) order by b.nama_barang asc");
								}
								
								while($dtbrg=mysqli_fetch_array($qrbrg))
								{
								echo '
										<option value="'.$dtbrg['id_barang'].'">'.$dtbrg['nama_barang'].'</option>
									';					
								}
								
//-------------------------LOOKUP DATA BARANG-------------------------------------------------------------
								
								?>
									</select>
								</div>
								
								<div class="form-group">
									<label>Alur Transaksi</label>
									<select name="jenis" class="form-control">
										<option value="Keluar">Keluar</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>Gudang</label>
									<select name="gudang" class="form-control">
								
								<?php
								
								if($_SESSION[level]=='administrator')
								{
									$sqlgudang=mysqli_query($con,"select * from gudang");
								}
								else
								{
									$sqlgudang=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
								}
								
								while ($dtgudang=mysqli_fetch_array($sqlgudang))
								{
									echo '<option value="'.$dtgudang['id_gudang'].'">'.$dtgudang['nama_gudang'].'</option>';
								}

								?>
									</select>
								</div>



		<label>Toko / Department</label>
	<div class="form-group">

<select id="toko" name="toko" class="panji" size="10">
	<option ></option>
<?php
								
								if($_SESSION[level]=='administrator')
								{
									$sqltoko=mysqli_query($con_toko,"select 
										master_toko.ip_toko.kd_toko,
										master_toko.ip_toko.nama_toko 
										from master_toko.ip_toko
										union all
										select 
										admin_stockit.dept.id_dept,
										admin_stockit.dept.nama_dept
										from admin_stockit.dept");
								}
								else
								{
									$sqltoko=mysqli_query($con_toko,"select 
										master_toko.ip_toko.kd_toko,
										master_toko.ip_toko.nama_toko 
										from master_toko.ip_toko
										union all
										select 
										admin_stockit.dept.id_dept,
										admin_stockit.dept.nama_dept
										from admin_stockit.dept");
								}

								
								while ($dttoko=mysqli_fetch_array($sqltoko)) { ?>


								<option value="<?php echo $dttoko['kd_toko']  ?> - <?php echo $dttoko['nama_toko']  ?> " ><?php echo $dttoko['kd_toko']  ?> - <?php echo $dttoko['nama_toko']  ?>  
								</option>
								
								<?php } ?>
		</select>
	</div>

								
								<div class="form-group">
									<label>Nomor DO</label>
									<input class="form-control" name="do">
								</div>

								<div class="form-group">
									<label for="date1">Tanggal DO&nbsp;</label>
									<input type="date" name="tanggal_do" id="tanggal_do" class="form-control mr-2" required>
								</div>
								
								<div class="form-group">
									<label>Jumlah</label>
									<input class="form-control" name="jumlah" placeholder="Masukkan angka">
								</div>
								
								<div class="form-group">
									<label>Keterangan (Optional)</label>
									<textarea class="form-control" rows="1" name="ket"></textarea>
								</div>
								
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
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
		$(".panji").select2();
	</script>	
</body>

</html>
