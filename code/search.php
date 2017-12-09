<?php
	normalHead();
	echo"
	<div class='contentAreaDefinetely'>
		<p class='bigText' style='text-align:left;margin-top:20px;position:relative;'>
			".$_GET['s']."
		</p>";
	$sql = "SELECT * FROM users";
	$result = $db->query($sql);
	$results = $result->fetchAll();
	for($i = 0; $i < count($results); $i++){
		$resUN = $results[$i]['username'];
		$resFN = "";
		$resLN = "";
		$resEM = "";
		$resID = $results[$i]['ID'];
		$resD1 = explode("{{;}}", $results[$i]['data1']);
		for($ii = 0; $ii < count($resD1); $ii++){
			$d1column = explode("{{:}}",$resD1[$ii]);
			if($d1column[0] == "firstname")
				$resFN = $d1column[1];
			else if($d1column[0] == "lastname")
				$resLN = $d1column[1];
			else if($d1column[0] == "email")
				$resEM = $d1column[1];
		}
		$name = $resFN." ".$resLN;
		if(strpos("@".strtolower($resUN), strtolower($_GET['s'])) !== false || strpos(strtolower($resFN." ".$resLN), strtolower($_GET['s'])) !== false
			 || strtolower($resEM) == strtolower($_GET['s'])) {
			echo"
			<div style='height:60px;width:calc(100% - 10px);position:relative;background-color:rgba(255, 255, 255, 0.3);
				margin:5px;";if($i == count($results)-1)echo"margin-bottom:20px;";echo"box-shadow:2px 2px 2px 0px rgba(0, 0, 0, 0.2);text-align:center;'>
				<a class='bigText' style='color:#066;text-decoration:none;' href='index.php?u=".$resID."'>
					".$resFN." ".$resLN."   @".$resUN."
				</a>
			</div>
			";					
		}
	}
?>