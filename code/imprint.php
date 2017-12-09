<?php
	if($logged_in)
		normalHead();
	else {
		echo"
		<div class='container' id='welcomeContainer'>
			<div class='header' id='welcomeHeader'>
				<div class='contentAreaDefinetely'>
					<div class='headerTitleDiv'><a href='index.php' class='headerTitle'>&bdquo;topic&ldquo;</a></div>
				</div>
			</div>
			<div class='main' id='adMain'>";
	} echo"
		<div class='contentAreaDefinetely'>
			<p class='bigText' style='margin-left:15px;text-align:left;margin-top:20px;position:relative;'>
				Legal Notice
			</p>
			<p style='margin-left:20px;' class='smallText'>
				<br>topic is a website developed by <br/><br/>
				Onno Eberhard<br/>
				Im Riehewinkel 10<br/>
				30926 Seelze<br/>
				Germany<br/>
				<br/>
				Email: turtle.enterprises.contact@gmail.com<br/><br/><br/><br/>
				<a class='smallText' style='text-decoration:none;' href='http://www.turtle-enterprises.co.de/'>
				Turtle Enterprises</a> is a company founded by <br/><br/></p>
				<p style='margin-left:20px;' class='smallText'>Onno Eberhard<br/>
				Im Riehewinkel 10<br/>
				30926 Seelze<br/>
				Germany
				<br/><br/>
			</p>
			<p class='smallText' style='margin-top:-100px;margin-bottom:60px;margin-left:200px;'>Yannis Gerlach<br/>
				Erlenweg 10<br/>
				30926 Seelze<br/>
				Germany
			</p>
			<img src='./other stuff/icon_new.png' style='margin-top:-460px;margin-left:525px;'></img>";
?>