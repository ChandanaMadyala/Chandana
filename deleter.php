<?php
	if(isset($_GET['glFile'])){
		$root="models";
		unlink($root."/".$_GET['glFile']);
	}
?>
