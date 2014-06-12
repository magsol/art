<?php

session_start();
require_once('config.php');
require_once('twitteroauth/twitteroauth.php');
require_once('functions/sql.php');
require_once('functions/encrypt.php');

// What action are we executing?
if (isset($_GET['action'])) {
	$action = ($_GET['action'][strlen($_GET['action']) - 1] == '/' ? substr($_GET['action'], 0, strlen($_GET['action']) - 1) : $_GET['action']);
	switch($action) {
		case 'wtf':
			// About page.
			$smarty->display('wtf.tpl');
			break;

		case 'rant':
			// Contact page.
			$smarty->display('rant.tpl');
			break;

		case 'initialize':
			/* Build TwitterOAuth object with client credentials. */
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
			/* Get temporary credentials. */
			$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

			/* Save temporary credentials to session. */
			$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			 
			/* If last connection failed don't display authorization link. */
			switch ($connection->http_code) {
				case 200:
					/* Build authorize URL and redirect user to Twitter. */
					$url = $connection->getAuthorizeURL($token);
					header('Location: ' . $url); 
					break;
				default:
					/* Show notification if something went wrong. */
					$msg = 'Could not connect to Twitter for some reason. Try again later, maybe?';
					$smarty->assign('message', $msg);
					$smarty->display("error.tpl");
					session_destroy();
			}
			break;

		case 'callback':
			/* If the oauth_token is old redirect to the connect page. */
			if (isset($_REQUEST['oauth_token']) &&
				$_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
				$_SESSION['oauth_status'] = 'oldtoken';
				header('Location: ' . SITE_ROOT . 'clear/');
			}

			/* Create TwitteroAuth object with app key/secret and token 
			 * key/secret from default phase
			 */
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
				$_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

			/* Request access tokens from twitter */
			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

			/* Save the access tokens. Normally these would be saved in a database for future use. */
			if (!update_oauth($conn, $access_token['screen_name'], 
				$access_token['oauth_token'], $access_token['oauth_token_secret'])) {

				/* Show notification if something went wrong. */
				$msg = 'Something went wrong with your OAuth step. Try again?';
				$smarty->assign('message', $msg);
				$smarty->display("error.tpl");
				session_destroy();
				break;
			}
			$_SESSION['access_token'] = $access_token;

			/* Remove no longer needed request tokens */
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);

			/* If HTTP response is 200 continue otherwise send to connect page to retry */
			if (200 == $connection->http_code) {
				/* The user has been verified and the access tokens can be saved for future use */
				$_SESSION['status'] = 'verified';
				header('Location: ' . SITE_ROOT . 'login/');
			} else {
				$msg = 'Received a bad HTTP code: ' . $connection->http_code . '. Any idea what it means?';
				$smarty->assign('message', $msg);
				$smarty->display("error.tpl");
				session_destroy();
			}
			break;

		case 'login':
			// User adds login credentials for Garmin Connect.
			if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
				header('Location: ' . SITE_ROOT . 'clear/');
			}
			$token = $_SESSION['access_token'];
			$connection = $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
				$token['oauth_token'], $token['oauth_token_secret']);
			$results = $connection->get('users/show', array('screen_name' => $token['screen_name']));

			$chunks = explode("_", $results->profile_image_url);
			$ext = explode(".", $chunks[count($chunks) - 1]);
			array_pop($chunks);
			$chunks = implode("_", $chunks);
			$smarty->assign('user_url', $chunks . "." . $ext[1]);
			$smarty->assign('user_name', $results->name);
			$smarty->assign('user_handle', $token['screen_name']);
			$smarty->display('login.tpl');
			break;

		case 'submit':
			// User has submitted login information.
			if (!isset($_POST['username'])) {
				header('Location: ' . SITE_ROOT . 'clear/');
			}

			// Pull data from the form, clean it, and insert it.
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$hour = intval($_POST['hour']);
			$minute = intval($_POST['minute']);
			if (strlen($username) <= 0 || strlen($password) <= 0 || 
				$hour > 20 || $hour < 8 || $minute < 0 || $minute > 59) {
				header('Location: ' . SITE_ROOT . 'login/');
			}
			$handle = $_SESSION['access_token']['screen_name'];
			$username = encrypt_string($username, KEY);
			$password = encrypt_string($password, KEY);

			if (!update_gc($conn, $handle, $username, $password, $hour, $minute)) {
				$msg = 'Could not set your Garmin Connect credentials for some reason. Is Mercury in retrograde or something?';
				$smarty->assign('message', $msg);
				$smarty->display("error.tpl");
				session_destroy();
			} else {
				// Success!
				$msg = "I guess we can safely assume you know what you're doing. Either that, or you planted something sinister in those OAuth settings. You monster!";
				$smarty->assign('message', $msg);
				$smarty->display('success.tpl');
			}

			break;

		case 'clear':
			// Clear the session.
			session_destroy();
			header('Location: ' . SITE_ROOT);
			break;

		case 'delete':
			// Delete all the data associated with this user.
			delete_user($conn, $_SESSION['access_token']['screen_name']);
			$msg = "All your data has been purged from my database. All that innocent, hardworking data. I hope you're satisfied. You monster!";
			$smarty->assign('message', $msg);
			$smarty->display('success.tpl');

		default:
			$trailingSlash = $_GET['action'][strlen($_GET['action']) - 1] == '/';
			$smarty->assign('randomVar', ($trailingSlash ? 0 : 1));
			$smarty->display('404.tpl');

	}
} else {
	// Home page, don't do much of anything.
	$smarty->display('index.tpl');
}
