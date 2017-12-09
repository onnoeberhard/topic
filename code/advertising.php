<?php
	function adsInfoPage($logged_in) {
		global $users;
		if($logged_in)
			normalHead();
		else {
			echo"
			<div class='container' id='welcomeContainer'>
				<div class='header' id='welcomeHeader'>
					<div class='contentAreaDefinetely'>
						<div class='headerTitleDiv'><a href='index.php' class='headerTitle'>topic</a></div>
					</div>
				</div>
				<div class='main' id='adMain'>";
		}
		echo"
		<div class='contentAreaDefinetely'>
			<p class='bigText' style='margin-left:15px;text-align:left;margin-top:20px;position:relative;'>
				Advertising
			</p>
			<p style='margin-left:20px;' class='smallText'>
				We provide a free social online platform with topic. Topic now already has over ";
				$i = strlen($users);
				$s = substr($users, 0, 1);
				for($ii = 0; $ii < $i-1; $ii++)
					$s .= "0";
				echo"$s users. 
				<br/>To continue providing this free service to the world, it has to be financed somehow. Our solution to that problem is advertising.
			</p>
			<p class='bigText' style='margin-left:15px;text-align:left;font-size:35px;margin-top:20px;position:relative;'>
				How it works
			</p>
			<p style='margin-left:20px;' class='smallText'>
				When you create a banner / ad, you have to upload / link to a png or a gif file. 
				The monthly price will be calculated depending on several factors like
				the number of topic-users, the clicks on your ad and the times your ad is visible to a user (impressions). ";
				if(!$logged_in)echo"To create an ad, you fist have to <a class='smallText' href='index.php'>create a topic account</a>.";echo"
			</p>
			<p class='bigText' style='margin-left:15px;text-align:left;font-size:35px;margin-top:20px;position:relative;'>
				Where will my ad be shown?
			</p>
			<p style='margin-left:20px;' class='smallText'>
				There are 100 banners on topic; some of them are used and some are not used (not used ones just say 'This could be your ad!'). 
				Which one of these banners is shown is calculated by random (the possibility of a not used banner is much lower than the possibility of a used 
				one). Ads can be shown anywhere in topic for a normal user. The user can select the places where he wants to see ads and where he doesn't 
				(of course he can't disable ads; there's a minimum number of places to select).
			</p>
			<div style='width:100%;text-align:center;margin-bottom:20px;margin-top:50px;'><form method='get' action='index.php'>
				";if(!$logged_in)echo"<button class='transculentButton' type='submit' name='a' value='crac' style='font-size:48px;'>Create Account</button>";
				else echo"<button class='transculentButton' type='submit' name='a' value='crad' style='font-size:48px;'>Create Ad</button>";echo"
			</form></div>";
	}
	function adsCreateBanner($fillOutError) {
		global $users, $db;
		$sql = "SELECT * FROM ads";
		$result = $db->query($sql);
		$ads = $result->fetchAll();
		$no = count($ads)+1;
		$cp = false;
		if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "cp") {
			$cp = true;
		}
		normalHead();echo"
		<div class='contentAreaDefinetely'><form id='adcrfrm' method='post' action='index.php'>
			<input type='hidden' name='price' id='adprice' value='dynamic'/>
			<p class='bigText' style='margin-left:15px;width:30%;text-align:left;margin-top:20px;position:relative;margin-bottom:30px;'>
				Ad Creator
			</p>
			<div style='margin-top:-80px;margin-bottom:30px;text-align:center;'>
			<button class='transculentButton' type='submit' name='a' value='cradr' style='font-size:40px;'>
			Create Ad</button></div>
			<p class='smallText' style='float:right;margin-top:-60px;'>
				Your ad will be no. $no/100&ensp;
			</p>
			<div id='adsFillOutErrorDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:";
			if($fillOutError)echo"block";else echo"none";echo";background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>You have to fill out everything!</p>
				<button class='transculentButton' type='button' onclick='adCloseFillOutError();' style='margin-top:-122px;float:right'>x</button>
			</div>
			<div id='adsTitleDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Title</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpTitle();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>The title is shown normally only to you in your Ad Manager. 
				It is also used if the banner image is broken or not available.<br/>You can change the title in your Ad Manager.</p>
			</div>
			<div id='adsLinkDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Link</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpLink();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>This is the link your ad points to. If a user clicks on your ad he will 
				be redirected to the location of this link.<br/>You can change the title in your Ad Manager.</p>
			</div>
			<div id='adsImgDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Image</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpImg();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>This is the location of your image file. We use this method rather than the 
				upload of a image file to our server because it is easier for you to change the image on your server. The image size should be 230px*70px.
				The PNG/GIF selecter is there to select the format (.gif -> GIF = moving picture | .png -> PNG = not moving picture)<br/>
				You can change the link in your Ad Manager. You cannot change the format.</p>
			</div>	
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					title
				</p>
				<button class='transculentButton' type='button' onclick='adHelpTitle();' 
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' name='title' ";if($_POST != NULL && array_key_exists('title', $_POST))
					echo "value='".$_POST['title']."' ";echo"style='float:right;margin-top:-35px;font-size:24px;
				width:650px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
			</div>
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .0);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					link
				</p>
				<button class='transculentButton'  type='button' onclick='adHelpLink();' 
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' name='link' ";if($_POST != NULL && array_key_exists('link', $_POST))
					echo "value='".$_POST['link']."' ";echo"style='float:right;margin-top:-35px;font-size:24px;
				width:650px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
			</div>
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					link to png/gif
				</p>
				<button class='transculentButton'  type='button' onclick='adHelpImg();'
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' name='imglink' ";if($_POST != NULL && array_key_exists('imglink', $_POST))
					echo "value='".$_POST['imglink']."' ";echo" style='float:right;margin-top:-35px;font-size:24px;margin-right:60px;
				width:590px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
				<select name='format' onchange='adcr_format();'
				 style='float:right;width:55px;margin-top:-35px;-webkit-appearance:none;font-size:25px;color:white;
				font-family:\"Trebuchet MS\", Arial, sans-serif;background-color:rgba(255, 255, 255, 0.3);border:none;
								box-shadow:0px 0px 1px rgba(0,0,0,0.3);'>
					<option value='png' id='adcr_png' style='background-color:#ffa200;'>PNG</option>
					<option value='gif' id='adcr_gif' style='background-color:#ffa200;'>GIF</option>
				</select>
			</div>
			<!--<div style='width:100%;text-align:center;margin-top:20px;margin-bottom:-30px;'><button class='transculentButton' 
			type='button' onclick='adcr_dp();' style='font-size:30px;margin-right:3px;'>Dynamic Price</button>
			<button class='transculentButton' style='font-size:30px;margin-left:3px;'
			type='button' onclick='adcr_cp();'>Constant Price</button></div>-->
			<div id='adpricepng'><div class='addynamicprice'><div style='width:100%;margin-top:50px;text-align:center;'>
			<p class='bigText' style='margin-top:-30px;color:#066;font-size:35px;'>";
				$i = strlen($users);
				$s = substr($users, 0, 1);
				for($ii = 0; $ii < $i-1; $ii++)
					$s .= "0";echo"
				1$ * (~".$s." * 0.0001) + (~".($s*0.45)." * 0.00005) + (~".(($s*0.45)/200)." * 0.05$) &asymp;<br/>
				~".(1*($s*0.00005)+(($s*0.45)*0.00005)+((($s*0.45)/200)*0.05))."$/month*
			</p></div>
			<div style='width:100%;margin-top:20px;text-align:center;'><p class='bigText' style='font-size:25px;color:#066;'>
				( format ( png = 1 | gif = 2 ) $<br/>
				* [all users] ( users * 0.0001 )<br/>
				+ [impressions] ( impressions * 0.00005 $ )
				<br/>+ [clicks] ( clicks * 0.05 $ ) )<br/>/ month
			</p>
			<p class='smallText' style='margin-top:10px;margin-bottom:5px;'>
				*This is not the actual monthly price but just an example; the price is monthly calculated depending on several values(see above)
			</p></div></div>
			<div class='adconstantprice' style='display:none;'><div style='width:100%;margin-top:50px;text-align:center;'>
			<p class='bigText' style='color:#066;font-size:35px;'>
				7.50$/month
			</p></div>
			<div style='width:100%;margin-top:30px;text-align:center;margin-bottom:20px;'><p class='bigText' style='font-size:25px;color:#066;'>
				( format ( png = 7.50 | gif = 15 ) $ / month
			</p></div></div></div>
			<div id='adpricegif' style='display:none;'><div class='addynamicprice'><div style='width:100%;margin-top:50px;text-align:center;'>
			<p class='bigText' style='color:#066;font-size:35px;'>";
				$i = strlen($users);
				$s = substr($users, 0, 1);
				for($ii = 0; $ii < $i-1; $ii++)
					$s .= "0";echo"
				2$ * (~".$s." * 0.0001) + (~".($s*0.45)." * 0.00005) + (~".(($s*0.45)/200)." * 0.05$) &asymp;<br/>
				~".(2*($s*0.00005)+(($s*0.45)*0.00005)+((($s*0.45)/200)*0.05))."$/month
			</p></div>
			<div style='width:100%;margin-top:30px;text-align:center;margin-bottom:20px;'><p class='bigText' style='font-size:25px;color:#066;'>
				( format ( png = 1 | gif = 2 ) $<br/>
				* [all users] ( users * 0.0001 )<br/>
				+ [impressions] ( impressions * 0.00005 $ )
				<br/>+ [clicks] ( clicks * 0.05 $ ) )<br/>/ month
			</p></div></div>
			<div class='adconstantprice' style='display:none;'><div style='width:100%;margin-top:50px;text-align:center;'>
			<p class='bigText' style='color:#066;font-size:35px;'>
				15$/month
			</p></div>
			<div style='width:100%;margin-top:30px;text-align:center;margin-bottom:20px;'><p class='bigText' style='font-size:25px;color:#066;'>
				( format ( png = 7.50 | gif = 15 ) $ / month
			</p></div></div></div></form>
			";
	}
	function adsCreateIt() {
		global $me, $db;
		if($_POST['title'] != "" && $_POST['link'] != "" && $_POST['imglink'] != "") {
			$sql = "INSERT INTO ads (owner, img, link, title, data1)VALUES
			('$me->ID', '".$_POST['imglink']."', '".$_POST['link']."', '".$_POST['title']."', '".
			"format{{:}}".$_POST['format']."{{;}}price{{:}}".$_POST['price']."{{;}}')";
			$db->query($sql);
			echo "<meta http-equiv='refresh' content='0; URL=index.php?a=myads'>";
		} else echo "<meta http-equiv='refresh' content='0; URL=index.php?a=cradfoe'>";
	}
	function adsManager() {
		global $db, $me;
		normalHead();echo"<div class='contentAreaDefinetely'>
		<p class='bigText' style='margin-left:15px;width:30%;text-align:left;margin-top:20px;position:relative;margin-bottom:30px;'>
			My Ads
		</p>
		";
		$sql = "SELECT * FROM ads WHERE owner='$me->ID'";
		$result = $db->query($sql);
		$ads = $result->fetchAll();
		if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "save") {
			$sql = "UPDATE ads SET title='".$_POST['title']."', link='".$_POST['link']."', img='".$_POST['imglink']."' WHERE ID=".$_POST['id'];
			$db->query($sql);
			echo"<meta http-equiv='refresh' content='0; URL=index.php?a=myads#myad".$_POST['i']."'>";
		}
		for($i = 0; $i < count($ads); $i++) {
			echo"<form method='post' action='index.php?a=myads#myad".$i."'>
			<input type='hidden' name='i' value='".$i."'/>
			<input type='hidden' name='id' value='".$ads[$i]['ID']."'/>
			<p class='bigText' id='myad$i' style='margin-top:15px;color:#066;margin-bottom:20px;'>".$ads[$i]['title']."</p>
			<div id='adsTitleDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Title</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpTitle();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>The title is shown normally only to you in your Ad Manager. 
				It is also used if the banner image is broken or not available.</p>
			</div>
			<div id='adsLinkDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Link</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpLink();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>This is the link your ad points to. If a user clicks on your ad he will 
				be redirected to the location of this link.</p>
			</div>
			<div id='adsImgDialog' style='position:absolute;width:500px;height:auto;margin-left:215px;z-index:1000;display:none;
			background-color:rgba(0, 0, 0, .5);text-align:center;'>
				<p class='bigText'>Image</p>
				<button class='transculentButton' type='button' onclick='adCloseHelpImg();' style='margin-top:-60px;float:right'>x</button>
				<p class='smallText' style='margin-bottom:5px;color:#fff;'>This is the location of your image file. We use this method rather than the 
				upload of a image file to our server because it is easier for you to change the image on your server. The image size should be 230px*70px.</p>
			</div>	
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					title
				</p>
				<button class='transculentButton' type='button' onclick='adHelpTitle();' 
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' value='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['title']; else echo $ads[$i]['title'];
					echo"' name='title' style='float:right;margin-top:-35px;font-size:24px;
				width:650px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
			</div>
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .0);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					link
				</p>
				<button class='transculentButton'  type='button' onclick='adHelpLink();' 
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' name='link' value='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['link']; else echo $ads[$i]['link'];
					echo"' style='float:right;margin-top:-35px;font-size:24px;
				width:650px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
			</div>
			<div style='width:calc(100% - 24px);position:relative;padding:8px;background-color:rgba(100, 100, 100, .2);'>
				<p class='bigText' style='text-align:left;position:relative;font-size:30px;width:27%;'>
					link to png/gif
				</p>
				<button class='transculentButton'  type='button' onclick='adHelpImg();'
				style='font-size:25px;float:right;margin-right:655px;margin-top:-35px;'>?</button>
				<input type='text' name='imglink' value='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['imglink']; else echo $ads[$i]['img'];
					echo"' style='float:right;margin-top:-35px;font-size:24px;
				width:590px;margin-right:60px;background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
				<p class='bigText' style='font-size:25px;text-shadow:none;color:#000;text-align:center;width:55px;float:right;margin-top:-34px;'>";
				if(strpos($ads[$i]['data1'], "format{{:}}gif") !== false) echo "GIF"; else echo "PNG";echo"</p>
			</div>
			<button class='transculentButton' type='submit' name='a' value='apply' style='font-size:40px;margin-top:55px;margin-bottom:-106px;margin-left:170px;'>
			Apply &rarr;</button>
			<div style='margin-bottom:40px;margin-top:30px;margin-left:380px;width:260px;height:100px;background-color:rgba(255, 255, 255, .3);
			box-shadow:2px 2px 2px 0px rgba(0, 0, 0, .2);'>
				<a class='smallText' href='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['link']; else echo $ads[$i]['link'];
					echo"' target='_blank'>
					<img alt='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['title']; else echo $ads[$i]['title'];
					echo"' src='";if($_POST != NULL && array_key_exists('a', $_POST) && $_POST['a'] == "apply" && $_POST['i'] == $i)
					echo $_POST['imglink']; else echo $ads[$i]['img'];
					echo"' style='width:230px;height:70px;border:1px solid #000;margin:15px;'></img>
				</a>
			</div>
			<button class='transculentButton' type='submit' name='a' value='save' style='font-size:40px;margin-top:-115px;
			margin-right:100px;float:right;'>Save</button></form>
			";
		}
	}
	function show_ad($which_one) {
		global $db;
		$BELOW_FRIENDS = 1;
		$sql = "SELECT * FROM ads";
		$result = $db->query($sql);
		$ads = $result->fetchAll();
		$ad = $ads[0];
		if($which_one == $BELOW_FRIENDS)
			echo"<div style='margin-top:30px;margin-left:calc(50% - 130px);width:260px;height:100px;background-color:rgba(255, 255, 255, .3);
				box-shadow:2px 2px 2px 0px rgba(0, 0, 0, .2);'>
					<a class='smallText' href='".$ad['link']."' target='_blank'>
						<img draggable='false' alt='".$ad['title']."' src='".$ad['img']."' 
						style='width:230px;height:70px;border:1px solid #000;margin:15px;'></img>
					</a>
				</div>";
	}
?>