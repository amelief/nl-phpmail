<?php

/*
  ==============================================================================================
  NL-PHPMail 2.2.2 � 2005-2008 Amelie M.
  Original concept by Sasha (2002-2005), http://nothing-less.net.
  ==============================================================================================
  																								*/



######################## DO NOT EDIT THIS FILE. ###########################


if (file_exists('verify.png')) {
	if (!is_writable('verify.png')) exit('<strong>NL-PHPMail CAPTCHA error:</strong> NL-PHPMail can\'t create the CAPTCHA image because verify.png is not writable (CHMODed to 666). Please rectify this to continue.');
}
else exit('<strong>NL-PHPMail CAPTCHA error:</strong> NL-PHPMail can\'t find verify.png. Please make sure it is uploaded and in the SAME folder as your form.');

if (!function_exists('imagecreatetruecolor')) exit('NL-PHPMail CAPTCHA error: Unfortunately you do not seem have the necessary requirements to use the image verification (CAPTCHA) protection. If you still wish to use NL-PHPMail, please set $enable_captcha to \'no\' in nlphpmail.php and delete the image verification parts from your form.');

error_reporting(0);

session_start();
$_SESSION['encoded_string'] = '';

$captcha = imagecreatetruecolor(60, 20);
imageantialias($captcha, true);

$rand1 = rand(160, 245);
$rand2 = rand(160, 245);
$rand3 = rand(160, 245);

$text[0] = imagecolorallocate($captcha, rand(0, 100), rand(0, 100), rand(0, 100));
$text[1] = imagecolorallocate($captcha, rand(0, 100), rand(0, 100), rand(0, 100));
$text[2] = imagecolorallocate($captcha, rand(0, 100), rand(0, 100), rand(0, 100));
$text[3] = imagecolorallocate($captcha, rand(0, 100), rand(0, 100), rand(0, 100));
$text[4] = imagecolorallocate($captcha, rand(0, 100), rand(0, 100), rand(0, 100));

$background = imagecolorallocate($captcha, 255, 255, 255);
$circle = imagecolorallocate($captcha, $rand1, $rand1, $rand1);
$line = imagecolorallocate($captcha, $rand2, $rand2, $rand2);
$line2 = imagecolorallocate($captcha, $rand3, $rand3, $rand3);

srand((double)microtime()*1000000);

$string = md5(rand(0, 9999));

$_SESSION['encoded_string'] = substr($string, 17, 5);

imagefill($captcha, 0, 0, $background);
imagearc($captcha, rand(5, 45), rand(5, 10), rand(0, 50), rand(0, 20), rand(0, 360), rand(0, 360), $circle);
imageline($captcha, rand(5, 45), rand(5, 10), rand(0, 50), rand(0, 20), $line);
imageline($captcha, rand(5, 45), rand(5, 10), rand(0, 50), rand(0, 20), $line2);

for($i = 0; $i < 5; $i++) {
	if ($i == 0) $x = 6;
	elseif ($i == 1) $x = 16;
	elseif ($i == 2) $x = 26;
	elseif ($i == 3) $x = 36;
	elseif ($i == 4) $x = 46;
	else $x = 1;
	imagestring($captcha, 5, $x, 1, substr($_SESSION['encoded_string'], $i, 1), $text[$i]);
}

imagepng($captcha, 'verify.png');
imagedestroy($captcha);
?>