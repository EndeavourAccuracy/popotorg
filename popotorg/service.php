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
function ProcessService ()
/*****************************************************************************/
{
	if ((isset ($_POST['mod_id'])) &&
		(isset ($_POST['toadd'])) &&
		(isset ($_SESSION['user_id'])))
	{
		$iModID = intval ($_POST['mod_id']);
		$iToAdd = intval ($_POST['toadd']);
		$iUserID = intval ($_SESSION['user_id']);

		$query_service = "SELECT
				service_id
			FROM `popot_service`
			WHERE (user_id='" . $iUserID . "')
			AND (mod_id='" . $iModID . "')";
		$result_service = Query ($query_service);
		if (($iToAdd == 1) && (mysqli_num_rows ($result_service) == 0))
		{
			$query_service_on = "INSERT INTO `popot_service` SET
				user_id='" . $iUserID . "',
				mod_id='" . $iModID . "'";
			Query ($query_service_on);
		}
		if (($iToAdd == 0) && (mysqli_num_rows ($result_service) == 1))
		{
			$query_service_off = "DELETE FROM `popot_service`
				WHERE (user_id='" . $iUserID . "')
				AND (mod_id='" . $iModID . "')";
			Query ($query_service_off);
		}
		$arResult['result'] = 1;
		$arResult['error'] = '';
	} else {
		$arResult['result'] = 0;
		$arResult['error'] = 'Add data, or login.';
	}

	print (json_encode ($arResult));
}
/*****************************************************************************/
function ShowService ($iModID)
/*****************************************************************************/
{
	$query_service = "SELECT
			service_id
		FROM `popot_service`
		WHERE (user_id='" . $_SESSION['user_id'] . "')
		AND (mod_id='0')";
	$result_service = Query ($query_service);
	if (mysqli_num_rows ($result_service) == 1)
	{
		print ('You receive emails about <i>everything</i>' .
			' (<a href="/user.php?action=Settings">change</a>).');
	} else {
		$query_service = "SELECT
				service_id
			FROM `popot_service`
			WHERE (user_id='" . $_SESSION['user_id'] . "')
			AND (mod_id='" . $iModID . "')";
		$result_service = Query ($query_service);
		if (mysqli_num_rows ($result_service) == 1)
			{ $sChecked = ' checked'; } else { $sChecked = ''; }
print ('
<input type="checkbox" id="email_s" name="email_s" style="cursor:pointer;"' . $sChecked . '>
<div id="service-error" style="color:#f00;"></div>
<span class="small" id="scom">Email me about<br>new comments and replays.</span>
<script>
$("#email_s").click(function(){
	var toadd_bool = $("#email_s").is(":checked");
	if (toadd_bool == false)
		{ var toadd = 0; } else { var toadd = 1; }

	$.ajax({
		type: "POST",
		url: "/service.php",
		data: ({
			mod_id : "' . $iModID . '",
			toadd : toadd
		}),
		dataType: "json",
		success: function(data) {
			var result = data["result"];
			var error = data["error"];
			if (result == 1)
			{
				alert ("Success.");
			} else {
				$("#service-error").html(error);
			}
		},
		error: function() {
			$("#service-error").html("Error calling service.php.");
		}
	});
});
</script>
');
	}
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	ProcessService();
} else if (isset ($_SESSION['user_id'])) {
	if (isset ($iModID)) { ShowService ($iModID); }
} else {
print ('
<input type="checkbox" style="cursor:pointer;" onmouseover="document.getElementById(\'scom\').innerHTML = \'You need to login<br>to use this.\';" onmouseout="document.getElementById(\'scom\').innerHTML = \'Email me about<br>new comments and replays.\';" disabled>
<br>
<span class="small" id="scom">Email me about<br>new comments and replays.</span>
');
}
?>
