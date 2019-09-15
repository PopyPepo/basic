<html ng-app="myApp">
<head>
	<meta charset="utf-8">

	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Dashboard Generate</title>
	<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<script src="angular.min.js"></script>
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
	<script>angular.module("myApp", []).directive('ngConfirmClick', [
	function(){
		return {
			link: function (scope, element, attr) { 
				var msg = attr.ngConfirmClick || "Are you sure?";
				console.log(msg);
				var clickAction = attr.confirmedClick;
				element.bind('click',function (event) {
					if ( window.confirm(msg) ) {
						scope.$eval(clickAction)
					}
				});
			}
		};
}]);</script>
	<script src="generater.js"></script>
	<style type="text/css">
		.no-skin .nav-list>li>a {
			white-space: nowrap;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		body{max-width: 1440px;}
	</style>
</head>
<body ng-controller="generateAll">
<div class="container-fluid mt-5"><div class="row">
	<div class="col-sm-3" style="/*width: 20%;margin-top: 50px;float: left;*/">
		<fieldset class="">
			<legend style="margin: 0;">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-search"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Search ..." ng-model="findTable" autocomplete="off">
				</div>
			</legend>
			<nav>
				<div class="list-group" style="/*margin: 0;*/">
					<!-- <li class="list-group-item {{ table.TABLE_NAME==tableInstance.TABLE_NAME ? 'active' : ''}}" ng-repeat="table in tableList | filter: findTable" class=""> -->
						<a href="javascript:0;" ng-repeat="table in tableList | filter: findTable" 
						class="list-group-item {{ table.TABLE_NAME==tableInstance.TABLE_NAME ? 'active' : ''}}" 
						ng-click="setTable(table);" 
						title='{{ table.TABLE_COMMENT ? table.TABLE_NAME+" ("+table.TABLE_COMMENT+")" : table.TABLE_NAME }}'>
							 {{table.TABLE_NAME}} {{ table.TABLE_COMMENT ? " ("+table.TABLE_COMMENT+")" : "" }}
						</a>
					<!-- </li> -->
				</div>
			</nav>
		</fieldset>
	</div>

	<div class="col-sm-9" style="/*width: 80%;margin-top: 50px;float: left;*/" ng-show="tableInstance">
		<fieldset class="">
			<legend style="margin: 0;">
				{{ tableInstance.TABLE_COMMENT ? tableInstance.TABLE_COMMENT : tableInstance.TABLE_NAME }}
				<small>{{ tableInstance.TABLE_NAME }}</small>
			</legend>
			

			<center ng-show="!foderInstance">
				<button ng-click="createForder(tableInstance);">สร้างโฟลเดอร์ 
					{{ tableInstance.TABLE_NAME }} {{ tableInstance.TABLE_COMMENT ? " ("+tableInstance.TABLE_COMMENT+")" : "" }}
				</button>
			</center>

			<table class="table" ng-show="foderInstance">
				<thead class="text-danger">
					<th>Function</th>
					<th>Filename</th>
					<th>Path</th>
					<th class="text-center"><i class="material-icons">settings</i></th>
					<!-- <th>Salary</th> -->
				</thead>
				<tbody>

					<tr ng-repeat="fileInstance in functioninstance" onmouseover="this.style.background='antiquewhite';" onmouseout="this.style.background='none';"> 
						<td>{{ fileInstance.file.substr(0,fileInstance.file.length-4) }} 
							<!-- {{ tableInstance.TABLE_COMMENT ? tableInstance.TABLE_COMMENT : tableInstance.TABLE_NAME }} -->
							{{ fileInstance.suc }}
						</td>
						<td>{{ fileInstance.file ? tableInstance.TABLE_NAME+fileInstance.file : 'index.php' }}</td>
						<td>

							{ROOT_PROJECT} / {{ tableInstance.TABLE_NAME }} 
							/ {{ fileInstance.file ? tableInstance.TABLE_NAME+fileInstance.file : (fileInstance.path=='i18n' ? 'massages.json' : 'index.php') }}

							<!-- {{ fileInstance.path=='controller' ? tableInstance.TABLE_NAME+fileInstance.file : tableInstance.TABLE_NAME+'/'+(fileInstance.file ? tableInstance.TABLE_NAME+fileInstance.file : 'index.php') }} -->
						</td>
						<td align="center">
							<button type="button" class="btn btn-info btn-xs btn-block" ng-click="createFile(tableInstance, fileInstance);setTable(tableInstance);" ng-show="foderInstance.indexOf(tableInstance.TABLE_NAME+fileInstance.file)===-1">
								Genedate File
							</button>

							<button type="button" class="btn btn-warning btn-xs btn-block" ng-click="mag=!mag;" ng-dblclick="createFile(tableInstance, fileInstance);setTable(tableInstance);mag=false;" ng-show="foderInstance.indexOf(tableInstance.TABLE_NAME+fileInstance.file)!==-1">
								เขียนทับไฟล์เดิม
							</button>
							<small ng-show="mag" class="form-text text-muted">
								<i>ใช้การ <mark><strong>ดับเบิ้ลคลิก</strong></mark> หาต้องการเขียนไฟล์ทับ</i>
							</small>

						</td>
					</tr>

					<!-- <tr ng-repeat="fileInstance in foderInstance">
						<td>{{ fileInstance }}</td>
						<td>{{ fileInstance.file }}</td>
						<td>{{ '{ROOT_PROJECT}/view/'+tableInstance.TABLE_NAME+'/'+fileInstance }}</td>
						<td class="text-center">Oud-Turnhout</td>
					</tr> -->

					<!-- <tr>
						<td>
							<div class="form-group label-floating">
								<label class="control-label">Function</label>
								<select class="form-control" ng-model="filename" ng-options="value.name for value in functioninstance"></select>
							</div>
						</td>
						<td>
							<div class="form-group label-floating">
								<label class="control-label">
									{{ filename.name ? filename.name : 'File name'}}
									{{ filename.file ? ' > '+filename.file : ''}}
								</label>
								<input type="text" ng-model="filename.file" class="form-control">
							</div>
						</td>
						<td>{{ 'ROOT_PROJECT/view/'+tableInstance.TABLE_NAME+'/'+filename.file }}</td>
						<td class="text-center">
							<button class="btn btn-primary btn-sm">Genedate File</button>
						</td>
					</tr> -->
				</tbody>
			</table>

		</fieldset>
	</div>

</div></div>
</body>
</html>
