<?php

session_start();
require_once('config.php');
require_once('twitteroauth/twitteroauth.php');
require_once('functions/sql.php');

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
				header('Location: /twathletic/clear/');
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
				header('Location: /twathletic/login/');
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
				header('Location: /twathletic/clear/');
			}
			$token = $_SESSION['access_token'];
			$connection = $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
				$token['oauth_token'], $token['oauth_token_secret']);
			$results = $connection->get('users/show', array('screen_name' => $token['screen_name']));

			$smarty->assign('user_url', $results->profile_image_url);
			$smarty->assign('user_name', $results->name);
			$smarty->assign('user_handle', $token['screen_name']);
			$smarty->display('login.tpl');
			break;

		case 'submit':
			// User has submitted login information.
			if (!isset($_POST['username'])) {
				header('Location: /twathletic/clear/');
			}

			break;

		case 'clear':
			// Clear the session.
			session_destroy();
			header("Location: /twathletic/");
			break;

		default:
			// 404

	}

} else {
	// Home page, don't do much of anything.
	$smarty->display('index.tpl');
}
exit;


/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

if (isset($_POST['username'])) {
	// Process the form.
	$gcuser = base64_encode($_POST['username']);
	$gcpass = base64_encode($_POST['password']);
	$time = $_POST['time'];

	$sql = 'SELECT * FROM users WHERE handle = ?';
	$result = mysqli_query($conn, "SELECT * FROM users WHERE handle = '" .
		$access_token['screen_name'] . "'");
	$rows = mysqli_num_rows($result);
	if ($rows > 0) {
		// User exists; do an update.
		$sql = "UPDATE users SET access_token = ?, access_secret = ?, " . 
				"gcname = ?, gcpass = ?, time = ? WHERE handle = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, 'ssssis', $access_token['oauth_token'], 
			$access_token['oauth_token_secret'], $gcuser, $gcpass, $time,
			$access_token['screen_name']);
		$results = mysqli_stmt_execute($stmt);
		if ($results === false) {
			echo 'Unable to update! Crap on a stick.';
			exit;
		}
		mysqli_stmt_close($stmt);
	} else {
		// New user; insert.
		$sql = "INSERT INTO users VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, 'sssssi', $access_token['screen_name'],
			$access_token['oauth_token'], $access_token['oauth_token_secret'],
			$gcuser, $gcpass, $time);
		$results = mysqli_stmt_execute($stmt);
		if ($results === false) {
			echo 'Unable to add your information! Oopsies.';
			exit;
		}
		mysqli_stmt_close($stmt);
	}
	header('Location: ./clearsessions.php');
} else {
	include("form.php");
}


/* If method is set change API call made. Test is called by default. */
//$content = $connection->get('account/verify_credentials');

/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992));
//$connection->post('friendships/destroy', array('id' => 9436992));

/* Include HTML to display on the page */
//include('html.inc');
