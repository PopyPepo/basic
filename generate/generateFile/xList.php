<?php 
function xList($conn, $tableIns, $fileIns){
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

$excute = mysqli_query($conn, $sql);

$list.=$open;
$list.='
	<div class="">
		<h2 class="float-left">รายการข้อมูล'.$name.'</h2>

		<ul class="btn-group float-right">
			<a href="index.php" class="btn btn-warning btn-xs white"><i class="fa fa-home"></i> หน้าแรก</a>
			<a href="index.php?page='.$table.'/'.$table.'Create" class="btn btn-success btn-xs white"><i class="fa fa-plus-circle"></i>  เพิ่มขอมูล'.$name.'</a>
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
								<a href="<?php echo \'index.php?page='.$table.'/'.$table.'Show&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
								<a href="<?php echo \'index.php?page='.$table.'/'.$table.'Edit&'.$id->Column_name.'=\'.$instance[\''.$id->Column_name.'\']; ?>/" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
';
$list.=$close;

	return $list;
}
//echo $initController;
?>