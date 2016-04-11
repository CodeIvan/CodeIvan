<?php
	require_once '../class/user.php';
	$user = new User();

	if(!$user->is_logged_in())
	{
		$user->redirect('login.php');
	}

	if($user->is_logged_in())
	{
		$user->doLogout();
		$user->redirect('login.php');
	}
?>
