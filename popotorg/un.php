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
function Unsubscribe ()
/*****************************************************************************/
{
	$sUn = $_POST['email'];

	$iDeleted = 0;

	$query_unsubscribe = "DELETE s FROM `popot_service` s
		LEFT JOIN `popot_user` u
			ON s.user_id=u.user_id
		WHERE (u.email='" . mysqli_real_escape_string
			($GLOBALS['link'], $sUn) . "')";
	$result_unsubscribe = Query ($query_unsubscribe);
	$iDeleted += mysqli_affected_rows ($GLOBALS['link']);

	$query_unsubscribe = "UPDATE `popot_user` SET
			notifynew_pv1_yn='0',
			notifynew_pv2_yn='0',
			notifynew_pv4_yn='0'
		WHERE (email='" . mysqli_real_escape_string
			($GLOBALS['link'], $sUn) . "')";
	$result_unsubscribe = Query ($query_unsubscribe);
	$iDeleted += mysqli_affected_rows ($GLOBALS['link']);

	if ($iDeleted > 0)
	{
		$GLOBALS['top_text'] = 'Deleted ' . $iDeleted .
			' subscription(s) from "' . Sanitize ($sUn) . '".';
		$GLOBALS['top_type'] = 'success';
	} else {
		$GLOBALS['top_text'] = 'Nothing to delete for "' .
			Sanitize ($sUn) . '".';
		$GLOBALS['top_type'] = 'normal';
	}
}
/*****************************************************************************/

if ((isset ($_POST['email'])) &&
	(IsAdmin() === TRUE)) { Unsubscribe(); }

StartHTML ('User', 'Unsubscribe', 'user.php', 'Account');

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
<form name="input" action="un.php" method="post">
<input type="text" id="email" name="email" maxlength="50" placeholder="email address">
<input name="pressed" type="submit" value="Unsubscribe">
</form>
</span>
');
}

EndHTML();
?>
