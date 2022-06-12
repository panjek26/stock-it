<?php
include ("koneksi/koneksi.php");
session_start();
if(!isset($_SESSION['username'])) 
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
						<span class="caret"></span>
						</a>
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
	========================================================= MENU
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
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		<?php
//------------------------------------ Summary Data ---------------------------------------------
		$qrbrg= mysqli_query($con,"select id_barang from barang");
		$jmlbrg=mysqli_num_rows($qrbrg);
		
		$qrstok= mysqli_query($con,"select b.id_barang, b.nama_barang,b.satuan, sum(p.stok) as jumlah from barang b left join posisi p on b.id_barang=p.id_barang
group by b.id_barang
having sum(p.stok) is null or sum(p.stok) <=5");
		//$dtstok=mysqli_fetch_array($qrstok);
		//$jmlstok=$dtstok['total'];
		$jmlstok=mysqli_num_rows($qrstok);
		
		$qrtrx= mysqli_query($con,"select id_transaksi from transaksi");
		$jmltrx=mysqli_num_rows($qrtrx);
		
		//$qrmasuk= mysqli_query($con,"select sum(jumlah) as masuk from transaksi where (month(tgl_transaksi)=month(now())) and (jenis_transaksi='Masuk')");
		$qrmasuk= mysqli_query($con,"select sum(jumlah) as masuk from transaksi where (jenis_transaksi='Masuk') and (month(tanggal_do)=month(now()))");
		$dtmasuk=mysqli_fetch_array($qrmasuk);
		$stokmasuk=$dtmasuk['masuk'];
		
		//$qrkeluar= mysqli_query($con,"select sum(jumlah) as keluar from transaksi where (month(tgl_transaksi)=month(now())) and (jenis_transaksi='Keluar')");
		$qrkeluar= mysqli_query($con,"select sum(jumlah) as keluar from transaksi where (jenis_transaksi='Keluar') and (month(tanggal_do)=month(now()))");
		$dtkeluar=mysqli_fetch_array($qrkeluar);
		$stokkeluar=$dtkeluar['keluar'];
		
		if(empty($jmlbrg))
		{
			$jmlbrg=0;
		}
		if(empty($jmlstok))
		{
			$jmlstok=0;
		}
		if(empty($stokmasuk))
		{
			$stokmasuk=0;
		}
		if(empty($stokkeluar))
		{
			$stokkeluar=0;
		}
		
		echo '		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<a href="history1.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-gift glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"></div>
							<a href="history1.php"><div class="text-muted">Log Transaksi</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<a href="laporan1.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-shopping-cart glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"></div>
							<a href="laporan1.php"><div class="text-muted">Stock Saat ini</div></a>
						</div>
					</div>
				</div>
			</div>

<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget ">
					<div class="row no-padding">
						<a href="laporan6.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-transfer glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"></div>
							<a href="laporan6.php"><div class="text-muted">Laporan LPP</div></a>
						</div>
					</div>
				</div>
			</div>
			
					
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						
						
					</div>
				</div>
			</div>
			
		</div>
		
		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<a href="barang.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-gift glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">'.$jmlbrg.'</div>
							<a href="barang.php"><div class="text-muted">Total Items</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<a href="laporan1.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-shopping-cart glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">'.$jmlstok.'</div>
							<a href="laporan5.php"><div class="text-muted">Out of Stock</div></a>
						</div>
					</div>
				</div>
			</div>
			
			
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<a href="laporan3.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-import glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">'.$stokmasuk.'</div>
							<a href="laporan3.php"><div class="text-muted">Stock In</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<a href="laporan4.php">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-export glyphicon-l"></em>
						</div>
						</a>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">'.$stokkeluar.'</div>
							<a href="laporan4.php"><div class="text-muted">Stock Out</div></a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		
		<div class="row">

		</div>';
		
		
		$qrreq= mysqli_query($con,"select id_request from request");
		$jmlreq=mysqli_num_rows($qrreq);
		
		$qropen= mysqli_query($con,"select * from request where status='open'");
		$jmlopen=mysqli_num_rows($qropen);
		
		$qrapv= mysqli_query($con,"select id_request from request where status='approved'");
		$jmlapv=mysqli_num_rows($qrapv);
		
		$qrrej= mysqli_query($con,"select id_request from request where status='rejected'");
		$jmlrej=mysqli_num_rows($qrrej);
		
		
		if(empty($jmlreq))
		{
			$jmlreq=0;
		}
		if(empty($jmlopen))
		{
			$jmlopen=0;
		}
		if(empty($jmlapv))
		{
			$jmlapv=0;
		}
		if(empty($jmlrej))
		{
			$jmlrej=0;
		}
		
		echo '		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					
				</div>
			</div>
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<a href="request.php">

						</a>

					</div>
				</div>
			</div>
			
		</div>
		
		<!--
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">In-Out Traffic Overview</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		-->
		';
//------------------------------------ Summary Data ---------------------------------------------
		?>		
		
			<div class="panel panel-blue">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-check"></span>To-do List</div>
					<div class="panel-body">
						<ul class="todo-list">
							<?php
//------------------------------------ Tampilkan daftar to-do list ---------------------------------------------							
							
							$qrlist=mysqli_query($con,"select * from todo where input_by ='$pengguna'");
							
							while($dtlist=mysqli_fetch_array($qrlist))
							{
							echo '
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />';
									
									if($dtlist['mark']=="yes")
									{
										echo '<label for="checkbox"><span style="text-decoration:line-through;">'.$dtlist['todo_name'].'</span></label>';
									}
									else						
									{
										echo '<label for="checkbox"><span>'.$dtlist['todo_name'].'</span></label>';
									}
									
							echo '	
								</div>
								<div class="pull-right action-buttons">
									<a href="update-todo.php?mode=coret&id='.$dtlist['todo_id'].'"><span class="glyphicon glyphicon-pencil" title="Coret"></span></a>
									<a href="update-todo.php?mode=hapus&id='.$dtlist['todo_id'].'" class="trash"><span class="glyphicon glyphicon-trash" title="Hapus"></span></a>
								</div>
							</li>';
							}
							?>							
						</ul>
					</div>
					<div class="panel-footer">
						<form name="from-todo" method="post" action="update-todo.php?mode=baru">
						<div class="input-group">
							
							<input id="btn-input" type="text" name="pekerjaan" class="form-control input-md" placeholder="Add new task" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary btn-md" id="btn-todo">Add</button>
							</span>
							
						</div>
						</form>
					</div>
				</div>
		
	</div>	<!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

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
