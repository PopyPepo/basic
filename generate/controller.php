<?php 
include("../connect.php");
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$action = isset($_GET['action']) ? $_GET['action'] : null;

$json = array();
$c="";
$mass="";
$col = "";	$val = "";	$c="";

switch ($action) {

	case 'show_table':
		$sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = '".$database."'";
		$query = mysqli_query($conn, $sql);

		while ($instance=mysqli_fetch_assoc($query)) {	/*$json.=$c;
			$json.= json_encode($instance);
			$c=',';*/

			$json['instance'][] = $instance;
		}
	break;

	case 'getFoderInstance':
		//$file = "../view/Layout";
		$foder = "../".$_GET['forderName'];
		if (is_dir($foder)){
			$json['message']="yes";
			if ($handle = opendir($foder)) {
				while (false !== ($entry = readdir($handle))) {
					if (strlen($entry)>5){ 
						$entry = $entry=="form.php" ? $_GET['forderName'].$entry : $entry;
						$json['instance'][] = $entry;
					}
				}
				closedir($handle);
			}

			$file = ($_GET['forderName']);
			// if (file_exists($foder."/".$file."Controller.js")){ 
			// 	// $json.=$c; 
			// 	// $json.=json_encode($file."Controller.js"); 
			// 	// $c=",";
			// 	$json['instance'][]=$file."Controller.js";
			// }

			// if (file_exists($foder."/".$file."Controller.php")){ 
			// 	// $json.=$c; 
			// 	// $json.=json_encode($file."Controller.php"); 
			// 	// $c=",";
			// 	$json['instance'][]=$file."Controller.php";
			// }
			// $json.=$c;
			$json['instance'][] = "1";
		}else{
			$json['message']="no";
		}

	break;

	case 'createForder':
		$foder = "../".$_GET['forderName'];
		//$message = "Success";
		if (!mkdir($foder, 0777, true)) {
			$mass .= ('Failed to create view folders.');
			chmod($foder, 0777);
		}else{
			// $foder = "../".$_GET['forderName']."/controller";
			// //$message = "Success";
			// if (!mkdir($foder, 0777, true)) {
			// 	$mass .= (' Failed to create controller folders.');
			// }

			// $foder = "../app/".$_GET['forderName']."/i18n";
			// //$message = "Success";
			// if (!mkdir($foder, 0777, true)) {
			// 	$mass .= (' Failed to create i18n folders.');
			// }

			// $foder = "../app/".$_GET['forderName']."/model";
			// //$message = "Success";
			// if (!mkdir($foder, 0777, true)) {
			// 	$mass .= (' Failed to create model folders.');
			// }

			// $foder = "../app/".$_GET['forderName']."/view";
			// //$message = "Success";
			// if (!mkdir($foder, 0777, true)) {
			// 	$mass .= (' Failed to create view folders.');
			// }
		}

		
	break;

	case 'createFile':	// $json['params'] = $_GET;
		/*$table = isset($_GET['forderName']) ? $_GET['forderName'] : 'rs_live';
		$foder = $_GET['type']=='view' ? "../view/".$table : "../".$_GET['type'];
		$type = $_GET['type'];
		$file = $_GET['file'];
		$filname = $file.($_GET['type']=='taglib' ? '.js' : '.php');
		$objCreate = fopen($foder.'/'.$filname, 'wb');

		include("generater.php");

		$ex = fwrite($objCreate, $html);
		if($objCreate){
			$json['message'] = "File Created.";
		}
		else{
			$json['message'] = "File Not Create.";
		}
		fclose($objCreate);*/

		// $json = $_POST;

		$table = $_POST['table'];
		$files = $_POST['files'];
		$functionFile = $files['file'];
		
		$filname = "../".$table['TABLE_NAME']."/";

		if ($files['file']=='form.php'){
			$filname .= $files['file'];
		}else{
			$filname .= $table['TABLE_NAME'].$files['file'];
		}

		$functionName = str_replace(".php", "", $functionFile);

		$functionName = $functionName=="List" ? "x".$functionName : $functionName;
		$functionFile = $functionName=="xList" ? "x".$functionFile : $functionFile;

		include("generateFile/".$functionFile);
		$table['database'] = $database;
		$html = $functionName($conn, $table, $files);

		$objCreate = fopen($filname, 'wb');
		$ex = fwrite($objCreate, $html);
		if($objCreate){
			$json['message'] = "File Created.";
		}
		else{
			$json['message'] = "File Not Create.";
		}
		fclose($objCreate);
		chmod($filname, 0777);

		// $json['html'] = $html;
		$json['filname'] = $filname;
		$json['functionName'] = $functionName;
		$json['functionFile'] = $functionFile;

		// $json['functionName'] = $functionName;
		// $json['result'] = $html;
	break;
}
	
mysqli_close($conn);
echo json_encode($json);
?>