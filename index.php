<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('encrypt.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

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
