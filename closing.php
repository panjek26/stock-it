<?php
include ("koneksi/koneksi.php");
session_start();
if(!isset($_SESSION['username']) or ($_SESSION['level']!='administrator')) 
{
	include("login.php");
	exit;
}
$pengguna=$_SESSION['username'];
$date_closing1 =date('Y-m')."-01";
$date_closing2 =date('Y-m')."-31";

#$date1= date("Y M");
#$date_trans=date('Y-M', strtotime($date1. ' - 1 months'));
#$date_filter1=date('Y-m', strtotime($date1. ' - 1 months'))."-01";
#$date_filter2=date('Y-m', strtotime($date1. ' - 1 months'))."-31";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aplikasi Stok Barang IT</title>
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
				<h1 class="page-header">Closing Periode</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="alert bg-primary" role="alert">
					<span class="glyphicon glyphicon-info-sign"></span> Klik tombol dibawah ini untuk melakukan closing stock  <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				
			
<!-- ==================================================================================================================== --->
				
<form action="" method="post" name="postform">
	<div align="left">
	  
	  <div id="formsubmitbutton">
	    <input type="submit" class="btn btn-primary btn-md" name="closing"  onclick="ButtonClicked()" value="PROSES CLOSING !!!" />
	  </div>
	  
	  <div id="buttonreplacement" style="margin-left:30px; display:none;">
		<img src="img/loading.gif" alt="loading...">
	  </div>
	  
   </div>
</form>


<script type="text/javascript">
/*
   Replacing Submit Button with 'Loading' Image
   Version 2.0
   December 18, 2012

   Will Bontrager Software, LLC
   http://www.willmaster.com/
   Copyright 2012 Will Bontrager Software, LLC

   This software is provided "AS IS," without 
   any warranty of any kind, without even any 
   implied warranty such as merchantability 
   or fitness for a particular purpose.
   Will Bontrager Software, LLC grants 
   you a royalty free license to use or 
   modify this software provided this 
   notice appears on all copies. 
*/
function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("buttonreplacement").style.display = ""; // to display
   return true;
}
var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;
</script>

<?php
if(isset($_POST['closing'])){
	

	 $query_check=("select distinct date_stock from last_stock where date_stock >='$date_closing1' 
	 						and date_stock <='$date_closing2';");
	 $hasil=mysqli_query($con,$query_check);
	 if (mysqli_num_rows($hasil) > 0) {
	 	echo "<p align='center'>&nbsp;</p>";
		echo "<div class='alert bg-danger' role='alert'>";
		echo "<span class='glyphicon glyphicon-warning-sign'> </span> Anda sudah menjalankan closing.";
	 	#echo $query_check;


	 }else{
		$simpan=mysqli_query($con,"insert into last_stock (id_barang,id_gudang,stok,date_stock) select id_barang,id_gudang,stok, DATE_FORMAT(now(), '%Y-%m-%d') from posisi");

		echo "<p align='center'>&nbsp;</p>";
		echo "<div class='alert bg-success' role='alert'>";
		echo "<span class='glyphicon glyphicon-check'> </span> Process Closing Stock telah selesai.";
		#echo $query_check;
	 }
	?>
	


		

		
	</div>
	<?php
}else{
	unset($_POST['closing']);
}

/*
untuk memanggil nama fungsi :: jika anda ingin membackup semua tabel yang ada didalam database, biarkan tanda BINTANG (*) pada variabel $tables = '*'
jika hanya tabel-table tertentu, masukan nama table dipisahkan dengan tanda KOMA (,) 
*/
function process_closing()
{

}
?>

<!-- ==================================================================================================================== -->				
				
				<!--
				<div class="alert bg-warning" role="alert">
					<span class="glyphicon glyphicon-warning-sign"></span> Welcome to the admin dashboard panel bootstrap template <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				<div class="alert bg-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign"></span> Welcome to the admin dashboard panel bootstrap template <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				-->
			</div>				
			
		</div><!--/.row-->
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
