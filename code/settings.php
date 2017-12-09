<?php
	normalHead();
	if($_GET != NULL && array_key_exists('a', $_GET) && $_GET['a'] == "delac") {
		echo"
		<div class='contentAreaDefinetely'>
			<form method='post' action='index.php' style='text-align:center; margin-top:100px;'>
				<h1 style='color:#066;text-align:center;position:relative;font-family:\"Trebuchet MS\", Arial, sans-serif;font-size:48px;font-weight:normal;'>
					".$txt['delac']."
				</h1><br/>
				<p style='color:#333;font-weight:normal;text-shadow:1px 1px 1px rgba(255, 255, 255, 0.2);
				font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;font-size:15px;'>".$txt['reallydelac']."</p><br/>
				<br/><button type='submit' class='transculentButton' name='a' value='delacYES'>".$txt['delete']."</button>&ensp;
				<button type='submit' class='transculentButton' name='a' value='delacNO')'>".$txt['cancel']."</button>
			</form>";
	}
	else {
		echo"
		<form name='settings_form' method='post' action='index.php'>
			<input type='hidden' name='a' value='settingsSubmission'/>
			<div class='contentAreaDefinetely'>
				<p class='bigText' style='text-align:left;margin-top:20px;margin-left:7px;position:relative;width:0;'>
					".$txt['settings']."
				</p>
				<button class='transculentButton' type='submit' style='float:right;margin-top:-60px;margin-right:20px;font-size:48px;'>
					".$txt['save']."
				</button>
				<div style='width:calc(100% - 60px);position:relative;margin-left:30px;margin-top:30px;'>
					<p class='bigText' id='g' style='text-align:left;margin-top:20px;font-size:40px;margin-left:-15px;position:relative;'>
						".$txt['general']."
					</p>
					<div style='width:100%;position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
						<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:70%;'>
							".$txt['language']."
						</p>
						<select name='language' style='float:right;margin-top:-38px;-webkit-appearance:none;font-size:30px;color:white;
						font-family:\"Trebuchet MS\", Arial, sans-serif;background-color:rgba(255, 255, 255, 0.3);border:none;
										box-shadow:0px 0px 1px rgba(0,0,0,0.3);'>
							<option value='EN' ";if($me->settings['lang'][1] == "EN")echo"selected ";echo"
							style='background-color:#ffa200;'>English</option>
							<option value='DE' ";if($me->settings['lang'][1] == "DE")echo"selected ";echo"
							style='background-color:#ffa200;'>Deutsch</option>
						</select>
					</div>
					<div style='width:100%;position:relative;padding:8px;'>
						<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:30%;'>
							".$txt['chpassword']."
						</p>
						<input type='password' name='old_pw' placeholder='".$txt['oldpw']."' style='margin-right:410px;margin-top:-35px;font-size:23px;
						float:right;width:200px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
						<input type='password' name='new_pw' placeholder='".$txt['newpw']."' style='float:right;margin-top:-35px;font-size:23px;width:200px;
						margin-right:205px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
						<input type='password' name='new_pw2' placeholder='".$txt['newpw2']."' style='float:right;margin-top:-35px;font-size:23px;width:200px;
						background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
					</div>
					<div style='width:100%;position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
						<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:70%;'>
							".$txt['delac']."
						</p>
						<button style='float:right;margin-top:-38px;font-size:30px;' class='transculentButton' 
						name='a' value='delac'>
							".$txt['delete']."
						</select>
					</div>
					<p class='bigText' id='pi' style='text-align:left;margin-top:20px;font-size:40px;margin-left:-15px;position:relative;'>
						".$txt['persinf']."
					</p>
					<div style='width:100%;position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
						<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:30%;'>
							".$txt['name']."
						</p>
						<input type='text' value='".$me->firstname[1]."' name='firstname' style='float:right;margin-top:-35px;font-size:24px;margin-right:310px;
						width:300px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
						<input type='text' value='".$me->lastname[1]."' name='lastname' style='float:right;margin-top:-35px;font-size:24px;width:300px;
						background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
					</div>
					<div style='width:100%;position:relative;padding:8px;'>
						<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:30%;'>
							".$txt['birthdate']."
						</p>
						<div style='float:right;margin-top:-38px;'>
						<select name='birthday' value='".$me->birthdate[1]."' size='1' style='width:55px;margin-right:5px;-webkit-appearance:none;
						font-size:30px;color:white;font-family:\"Trebuchet MS\", Arial, sans-serif;background-color:rgba(255, 255, 255, 0.3);border:none;
						box-shadow:0px 0px 1px rgba(0,0,0,0.3);'>
							<option value='' style='background-color:#ffa200;'></option>
							<option value='01' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "01")echo"selected";echo" 
							 style='background-color:#ffa200;'>1</option>
							<option value='02' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "02")echo"selected";echo" 
							 style='background-color:#ffa200;'>2</option>
							<option value='03' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "03")echo"selected";echo" 
							 style='background-color:#ffa200;'>3</option>
							<option value='04' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "04")echo"selected";echo" 
							 style='background-color:#ffa200;'>4</option>
							<option value='05' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "05")echo"selected";echo" 
							 style='background-color:#ffa200;'>5</option>
							<option value='06' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "06")echo"selected";echo" 
							 style='background-color:#ffa200;'>6</option>
							<option value='07' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "07")echo"selected";echo" 
							 style='background-color:#ffa200;'>7</option>
							<option value='08' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "08")echo"selected";echo" 
							 style='background-color:#ffa200;'>8</option>
							<option value='09' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "09")echo"selected";echo" 
							 style='background-color:#ffa200;'>9</option>
							<option value='10' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "10")echo"selected";echo" 
							 style='background-color:#ffa200;'>10</option>
							<option value='11' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "11")echo"selected";echo" 
							 style='background-color:#ffa200;'>11</option>
							<option value='12' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "12")echo"selected";echo" 
							 style='background-color:#ffa200;'>12</option>
							<option value='13' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "13")echo"selected";echo" 
							 style='background-color:#ffa200;'>13</option>
							<option value='14' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "14")echo"selected";echo" 
							 style='background-color:#ffa200;'>14</option>
							<option value='15' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "15")echo"selected";echo" 
							 style='background-color:#ffa200;'>15</option>
							<option value='16' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "16")echo"selected";echo" 
							 style='background-color:#ffa200;'>16</option>
							<option value='17' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "17")echo"selected";echo" 
							 style='background-color:#ffa200;'>17</option>
							<option value='18' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "18")echo"selected";echo" 
							 style='background-color:#ffa200;'>18</option>
							<option value='19' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "19")echo"selected";echo" 
							 style='background-color:#ffa200;'>19</option>
							<option value='20' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "20")echo"selected";echo" 
							 style='background-color:#ffa200;'>20</option>
							<option value='21' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "21")echo"selected";echo" 
							 style='background-color:#ffa200;'>21</option>
							<option value='22' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "22")echo"selected";echo" 
							 style='background-color:#ffa200;'>22</option>
							<option value='23' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "23")echo"selected";echo" 
							 style='background-color:#ffa200;'>23</option>
							<option value='24' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "24")echo"selected";echo" 
							 style='background-color:#ffa200;'>24</option>
							<option value='25' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "25")echo"selected";echo" 
							 style='background-color:#ffa200;'>25</option>
							<option value='26' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "26")echo"selected";echo" 
							 style='background-color:#ffa200;'>26</option>
							<option value='27' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "27")echo"selected";echo" 
							 style='background-color:#ffa200;'>27</option>
							<option value='28' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "28")echo"selected";echo" 
							 style='background-color:#ffa200;'>28</option>
							<option value='29' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "29")echo"selected";echo" 
							 style='background-color:#ffa200;'>29</option>
							<option value='30' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "30")echo"selected";echo" 
							 style='background-color:#ffa200;'>30</option>
							<option value='31' ";if(count($me->birthdate) == 4 && $me->birthdate[1] == "31")echo"selected";echo" 
							 style='background-color:#ffa200;'>31</option>
						</select>
						<select name='birthmonth' selected='".$me->birthdate[2]."' size='1' style='width:170px;-webkit-appearance:none;font-size:30px;
						color:white;font-family:\"Trebuchet MS\", Arial, sans-serif;background-color:rgba(255, 255, 255, 0.3);border:none;margin-right:5px;
						box-shadow:0px 0px 1px rgba(0,0,0,0.3);'>
							<option value='' style='background-color:#ffa200;'></option>
							<option value='01' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "01")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['january']."</option>
							<option value='02' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "02")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['february']."</option>
							<option value='03' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "03")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['march']."</option>
							<option value='04' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "04")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['april']."</option>
							<option value='05' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "05")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['may']."</option>
							<option value='06' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "06")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['june']."</option>
							<option value='07' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "07")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['july']."</option>
							<option value='08' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "08")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['august']."</option>
							<option value='09' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "09")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['september']."</option>
							<option value='10' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "10")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['october']."</option>
							<option value='11' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "11")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['november']."</option>
							<option value='12' ";if(count($me->birthdate) == 4 && $me->birthdate[2] == "12")echo"selected";echo" 
							style='background-color:#ffa200;'>".$txt['december']."</option>
						</select>
						<input name='birthyear' type='Text' ";if(count($me->birthdate) == 4)echo"value='".$me->birthdate[3]."' ";echo"
						size='4' maxlength='4' style='width:70px;padding:1px 5px;font-size:30px;
						color:white;font-family:\"Trebuchet MS\", Arial, sans-serif;background-color:rgba(255, 255, 255, 0.3);border:none;
						box-shadow:0px 0px 1px rgba(0,0,0,0.3);'/>
						</div>
					</div>
				</div>
			</form>
		";
	}
?>