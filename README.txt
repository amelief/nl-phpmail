~~~~~~~~~~~~~~~~~~~~~~
##
## NL-PHPMail 2.2.2 ##
                    ##
~~~~~~~~~~~~~~~~~~~~~~


PLEASE BE SURE TO READ ALL OF THIS FILE BEFORE USING NL-PHPMail.

===================================================================
NL-PHPMail: Copyright © 2002-2005 Sasha (http://nothing-less.net), and 2005-2009 Amelie M.

You may:
- Use and edit/modify NL-PHPMail however you like, AS LONG AS A LINK BACK TO codegrrl.com IS PROVIDED.
- Tell other people about it
- Ask for help regarding this script at any time

You may not:
- Redistribute this script in any way, shape or form without written permission from its creator, whether it has been modified or not
- Claim ownership of this script, however much you have modified it
- Earn money by installing, customising, modifying or troubleshooting this script for other people
- Hold Sasha, Amelie or anyone at CodeGrrl.com responsible for anything that arises from its use

Amelie, Not-Noticeably.net
===================================================================


INTRODUCTION
-----------------------------------------------

NL-PHPMail is a simple form-mailing script which uses PHP's mail() function to send the contents of a web form to your email address.


CHANGELOG
-----------------------------------------------

Version 2.2.2:

	- Fix for PHP 5.3.1
	- Renamed verify.jpg to verify.png (for PHP 5.3.1 GD bug)
	- Removed deprecated code

Version 2.2.1:

	- Removed name and email address from mail headers in order to increase security and allow sending of mail from strict servers
	- Cleared up code, better instructions

Version 2.2:

	-Changed error handling to a function for easier integration
	-General code optimisation
	-Improved header injection protection and captcha
	-Fixed cleanup function so that entities are no longer escaped in emails received

Version 2.1.2:

	-Added a few security fixes
	-email address is now not required

Version 2.1.1:

	-A couple of bug fixes regarding image verification

Version 2.1:

	-Added image verification and further HTML validation to example form
	-Renamed form from form.html to form.php

Version 2.0:

	-Added spam protection measures
	-Changed the name of the script from email.php to nlphpmail.php - hopefully spammers won't be able to find it as easily!
	-Fully compatible with register_globals disabled
	-Better email verification - protects against spammers using your form to spam others
	-form.html is now XHTML 1.1 compliant
	-Script sanitizes input properly and is much harder to hack
	-Useable with multiple HTML forms! (Yay!)

Version 1.5:

	-Changed the script to a zip file download instead of an online tutorial
	-Added an example HTML form
	-Added a link back button
	-Changed the setup of the script, with the variables at the top of the file so it's easier to edit and set up.


REQUIREMENTS
-----------------------------------------------

To use NL-PHPMail, you need a server with PHP 4.2 or higher which allows the use of PHP's mail() function (not all hosts allow this - please check with your host before using the script. To use image verification, your PHP installation will need the GD image libraries. Please ask your host if you are unsure if this is available on your server.


FILES
-----------------------------------------------

Inside this zip file, you should have the following files:

- nlphpmail.php
     This is the main script file and the only one you need to edit
- captcha.php
     This file contains the CAPTCHA configuration. Do not edit this.
- form.php
     An example form that you can edit
- verify.png
     The CAPTCHA image
- phpmail.gif
     A link button, should you require it.
- README.txt
     This file :)


HOW TO INSTALL AND USE THE SCRIPT
-----------------------------------------------

1. Open up form.php and edit it to fit in with your website. Or alternatively, create your own HTML form (as long as it has a .php extension) and have it point to nlphpmail.php in the <form action=""> tag, (see the example in form.php if you are not sure how to do this).

Make sure you change this value to match the subject of the email you want to be sent:

	<input type="hidden" name="subject" value="SUBJECT HERE" />

If you are creating your own form page, remember to add this or your email will have no subject (which some email clients identify as spam, and some servers refuse to send).

2. Open nlphpmail.php in a text editor such as Notepad and read through the file - instructions are given where edits are required.

3. Upload the form, captcha.php, verify.png and nlphpmail.php to your webserver. They can be in any folder you wish, as long as they are in the same folder. If you upload nlphpmail.php into a different folder from the form, make sure you change the path in the <form action=""> part as well.
IMPORTANT: YOU WILL NEED TO CHMOD verify.png TO 666 FOR THE SCRIPT TO WORK PROPERLY!

4. If you are writing your own form page, please make sure that you "name" your submit or send button "submit". If you do not do this, your form will not work. This is part of the spam protection and makes sure that your form was actually filled in from your page.

Example:
	<input type="submit" value="Send form" name="submit" />

See the name="submit" part? That part MUST be included for the script to work.

Another thing you must do if you are creating your own form is to include captcha.php (you only need to do this if you require the use of image verification - you should set this preference in nlphpmail.php).

To do this:

a) At the VERY START of your form page (which must have a .php extension for this to work), before any HTML or other PHP code, add this line:

	<?php @include 'captcha.php'; ?>

This code must appear before any content on your page, and there must be no whitespace above it. If you aren't making your own form, make sure that when editing form.php, you start editing beneath that code.

b) Where you want the image verification to show up, use this code:

	<label for="verifyimage">Enter the letters and numbers you see on this image into the box below:</label><br />
	<img src="verify.png" alt="CAPTCHA Image" /><br />
	<input type="text" name="verifyimage" id="verifyimage" maxlength="5" />

You MUST use the <input> tag as written above. If you don't, you will be unable to send the form. Feel free to change the text and placement of the image around (you cannot change the name of the image, so you must make sure the source of the image is "verify.png" and nothing else).

Please remember that not everyone will be able to use your form if you are using image verification. A lot of people browse with images turned off, or use screen readers which can't decode the image, or simply can't see the letters and numbers on the image. Make sure that you have an alternative method for such users to contact you.

If you aren't using image verification and are not making your own form, please make sure to delete the parts of code as specified in form.php (there are two parts to delete, make sure you delete both of them). You can then rename your form to .html if you so wish.

Also, make sure you include the subject line in your form as detailed in step 1 above.

Please note: If you are using image verification, you will need to refresh the form page if you get an error message (as a new image must be created). Simply pressing "back" on your browser will not be enough. You may wish to tell your visitors in your error messages.
Also, the form will automatically clear itself in some browsers when refreshed for a new image. Please be aware of this if you expect long messages to be sent through your form.


ADDITIONAL NOTES
-----------------------------------------------

This version of NL-PHPMail is compatible with multiple forms. All you have to do is to make another form page and point it to this script, remembering to change the subject field in the HTML. Your form will be sent to the same email address as you specified for the script's original use, and will have the same required fields which means you must specify those fields in all forms pointed to this script. If you don't want this to happen, you will need to upload another copy of the script and point your new form there.


CREDITS
-----------------------------------------------

Original script created by Sasha (http://nothing-less.net/)

NL-PHPMail was rewritten from v2.0+ by Amelie of Not-Noticeably.net for CodeGrrl.com.

Email verification code from Zend.com and CodeGrrl.com Forums, posted by Jenny F aka OrangeSkidoo.
Header injection protection uses part of a tutorial from Tutorialtastic (http://www.tutorialtastic.co.uk/) by Jem.
Image verification adapted from a tutorial by John, available from http://www.phpnoise.com/tutorials/1/1.


PROBLEMS?
-----------------------------------------------

If you run into any problems with NL-PHPMail, please visit the CodeGrrl FAQ (http://codegrrl.com/faq/) to see if your problem has already been addressed. If it hasn't, please visit the forums (http://codegrrl.com/forums/) and search there. You should only start a new topic if you do not find ANY of the solutions helpful.

We respectfully ask that you DO NOT email Vixx or any other CG staff members personally about problems with this or any other of our scripts. Any such requests will be ignored.