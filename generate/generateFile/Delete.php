<?php 
function Delete($conn, $tableIns, $fileIns){


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


$delete='
<?php
include("../connect.php");
$'.$id->Column_name.' = isset($_GET[\''.$id->Column_name.'\']) ? $_GET[\''.$id->Column_name.'\'] : null;
if ($'.$id->Column_name.'){
	$deleteSql = "DELETE FROM '.$table.' WHERE '.$id->Column_name.'=\'".$'.$id->Column_name.'."\'";
	$excute = mysqli_query($conn, $deleteSql);
	if ($excute){
		echo \'<script>
			alert("ลบข้อมูล'.$name.' สำเร็จ");
			window.location.href = "../index.php?page='.$table.'/'.$table.'List";
		</script>\';
	}else{
		echo \'<script>
			alert("ลบข้อมูล'.$name.' ไม่สำเร็จ กรุณาตรวจสอบ!!!");
			window.history.back();
		</script>\';
	}
}else{
	echo \'<script>
		alert("ไม่พบข้อมูล กรุณาตรวจสอบ!!!");
		window.history.back();
	</script>\';
}?>
';



	return $delete;
}
//echo $initController;
?>