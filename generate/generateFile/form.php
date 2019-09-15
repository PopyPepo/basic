<?php 
function form($conn, $tableIns, $fileIns){


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


$form='';
$c='';

$initController='';





/*-----------------------------------------*/
$excute = mysqli_query($conn, $sql);
while ($instanc = mysqli_fetch_object($excute)){ $initController.=$c;
	$span = $instanc->Null=='NO' ? ' <span class="text-danger">*</span>' : '';
	$required = $instanc->Null=='NO' ? 'required="required" ' : '';

	//print_r($instanc);
$form.= '
<div class="form-group row">
	<label class="col-form-label col-md-3 text-right" for="'.$instanc->Field.'">'.$instanc->Comment.' '.$span.'</label>
	<div class="col-md-9">
		<input type="text" class="form-control" id="'.$instanc->Field.'" name="'.$instanc->Field.'" value="<?php echo $instance[\''.$instanc->Field.'\']; ?>" '.$required.'>
	</div>
</div>
';


$initController.='
"'.$instanc->Field.'": "\'.$instance[\''.$instanc->Field.'\'].\'"';
$c=",";
}
/*-----------------------------------------*/

$form.= '
<hr>
';

	return $form;
}
//echo $initController;
?>