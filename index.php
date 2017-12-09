<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      	<link href="stuff/style.css" rel="stylesheet" type="text/css" />
        <link rel="icon" href="other stuff/icon_new.png" type="image/png">
       	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="stuff/script.js"></script>
        <script type="text/javascript" src="script/utils.js"></script>
	</head>
    <body>
		<?php
			include './stuff/vars.php';
            include './code/stuff.php';
			include './code/advertising.php';
			include './lang/EN.php';
            $me;
			$me2 = new User();
            $logged_in = false;
			$showFooter = true;
			$normalTitle = true;
			$sql = "SELECT ID FROM users";
			$result = $db->query($sql);
			$ids = $result->fetchAll();
			$sql = "SELECT username FROM users";
			$result = $db->query($sql);
			$usernames = $result->fetchAll();
			for($i = 0; $i < count($ids); $i++) {
				$id = $ids[$i][0];
				$username = $usernames[$i][0];
				$sql = "SELECT data1 FROM users WHERE ID=$id";
				$result = $db->query($sql);
				$data1ses = $result->fetchAll();
				for($ii = 0; $ii < count($data1ses); $ii++){
					$data1row = explode("{{;}}", $data1ses[$ii][0]);
					for($iii = 0; $iii < count($data1row); $iii++){
						$data1column = explode("{{:}}",$data1row[$iii]);
						if($data1column[0] == "ips") {
							for($vi = 1; $vi < count($data1column)+1; $vi++){
								if($data1column[$vi-1] == $_SERVER['REMOTE_ADDR']) {
									if($username == "admin") {
										$me2 = new User();
										$me2->getFromId($id);
									}
									$me = new User();
									$me->getFromId($id);
									$logged_in = true;
									include '/lang/'.$me->settings['lang'][1].'.php';
								}
							}
						}
					}
				}
			}
			if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "advertising") {						//ADVERTISING
				adsInfoPage($logged_in);																			//+
			} else if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "imprint") {					//LEGAL NOTICE
				include "./code/imprint.php";																		//+
			} else if(!$logged_in) {
				if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "crac") {							//ADVERTISING
					echo "<meta http-equiv='refresh' content='0; URL=index.php'>";									//+
				} else {																							//WELCOME
					include './code/welcome.php';																	//*
				}
            } else if($me != NULL) {
				if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "logout") {						//LOGOUT
					$me->removeIP($_SERVER['REMOTE_ADDR']);															//+
					$me = NULL;																						//+
					$logged_in = false;																				//+
					echo "<meta http-equiv='refresh' content='0; URL=index.php'>";									//+
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "statusUpdate") {		//STATUS-UPDATE SUBMISSION
					$me->postStatus($_POST['what'], $_POST['who']);													//*
					echo "<meta http-equiv='refresh' content='0; URL=index.php'>";									//*
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "chatMessageSend") {	//CHAT-MESSAGE SUBMISSION
					$me->sendMessage($_POST['what'], $_GET['c']);													//+
					echo "<meta http-equiv='refresh' content='0; URL=index.php?c=".$_GET['c']."'>";					//+
				} else if($_GET != NULL && array_key_exists('u', $_GET)) {											//SHOW PROFILE PAGE OF SOMEONE
					include './code/profile.php';																	//*
				} else if($_GET != NULL && array_key_exists('a', $_GET)												//SETTINGS
					 && ($_GET['a'] == "settings" || $_GET['a'] == "delac")) {										//+
					include './code/settings.php';																	//+
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "settingsSubmission") {	//SETTINGS - SUBMISSION
					$me->updateSettings();																			//*
					echo "<meta http-equiv='refresh' content='0; URL=index.php?a=settings'>";						//*
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "delac") {				//DELETE ACCOUNT
					echo "<meta http-equiv='refresh' content='0; URL=index.php?a=delac'>";							//+
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "delacYES") {			//+
					$me->delac();																					//+
					echo "<meta http-equiv='refresh' content='0; URL=index.php'>";									//+
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "delacNO") {			//+
					echo "<meta http-equiv='refresh' content='0; URL=index.php?a=settings'>";						//+
				} else if($_POST != NULL && array_key_exists('afrq', $_POST)) {										//FRIEND REQUEST
					$me->send_frq($_POST['afrq']);																	//*
					echo "<meta http-equiv='refresh' content='0; URL=index.php?u=".$_POST['afrq']."'>";				//*
				} else if($_GET != NULL && array_key_exists('s', $_GET) && $_GET['s'] != "") {						//SEARCH
					include './code/search.php';																	//+
				} else if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "advertising") {			//ADVERTISING
					adsInfoPage($logged_in);																		//*
				} else if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "crad") {					//*
					adsCreateBanner(false);																			//*
				} else if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "cradfoe") {				//*
					adsCreateBanner(true);																			//*
				} else if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "cradr") {				//*
					adsCreateIt();																					//*
				} else if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "myads") {					//*
					adsManager();																					//*
				} 
				
				else if($me->username != "admin") {																	//HOME
					$aiscextra = "&a=c";
					$aishextra = "";
					if($_GET != NULL && array_key_exists('c', $_GET) && !(array_key_exists('a', $_GET) && $_GET['a'] == "h")) {
						$aiscextra = "";
						$aishextra = "?c=".$_GET['c']."&a=h";
					}
					echo"
					<div class='container' id='homeContainer'>
						";normalHeader();echo"
						<div class='main' id='homeMain'>
							<div class='contentAreaMaybe'>
								<div id='homeList'>";
										$sql = "SELECT ID FROM ads WHERE owner='$me->ID'";
										$result = $db->query($sql);
										$ids = $result->fetchAll();
										if($ids != NULL)echo"
										<div style='width:100%;height:60px;text-align:center;box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);'>
											<a class='bigText' style='text-decoration:none;' href='index.php?a=myads'>Ad Manager</a>
										</div>";echo"
										<div style='width:100%;height:60px;text-align:center;box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);'>
											<a class='bigText' style='text-decoration:none;' href='index.php".$aishextra."'>Home</a>
										</div>
										<div style='width:100%;height:calc(100% - 60px"
										;if($ids != NULL)echo" - 60px";echo");overflow-y:auto;overflow-x:hidden;'>";
										$sql = "SELECT data2 FROM users WHERE ID=".$me->ID;
										$result = $db->query($sql);
										$data2ses = $result->fetchAll();
										for($i = 0; $i < count($data2ses); $i++){
											$data2row = explode("{{;}}", $data2ses[$i][0]);
											for($ii = 0; $ii < count($data2row); $ii++){
												$data2column = explode("{{:}}",$data2row[$ii]);
												if($data2column[0] == "friend") {
													$u = new User();
													$u->getFromId($data2column[1]);
													echo"
													<div style='width:100%;text-align:center;box-shadow:0px 1px 0px 0px rgba(0,0,0,0.075);'>
														<a class='bigText' style='text-decoration:none;' href='index.php?c=".$u->ID.$aiscextra."'>"
															.$u->username."
														</a>
														<a class='bigText' style='text-decoration:none;float:right;margin-right:4px;'
														 href='index.php?u=".$u->ID."'>&gt;</a>
													</div>";
												}
												if($data2column[0] == "vip") {
													$u = new User();
													$u->getFromId($data2column[1]);
													echo"
													<div style='width:100%;text-align:center;box-shadow:0px 1px 0px 0px rgba(0,0,0,0.075);'>
														<a class='bigText' style='color:#ffa;text-decoration:none;' href='index.php?c=".$u->ID.$aiscextra."'>
															".$u->username."
														</a>
														<a class='bigText' style='text-decoration:none;float:right;margin-right:4px;' 
														href='index.php?u=".$u->ID."'>&gt;</a>
													</div>";
												}
											}
										}show_ad(1);echo"
									</div>
								</div>
								<div id='homeAction'>
									<div id='homeActionCard'";if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "h")echo" class='flipped'";echo">
										<div class='front' style='overflow:auto;'>";
											include "./code/home.php"; echo"
										</div>
										<div class='back'>
												";
												if($_GET != NULL && array_key_exists('c', $_GET) && array_key_exists('a', $_GET) && $_GET['a'] == "c") {
													echo"<script>openChat(true);</script>";
												} if($_GET != NULL && array_key_exists('c', $_GET)) {
													if(array_key_exists('b', $_GET) && $_GET['b'] == "deleteMsg") {
														$sql = "SELECT people FROM chats";
														$result = $db->query($sql);
														$people = $result->fetchAll();
														$userMe = false;
														$userOther = false;
														$i = 0;
														for($i = 0; $i < count($people); $i++){
															$people_row = explode("{{;}}", $people[$i][0]);
															for($ii = 0; $ii < count($people_row); $ii++){
																if($people_row[$ii] == $me->ID)
																	$userMe = true;
																else if($people_row[$ii] == $_GET['c'])
																	$userOther = true;
																if($userMe && $userOther)
																	break;
															}
															if(!($userMe == true && $userOther == true)) {
																$userMe = false;
																$userOther = false;
															}
															else
																break;
														}
														if($userMe == true && $userOther == true) {
															$sql = "SELECT posts FROM chats";
															$result = $db->query($sql);
															$posts = $result->fetchAll();
															$posts_row = explode("{{;}}", $posts[$i][0]);
															$posts_row2 = "";
															for($ii = 0; $ii < count($posts_row)-1; $ii++){
																if($ii != $_GET['msg'])
																	$posts_row2 .= $posts_row[$ii]."{{;}}";
															}
															$sql = "SELECT ID FROM chats";
															$result = $db->query($sql);
															$ids = $result->fetchAll();
															$id = $ids[$i][0];
															$sql = "UPDATE chats SET posts='$posts_row2' WHERE ID=$id";
															$db->query($sql);
														}
														echo"<meta http-equiv='refresh' content='0; URL=index.php?c=".$_GET['c']."'>";
													} else if(array_key_exists('b', $_GET) && $_GET['b'] == "block") {
														$sql = "SELECT people FROM chats";
														$result = $db->query($sql);
														$people = $result->fetchAll();
														$userMe = false;
														$userOther = false;
														$i = 0;
														for($i = 0; $i < count($people); $i++){
															$people_row = explode("{{;}}", $people[$i][0]);
															for($ii = 0; $ii < count($people_row); $ii++){
																if($people_row[$ii] == $me->ID)
																	$userMe = true;
																else if($people_row[$ii] == $_GET['c'])
																	$userOther = true;
																if($userMe && $userOther)
																	break;
															}
															if(!($userMe == true && $userOther == true)) {
																$userMe = false;
																$userOther = false;
															}
															else
																break;
														}
														if($userMe == true && $userOther == true) {
															$sql = "SELECT data1 FROM chats";
															$result = $db->query($sql);
															$data1ses = $result->fetchAll();
															$data1_row = explode("{{;}}", $data1ses[$i][0]);
															array_push($data1_row, "block{{:}}$me->ID{{:}}".$_GET['c']);
															$data1 = "";
															if(count($data1_row) > 0)$data1 = implode("{{;}}", $data1_row);
															$sql = "SELECT ID FROM chats";
															$result = $db->query($sql);
															$ids = $result->fetchAll();
															$id = $ids[$i][0];
															$sql = "UPDATE chats SET data1='$data1' WHERE ID=$id";
															$db->query($sql);
														}
														echo"<meta http-equiv='refresh' content='0; URL=index.php?c=".$_GET['c']."'>";
													} else if(array_key_exists('b', $_GET) && $_GET['b'] == "unblock") {
														$sql = "SELECT people FROM chats";
														$result = $db->query($sql);
														$people = $result->fetchAll();
														$userMe = false;
														$userOther = false;
														$i = 0;
														for($i = 0; $i < count($people); $i++){
															$people_row = explode("{{;}}", $people[$i][0]);
															for($ii = 0; $ii < count($people_row); $ii++){
																if($people_row[$ii] == $me->ID)
																	$userMe = true;
																else if($people_row[$ii] == $_GET['c'])
																	$userOther = true;
																if($userMe && $userOther)
																	break;
															}
															if(!($userMe == true && $userOther == true)) {
																$userMe = false;
																$userOther = false;
															}
															else
																break;
														}
														if($userMe == true && $userOther == true) {
															$sql = "SELECT data1 FROM chats";
															$result = $db->query($sql);
															$data1ses = $result->fetchAll();
															$data1_row = explode("{{;}}", $data1ses[$i][0]);
															$data1_row2 = "";
															for($ii = 0; $ii < count($data1_row); $ii++){
																$data1column = explode("{{:}}", $data1_row[$ii]);
																if(!($data1column[0] == "block" && $data1column[1] == $me->ID && $data1column[2] == $_GET['c']))
																	$data1_row2 .= $data1_row[$ii]."{{;}}";
															}
															if($data1_row2 == "{{;}}")$data1_row2 = "";
															$sql = "SELECT ID FROM chats";
															$result = $db->query($sql);
															$ids = $result->fetchAll();
															$id = $ids[$i][0];
															$sql = "UPDATE chats SET data1='$data1_row2' WHERE ID=$id";
															$db->query($sql);
														}
														echo"<meta http-equiv='refresh' content='0; URL=index.php?c=".$_GET['c']."'>";
													}
													$sql = "SELECT people FROM chats";
													$result = $db->query($sql);
													$people = $result->fetchAll();
													$userMe = false;
													$userOther = false;
													$i = 0;
													for($i = 0; $i < count($people); $i++){
														$people_row = explode("{{;}}", $people[$i][0]);
														for($ii = 0; $ii < count($people_row); $ii++){
															if($people_row[$ii] == $me->ID)
																$userMe = true;
															else if($people_row[$ii] == $_GET['c'])
																$userOther = true;
															if($userMe && $userOther)
																break;
														}
														if(!($userMe == true && $userOther == true)) {
															$userMe = false;
															$userOther = false;
														}
														else
															break;
													}
													if($userMe == true && $userOther == true) {
														$sql = "SELECT data1 FROM chats";
														$result = $db->query($sql);
														$data1ses = $result->fetchAll();
														$data1_row = explode("{{;}}", $data1ses[$i][0]);
														$blocked = false;
														for($ii = 0; $ii < count($data1_row); $ii++){
															if($data1_row[$ii] == "block{{:}}$me->ID{{:}}".$_GET['c'])
																$blocked = true;
														}
														echo"
														<div style='height:40px;width:100%;display:table;position:relative;
														box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);padding-bottom:3px;'>
															<p class='bigText' style='font-size:30px;text-shadow:none;color:#066;'>
															";$u = new User();
															$u->getFromId($_GET['c']);
															echo"&emsp;$u->username
															</p>
															<form method='get' action='index.php'>
																<input type='hidden' name='c' value='".$_GET['c']."'/>
																<input type='hidden' name='who' value='$me->ID'/>
																<button class='transculentButton' type='submit' name='b' value='";
																if($blocked)echo"unblock";else echo"block";echo"' 
																style='font-size:28px;float:right;margin-top:-36px;margin-right:20px;'>
																";if($blocked)echo"unblock";else echo"block";echo"</button>
															</form>
														</div>
														<div style='height:calc(100% - 78px); id='homeChat'>";
														if(!$blocked) {
															$sql = "SELECT posts FROM chats";
															$result = $db->query($sql);
															$posts = $result->fetchAll();
															$posts_row = explode("{{;}}", $posts[$i][0]);
															for($ii = 0; $ii < count($posts_row); $ii++){
																$m = "";
																$p = $_GET['c'];
																$u = 0;
																$t = "";
																$posts_column = explode("{{:}}", $posts_row[$ii]);
																if(count($posts_column) == 3) {
																	$m = $posts_column[1];	
																	$u = $posts_column[0];
																	$t = $posts_column[2];
																	$message_post = new Box();
																	$message_post->build_message($m, $u, $t, $ii, $p);
																	$message_post->show();
																}
															}
														}
													} else {
														echo"
														<div style='height:40px;width:100%;display:table;position:relative;
														box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);padding-bottom:3px;'>
															<p class='bigText' style='font-size:30px;text-shadow:none;color:#066;'>
																";$u = new User();
																$u->getFromId($_GET['c']);
																echo"&emsp;$u->username
															</p>
															<form method='get' action='index.php'>
																<input type='hidden' name='c' value='".$_GET['c']."'/>
																<input type='hidden' name='who' value='$me->ID'/>
																<button class='transculentButton' type='submit' name='b' value='block'
																 style='font-size:28px;float:right;margin-top:-36px;margin-right:20px;'>
																block</button>
															</form>
														</div>
														<div style='height:calc(100% - 76px); id='homeChat'>";
													}
													echo"
													</div>
													<form method='post' id='homeChatMessageForm' name='homeChatMessageForm' autocomplete='off'>
														<div style='height:30px;width:100%;display:table;position:relative;
														box-shadow:0px -2px 3px 0px rgba(0,0,0,0.1);padding-bottom:3px;'>
															<input type='hidden' name='a' value='chatMessageSend'/>
															<!--<textarea id='homeChatMessageText' name='what' rows='2'
															style='font-family:Arial, Helvetica, sans-serif;resize:none;position:relative;
															display:table-cell;width:calc(85% - 6px);margin:1px 3px;vertical-align:top;
															height:40px;margin-top:5px;background-color:rgba(255, 255, 255, 0.3);border:none;
															box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'></textarea>-->
															<input type='text' id='homeChatMessageText' name='what'
															style='font-family:Arial, Helvetica, sans-serif;resize:none;position:relative;
															display:table-cell;width:calc(85% - 6px);margin:1px 3px;vertical-align:top;
															height:20px;margin-top:5px;background-color:rgba(255, 255, 255, 0.3);border:none;
															box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'></textarea>
															<button class='transculentButton' type='submit'
															style='display:table-cell;width:calc(15% - 6px);vertical-align:top;margin:1px 3px;height:28px;
															float:right;font-size:18px;margin-top:-28px;'>".$txt['send']."</button>
														</div>
													</form>";
												}
												echo"
										</div>
									</div>
								</div>
								<script>focusMessage()</script>
					";
					if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "h")
						echo"<script>closeChat()</script>";
					if($_GET != NULL && !array_key_exists('a', $_GET) && array_key_exists('c', $_GET))
						echo"<script>openChat(false);</script>";
				} else if($me->username == "admin") {
					include "./code/admin.php";
					if(($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "admin") || 
					   ($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "admin"))
						admin_do();
					else
						admin_show_yourself();
				} 
				if($me2->username == "admin" && $me->username != "admin") {
					include "./code/admin.php";
					if(($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "admin") || 
					   ($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "admin"))
						admin_do();
					else
						admin_show_yourself();
				}
            }
			if($showFooter) {
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
				";
			} if($normalTitle) {
				echo"
				<head>
					<title>
						topic
					</title>
				</head>
				";
			}
		?>
  	</body>
</html>