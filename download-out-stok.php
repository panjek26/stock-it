<?php
session_start();
include "koneksi/koneksi.php";

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

if(substr($_SESSION['level'],0,6)=='gudang')
{
		$sqlcari=mysqli_query($con,"select * from gudang where kode_gudang='$_SESSION[level]'");
		$dtcari=mysqli_fetch_array($sqlcari);
		$idgudang=$dtcari['id_gudang'];
		$sql="select b.id_barang, b.nama_barang,b.satuan, g.nama_gudang, p.stok from barang b, gudang g, posisi p where (b.id_barang=p.id_barang) and (g.id_gudang=p.id_gudang) and (p.id_gudang='$idgudang') order by b.nama_barang asc";				
							
}
else
{
		$sql="select b.id_barang, b.nama_barang,b.satuan, sum(p.stok) as jumlah from barang b left join posisi p on b.id_barang=p.id_barang
group by b.id_barang
having sum(p.stok) is null or sum(p.stok) <=5";				
											
}

//$sql="select nama_barang,satuan,stok from barang order by nama_barang asc";				

$Use_Title = 1;
$now_date = date('d-m-Y H:i');
$title = "LAPORAN STOK BARANG";

//execute query
$result = mysqli_query($con,$sql);

$w=2;
if (isset($w) && ($w==1))
{
	$file_type = "msword";
	$file_ending = "doc";
}else {
	$file_type = "vnd.ms-excel";
	$file_ending = "xls";
}


header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=laporan-stok.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*	Start of Formatting for Word or Excel	*/

if (isset($w) && ($w==1)) //check for $w again
{
	/*	FORMATTING FOR WORD DOCUMENTS ('.doc')   */
	//create title with timestamp:
	if ($Use_Title == 1)
	{
		echo("$title\n\n");
	}
	//define separator (defines columns in excel & tabs in word)
	$sep = "\n"; //new line character

	while($row = mysqli_fetch_row($result))
	{
		//set_time_limit(60); // HaRa
		$schema_insert = "";
		for($j=0; $j<mysqli_num_fields($result);$j++)
		{
		//define field names
		$field_name = mysqli_field_name($result,$j);
		//will show name of fields
		$schema_insert .= "$field_name:\t";
			if(!isset($row[$j])) {
				$schema_insert .= "NULL".$sep;
				}
			elseif ($row[$j] != "") {
				$schema_insert .= "$row[$j]".$sep;
				}
			else {
				$schema_insert .= "".$sep;
				}
		}
		$schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert .= "\t";
		print(trim($schema_insert));
		//end of each mysqli row
		//creates line to separate data from each mysqli table row
		print "\n----------------------------------------------------\n";
	}
}else{
	/*	FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
	//create title with timestamp:
	if ($Use_Title == 1)
	{
		echo("$title\n");
	}
	//define separator (defines columns in excel & tabs in word)
	$sep = "\t"; //tabbed character

	//start of printing column names as names of mysqli fields
	for ($i = 0; $i < mysqli_num_fields($result); $i++)
	{
		echo mysqli_field_name($result,$i) . "\t";
	}
	print("\n");
	//end of printing column names

	//start while loop to get data
	while($row = mysqli_fetch_row($result))
	{
		//set_time_limit(60); // HaRa
		$schema_insert = "";
		for($j=0; $j<mysqli_num_fields($result);$j++)
		{
			if(!isset($row[$j]))
				$schema_insert .= "NULL".$sep;
			elseif ($row[$j] != "")
				$schema_insert .= "$row[$j]".$sep;
			else
				$schema_insert .= "".$sep;
		}
		$schema_insert = str_replace($sep."$", "", $schema_insert);
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		print(trim($schema_insert));
		print "\n";
	}
}

?>
