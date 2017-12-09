<?php
	function admin_show_yourself() {
		global $me, $me2, $txt;
		if($me->username != "admin") {
			echo "
					</div>
				</div>
			</div>
			<div class='footer'>
				<div class='contentAreaMaybe'>
					<a style='text-decoration:none; color:#bbb; font-size:14px; float:left; font-family:Trebuchet MS, Arial, Helvetica, sans-serif;'
					href='index.php?a=advertising'>&nbsp;Advertising</a>
					<a style='text-decoration:none; color:#bbb; font-size:14px; float:left; font-family:Trebuchet MS, Arial, Helvetica, sans-serif;'
					href='index.php?a=imprint'>&emsp;Legal Notice</a>
					<a style='text-decoration:none; color:#bbb; font-size:14px; float:right; font-family:Trebuchet MS, Arial, Helvetica, sans-serif;'
					href='http://www.turtle-enterprises.co.de/' target='_blank'>Turtle Enterprises&nbsp;</a>
				</div>
			</div>
			<div class='container' id='adminContainer' id='adminContent'>
				<div class='header' id='welcomeHeader'>
					<div class='contentAreaDefinetely'>
						<a href='index.php' class='headerTitle' style='position:relative;height:35px;top:5px;margin-left:15px;'>topic</a>&emsp;
						<a href='index.php#adminContent' class='headerTitle' style='position:relative;height:35px;top:5px;margin-left:15px;'>admin</a>
					</div>
				</div>";
		} else {
			echo"
			<div class='container' id='normalContainer' id='adminContent'>";
			normalHeader();
		}
		echo"
			<div class='contentAreaDefinetely'>
				<p class='bigText' style='color:#066;'>
					Greetings, Master!
				</p>
				<p class='bigText' style='float:right;text-align:right;margin-top:-30px;font-size:20px;color:#066;'>
					You were online lastly at";
					$_when = $me->lastonline[1];
					$when = "";
					if(substr($_when, 0, 4) != date('Y')) {
						$when = substr($_when, 6, 2).".".substr($_when, 4, 2).".".substr($_when, 0, 4);
					} else if(substr($_when, 4, 2) != date('m') || substr($_when,6, 2) != date('d')) {
						$when = substr($_when, 6, 2).".".substr($_when, 4, 2).".";
					} else if(substr($_when, 8, 2) != date('H') || substr($_when, 10, 2) != date('i')) {
						$when = substr($_when, 8, 2).":".substr($_when, 10, 2);
					} else {
						$when = substr($_when, 8, 2).":".substr($_when, 10, 2).":".substr($_when, 12, 2);
					}echo" $when
				</p>
				<form action='index.php' method='post' style='text-align:center'>
					<input type='hidden' name='a' value='admin'/>
					<input type='hidden' name='b' value='do'/>
					<input type='text' style='5px;font-size:24px;margin-top:35px;
					width:600px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;' name='c'/>
					</br><br/>
					<button type='submit' class='transculentButton' stye='font-size:24px;'>DO</button>
				</form>
				<form action='index.php' method='post' style='margin-top:50px;text-align:center'>
					<input type='hidden' name='a' value='admin'/>
					<button type='submit' class='transculentButton' name='b' value='testing' stye='font-size:35px;'>¡GOTO TESTING AREA!</button>
				</form>
		";
	}
	function admin_do() {
		if($_POST != NULL) {
			if($_POST['b'] == "do" && ((strpos($_POST['c'], "login_as") !== false) || (strpos($_POST['c'], "login as") !== false))) {
				global $me, $me2, $db;
				$me2 = $me;
				if($me->username != "admin") {
					$me->removeIP($_SERVER['REMOTE_ADDR']);
				}
				$me = NULL;
				$username = substr($_POST['c'], 9);
				$sql = "SELECT * FROM users WHERE username='$username'";
				$result = $db->query($sql);
				$row = $result->fetchAll();
				if($row == NULL && strpos($r_email, '@') !== false) {
					$s = "email{{:}}".$username."{{;}}";
					$sql = "SELECT * FROM users WHERE data1 LIKE '%$s%'";
					$result = $db->query($sql);
					$row = $result->fetchAll();
				} 
				$me = new User();
				$me->build($row[0]['ID'], $row[0]['username'], $row[0]['password'], $row[0]['data1'], $row[0]['data2']);
				$me->addIP($_SERVER['REMOTE_ADDR']);
				echo "<meta http-equiv='refresh'  content='0; URL=index.php'>";
			} else if($_POST['b'] == "do" && strpos($_POST['c'], "SQL") !== false) {
				global $db;
				$sql = substr($_POST['c'], 4);
				$db->query($sql);
			} else if($_POST['b'] == "testing") {
				echo"<meta http-equiv='refresh' content='0; URL=index.php?a=admin&b=testing#adminContent'>";	
			} 
		} else if($_GET['b'] == "testing") {
			include "./code/testing.php";
		}
	}
?>