<?php
	global $me;
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
						testing area
					</p>
	";
?>