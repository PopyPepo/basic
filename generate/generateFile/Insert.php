<?php 
function Insert($conn, $tableIns, $fileIns){

	/********************************** */

	$table = $tableIns['TABLE_NAME'];
	$sql = "SHOW FULL COLUMNS FROM ".$table." WHERE Extra!='auto_increment' ";
	$excute = mysqli_query($conn, $sql);


	$tableSql = "SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_NAME = '".$table."'";
	$tableexcute = mysqli_query($conn, $tableSql);
	$tableInstanc = mysqli_fetch_object($tableexcute);

	$name = $tableInstanc->TABLE_COMMENT ? $tableInstanc->TABLE_COMMENT : $table;

// 	/*while ($instanc = mysqli_fetch_object($excute)){
// 		echo $instanc->Field.', ';
// 		//echo 'OLD.'.$instanc->Field.', ';
// 	}*/

// 	$colIndex = array();
	$id = array();

	$sqlS = "SHOW INDEX FROM ".$table."";
	$excuteS = mysqli_query($conn, $sqlS);
	while ($instancS = mysqli_fetch_object($excuteS)){
		//print_r($instancS);
		if (isset($instancS->Column_name)){$colIndex[] = $instancS->Column_name;}
		if ($instancS->Key_name=='PRIMARY' && !$id){$id = $instancS;}
	}

// 	// echo '
// 	// -------------------------------------------------------';
$insert='
<?php
include("../connect.php");
';
$c = '';
$col = '';
$val = '';
$excute = mysqli_query($conn, $sql);
while ($instanc = mysqli_fetch_object($excute)){
	$col .= $c.$instanc->Field;
	$val .= $c."'\".$".$instanc->Field.".\"'";
	$insert.='$'.$instanc->Field.' = $_POST[\''.$instanc->Field.'\'];
';
	$c=', ';
}
$insert.='
$insertSql = "INSERT INTO '.$table.' ('.$col.') VALUES ('.$val.')";
$excute = mysqli_query($conn, $insertSql);
if ($excute){
	$last_id = $conn->insert_id;
	header("location:"."../index.php?page='.$table.'/'.$table.'Show&'.$id->Column_name.'=".$last_id);
}else{
	echo \'<script>
		alert("เพิ่มข้อมูล'.$name.' ไม่สำเร็จ กรุณาตรวจสอบ!!!");
		window.history.back();
	</script>\';
}
';
$insert.='
$insertSql = "INSERT INTO '.$table.' ('.$col.') VALUES ('.$val.')";
$excute = mysqli_query($conn, $insertSql);
if ($excute){
	$last_id = $conn->insert_id;
	header("location:"."../index.php?page='.$table.'/'.$table.'Show&'.$id->Column_name.'=".$last_id);
}else{
	echo \'<script>
		alert("เพิ่มข้อมูล'.$name.' ไม่สำเร็จ กรุณาตรวจสอบ!!!");
		window.history.back();
	</script>\';
}
';
$insert.='?>
';
	return $insert;
}
//echo $initController;
?>