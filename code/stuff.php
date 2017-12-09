<?php
	$lang = 'EN';
	if($_GET != NULL && array_key_exists('l', $_GET))
		$lang = $_GET['l'];
	include './lang/'.$lang.'.php';
	/*$dbName = $_SERVER["DOCUMENT_ROOT"] . "/topic/stuff/topic.mdb";
	if (!file_exists($dbName)) { die("Could not find database file."); }
	$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=1234;");*/
	/*$db = new PDO('mysql:host=localhost;', "admin", "1234");
	$sql="DROP DATABASE topic";
	$db->exec($sql);
	$sql="CREATE DATABASE topic";
	$db->exec($sql);*/
	if($_SERVER['REMOTE_ADDR'] == "::1") {
		$dbName = $_SERVER["DOCUMENT_ROOT"] . "/topic/stuff/topic.mdb";
		if (!file_exists($dbName)) { die("Could not find database file."); }
		$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=1234;");
	} else
		$db = new PDO('mysql:host=localhost;dbname='.$db_name, "$mysql_username", "$mysql_password");
	/*$sql = "CREATE TABLE users
	(ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), username TEXT, password TEXT, data1 TEXT, data2 TEXT)";
	$db->query($sql);
	$sql = "CREATE TABLE chats
	(ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), people TEXT, posts TEXT, data1 TEXT)";
	$db->query($sql);
	$sql = "CREATE TABLE ads
	(ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), owner TEXT, link TEXT, title TEXT, data1 TEXT, data2 TEXT, data3 TEXT)";
	$db->query($sql);*/
	$sql = "SELECT * FROM users";
	$result = $db->query($sql);
	$users = count($result->fetchAll());
	class User {
		public $ID;
		public $data1;
		public $data2;
		public $username;
		public $password;
		public $email;
		public $firstname;
		public $lastname;
		public $birthdate;
		public $ips;
		public $settings;
		public $settings_keys = array();
		public $pic;
		public $status = array();
		public $friends = array();
		public $vips = array();
		public $friend_requests = array();
		public $blocked = array();
		public $data1_vars;
		public $joindate;
		public $lastonline;
		function build($_ID, $_username, $_password, $_data1, $_data2) {
			$this->ID = $_ID;
			$this->username = $_username;
			$this->password = $_password;
			$this->data1 = $_data1;
			$this->data2 = $_data2;
			$data1_array = explode("{{;}}", $_data1);
			for($i = 0; $i < count($data1_array); $i++) {
				$d1_var = explode("{{:}}", $data1_array[$i]);
				if($d1_var[0] == "email")
					$this->email = $d1_var;
				else if($d1_var[0] == "firstname")
					$this->firstname = $d1_var;
				else if($d1_var[0] == "lastname")
					$this->lastname = $d1_var;
				else if($d1_var[0] == "birthdate")
					$this->birthdate = $d1_var;
				else if($d1_var[0] == "ips")
					$this->ips = $d1_var;
				else if($d1_var[0] == "settings") {
					$settings = array();
					array_push($this->settings_keys, "label_key");
					array_push($settings, "settings");
					for($ii = 1; $ii < count($d1_var); $ii++) {
						$_settings = explode("{{,}}", $d1_var[$ii]);
						array_push($this->settings_keys, $_settings[0]);
						array_push($settings, $_settings);
					}
					$this->settings = array_combine($this->settings_keys, $settings);
				}
				else if($d1_var[0] == "joindate")
					$this->joindate = $d1_var;
				else if($d1_var[0] == "lastonline")
					$this->lastonline = $d1_var;
			}
			$data2_array = explode("{{;}}", $_data2);
			for($i = 0; $i < count($data2_array); $i++) {
				$d2_var = explode("{{:}}", $data2_array[$i]);
				if($d2_var[0] == "status")
					array_push($this->status, $data2_array[$i]);
				else if($d2_var[0] == "friend")
					array_push($this->friends, $data2_array[$i]);
				else if($d2_var[0] == "vip")
					array_push($this->vips, $data2_array[$i]);
				else if($d2_var[0] == "friend_request")
					array_push($this->friend_requests, $data2_array[$i]);
			}
		}
		function create($_username, $_password, $_email) {
			global $db;
			$sql = "SELECT * FROM users";
			$result = $db->query($sql);
			$rows = $result->fetchAll();
			$_ID = 0;
			sort($rows);
			$idok = false;
			$i = 0;
			while(!$idok) {
				if(!array_key_exists($i, $rows) || $rows[$i]['ID'] != $i) {
					$_ID = $i;
					$idok = true;
				} $i++;
			}
			$_data1 = "email{{:}}$_email{{;}}settings{{:}}lang{{,}}EN{{;}}joindate{{:}}".date("Ymd")."{{;}}lastonline{{:}}".date("YmdHis");
			$_data2 = "";
			$this->build($_ID, $_username, $_password, $_data1, $_data2);
			$sql = "INSERT INTO users (ID, username, password, data1)VALUES('$this->ID', '$this->username', '$this->password', '$this->data1')";
			$db->query($sql);
		}
		function addIP($ip) {
			if($this->ips == NULL)
				$this->ips = array('ips');
			array_push($this->ips, $ip);
			$this->updateDB();
		}
		function removeIP($ip) {
			$key = array_keys($this->ips, $ip);
			unset($this->ips[$key[0]]);
			$this->lastonline[1] = date("YmdHis");
			$this->updateDB();
		}
		function updateDB() {
			global $db;
			$this->data1 = "";
			$this->data2 = "";
			$_settings = array();
			array_push($_settings, "settings");
			for($i = 1; $i < count($this->settings); $i++)
				array_push($_settings, implode("{{,}}", $this->settings[$this->settings_keys[$i]]));
			if(count($this->email) > 1) $this->data1 .= implode("{{:}}", $this->email)."{{;}}";
			if(count($this->ips) > 1) $this->data1 .= implode("{{:}}", $this->ips)."{{;}}";
			if(count($this->firstname) > 1) $this->data1 .= implode("{{:}}", $this->firstname)."{{;}}";
			if(count($this->lastname) > 1) $this->data1 .= implode("{{:}}", $this->lastname)."{{;}}";
			if(count($this->birthdate) > 1) $this->data1 .= implode("{{:}}", $this->birthdate)."{{;}}";
			if(count($this->settings) > 1) $this->data1 .= implode("{{:}}", $_settings)."{{;}}";
			$this->data1 .= implode("{{:}}", $this->joindate)."{{;}}";
			$this->data1 .= implode("{{:}}", $this->lastonline)."{{;}}";	
			if(count($this->vips) > 0) $this->data2 .= implode("{{;}}", $this->vips)."{{;}}";	
			if(count($this->friends) > 0) $this->data2 .= implode("{{;}}", $this->friends)."{{;}}";
			if(count($this->friend_requests) > 0) $this->data2 .= implode("{{;}}", $this->friend_requests)."{{;}}";
			if(count($this->status) > 0) $this->data2 .= implode("{{;}}", $this->status)."{{;}}";
			$sql = "UPDATE users SET username='$this->username', password='$this->password', data1='$this->data1', data2='$this->data2' WHERE ID=$this->ID";
			$db->query($sql);
		}
		function getFromId($id) {
			global $db;
			$sql = "SELECT * FROM users WHERE ID=$id";
			$result = $db->query($sql);
			$row = $result->fetchAll();
			$_username = $row[0]['username'];
			$_password = $row[0]['password'];
			$_data1 = $row[0]['data1'];
			$_data2 = $row[0]['data2'];
			$this->build($id, $_username, $_password, $_data1, $_data2);
		}
		function postStatus($what, $who) {
			$when = date("YmdHisu");
			$_var = "status{{:}}$what{{:}}$who{{:}}$when{{:}}{{:}}{{:}}";
			array_push($this->status, $_var);
			$this->updateDB();
		}
		function sendMessage($what, $who) {
			$what = str_replace("'", "&rsquo;", $what);
			global $db;
			$sql = "SELECT posts FROM chats WHERE people='$this->ID{{;}}$who{{;}}'";
			$result = $db->query($sql);
			$posts = $result->fetchAll();
			if($posts == NULL) {
				$sql = "SELECT posts FROM chats WHERE people='$who{{;}}$this->ID{{;}}'";
				$result = $db->query($sql);
				$posts = $result->fetchAll();
				if($posts == NULL) {
					$when = date("YmdHisu");
					$sql = "INSERT INTO chats (people, posts, data1)VALUES('$this->ID{{;}}$who{{;}}', '$this->ID{{:}}$what{{:}}$when{{;}}', '')";
					$db->query($sql);
				} else {
					$_posts = $posts[0][0];
					$when = date("YmdHisu");
					$_posts .= "$this->ID{{:}}$what{{:}}$when{{;}}";
					$sql = "UPDATE chats SET posts='$_posts' WHERE people='$who{{;}}$this->ID{{;}}'";
					$db->query($sql);
				}
			} else {
				$_posts = $posts[0][0];
				$when = date("YmdHisu");
				$_posts .= "$this->ID{{:}}$what{{:}}$when{{;}}";
				$sql = "UPDATE chats SET posts='$_posts' WHERE people='$this->ID{{;}}$who{{;}}'";
				$db->query($sql);
			}
		}
		function updateSettings() {
			if($_POST['old_pw'] != "" && $_POST['new_pw'] != "" && $_POST['new_pw2'] != "" && 
				md5($_POST['old_pw']) == $this->password && $_POST['new_pw'] == $_POST['new_pw2']) {
				$this->password = md5($_POST['new_pw']);
			}
			$this->firstname = array("firstname", $_POST['firstname']);
			$this->lastname = array("lastname", $_POST['lastname']);
			$this->birthdate = array("birthdate", $_POST['birthday'], $_POST['birthmonth'], $_POST['birthyear']);
			$this->settings['lang'][1] =  $_POST['language'];
			$this->updateDB();
		}
		function delac() {
			global $db;
			$sql = "DELETE FROM chats WHERE people LIKE '%{{;}}$this->ID{{;}}'";
			$db->query($sql);
			$sql = "DELETE FROM chats WHERE people LIKE '$this->ID{{;}}%'";
			$db->query($sql);
			$sql = "SELECT ID FROM users";
			$result = $db->query($sql);
			$ids = $result->fetchAll();
			for($i = 0; $i < count($ids); $i++) {
				$id = $ids[$i][0];
				$u = new User();
				$u->getFromId($id);
				$_friends = array();
				$_vips = array();
				$_friend_requests = array();
				for($ii = 0; $ii < count($u->friends); $ii++) {
					if($u->friends[$ii] != "friend{{:}}$this->ID")
						array_push($_friends, $u->friends[$ii]);
				}
				for($ii = 0; $ii < count($u->vips); $ii++) {
					if($u->vips[$ii] != "vip{{:}}$this->ID")
						array_push($_vips, $u->vips[$ii]);
				}
				for($ii = 0; $ii < count($u->friend_requests); $ii++) {
					if($u->friend_requests[$ii] != "friend_request{{:}}$this->ID")
						array_push($_friend_requests, $u->friend_requests[$ii]);
				}
				$u->friends = $_friends;
				$u->vips = $_vips;
				$u->friend_requests = $_friend_requests;
				$u->updateDB();
			}
			$sql = "DELETE FROM ads WHERE owner='$this->ID'";
			$db->query($sql);
			$sql = "DELETE FROM users WHERE ID=$this->ID";
			$db->query($sql);
		}
		function send_frq($who) {
			$_u = new User();
			$_u->getFromId($who);
			array_push($_u->friend_requests, "friend_request{{:}}$this->ID");
			$_u->updateDB();
		}
	}
	class Box {
		public $type = 0;
		public $id;
		public $what;
		public $who;
		public $when;
		public $no;
		public $entry1;
		public $entry2;
		public $entry3;
		public $partner;
		public $likers;
		public $dislikers;
		public $comments;
		public $likes;
		public $iLike = false;
		public $iDislike = false;
		function build_status($_what, $_who, $_when, $comments, $likes, $dislikes, $no) {
			global $me;
			$this->entry1 = "status{{:}}$_what{{:}}";
			$this->entry2 = "{{:}}$_when{{:}}$comments{{:}}$likes,LIKES{{:}}$dislikes";
			$this->entry3 = "{{:}}$_when{{:}}$comments{{:}}$likes{{:}}$dislikes,DISLIKES";
			$this->likers = $likes;
			$this->dislikers = $dislikes;
			if(in_array($me->ID, explode("{{,}}", $this->likers)))
				$this->iLike = true;
			if(in_array($me->ID, explode("{{,}}", $this->dislikers)))
				$this->iDisike = true;
			$this->type = 1;
			$this->what = $_what;
			$u = new User();
			$u->getFromId($_who);
			$this->id = $u->ID;
			$this->who = $u->username;
			$this->comments = explode("{{,}}", $comments);
			for($i = 0; $i < count($this->comments); $i++)
				$this->comments[$i] = explode("{{.}}", $this->comments[$i]);
			$this->likes = count(explode("{{,}}", $this->likers)) - count(explode("{{,}}", $this->dislikers));
			$this->no = $no;
			if(substr($_when, 0, 4) != date('Y')) {
				$this->when = substr($_when, 6, 2).".".substr($_when, 4, 2).".".substr($_when, 0, 4);
			} else if(substr($_when, 4, 2) != date('m') || substr($_when,6, 2) != date('d')) {
				$this->when = substr($_when, 6, 2).".".substr($_when, 4, 2).".";
			} else if(substr($_when, 8, 2) != date('H') || substr($_when, 10, 2) != date('i')) {
				$this->when = substr($_when, 8, 2).":".substr($_when, 10, 2);
			} else {
				$this->when = substr($_when, 8, 2).":".substr($_when, 10, 2).":".substr($_when, 12, 2);
			}
		}
		function build_message($_what, $_who, $_when, $no, $partner) {
			$this->type = 2;
			$this->what = $_what;
			$this->who = $_who;
			$this->partner = $partner;
			$this->no = $no;
			if(substr($_when, 0, 4) != date('Y')) {
				$this->when = substr($_when, 6, 2).".".substr($_when, 4, 2).".".substr($_when, 0, 4);
			} else if(substr($_when, 4, 2) != date('m') || substr($_when,6, 2) != date('d')) {
				$this->when = substr($_when, 6, 2).".".substr($_when, 4, 2).".";
			} else if(substr($_when, 8, 2) != date('H') || substr($_when, 10, 2) != date('i')) {
				$this->when = substr($_when, 8, 2).":".substr($_when, 10, 2);
			} else {
				$this->when = substr($_when, 8, 2).":".substr($_when, 10, 2).":".substr($_when, 12, 2);
			}
		}
		function show() {
			if($this->type == 1) {
				echo"
				<div class='statusBox' style='height:auto;padding-bottom:7px;width:calc(100% - 10px);position:relative;background-color:rgba(255, 255, 255, .3);
					margin:5px;	box-shadow:2px 2px 2px 0px rgba(0, 0, 0, .2);'>
					<p class='bigText' style='font-size:13px;color:rgba(0, 0, 0, .5);margin-bottom:-17px;margin-right:150px;text-shadow:none;text-align:right'>
						".$this->when."&ensp;
					</p>
					";/*if($this->likes != 0) {*/
					echo"<p class='bigText' style='font-size:22px;color:rgba(0, 0, 0, .5);text-shadow:none;text-align:right;margin-bottom:-28px;
						margin-right:10px;'>
						&ensp;";if($this->likes > 0)echo"+";echo $this->likes."
					</p>";/*}*/echo"
					<p class='bigText' style='font-size:32px;color:#066;text-align:left;margin-left:5px;margin-bottom:-2px;'>
						&ensp;".$this->who."
					</p>
					<img src='./other stuff/icon_new.png' width='110px' height='110px' style='margin:5px 10px;'/>
					<div style='display:table;height:110px;margin-top:-115px;margin-left:135px;width:calc(100% - 135px - 40px);'>
					<p class='smallText' style='display:table-cell;vertical-align:middle;padding-top:-20px;'>".$this->what."</p>
					</div>
					<div class='statusHoverDiv' style='height:120px;display:table;margin-top:-120px;width:40px;float:right;'>
						<div style='display:table-cell;vertical-align:middle'>
							<form method='post' action='index.php' id='sl_$this->no' style='";if($this->iLike)echo"display:block;color:green;";echo"'>
								<input type='hidden' name='id'  value='$this->id'/>
								<input type='hidden' name='entry1'  value='$this->entry1'/>
								<input type='hidden' name='entry2'  value='$this->entry2'/>
								<input type='hidden' name='likers'  value='$this->likers'/>
								<!--<button class='transculentButton' type='submit' name='b' value='like' style='";if($this->iLike)echo"color:green;";echo
								"font-size:20px;font-family:\"Wingdings\";margin:0px 2px;float:right;'></button>-->
								<button class='transculentButton' type='submit' name='b' value='like' 
								style='";if($this->iLike)echo"color:green;";echo"float:right;'>
								<img src='./img/like.png' width='30px' height='30px'></img></button>
							</form>
							<form method='post' action='index.php' id='sdl_$this->no' style='";if($this->iDislike)echo"display:block;color:red;";echo"'>
								<input type='hidden' name='id'  value='$this->id'/>
								<input type='hidden' name='entry1'  value='$this->entry1'/>
								<input type='hidden' name='entry2'  value='$this->entry3'/>
								<input type='hidden' name='likes'  value='$this->likes'/>
								<input type='hidden' name='dislikers'  value='$this->dislikers'/>
								<!--<button class='transculentButton' type='submit' name='b' value='dislike' style='";if($this->iDislike)echo"color:red;";echo
								"font-size:20px;font-family:\"Wingdings\";margin:0px 2px;float:right;'></button>-->
								<button class='transculentButton' type='submit' name='b' value='dislike'
								 style='";if($this->iDislike)echo"color:red;";echo"float:right;'>
								<img src='./img/dislike.png' width='30px' height='30px'></img></button>
							</form>
						</div>
						<div stye='display:table-cell;vertical-align:baseline'>
							<button class='transculentButton statusButton' id='ssm_$this->no' type='button' onclick='statusShowMore($this->no);'
							style='font-size:20px;float:right;'>&#9660;</button>
							<button class='transculentButton statusButton' id='ssl_$this->no' type='button' onclick='statusShowLess($this->no);'
							style='font-size:20px;float:right;display:none;'>&#9650;</button>
						</div>
					</div>
					<div id='statusMore_$this->no' style='display:none;'>
						<button class='transculentButton' onclick='whoLiked($this->no)' style='font-family:\"Wingdings\";color:green;'>
						<span style='margin-left:-13px;font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;'>
						".(count(explode("{{,}}", $this->likers))-1)."</span></button>
						<button class='transculentButton' onclick='whoDisliked($this->no)' style='font-family:\"Wingdings\";color:red;'>
						<span style='margin-left:-13px;font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;'>
						".(count(explode("{{,}}", $this->dislikers))-1)."</span></button>
						<div>
							";for($i = 0; $i < count($this->comments); $i++) {
								echo $this->comments[$i][1];echo"<br/>";
							}echo"
						</div>
					</div>
				</div>
				";
			}
			if($this->type == 2) {
				global $me;
				echo"
				<div class='messageBox' style='height:auto;width:auto;min-width:calc(70% - 5px);max-width:75%;padding:3px 0px;position:relative;
				background-color:rgba(255, 255, 255, .3);word-break:break-all;margin:5px;	box-shadow:2px 2px 2px 0px rgba(0, 0, 0, .2);float:";
					if($this->who == $me->ID)echo"right";else echo"left";echo";text-align:";if($this->who == $me->ID)echo"right";else echo"left";echo"'>";
					if($this->who == $me->ID)echo"<form method='get' action='index.php'>
					<input type='hidden' name='c'  value='$this->partner'/>
					<input type='hidden' name='msg'  value='$this->no'/>
					<button class='transculentButton deleteMessageButton' type='submit'
					name='b' value='deleteMsg' style='font-size:15px;margin:0px 10px;float:left;'>x</button>
					</form>";echo"
					<p class='bigText' style='font-size:36px;margin:0px 30px;color:#066;text-shadow:none;'>
						".$this->what."
					</p>";if(count_chars($this->what, 3) != "" && count_chars($this->what, 3) != " ") {echo"
					<p class='bigText' style='font-size:12px;margin:0px 30px;color:rgba(0, 96, 96, .5);text-shadow:none;margin-top:-19px;text-align:";
					if($this->who == $me->ID)echo"left";else echo"right";echo"'>
						".$this->when."
					</p>";
					}echo"
				</div>
				";
			}
		}
	}
	function normalHead() {
		echo"
		<div class='container' id='normalContainer'>
			";normalHeader();echo"
			<div class='main' id='normalMain'>
		";
	} function normalHeader() {
		global $me, $txt;
		if($me->username != "admin") {
			echo"
			<div class='header' id='normalHeader'>
				<div class='contentAreaMaybe'>
					<div class='headerTitleDiv'><a href='index.php' class='headerTitle'><!--&lsquo;topic&rsquo;-->topic</a></div>
					<form method='get' class='headerSearch' name='searchForm'>
						<input type='text' name='s'/>
						<button class='transculentButton' type='submit'>
							<img src='img/search_icon.png' height='17px' width='17px'/>
						</button>
					</form>
					<div class='headerMenu'>
						<ul>
							<li><span>&#9660;</span>
								<ul>
									<li><a href='index.php?u=".$me->ID."'><span>".$me->username."</span></a></li>
									<li><a href='index.php?a=settings'><span>".$txt['settings']."</span></a></li>
									<li><a href='index.php?a=logout'><span>".$txt['log out']."</span></a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>";
		} else {
			echo"
			<div class='header' id='normalHeader'>
				<div class='contentAreaMaybe'>
					<a href='index.php' class='headerTitle' style='position:relative;height:35px;top:5px;margin-left:15px;'>topic - admin</a>
					
					<form method='get' class='headerSearch' name='searchForm' style='margin-top:-25px;'>
						<input type='text' name='s'/>
						<button class='transculentButton' type='submit'>
							<img src='img/search_icon.png' height='17px' width='17px'/>
						</button>
					</form>
					<div class='headerMenu'>
						<ul>
							<li><span>&#9660;</span>
								<ul>
									<li><a href='index.php?u=".$me->ID."'><span>".$me->username."</span></a></li>
									<li><a href='index.php?a=settings'><span>".$txt['settings']."</span></a></li>
									<li><a href='index.php?a=logout'><span>".$txt['log out']."</span></a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>";
		}
	}
?>
