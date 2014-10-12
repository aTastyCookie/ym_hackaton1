<?php
	require_once('inc/_header.php');
	if(!count($_GET)){require_once('inc/_main.php');}
	elseif(isset($_GET['change_log'])){
		require_once('change_log.php');
	}
	require_once('inc/_footer.php');
?>    