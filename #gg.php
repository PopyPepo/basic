<?php 
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$database = "carrent";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/********************************** */

$table = 'detail';
$sql = "SHOW FULL COLUMNS FROM ".$table." WHERE Extra!='auto_increment' ";
$excute = mysqli_query($conn, $sql);


$tableSql = "SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_NAME = '".$table."'";
$tableexcute = mysqli_query($conn, $tableSql);
$tableInstanc = mysqli_fetch_object($tableexcute);

$name = $tableInstanc->TABLE_COMMENT;

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

echo '
-------------------------------------------------------';

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
$edit='
<?php
include("connect.php");
$sqlQuery = "SELECT * FROM '.$table.' WHERE '.$id->Column_name.'=\'".$_GET[\''.$id->Column_name.'\']."\' ";
$query = mysqli_query($conn, $sqlQuery);
$instance=mysqli_fetch_assoc($query);
?>
';



$list='
<?php
include("connect.php");

$perPage = 20;
$p = isset($_GET["p"]) ? $_GET["p"] : 1 ;
$pageStart = ($p-1)*$perPage;

$sqlQuery = "SELECT * FROM '.$table.' LIMIT $pageStart, $perPage";
$query = mysqli_query($conn, $sqlQuery);
?>
';
$form='';
$c='';
$show=$edit;
$initController='';
$ngInit='
		<form name="'.$table.'Update" class="col-12" action="<?php echo \''.$table.'/'.$table.'Update.php?'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>" method="POST" enctype="multipart/form-data">';




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
$create.=$open;
$create.='
	<div class="">
		<h2 class="float-left">เพิ่มข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/list" class="btn btn-primary btn-xs white"><i class="fa fa-list"></i> รายการข้อมูล'.$name.'</a>
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


$edit.=$open;
$edit.='
	<div class="">
		<h2 class="">แก้ไขข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/list" class="btn btn-primary btn-xs white"><i class="fa fa-list"></i> รายการข้อมูล'.$name.'</a>
			<a href="index.php?page='.$table.'/create" class="btn btn-success btn-xs white"><i class="fa fa-plus-circle"></i>  เพิ่มขอมูล'.$name.'</a>
			<a href="<?php echo \'index.php?page='.$table.'/show&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-info btn-xs white"><i class="fa fa-arrow-left"></i> กลับไปยังหน้าแสดงข้อมูล</a>
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

$excute = mysqli_query($conn, $sql);

$list.=$open;
$list.='
	<div class="">
		<h2 class="float-left">รายการข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/create" class="btn btn-success btn-xs white"><i class="fa fa-plus-circle"></i>  เพิ่มขอมูล'.$name.'</a>
		</ul>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="table-responsive">

			<table class="table table-hover table-vertical-middle nomargin">
				<thead>
					<tr style="width:5%;">
						<th class="text-center">#</th>';
						while ($instanc = mysqli_fetch_object($excute)){
						$list.='
						<th>'.$instanc->Comment.'</th>';
						}
						$list.='<th class="text-center"><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php while($instance=mysqli_fetch_assoc($query)){ ?>
						<tr>
							<td class="text-center">
								<?php echo ($pageStart++) +1; ?>
							</td>';
							$excute = mysqli_query($conn, $sql);
							while ($instanc = mysqli_fetch_object($excute)){
							$list.='
							<td><?php echo $instance[\''.$instanc->Field.'\']; ?></td>';
							}
							$list.='<td class="text-center">
								<a href="<?php echo \'index.php?page='.$table.'/show&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
								<a href="<?php echo \'index.php?page='.$table.'/edit&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
';
$list.=$close;

$excute = mysqli_query($conn, $sql);



$show.=$open;
$show.='
	<div class="">
		<h2 class="">แสดงข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/list" class="btn btn-primary btn-xs white"><i class="fa fa-list"></i> รายการข้อมูล'.$name.'</a>
			<a href="index.php?page='.$table.'/create" class="btn btn-success btn-xs white"><i class="fa fa-plus-circle"></i>  เพิ่มขอมูล'.$name.'</a>
		</ul>
		<div class="clearfix"></div>
	</div>

	<div class="row">';

			

$show.= '
		<div class="table-responsive">
			<table class="table">
				<tbody>';
				while ($instanc = mysqli_fetch_object($excute)){
					$show.= '
					<tr>
						<th class="text-right" style="width:25%">'.$instanc->Comment.': </th>
						<td>'.'<?php echo $instance[\''.$instanc->Field.'\']; ?>'.'</td>
					</tr>
					';
				}
					$show.= '
					<tr>
						<th style="width:25%"></th>
						<td>
							<a href="<?php echo \'index.php?page='.$table.'/edit&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>" class="btn btn-warning"><i class="far fa-edit"></i> แก้ไขข้อมูล</a>
							<a href="<?php echo \''.$table.'/'.$table.'Delete.php?'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>" class="btn btn-danger" onclick="return confirm(\'คุณต้องการลบข้อมูล หรือไม่?\')"><i class="far fa-trash-alt"></i> ลบข้อมูล</a>
						</td>
					</tr>
					';

		$show.= 		'
				</tbody>
			</table>
		</div>';
			$show.='
	</div>
';
$show.=$close;




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
	header("location:"."../index.php?page='.$table.'/show&'.$id->Column_name.'=".$last_id);
}else{
	echo \'<script>
		alert("เพิ่มข้อมูล'.$name.' ไม่สำเร็จ กรุณาตรวจสอบ!!!");
		window.history.back();
	</script>\';
}
';
$insert.='?>
';


$update='
<?php
include("../connect.php");
';
$c='';
$col = '';
$val = '';
$excute = mysqli_query($conn, $sql);
while ($instanc = mysqli_fetch_object($excute)){
	$col .= $c.$instanc->Field."="."'\".$".$instanc->Field.".\"'";
	$update.='$'.$instanc->Field.' = $_POST[\''.$instanc->Field.'\'];
';
	$c=', ';
}
$update.='
$'.$id->Column_name.' = isset($_GET[\''.$id->Column_name.'\']) ? $_GET[\''.$id->Column_name.'\'] : null;
if ($'.$id->Column_name.'){
	$updateSql = "UPDATE '.$table.' SET '.$col.' WHERE '.$id->Column_name.'=\'".$'.$id->Column_name.'."\'";
	$excute = mysqli_query($conn, $updateSql);
	if ($excute){
		echo \'<script>
			alert("ปรับปรุงข้อมูล'.$name.' สำเร็จ");
			window.location.href = "../index.php?page='.$table.'/show&'.$id->Column_name.'=\'.$'.$id->Column_name.'.\'";
		</script>\';
	}else{
		echo \'<script>
			alert("ปรับปรุงข้อมูล'.$name.' สำเร็จ");
			window.history.back();
		</script>\';
	}
}else{
	echo \'<script>
		alert("ไม่พบข้อมูล สำเร็จ");
		window.history.back();
	</script>\';
}
';
$update.='?>
';


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
			window.location.href = "../index.php?page='.$table.'/list";
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
echo "
".$table."
";

echo "
----------------------------------------------------------------------------------------------------- create.php";
echo $create;

echo "
----------------------------------------------------------------------------------------------------- edit.php";
echo $edit;

echo "
----------------------------------------------------------------------------------------------------- show.php";
echo $show;

echo "
----------------------------------------------------------------------------------------------------- form.php";
echo $form;

echo "
----------------------------------------------------------------------------------------------------- list.php";
echo $list;


echo "
----------------------------------------------------------------------------------------------------- ".$table."Insert.php";
echo $insert;


echo "
----------------------------------------------------------------------------------------------------- ".$table."Update.php";
echo $update;


echo "
----------------------------------------------------------------------------------------------------- ".$table."Delete.php";
echo $delete;

if (isset($_GET['cc'])){

	$mass="";
	if (!mkdir($table, 0777, true)) {
		echo $mass .= (' Failed to create controller folders.');
	}

	$objCreate = fopen($table."/create.php", 'wb');
	$ex = fwrite($objCreate, $create);
	if($objCreate){
		echo  "File Created. => create
		";
		chmod($table."/create.php", 0777);
	}
	else{
		echo  "File Not Create.  => create
		";
	}


	$objCreate = fopen($table."/edit.php", 'wb');
	$ex = fwrite($objCreate, $edit);
	if($objCreate){
		echo  "File Created. => edit
		";
		chmod($table."/edit.php", 0777);
	}
	else{
		echo  "File Not Create.  => edit
		";
	}

	$objCreate = fopen($table."/show.php", 'wb');
	$ex = fwrite($objCreate, $show);
	if($objCreate){
		echo  "File Created. => show
		";
		chmod($table."/show.php", 0777);
	}
	else{
		echo  "File Not Create.  => create
		";
	}

	$objCreate = fopen($table."/form.php", 'wb');
	$ex = fwrite($objCreate, $form);
	if($objCreate){
		echo  "File Created. => form
		";
		chmod($table."/form.php", 0777);
	}
	else{
		echo  "File Not Create.  => form
		";
	}

	$objCreate = fopen($table."/list.php", 'wb');
	$ex = fwrite($objCreate, $list);
	if($objCreate){
		echo  "File Created. => list
		";
		chmod($table."/list.php", 0777);
	}
	else{
		echo  "File Not Create.  => list
		";
	}


	$objCreate = fopen($table."/".$table."Insert.php", 'wb');
	$ex = fwrite($objCreate, $insert);
	if($objCreate){
		echo  "File Created. => Insert
		";
		chmod($table."/".$table."Insert.php", 0777);
	}
	else{
		echo  "File Not Create.  => Insert
		";
	}


	$objCreate = fopen($table."/".$table."Update.php", 'wb');
	$ex = fwrite($objCreate, $update);
	if($objCreate){
		echo  "File Created. => Update
		";
		chmod($table."/".$table."Update.php", 0777);
	}
	else{
		echo  "File Not Create.  => Update
		";
	}

	$objCreate = fopen($table."/".$table."Delete.php", 'wb');
	$ex = fwrite($objCreate, $delete);
	if($objCreate){
		echo  "File Created. => Delete
		";
		chmod($table."/".$table."Delete.php", 0777);
	}
	else{
		echo  "File Not Create.  => Delete
		";
	}
}
//echo $initController;
?>