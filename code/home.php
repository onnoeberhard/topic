<?php
	echo"
	<form method='post' id='homeStatusForm' name='homeStatusForm' autocomplete='off'>
		<div style='height:30px;width:100%;display:table;position:relative;box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);
		padding-bottom:3px;'>
			<input type='hidden' name='a' value='statusUpdate'/>
			<input id='homeStatusText' type='text' name='what'
			style='position:relative;display:table-cell;width:calc(81% - 6px);margin:1px 3px;vertical-align:top;
			height:20px;margin-top:5px;background-color:rgba(255, 255, 255, 0.3);border:none;
			box-shadow:0px 0px 1px rgba(0,0,0,0.3);padding:3px 1px;'/>
			<select id='homeStatusAudience' name='who' form='homeStatusForm'
			style='-webkit-appearance:none;display:table-cell;width:calc(11% - 6px);margin:1px 3px;
			margin-top:-27px;margin-left:calc(81% + 3px);height:26px;
			background-color:rgba(255, 255, 255, 0.3);border:none;box-shadow:0px 0px 1px rgba(0,0,0,0.3);'>
				<option value='friends'style='background-color:#ffdfa6'>".$txt['friends']."</option>
				<option value='vips'style='background-color:#ffdfa6'>".$txt['vips']."</option>
				<option value='everyone'style='background-color:#ffdfa6'>".$txt['everyone']."</option>
			</select>
			<button class='transculentButton' type='submit'
			style='display:table-cell;width:calc(8% - 6px);vertical-align:top;margin:1px 3px;height:28px;
			float:right;font-size:18px;margin-top:-28px;'>
			".$txt['post']."</button>
		</div>
	</form>
	";
	$b = new Box();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.<br/>
							Da war ein Absatz! Mensch! Wie aus dem nichts.. :O", 
							1, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 4);
		$b->show();/*<div>
		<p class='bigText' style='float:right;'>@".$me->username."&ensp;</p>
		<a class='smallText' href='#'>top news</a>
		<a class='smallText' href='#'>my topics</a>
		<a class='smallText' href='#'>posts</a>
		<a class='smallText' href='#'>popular topics</a>
	</div>
	<div id='top_news'>
		<div style='width:80%;margin:0 10%;'>
			<p class='smallText'>TOP NEWS</p>
			<div style='width:100%;height:2px;background-color:#ccc'></div>
		</div>
		";
		$b = new Box();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.", 
							2, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 4);
		$b->show();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.", 
							2, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 3);
		$b->show();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.", 
							2, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 2);
		$b->show();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.", 
							2, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 1);
		$b->show();
		$b->build_status("Hallo, dies ist ein Test-Nachricht um die Status-Box zu testen. Sie ist etwas länger, damit mehrere Zeilen ausgenutzt werden.", 
							2, "20130805175229000000", "3{{.}}Cool{{.}}20130806175229000000{{.}}{{.}}{{.}}2{{,}}", "3{{,}}", "4{{,}}", 0);
		$b->show();
		echo"
	</div>
	<div id='my topics'>
		<div style='width:80%;margin:0 10%;'>
			<p class='smallText'>MY TOPICS</p>
			<div style='width:100%;height:2px;background-color:#ccc'></div>
		</div>
		";
		$b = new Box();
		$b->build_status("HALLO", 0, "000000000000000000", "", "", "", 0);
		$b->show();
		$b->show();
		$b->show();
		$b->show();
		$b->show();
		$b->show();
		echo"
	</div>
	<div id='posts'>
		<div style='width:80%;margin:0 10%;'>
			<p class='smallText'>POSTS</p>
			<div style='width:100%;height:2px;background-color:#ccc'></div>
		</div>
		";
		if(array_key_exists('b', $_POST) && $_POST['b'] == "like") {
			$id = $_POST['id'];
			$sql = "SELECT data2 FROM users WHERE ID=$id";
			$result = $db->query($sql);
			$data2ses = $result->fetchAll();
			$data2 = $data2ses[0];
			$data2FIX = $data2ses[0];
			$entry = $_POST['entry1']."friends".$_POST['entry2'];
			$entry1 = str_replace(",LIKES", "", $entry);
			$entry2 = str_replace($me->ID."{{,}}", "", $entry);
			if($entry2 == $entry) {
				$entry2 = str_replace(",LIKES", $me->ID."{{,}}", $entry2);
			} else {
				$entry2 = str_replace(",LIKES", "", $entry2);
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			if($data2[0] == $data2FIX) {
				$entry = $_POST['entry1']."everyone".$_POST['entry2'];
				$entry1 = str_replace(",LIKES", "", $entry);
				$entry2 = str_replace($me->ID."{{,}}", "", $entry);
				if($entry2 == $entry) {
					$entry2 = str_replace(",LIKES", $me->ID."{{,}}", $entry2);
				} else {
					$entry2 = str_replace(",LIKES", "", $entry2);
				}
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			if($data2[0] == $data2FIX) {
				$entry = $_POST['entry1']."vips".$_POST['entry2'];
				$entry1 = str_replace(",LIKES", "", $entry);
				$entry2 = str_replace($me->ID."{{,}}", "", $entry);
				if($entry2 == $entry) {
					$entry2 = str_replace(",LIKES", $me->ID."{{,}}", $entry2);
				} else {
					$entry2 = str_replace(",LIKES", "", $entry2);
				}
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			$sql = "UPDATE users SET data2='$data2FIX' WHERE ID=$id";
			$db->query($sql);
			echo"<meta http-equiv='refresh' content='0; URL=index.php'>";
		}
		if(array_key_exists('b', $_POST) && $_POST['b'] == "dislike") {
			$id = $_POST['id'];
			$sql = "SELECT data2 FROM users WHERE ID=$id";
			$result = $db->query($sql);
			$data2ses = $result->fetchAll();
			$data2 = $data2ses[0];
			$data2FIX = $data2ses[0];
			$entry = $_POST['entry1']."friends".$_POST['entry2'];
			$entry1 = str_replace(",DISLIKES", "", $entry);
			$entry2 = str_replace($me->ID."{{,}}", "", $entry);
			if($entry2 == $entry) {
				$entry2 = str_replace(",DISLIKES", $me->ID."{{,}}", $entry2);
			} else {
				$entry2 = str_replace(",DISLIKES", "", $entry2);
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			if($data2[0] == $data2FIX) {
				$entry = $_POST['entry1']."everyone".$_POST['entry2'];
				$entry1 = str_replace(",DISLIKES", "", $entry);
				$entry2 = str_replace($me->ID."{{,}}", "", $entry);
				if($entry2 == $entry) {
					$entry2 = str_replace(",DISLIKES", $me->ID."{{,}}", $entry2);
				} else {
					$entry2 = str_replace(",DISLIKES", "", $entry2);
				}
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			if($data2[0] == $data2FIX) {
				$entry = $_POST['entry1']."vips".$_POST['entry2'];
				$entry1 = str_replace(",DISLIKES", "", $entry);
				$entry2 = str_replace($me->ID."{{,}}", "", $entry);
				if($entry2 == $entry) {
					$entry2 = str_replace(",DISLIKES", $me->ID."{{,}}", $entry2);
				} else {
					$entry2 = str_replace(",DISLIKES", "", $entry2);
				}
			}
			$data2FIX = str_replace($entry1, $entry2, $data2[0]);
			$sql = "UPDATE users SET data2='$data2FIX' WHERE ID=$id";
			$db->query($sql);
			echo"<meta http-equiv='refresh' content='0; URL=index.php'>";
		}
		$sql = "SELECT data2 FROM users WHERE ID=".$me->ID;
		$result = $db->query($sql);
		$data2ses = $result->fetchAll();
		$friends = array();
		$vips = array();
		for($i = 0; $i < count($data2ses); $i++){
			$data2row = explode("{{;}}", $data2ses[$i][0]);
			for($ii = 0; $ii < count($data2row); $ii++){
				$data2column = explode("{{:}}",$data2row[$ii]);
				if($data2column[0] == "friend") {
					array_push($friends, $data2column[1]);
				}
				if($data2column[0] == "vip") {
					array_push($friends, $data2column[1]);
					array_push($vips, $data2column[1]);
				}
			}
		}
		$status = array();
		for($i = 0; $i < count($friends); $i++) {
			$sql = "SELECT data2 FROM users WHERE ID=".$friends[$i];
			$result = $db->query($sql);
			$data2ses = $result->fetchAll();
			for($ii = 0; $ii < count($data2ses); $ii++){
				$data2row = explode("{{;}}", $data2ses[$ii][0]);
				for($iii = 0; $iii < count($data2row); $iii++){
					$data2column = explode("{{:}}",$data2row[$iii]);
					array_push($data2column, $friends[$i]);
					if($data2column[0] == "status") {
						if(($data2column[2] == "friends" && in_array($friends[$i], $friends)) || 
						   ($data2column[2] == "vips" && in_array($friends[$i], $vips)) ||
							$data2column[2] == "everyone")
							array_push($status, $data2column);
					}
				}
			}
		}
		$status_sort = array();
		for($ii = 0; $ii < count($status); $ii++) {
			array_push($status_sort, $status[$ii][3]);
		}
		$status = array_combine($status_sort, $status);
		rsort($status_sort);
		for($ii = 0; $ii < count($status); $ii++) {
			$open = false;
			if(array_key_exists('b', $_POST) && $_POST['b'] == "showMore")
				$open = true;
			$no = count($status_sort) - $ii - 1;
			$status_post = new Box();
			$status_post->build_status
				($status[$status_sort[$ii]][1], $status[$status_sort[$ii]][7], $status[$status_sort[$ii]][3], 
				$status[$status_sort[$ii]][4], $status[$status_sort[$ii]][5], $status[$status_sort[$ii]][6], $no,
				$open);
			$status_post->show();
		}
		echo"
	</div>";
	if(count($me->friend_requests) > 0) {
		for($i = 0; $i < count($me->friend_requests); $i++) {
			$frqs = explode("{{:}}", $me->friend_requests[$i]);
			$u = new User();
			$u->getFromId($frqs[1]);
			echo"
			<div style='height:80px;width:100%;display:table;position:relative;box-shadow:0px 2px 3px 0px rgba(0,0,0,0.1);
			padding-bottom:3px;'>
				<p class='bigText' style='color:#066;margin-top:10px;text-align:center;'>
					Friend Request From 
					<a style='text-decoration:none;color:#066;' href='index.php?u=".$frqs[1]."'>".$u->username."
				</p>
			</div>";
		}
	}*/
?>