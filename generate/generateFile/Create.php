<?php 
function Create($conn, $tableIns, $fileIns){


/********************************** */

$table = $tableIns['TABLE_NAME'];
$sql = "SHOW FULL COLUMNS FROM ".$table." WHERE Extra!='auto_increment' ";
$excute = mysqli_query($conn, $sql);


$tableSql = "SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_NAME = '".$table."'";
$tableexcute = mysqli_query($conn, $tableSql);
$tableInstanc = mysqli_fetch_object($tableexcute);

$name = $tableInstanc->TABLE_COMMENT ? $tableInstanc->TABLE_COMMENT : $table;

/*while ($instanc = mysqli_fetch_object($excute)){
	echo $instanc->Field.', ';
	//echo 'OLD.'.$instanc->Field.', ';
}*/

$colIndex = array();
$id = array();

$sqlS = "SHOW INDEX FROM ".$table."";
$excuteS = mysqli_query($conn, $sqlS);
while ($instancS = mysqli_fetch_object($excuteS)){
	//print_r($instancS);
	if (isset($instancS->Column_name)){$colIndex[] = $instancS->Column_name;}
	if ($instancS->Key_name=='PRIMARY' && !$id){$id = $instancS;}
}


$open = '
<div class="container">';


$close = '
</div>
';
$c='';
$excute = mysqli_query($conn, $sql);
$create='
<?php
include("connect.php");
$instance = array(';
while ($instanc = mysqli_fetch_object($excute)){
	$create.=$c.'
	"'.$instanc->Field.'"=>null';
	$c=',';
}
$create.='
);
?>
';

$create.=$open;
$create.='
	<div class="">
		<h2 class="float-left">เพิ่มข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/'.$table.'List" class="btn btn-primary btn-xs white"><i class="fa fa-list"></i> รายการข้อมูล'.$name.'</a>
		</ul>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		<form name="'.$table.'Add" class="col-12" action="'.$table.'/'.$table.'Insert.php" method="POST" enctype="multipart/form-data">
			<?php include_once("'.$table.'/form.php"); ?>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
				</div>
			</div>
		</form>
	</div>
';
$create.=$close;


	return $create;
}
//echo $initController;
?>