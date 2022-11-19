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
function SignIn ()
/*****************************************************************************/
{
	$sNick = $_POST['nick'];

	$query_user = "SELECT
			user_id,
			nick
		FROM `popot_user`
		WHERE (nick='" . mysqli_real_escape_string
			($GLOBALS['link'], $sNick) . "')";
	$result_user = Query ($query_user);
	if (mysqli_num_rows ($result_user) == 1)
	{
		$row_user = mysqli_fetch_assoc ($result_user);
		$_SESSION['user_id'] = $row_user['user_id'];
		$_SESSION['nick'] = Sanitize ($row_user['nick']);
		/***/
		$GLOBALS['top_text'] = 'You are now user "' . $_SESSION['nick'] . '".';
		$GLOBALS['top_type'] = 'success';
	} else {
		$GLOBALS['top_text'] = 'Cannot find user "' . Sanitize ($sNick) . '".';
		$GLOBALS['top_type'] = 'error';
	}
}
/*****************************************************************************/

if ((isset ($_POST['nick'])) &&
	(IsAdmin() === TRUE)) { SignIn(); }

StartHTML ('User', 'Sign in', 'user.php', 'Account');

if (IsAdmin() === FALSE)
{
	if (isset ($_SESSION['user_id']))
	{
		print ('First, <a href="/user.php?action=Logout">logout</a>' .
			' and re-login as an admin.');
	} else {
		print ('First, <a href="/user.php?action=Login">login</a>' .
			' as an admin.');
	}
} else {
	AdminLinks();

print ('
<span style="text-align:center;">
<form name="input" action="signin.php" method="post">
<input name="pressed" type="submit" value="Sign in">
&nbsp;as&nbsp;
<input type="text" id="nick" name="nick" maxlength="40" placeholder="nick">
</form>
</span>
');
}

EndHTML();
?>
