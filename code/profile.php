<?php
	if($_POST != NULL && array_key_exists('who', $_POST) && array_key_exists('a', $_POST) && $_POST['a'] == "accept") {
		array_push($me->friends, "friend{{:}}".$_POST['who']);
		$me->updateDB();
		$_u = new User();
		$_u->getFromId($_POST['who']);
		array_push($_u->friends, "friend{{:}}$me->ID");
		$_u->updateDB();
		$frq = array();
		for($i = 0; $i < count($me->friend_requests); $i++) {
			if($me->friend_requests[$i] != "friend_request{{:}}".$_POST['who']) {
				array_push($frq, $me->friend_requests[$i]);
			}
		}
		$me->friend_requests = $frq;
		$me->updateDB();
		echo"<meta http-equiv='refresh' content='0; URL=index.php?u=".$_POST['who']."'>";
	}
	if($_POST != NULL && array_key_exists('who', $_POST) && array_key_exists('a', $_POST) && $_POST['a'] == "decline") {
		$frq = array();
		for($i = 0; $i < count($me->friend_requests); $i++) {
			if($me->friend_requests[$i] != "friend_request{{:}}".$_POST['who']) {
				array_push($frq, $me->friend_requests[$i]);
			}
		}
		$me->friend_requests = $frq;
		$me->updateDB();
		echo"<meta http-equiv='refresh' content='0; URL=index.php?u=".$_POST['who']."'>";
	}
	$_user = new User();
	$_user->getFromId($_GET['u']);
	normalHead();
	echo"
	<div class='contentAreaDefinetely'n style='text-align:center;'>
		<p style='color:#066;text-align:center;margin-top:50px;
		font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>".
			$_user->firstname[1]." ".$_user->lastname[1]." @".$_user->username."
		</p>";
		if(in_array("friend{{:}}$me->ID", $_user->friends)) {
			echo"<p style='color:#000;text-align:center;margin-top:50px;
				font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>
					friend
				</p>";
		} else if(in_array("vip{{:}}$me->ID", $_user->vips)) {
			echo"<p style='color:#000;text-align:center;margin-top:50px;color:yellow;
				font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>
					VIP
				</p>";
		} else if(in_array("friend_request{{:}}$me->ID", $_user->friend_requests)) {
			echo"<p style='color:#000;text-align:center;margin-top:50px;
				font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>
					friend request sent
				</p>";
		} else if(in_array("friend_request{{:}}$_user->ID", $me->friend_requests)) {
			echo"<p style='color:#000;text-align:center;margin-top:50px;
				font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>
					got friend request
				</p>
				<form method='post'>
				<input type='hidden' name='who' value='$_user->ID'/>
				<button class='transculentButton' name='a' value='accept' type='submit' style='margin-top:50px;font-size:30px;'>
					accept
				</button>
				<button class='transculentButton' name='a' value='decline' type='submit' style='margin-top:50px;font-size:30px;'>
					decline
				</button>
				</form>";
		} else if($_user->ID == $me->ID) {
			echo"<p style='color:#000;text-align:center;margin-top:50px;
				font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;'>
					me
				</p>
				<form method='get' action='index.php#pi'>
					<button class='transculentButton' name='a' value='settings' type='submit' style='margin-top:50px;font-size:30px;'>
						 edit information
					</button>
				</form>";
		} else {
			echo"<form method='post' action='index.php'>
				<button class='transculentButton' name='afrq' value='".$_GET['u']."' type='submit' style='margin-top:50px;font-size:30px;'>
					 send friend request
				</button>
			</form>";
		}
		if($_user->ID != $me->ID) {
			if($_user->ips != NULL) {
				echo"<p style='font-size:100px;color:#0f0;text-shadow:0px 0px 6px rgba(0, 0, 0, 0.4);'><b>.</b></p>";
			}
		}
?>