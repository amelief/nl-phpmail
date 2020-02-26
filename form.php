<?php @include 'captcha.php'; //DO NOT EDIT ABOVE THIS LINE! However, if you are NOT using image verification, please REMOVE this line. ?>


<?php
/*
  ==============================================================================================
  NL-PHPMail 2.2.2 © 2005-2008 Amelie M.
  Original concept by Sasha (2002-2005), http://nothing-less.net.
  ==============================================================================================
*/

// You may start editing the form here.

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>NL-PHPMail 2.2.2</title>
	</head>

	<body>
		<form method="post" action="nlphpmail.php">
			<p>
				<input type="hidden" name="subject" id="subject" value="Feedback form" />
				<label for="name">Name:</label> <input type="text" name="name" id="name" size="40" /><br />
				<label for="email">Email:</label> <input type="text" name="email" id="email" size="40" /><br />
				Website: <input type="text" name="url" id="url" value="http://" size="40" /><br />
				<label for="comments">Comments:</label> <br />
				<textarea name="comments" id="comments" cols="40" rows="3"></textarea><br />

				<!-- -- IMPORTANT: DELETE THIS PART IF YOU AREN'T USING IMAGE VERIFICATION! -- -->

				<label for="verifyimage">Enter the letters and numbers you see on this image into the box below (if you cannot see the image, please let me know):</label><br />
				<img src="verify.png" alt="CAPTCHA Image - if you cannot see this, please contact me for advice" /><br />
				<input type="text" name="verifyimage" id="verifyimage" maxlength="5" /><br />

				<!-- --------------------------- END OF PART TO DELETE ----------------------- -->

				<input type="submit" name="submit" id="submit" value="Send" size="30" />
				<input type="reset" name="reset" id="reset" value="Clear" size="30" />
			</p>
		</form>
		<p><a href="http://codegrrl.com/" title="NL-PHPMail from CodeGrrl.com">Powered by NL-PHPMail 2.2.2</a></p>
	</body>
</html>