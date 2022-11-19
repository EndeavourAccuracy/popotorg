<?php
/* popot.org v4.0 (November 2022)
 * Copyright (C) 2017-2022 Norbert de Jonge <nlmdejonge@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see [ www.gnu.org/licenses/ ].
 */

include_once (dirname (__FILE__) . '/popot_def.php');

/*****************************************************************************/
function ShowLoggedIn ()
/*****************************************************************************/
{
print ('
<select id="loggedin" name="loggedin"');
	if (isset ($_SESSION['user_id'])) { print (' disabled'); }
print ('>
<option value="1">Keeps</option>
<option value="2">Until I exit the browser</option>
<option value="3">1 hour</option>
<option value="4">3 hours</option>
<option value="5">6 hours</option>
<option value="6">12 hours</option>
<option value="7">24 hours</option>
</select>
');
}
/*****************************************************************************/
function ShowCountries ($iCountry)
/*****************************************************************************/
{
	print ('<select class="form-control" id="country" name="country">');
	print ('<option selected>Select...</option>');
	$query_countries = "SELECT
			*
		FROM `popot_country`";
	$result_countries = Query ($query_countries);
	while ($row_countries = mysqli_fetch_assoc ($result_countries))
	{
		$iCountryId = $row_countries['country_id'];
		print ('<option value="' . $iCountryId . '"');
		if ($iCountry == $iCountryId) { print (' selected'); }
		print ('>' . $row_countries['country_name'] . '</option>');
	}
	print ('</select>');
}
/*****************************************************************************/
function RegisterForm ($iRegister)
/*****************************************************************************/
{
	if ($iRegister == 0)
	{
		if (isset ($_SESSION['user_id']))
		{
			$query_get_user = "SELECT
					*
				FROM `popot_user`
				WHERE (user_id='" .	$_SESSION['user_id'] . "')";
			$result_get_user = Query ($query_get_user);
			if (mysqli_num_rows ($result_get_user) == 1)
			{
				$row_get_user = mysqli_fetch_assoc ($result_get_user);
				$edit_nick = $row_get_user['nick'];
				$edit_gender = $row_get_user['gender'];
				$edit_email = $row_get_user['email'];
				$edit_email_p = $row_get_user['email_p'];
				$set_country = $row_get_user['country'];
				$edit_website = $row_get_user['website'];
				$notifynew_pv1_yn = $row_get_user['notifynew_pv1_yn'];
				$notifynew_pv2_yn = $row_get_user['notifynew_pv2_yn'];
				$notifynew_pv4_yn = $row_get_user['notifynew_pv4_yn'];
			} else {
				print ('<p>Strange user_id "' . $_SESSION['user_id'] . '".</p>');
				EndHTML();
				exit();
			}

			/*** All-inclusive email service ***/
			$query_service = "SELECT
					COUNT(*) AS service
				FROM `popot_service`
				WHERE (user_id='" . $_SESSION['user_id'] . "')
				AND (mod_id='0')";
			$result_service = Query ($query_service);
			$row_service = mysqli_fetch_assoc ($result_service);
			$edit_email_s = $row_service['service'];
		} else {
			print ('<p>You need to <a href="user.php?action=Login">' .
				'login</a> first.</p>');
			EndHTML();
			exit();
		}
	} else {
		$set_country = 0;
	}

print ('
<form name="input" action="user.php?action=');
	if ($iRegister == 1) { print ('Register'); } else { print ('Settings'); }
print ('" method="post" onsubmit="JavaScript:return ');
	if ($iRegister == 1) { print ('CheckReg'); } else { print ('CheckChg'); }
print ('();">
<table style="margin:0 auto; max-width:600px;">

<tr>
<td colspan="3">
<p style="text-align:center;">
Fields marked <span class="required">*</span> are required ');
	if ($iRegister == 1) { print ('for registration'); }
		else { print ('to change settings'); }
print ('.
</p>
</td>
</tr>

<tr>
<td class="dotted">Nick:<span class="required">*</span></td>
<td class="dotted" colspan="2">
<input class="form-control" type="text" id="nick" name="nick" maxlength="30"');
	if ($iRegister == 0) { print (' value="' . Sanitize ($edit_nick) . '" disabled'); }
print ('>
</td>
</tr>

<tr>
<td>Password:<span class="required">*</span></td>
<td><input class="form-control" type="password" id="password1" name="password1" maxlength="30"></td>
<td rowspan="2">Should be at least ' . $GLOBALS['password_min_length'] . ' characters.</td>
</tr>
<tr>
<td>Verify password:<span class="required">*</span></td>
<td><input class="form-control" type="password" id="password2" name="password2" maxlength="30"></td>
</tr>

<tr>
<td rowspan="2">Gender:</td>
<td>
<input type="radio" id="gender1" name="gender" value="1"');
	if (($iRegister == 0) && ($edit_gender == 1)) { print (' checked'); }
print ('> Male
</td>
<td rowspan="2">
<input type="radio" id="gender0" name="gender" value="0"');
	if ((($iRegister == 0) && ($edit_gender == 0)) ||
		($iRegister == 1)) { print (' checked'); }
print ('> None selected.
</td>
</tr>
<tr>
<td>
<input type="radio" id="gender2" name="gender" value="2"');
	if (($iRegister == 0) && ($edit_gender == 2)) { print (' checked'); }
print ('> Female
</td>
</tr>

<tr>
<td rowspan="2">Email:<span class="required">*</span></td>
<td colspan="2">
<input class="form-control" type="text" id="email" name="email" maxlength="50"');
	if ($iRegister == 0) { print (' value="' . Sanitize ($edit_email) . '"'); }
print ('>
</td>
</tr>
<tr>
<td colspan="2">
<input type="checkbox" id="email_p" name="email_p"');
	if ((($iRegister == 0) && ($edit_email_p == 1)) ||
		($iRegister == 1)) { print (' checked'); }
print ('> Hide email address from public.
</td>
</tr>

<tr>
<td>Country:</td>
<td colspan="2">');
	ShowCountries ($set_country);
print ('</td>
</tr>

<tr>
<td>Website:</td>
<td colspan="2">
<input class="form-control" type="text" id="website" name="website" maxlength="100" value="');
	if ($iRegister == 1) { print ('https://'); } else { print (Sanitize ($edit_website)); }
print ('">
</td>
</tr>

<tr>
<td>All-inclusive<br>email service:<a target="_blank" href="email_service.php"><img src="images/question_mark.png" style="margin-left:5px; vertical-align:middle;" alt="question mark"></a></td>
<td colspan="2">
<span style="display:block; float:left; width:40px;">
<input type="checkbox" id="email_s" name="email_s"');
	if (($iRegister == 0) && ($edit_email_s == 1)) { print (' checked'); }
print ('>
</span>
<span style="display:block; float:left; width:calc(100% - 40px);">
If you check this, you will receive an email every time someone comments on (or adds a replay to) <span class="italic">any</span> of the mods (custom levels). You can disable this via the Settings link at any time. If you prefer to only receive emails for certain mods, do not check this and instead use the checkboxes on those mods\' pages.
</span>
</td>
</tr>

<tr>
<td>Receive emails about:</td>
<td colspan="2">
<input type="checkbox" id="notifynew_pv1_yn" name="notifynew_pv1_yn"');
	if (($iRegister == 0) && ($notifynew_pv1_yn == 1)) { print (' checked'); }
print ('> Newly-added PoP1 for DOS mods.
<br>
<input type="checkbox" id="notifynew_pv2_yn" name="notifynew_pv2_yn"');
	if (($iRegister == 0) && ($notifynew_pv2_yn == 1)) { print (' checked'); }
print ('> Newly-added PoP2 for DOS mods.
<br>
<input type="checkbox" id="notifynew_pv4_yn" name="notifynew_pv4_yn"');
	if (($iRegister == 0) && ($notifynew_pv4_yn == 1)) { print (' checked'); }
print ('> Newly-added PoP1 for SNES mods.
</td>
</tr>
');

if ($iRegister == 1)
{
	VerifyCreate();
	if (get_extension_funcs ('gd') == TRUE)
	{
		$arGDInfo = gd_info();
		/*** Some GD releases use "bundled (2.1.0 compatible)". ***/
		$arGDVersion = preg_match ('/(\d+(?:\.\d+)*)/',
			$arGDInfo['GD Version'], $arMatch);
		$sGDVersion = $arMatch[0];
		if (version_compare ($sGDVersion, '2.0', '>=') == TRUE)
		{
			$sLabel = '<img src="/captcha.php" alt="x">';
		} else {
			$sLabel = VerifyShow() . ':';
		}
	} else {
		$sLabel = VerifyShow() . ':';
	}

print ('<tr>
<td>Calculate the answer:<span class="required">*</span></td>
<td colspan="2">
' . $sLabel . '
<br>
<input class="form-control" type="text" id="answer" name="answer">
</td>
</tr>');
}

print ('
<tr>
<td class="dotted" colspan="3">
<p style="text-align:center;">
<input name="pressed" type="submit" value="');
	if ($iRegister == 1) { print ('Register'); } else { print ('Change'); }
print ('">
</p>
</td>
</tr>

</table>
</form>
');
}
/*****************************************************************************/
function LoginForm ()
/*****************************************************************************/
{
	if (!isset ($_SESSION['user_id']))
	{
		print ('<p style="text-align:center;">You may need to <a href="user.php' .
			'?action=Register">register</a> first.</p>');
	} else {
		AdminLinks();
	}
	print ('<form name="input" action="user.php?action=Login" method="post"' .
		' onsubmit="JavaScript:return CheckLogin();">');
	print ('<table style="margin:0 auto;">');

print ('
<tr>
<td>Nick:</td>
<td>
<input type="text" id="nick" name="nick" maxlength="30"');
	if (isset ($_SESSION['user_id'])) { print (' disabled'); }
print ('>
</td>
</tr>

<tr>
<td>Password:</td>
<td>
<input type="password" id="password" name="password" maxlength="30"');
	if (isset ($_SESSION['user_id'])) { print (' disabled'); }
print ('>');
if (!isset ($_SESSION['user_id']))
{
print ('<br>
<span class="small italic">Did you <a href="contact_faq.php?subject=' .
	'Forgot%20my%20Password">forget</a> it?</span>');
}
print ('</td>
</tr>

<tr>
<td>Logged in for:</td>
<td>');
	ShowLoggedIn();
print ('</td>
</tr>

<tr>
<td class="dotted" colspan="2">
<p style="text-align:center;">
<input name="pressed" type="submit" value="Login"');
	if (isset ($_SESSION['user_id'])) { print (' disabled'); }
print ('>');
print ('</p>
</td>
</tr>

</table>
</form>
');
}
/*****************************************************************************/
function RegisterOrChange ()
/*****************************************************************************/
{
	$iFailed = 0;
	if (!isset ($_SESSION['user_id']))
	{
		$sNick = $_POST['nick'];
	} else {
		$sNick = $_SESSION['nick']; /*** We don't use this though. ***/
	}
	if (($_POST['pressed'] == 'Register') &&
		(in_array (strtolower ($sNick), $GLOBALS['admins']) === TRUE))
	{
		$GLOBALS['top_text'] = 'Nick is already in use!';
		$GLOBALS['top_type'] = 'error';
		$iFailed = 1;
	}
	if ((strlen ($sNick) < 1) && ($iFailed == 0)) {
		$GLOBALS['top_text'] = 'Nick is too short!';
		$GLOBALS['top_type'] = 'error';
		$iFailed = 1;
	}
	$sPassword1 = $_POST['password1'];
	$sPassword2 = $_POST['password2'];
	if (((strlen ($sPassword1) < $GLOBALS['password_min_length']) ||
		(strlen ($sPassword2) < $GLOBALS['password_min_length'])) &&
		($iFailed == 0))
	{
		$GLOBALS['top_text'] = 'Password is too short!';
		$GLOBALS['top_type'] = 'error';
		$iFailed = 1;
	}
	if ($sPassword1 == $sPassword2)
	{
		$sPassword = $sPassword1;
	} else if ($iFailed == 0) {
		$GLOBALS['top_text'] = 'Passwords did not match!';
		$GLOBALS['top_type'] = 'error';
		$iFailed = 1;
	}
	if (isset ($_POST['gender']))
	{
		$iGender = intval ($_POST['gender']);
	} else {
		$iGender = 0;
	}
	$sEmail = $_POST['email'];
	if ((!filter_var ($sEmail, FILTER_VALIDATE_EMAIL)) && ($iFailed == 0)) {
		$GLOBALS['top_text'] = 'Not a valid email address (' .
			Sanitize ($sEmail) . ')!';
		$GLOBALS['top_type'] = 'error';
		$iFailed = 1;
	}
	if (isset ($_POST['email_p']))
	{
		$iEmailPrivate = 1;
	} else {
		$iEmailPrivate = 0;
	}
	if (isset ($_POST['country']))
	{
		$iCountry = intval ($_POST['country']);
	} else {
		$iCountry = 0;
	}
	$sWebsite = $_POST['website'];
	if (isset ($_POST['email_s']))
	{
		$iEmailService = 1;
	} else {
		$iEmailService = 0;
	}
	if (isset ($_POST['notifynew_pv1_yn']))
		{ $iNotifyNewPV1 = 1; } else { $iNotifyNewPV1 = 0; }
	if (isset ($_POST['notifynew_pv2_yn']))
		{ $iNotifyNewPV2 = 1; } else { $iNotifyNewPV2 = 0; }
	if (isset ($_POST['notifynew_pv4_yn']))
		{ $iNotifyNewPV4 = 1; } else { $iNotifyNewPV4 = 0; }
	if (!isset ($_SESSION['user_id']))
	{
		$sVerify = intval (str_replace ('−', '-', $_POST['answer']));
	} else {
		$sVerify = VerifyAnswer();
	}
	$sIP = GetIP();
	$sDate = date ('Y-m-d H:i:s');

	if ($iFailed == 0)
	{
		if ($sVerify == VerifyAnswer())
		{
			if (!isset ($_SESSION['user_id']))
			{
				if ((CheckExists ('popot_user', 'nick', $sNick) == false) &&
					(CheckExists ('popot_user', 'email', $sEmail) === FALSE) &&
					(CheckExists ('popot_user', 'ip', $sIP) == false))
				{
					$query_add_user = "INSERT INTO `popot_user` SET
						nick='" . mysqli_real_escape_string
							($GLOBALS['link'], $sNick) . "',
						password=SHA1('" . mysqli_real_escape_string
							($GLOBALS['link'], $sPassword) . "'),
						gender='" . $iGender . "',
						email='" . mysqli_real_escape_string
							($GLOBALS['link'], $sEmail) . "',
						email_p='" . $iEmailPrivate . "',
						country='" . $iCountry . "',
						website='" . mysqli_real_escape_string
							($GLOBALS['link'], $sWebsite) . "',
						ip='" . $sIP . "',
						notifynew_pv1_yn='" . $iNotifyNewPV1 . "',
						notifynew_pv2_yn='" . $iNotifyNewPV2 . "',
						notifynew_pv4_yn='" . $iNotifyNewPV4 . "',
						date='" . $sDate . "'";
					Query ($query_add_user);

					/*** All-inclusive email service ***/
					if ($iEmailService == 1)
					{
						$iUserID = intval (mysqli_insert_id ($GLOBALS['link']));
						$query_service_on = "INSERT INTO `popot_service` SET
							user_id='" . $iUserID . "',
							mod_id='0'";
						Query ($query_service_on);
					}

					$GLOBALS['top_text'] = 'Registration complete.';
					$GLOBALS['top_type'] = 'success';
				} else {
					$GLOBALS['top_text'] = 'Nick, email or IP already in use!';
					$GLOBALS['top_type'] = 'error';
				}
			} else {
				/*** Do not add: user_id, nick, ip, date ***/
				$update_query = "UPDATE `popot_user` SET
					password=SHA1('" . mysqli_real_escape_string
						($GLOBALS['link'], $sPassword) . "'),
					gender='" . $iGender . "',
					email='" . mysqli_real_escape_string
						($GLOBALS['link'], $sEmail) . "',
					email_p='" . $iEmailPrivate . "',
					country='" . $iCountry . "',
					website='" . mysqli_real_escape_string
						($GLOBALS['link'], $sWebsite) . "',
					notifynew_pv1_yn='" . $iNotifyNewPV1 . "',
					notifynew_pv2_yn='" . $iNotifyNewPV2 . "',
					notifynew_pv4_yn='" . $iNotifyNewPV4 . "'
					WHERE (user_id = '" . $_SESSION['user_id'] . "')";
				Query ($update_query);

				/*** All-inclusive email service ***/
				$query_service = "SELECT
						COUNT(*) AS service
					FROM `popot_service`
					WHERE (user_id='" . $_SESSION['user_id'] . "')
					AND (mod_id='0')";
				$result_service = Query ($query_service);
				$row_service = mysqli_fetch_assoc ($result_service);
				if (($iEmailService == 1) && ($row_service['service'] == 0))
				{
					$query_service_on = "INSERT INTO `popot_service` SET
						user_id='" . $_SESSION['user_id'] . "',
						mod_id='0'";
					Query ($query_service_on);
				}
				if (($iEmailService == 0) && ($row_service['service'] == 1))
				{
					$query_service_off = "DELETE FROM `popot_service`
						WHERE (user_id='" . $_SESSION['user_id'] . "')
						AND (mod_id='0')";
					Query ($query_service_off);
				}

				$GLOBALS['top_text'] = 'Settings changed.';
				$GLOBALS['top_type'] = 'success';
			}
		} else {
			$GLOBALS['top_text'] = 'Incorrect CAPTCHA answer!';
			$GLOBALS['top_type'] = 'error';
		}
	}
}
/*****************************************************************************/
function Login ()
/*****************************************************************************/
{
	$iLoggedIn = intval ($_POST['loggedin']);

	$query_get_user = "SELECT
			*
		FROM `popot_user`
		WHERE (nick='" . mysqli_real_escape_string
			($GLOBALS['link'], $_POST['nick']) . "')
		AND (password=SHA1('" . mysqli_real_escape_string
			($GLOBALS['link'], $_POST['password']) . "'))";
	$result_get_user = Query ($query_get_user);
	if (mysqli_num_rows ($result_get_user) == 1)
	{
		$row_get_user = mysqli_fetch_assoc ($result_get_user);
		switch ($iLoggedIn)
		{
			case 1: $iKeep = 99999999; break; /*** Keeps; little over 3 years ***/
			case 2: $iKeep = 0; break; /*** Until I exit the browser ***/
			case 3: $iKeep = 3600; break; /*** 1 hour ***/
			case 4: $iKeep = 10800; break; /*** 3 hours ***/
			case 5: $iKeep = 21600; break; /*** 6 hours ***/
			case 6: $iKeep = 43200; break; /*** 12 hours ***/
			case 7: $iKeep = 86400; break; /*** 24 hours ***/
			default: $iKeep = 0; break; /*** Fallback. ***/
		}
		StartSession ($iKeep);
		$_SESSION['user_id'] = intval ($row_get_user['user_id']);
		$_SESSION['nick'] = Sanitize ($row_get_user['nick']);

		$GLOBALS['top_text'] = 'You are now logged in.';
		$GLOBALS['top_type'] = 'success';
	} else {
		$GLOBALS['top_text'] = 'Incorrect nick or password!';
		$GLOBALS['top_type'] = 'error';
	}
}
/*****************************************************************************/
function Logout ()
/*****************************************************************************/
{
	setcookie ('popot', session_id(), time() - (3600 * 25));
	$_SESSION = array();
	/***/
	$GLOBALS['top_text'] = 'Thank you for your visit.';
	$GLOBALS['top_type'] = 'success';
}
/*****************************************************************************/

/*** Actions before showing the page. ***/
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'Logout')
		{ Logout(); }
}
if (isset ($_POST['pressed']))
{
	if (($_POST['pressed'] == 'Register') || ($_POST['pressed'] == 'Change'))
		{ RegisterOrChange(); }
	if (($_POST['pressed'] == 'Login') && (!isset ($_SESSION['user_id'])))
		{ Login(); }
}

/*** Show the page. ***/
if (isset ($_GET['action']))
{
	switch ($_GET['action'])
	{
		case 'Register':
			StartHTML ('User', 'Register', 'user.php', 'Account');
			RegisterForm (1);
			break;
		case 'Login':
			StartHTML ('User', 'Login', 'user.php', 'Account');
			LoginForm();
			break;
		case 'Logout':
			StartHTML ('User', 'Logout', 'user.php', 'Account');
			print ('<p>Hope to see you again soon!</p>');
			break;
		case 'Settings':
			StartHTML ('User', 'Settings', 'user.php', 'Account');
			RegisterForm (0);
			break;
	}
}
if ($GLOBALS['html_started'] == 0)
{
	StartHTML ('User', '', '', 'Account');
	if (isset ($_SESSION['user_id']))
	{
		print ('<p><a href="user.php?action=Settings">Settings</a> &amp;' .
			' <a href="profile.php?user_id=' . $_SESSION['user_id'] .
			'">Profile</a> &amp;' .
			' <a href="user.php?action=Logout">Logout</a></p>');
	} else {
		print ('<p><a href="user.php?action=Register">Register</a> &amp;' .
			' <a href="user.php?action=Login">Login</a></p>');
	}
}

EndHTML();
?>
