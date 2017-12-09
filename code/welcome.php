<?php
	$ready = false;
	$log_in = true;
	$username = "";
	$password = "";
	$li_username = "";
	$li_username_ph = "";
	$li_password = "";
	$li_password_ph = "";
	$r_username = "";
	$r_username_ph = "";
	$r_password = "";
	$r_password_ph = "";
	$r_password2 = "";
	$r_password2_ph = "";
	$r_email = "";
	$r_email_ph = "";
	$reg_ver_code = "";
	$adminLogin = false;
	$usedMail = false;
	if(array_key_exists('a', $_POST) && $_POST['a'] == "login") {
		$li_username = $_POST['username'];
		$li_password = $_POST['password'];
		$sql = "SELECT password FROM users WHERE username='$li_username'";
		$result = $db->query($sql);
		$row = $result->fetchAll();
		if($row == NULL) {
			$s = "email{{:}}".$li_username."{{;}}";
			$sql = "SELECT password FROM users WHERE data1 LIKE '%$s%'";
			$result = $db->query($sql);
			$row = $result->fetchAll();
			if($row == NULL || strpos($r_email, '@') !== false) {
				$li_username = "";
				$li_password = "";
				$li_username_ph = "Wrong Username!";
			} else
				$usedMail = true;
		} else if(md5($li_password) != $row[0]['password']) {
			$li_password = "";
			$li_password_ph = "Wrong Password!";
		}
		if($li_username != "" && $li_password != "") {
			$ready = true;
			$password = md5($li_password);
			if(!$usedMail)
				$username = $li_username;
			else {
				$s = "email{{:}}".$li_username."{{;}}";
				$sql = "SELECT username FROM users WHERE data1 LIKE '%$s%'";
				$result = $db->query($sql);
				$row = $result->fetchAll();
				if($row != NULL)
					$username = $row[0]['username'];
				else
					$username = $li_username;
			}
		}
	} else if(array_key_exists('a', $_POST) && $_POST['a'] == "register1") {
		$r_username = $_POST['username'];
		$r_email = $_POST['email'];
		$r_password = $_POST['password'];
		$r_password2 = $_POST['password2'];
		if($r_password2 != $r_password) {
			$r_password2 = "";
			$r_password2_ph = "Not the same Password!";
		}
		if(!strpos($r_email, '@') && $r_email != "") {
			$r_email = "";
			$r_email_ph = "Not real!";
		}
		if(strpos($r_username, ' ') !== false) {
			$r_username = "";
			$r_username_ph = "One Word!";
		}
		$sql = "SELECT * FROM users WHERE username='$r_username'";
		$result = $db->query($sql);
		$row = $result->fetchAll();
		if($row != NULL) {
			$r_username = "";
			$r_username_ph = "Already registered!";
		}
		$s = "email{{:}}".$r_email."{{;}}";
		$sql = "SELECT * FROM users WHERE data1 LIKE '%$s%'";
		$result = $db->query($sql);
		$row = $result->fetchAll();
		if($row != NULL) {
			$r_email = "";
			$r_email_ph = "Already registered!";
		}
		/*if($r_year < (date("Y")-110) || $r_year > (date("Y")-12))
		$r_year = 0;*/
		if($r_username != "" && $r_email != "" && $r_password != "" && $r_password2 != "") {
			$ready = true;
			$username = $r_username;
			$password = md5($r_password);
		}
		if($ready) {
			$ready = false;
			$log_in = false;
			$length = 5;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$reg_ver_code = '';
			for ($i = 0; $i < $length; $i++) {
				$reg_ver_code .= $characters[rand(0, strlen($characters) - 1)];
			}
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'To: '.$username.' <'.$r_email.'>' . "\r\n";
			$headers .= 'From: topic <postmaster@localhost>' . "\r\n";
			mail($r_email, "topic Registration Verification", 
			"<html>
				<head>
					<title>topic Registration Verification</title>
				</head>
				<body style='background-color:#FFA200;'>
					<div style='text-align:center;'>
						<p style='color:#066;text-align:center;position:relative;top:50px;
								  font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>".
							"@$username<br/><br/>Your Code is:<br/>".$reg_ver_code."<br/><br/>Sincerely,<br/>Onno Eberhard, topic
						</p>
					</div>
				</body>
			</html>"
			, $headers);
			echo"
			<div class='container' id='regVerContainer'>
				<div class='header' id='regVerHeader'>
					<div class='contentAreaDefinetely'>
						<div class='headerTitleDiv'><a href='index.php' class='headerTitle'>topic</a></div>
					</div>
				</div>
				<div class='main' id='regVerMain'>
					<div class='contentAreaDefinetely'>
						<form method='post' style='text-align:center;'>
							<input type='hidden' name='username' value='$username'/>
							<input type='hidden' name='reg_ver_code' value='$reg_ver_code'/>
							<input type='hidden' name='r_email' value='$r_email'/>
							<input type='hidden' name='password' value='$password'/><br/><br/><br/>
							<h1>$username</h1><br/>
							<p>Please enter the Code we sent you to $r_email ($reg_ver_code):</p><br/>
							<input type='text' name='regVerCode'/><br/><br/>
							<button type='submit' class='transculentButton' name='a' value='register2verify'>"."Verify"."</button>&ensp;
							<button type='submit' class='transculentButton' name='a' value='register2cancel')'>"."Cancel"."</button>
						</form>
			";
		}
	} else if(array_key_exists('a', $_POST) && $_POST['a'] == "register2verify") {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$r_email = $_POST['r_email'];
		$reg_ver_code = $_POST['reg_ver_code'];
		if($_POST['regVerCode'] == $reg_ver_code) {
			$newUser = new User();
			$newUser->create($username, $password, $r_email);
			$ready = true;
			$log_in = true;
		} else {
			$ready = false;
			$log_in = false;
			echo"
			<div class='container' id='regVerContainer'>
				<div class='header' id='regVerHeader'>
					<div class='contentAreaDefinetely'>
						<div class='headerTitleDiv'><a href='index.php' class='headerTitle'>&bdquo;topic&ldquo;</a></div>
					</div>
				</div>
				<div class='main' id='regVerMain'>
					<div class='contentAreaDefinetely'>
						<form method='post' style='text-align:center;'>
							<input type='hidden' name='username' value='$username'/>
							<input type='hidden' name='reg_ver_code' value='$reg_ver_code'/>
							<input type='hidden' name='r_email' value='$r_email'/>
							<input type='hidden' name='password' value='$password'/><br/><br/><br/>
							<h1>$username</h1><br/>
							<p>Please enter the Code we sent you to $r_email:</p><br/>
							<input type='text' name='regVerCode' style='border-style:solid;border-color:red;border-width:2px;' placeholder='Wrong Code!'/><br/>
							<br/><button type='submit' class='transculentButton' name='a' value='register2verify'>"."Verify"."</button>&ensp;
							<button type='submit' class='transculentButton' name='a' value='register2cancel')'>"."Cancel"."</button>
						</form>
			";
		}
	} else if(array_key_exists('a', $_POST) && $_POST['a'] == "register2cancel") {
		echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
	} else if(array_key_exists('a', $_POST) && $_POST['a'] == "adminLogin") {
		if($_POST['b'] == "okay")
			echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
		if($_POST['b'] == "goon") {
			if($_POST['c'] == "fuck you") {
				$ready = true;
				$log_in = true;
				$adminLogin = true;
				$username = "admin";
			} else {
				$ready = true;
				$log_in = true;
				$username = "admin";
			}
		}
	}
	if(!$ready && $log_in) {
		echo"
		<div class='container' id='welcomeContainer'>
			<div class='header' id='welcomeHeader'>
				<div class='contentAreaDefinetely'>
					<div class='headerTitleDiv'><a href='index.php' class='headerTitle'>topic</a></div>
				</div>
			</div>
			<div class='main' id='welcomeMain'>
				<div class='contentAreaDefinetely'>
					<div id='welcomeLogIn'>
						<form method='post'>
							<input type='hidden' name='a' value='login'/>
							<p>".$txt['username'].":</p>
							<input type='text' name='username' value='$li_username' placeholder='$li_username_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "login" && $li_username == ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/>
							<p>".$txt['password'].":</p>
							<input type='password' name='password' value='$li_password' placeholder='$li_password_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "login" && $li_password == "" && $li_username != ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/><br /><br />
							<button type='submit' class='transculentButton'>".$txt['log in']."</button>&ensp;
						</form>
					</div>
					<div id='welcomeRegister'>
						<form method='post' autocomplete='off'>
							<input type='hidden' name='a' value='register1'/>".
							"<p>".$txt['username'].":</p>&ensp;
							<input type='text' name='username' value='$r_username' placeholder='$r_username_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "register1" && $r_username == ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/>
							<p>".$txt['email'].":</p>&ensp;
							<input type='email' name='email' value='$r_email' placeholder='$r_email_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "register1" && $r_email == ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/>
							<p>".$txt['password'].":</p>&ensp;
							<input type='password' name='password' value='$r_password' placeholder='$r_password_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "register1" && $r_password == ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/>&ensp;<input type='password' name='password2' value='$r_password2' placeholder='$r_password2_ph'";
							if(array_key_exists('a', $_POST) && $_POST['a'] == "register1" && $r_password2 == "" && $r_password != ""){
								echo "style='border-style:solid;border-color:red;border-width:2px;'";
							}echo"/><br /><br />
							&ensp;<button type='submit' class='transculentButton'>".$txt['register']."</button>
						</form>
					</div>
		";
	} else if($log_in) {
		if($username == "admin" && !$adminLogin && $_SERVER['REMOTE_ADDR'] != "::1") {
			echo"
			<div class='container' id='welcomeContainer'>
				<div class='header' id='welcomeHeader'>
					<div class='contentAreaDefinetely'>
						<div class='headerTitleDiv'><p class='headerTitle'>topic</a></div>
					</div>
				</div>
				<div class='main' id='welcomeMain'>
					<div class='contentAreaDefinetely'>
						<form action='index.php' method='post' style='text-align:center;margin-top:100px;'>
							<h1 style='color:#066;' class='bigText'>
								I don't believe you!
							</h1><br/>
							<input type='password' name='c'/><br/>
							<input type='hidden' name='a' value='adminLogin'/><br/><br/>
							<button type='submit' class='transculentButton' name='b' value='goon'>What d'ya say now?</button>&ensp;
							<button type='submit' class='transculentButton' name='b' value='okay'>You're right and I apologize. I'm a moron.</button>
						</form>
				";
		} else {
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
		}
	}
?>
