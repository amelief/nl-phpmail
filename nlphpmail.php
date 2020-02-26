<?php
/*
  ==============================================================================================
  NL-PHPMail 2.2.2 © 2005-2009 Amelie M.
  Original concept by Sasha (2002-2005), http://nothing-less.net.
  ==============================================================================================
  																								*/


// INSTRUCTIONS
// Edit the parts below to configure the form.

// Your email address (where the form should be sent):
$recipient = 'your.address@example.com';

// Path to header and footer (don't know what these are? See this tutorial: http://codegrrl.com/tutorials/headers-and-footers)
// This can be a relative path (like 'header.php' if it's in the same directory), or an absolute path (e.g. '/home/myusername/public_html/myfiles/header.php'.
// DO _NOT_ USE A URL (e.g. http://site.com/header.inc) - THIS WILL NOT WORK.
// If you aren't using headers and footers, do not edit this part.
$header_file = '';
$footer_file = '';

/* Change the parts below to the required fields in your form.
If these fields are not filled in, the script will display an error message asking the visitor to fill in the missing fields.
Here, you should use the EXACT names you have given to the form fields you would like required. For example, if you have this HTML:

	<input type="text" name="comment" />

...you would write "comment" below (WITH the double quotes). It IS case sensitive, so "Comment" is different to "comment". Check that you are using the same case as in your HTML or you will be unable to send the form.

If you want to add or remove a required field, just copy/delete one of the lines below. */

$required[] = "name";
$required[] = "email";
$required[] = "comments";

// Required field error
// This message will be shown if the user did not fill in the required fields.
// HTML can be used here, but if you use quotes ( " ) remember to put a backslash ( \ ) in front of them or you will get errors.
$error_required = "<p>You did not fill some of the required fields in properly. Please go back, refresh the form page, and try again.</p>";

// Invalid email error
// This message will be shown if the visitor submitted an invalid email address.
// HTML can be used - same rules as above apply with the quotes, however.
$error_email = "<p>It appears that the email address you provided is not valid. Please press the back button on your browser, refresh the form page, and try again.</p>";


// Success message
// This message will be shown when the form is successfully sent.
// As before, HTML can be used but quotes need to be escaped as specified above.
$success_message = "<p>Your feedback form has been sent. Thank you for your submission!</p>";

// CAPTCHA/Image verification
// Do you want to enable image verification? Answer yes or no (lowercase)
$enable_captcha = 'yes';



#################################################################################################
#  DO NOT EDIT ANYTHING BELOW.
#################################################################################################
error_reporting(0);

function cleaninput($data, $isemail = false) {
	$data = stripslashes(strip_tags($data));
	if ($isemail) $data = htmlentities($data);
	return trim($data);
}
// Credits go to Jenny F of prism-perfect.net and zend.com for this function
function validate_email($email) {
	if (preg_match('/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email)) {
		list($username, $domaintld) = explode('@', $email);
		if (function_exists('getmxrr')) {
			if (getmxrr($domaintld, $mxrecords)) return true;
			else return false;
		}
		else return true;
	}
	else return false;
}
function verifycaptcha() {
	@session_start();
	$verifyimage = trim(cleaninput($_POST['verifyimage']));
	if (isset($_SESSION['encoded_string']) && $verifyimage == $_SESSION['encoded_string']) return true;
	else return false;
}
function error_handler($message, $die = true) {
	global $header_file, $footer_file;

	$header_file = str_replace('http://', '', $header_file);
	$footer_file = str_replace('http://', '', $footer_file);

	if (!empty($header_file) && file_exists($header_file)) @include $header_file;
	else echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Feedback Form</title>
</head>
<body>';

	echo $message;

	if (!empty($footer_file) && file_exists($footer_file)) @include $footer_file;
	else echo '<p style="text-align: center"><a href="http://codegrrl.com/" title="NL-PHPMail from CodeGrrl.com"><img src="phpmail.gif" alt="Powered by NL-PHPMail" title="Powered by NL-PHPMail" style="border: 0 none;" /></a></p>
</body></html>';

	if ($die) exit;
}

$check = "[STRIPx" . substr(md5(preg_replace("/[@.-_]/i", '', $recipient) . 'eutoiw87ei'), 0, 7) . "xSTRIP]";

if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != 'POST') exit("<h2>Error</h2>\n<p>This page cannot be accessed directly.</p>\n<p>(<a href=\"http://codegrrl.com/faq/this-page-cannot-be-accessed-directly\">Why am I seeing this error?</a>)</p>");
else {
	if ($enable_captcha == 'yes') {
		if (!isset($_POST['verifyimage'])) error_handler("<h2>Error</h2>\n\n<p>There was a problem getting the image file for verification. Please make sure the image verification box is correctly named; check your settings and try again. See the readme file to see what your settings should be.</p>\n<p>If you do not require image verification, please set \$enable_captcha to 'no' in nlphpmail.php.</p>");
		if (!verifycaptcha()) {
			if (isset($_SESSION['encoded_string']) && isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-36000, '/');
				$_SESSION = array();
				session_destroy();
			}
			error_handler("<h2>Error</h2>\n\n<p>Incorrect image verification text entered. Please go back, refresh the page, and try again.</p>");
		}
		if (isset($_SESSION['encoded_string']) && isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-36000, '/');
			$_SESSION = array();
			session_destroy();
		}
	}

	foreach($required as $req) {
		if (empty($_POST[$req])) error_handler('<h2>Error</h2>' . $error_required);
	}

	// Credit goes to Jem for parts of this code
	$notallowed = "/(content-type|bcc:|cc:|mime-version:|content-transfer-encoding:|document.cookie|onclick|onmouse|onkey|onclick)/i";

	$msg = "---------------\n" . cleaninput($_POST['subject']) . "\n---------------\n\n";

	if (is_array($_POST)) {
		foreach($_POST as $n => $v) {
			$n = cleaninput($n);
			if ($n != 'email' && $n != 'subject' && $n != 'submit' && $n != 'verifyimage') {
				if (preg_match($notallowed, $v)) error_handler('<h2>Error</h2><p>Invalid characters detected. Please try again.');
				$msg .= ucfirst(strtolower($n)) . ': ' . cleaninput($v) . "\n";
			}
			elseif ($n == 'email') {
				$submittedaddr = cleaninput($v, true);
				if (function_exists('ctype_cntrl')) {
					if (ctype_cntrl($submittedaddr)) error_handler("<h2>Error</h2>\n<p>Invalid characters found in address.");
				}
				if (preg_match("/([\r\n]|%0A|%0D)/i", $submittedaddr)) error_handler('<h2>Error</h2><p>Invalid characters found in address.');
				if (preg_match($notallowed, $submittedaddr)) error_handler('<h2>Error</h2><p>Invalid characters found in address. Please try again.');
				$msg .= ucfirst(strtolower($n)) . ': ' . $submittedaddr . "\n";
			}
			$$n = cleaninput($v);
		}
	}

	if (isset($submittedaddr) && !empty($submittedaddr)) {
		if (validate_email($submittedaddr)) $validaddr = $submittedaddr;
		else error_handler('<h2>Error</h2>' . $error_email);
	}

	$msg .= 'Sender IP Address: ' . cleaninput($_SERVER['REMOTE_ADDR']) . "\n\n---------------\nPowered by NL-PHPMail v2.2.2 from http://codegrrl.com/\n---------------\n";

	$mailheaders = '';

	if (isset($validaddr) && !strstr(strtolower($_SERVER['SERVER_SOFTWARE']), 'win')) $mailheaders .= 'From: "NL-PHPMail" <' . $recipient . '>' . $check . 'Reply-To: <' . $validaddr . '>' . $check;
	else $mailheaders .= 'From: ' . $recipient . $check;

	$mailheaders .= 'X-Mailer: NL-PHPMail 2.2.2';

	if (function_exists('ctype_cntrl')) {
		if (ctype_cntrl($mailheaders)) error_handler("<h2>Error</h2>\n<p>Invalid characters found in mail headers.");
	}
	if (preg_match("/([\r\n]|%0A|%0D)/i", $mailheaders)) error_handler("<h2>Error</h2>\n<p>Invalid characters found in mail headers.");
	if (!preg_match('#^([-A-Za-z0-9_ :{1,3}/"\.@{1,2}<{0,2}>{0,2}{\[\]])+$#', $mailheaders)) error_handler("<h2>Error</h2>\nInvalid characters found in mail headers.");

	$mailheaders = str_replace($check, "\n", $mailheaders);

	if (@mail($recipient, $subject, $msg, $mailheaders)) error_handler('<h2>Thank you</h2>' . $success_message, false);
	else error_handler("<h2>Error</h2>\n<p>Your form could not be sent. Please try contacting the site owner at this address instead: <a href=\"mailto:" . $recipient . '" title="E-mail the site owner">' . $recipient . '</a>.</p>');
}
?>