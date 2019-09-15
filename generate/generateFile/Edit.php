<?php 
function Edit($conn, $tableIns, $fileIns){


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

$edit='
<?php
include("connect.php");
$sqlQuery = "SELECT * FROM '.$table.' WHERE '.$id->Column_name.'=\'".$_GET[\''.$id->Column_name.'\']."\' ";
$query = mysqli_query($conn, $sqlQuery);
$instance=mysqli_fetch_assoc($query);
?>
';
$ngInit='
		<form name="'.$table.'Update" class="col-12" action="<?php echo \''.$table.'/'.$table.'Update.php?'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>" method="POST" enctype="multipart/form-data">';
$edit.=$open;
$edit.='
	<div class="">
		<h2 class="">แก้ไขข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/'.$table.'List" class="btn btn-primary btn-xs white"><i class="fa fa-list"></i> รายการข้อมูล'.$name.'</a>
			<a href="index.php?page='.$table.'/'.$table.'Create" class="btn btn-success btn-xs white"><i class="fa fa-plus-circle"></i>  เพิ่มขอมูล'.$name.'</a>
			<a href="<?php echo \'index.php?page='.$table.'/'.$table.'Show&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-info btn-xs white"><i class="fa fa-arrow-left"></i> กลับไปยังหน้าแสดงข้อมูล</a>
		</ul>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		'.	$ngInit.'
			<?php include_once("'.$table.'/form.php"); ?>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
					<a href="<?php echo \''.$table.'/'.$table.'Delete.php?'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>" class="btn btn-danger" onclick="return confirm(\'คุณต้องการลบข้อมูล หรือไม่?\')"><i class="far fa-trash-alt"></i> ลบข้อมูล</a>
				</div>
			</div>
		</form>
	</div>
';
$edit.=$close;

	return $edit;
}
//echo $initController;
?>