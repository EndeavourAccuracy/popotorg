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
function ProcessComment ()
/*****************************************************************************/
{
	if ((isset ($_POST['mod_id'])) &&
		(isset ($_POST['toadd'])) &&
		(isset ($_SESSION['user_id'])))
	{
		$iLength = strlen ($_POST['toadd']);
		if (($iLength >= 1) && ($iLength <= 5000))
		{
			$iModID = intval ($_POST['mod_id']);
			$sComment = $_POST['toadd'];
			$iUserID = intval ($_SESSION['user_id']);
			/***/
			$sUserNick = $_SESSION['nick'];
			$sDate = date ('Y-m-d H:i:s');

			/*** $sModName ***/
			$query_mod = "SELECT
					mod_name
				FROM `popot_mod`
				WHERE (mod_id='" . $iModID . "')";
			$result_mod = Query ($query_mod);
			$row_mod = mysqli_fetch_assoc ($result_mod);
			$sModName = $row_mod['mod_name'];

			/*** Add comment. ***/
			$query_add_comment = "INSERT INTO `popot_comment` SET
				user_id='" . $iUserID . "',
				mod_id='" . $iModID . "',
				comment='" . mysqli_real_escape_string
					($GLOBALS['link'], $sComment) . "',
				date='" . $sDate . "'";
			Query ($query_add_comment);

			CreateXML ($iModID);

			/*** Notify users. ***/
			$query_to_mail = "SELECT
					DISTINCT(u.nick),
					u.email
				FROM `popot_service` s
				INNER JOIN `popot_user` u
					ON s.user_id=u.user_id
				WHERE (s.mod_id='" . $iModID . "')
				OR (s.mod_id='0')";
			$result_to_mail = Query ($query_to_mail);
			if (mysqli_num_rows ($result_to_mail) >= 1)
			{
				$arEmail = array();
				while ($row_to_mail = mysqli_fetch_assoc ($result_to_mail))
				{
					$sEmail = $row_to_mail['email'];
					$sNick = $row_to_mail['nick'];
					$arEmail[$sEmail] = $sNick;
				}
				$sMessage = 'User "' . Sanitize ($sUserNick) . '" added a comment to <a href="https://www.popot.org/custom_levels.php?mod=' . ModCodeFromID ($iModID) . '" style="font-style:italic;">' . Sanitize ($sModName) . '</a>.<br><br>To unsubscribe, read the <a href="https://www.popot.org/email_service.php">Email Service</a> page.';
				QueueEmail ($arEmail, '[ PoPOT ] new comment', $sMessage);
			}

			$arResult['result'] = 1;
			$arResult['error'] = '';
		} else {
			$arResult['result'] = 0;
			$arResult['error'] = 'Comment must be 1-5000 characters' .
				' (currently: ' . $iLength . ').';
		}
	} else {
		$arResult['result'] = 0;
		$arResult['error'] = 'Add data, or login.';
	}

	print (json_encode ($arResult));
}
/*****************************************************************************/
function ShowComment ($iModID)
/*****************************************************************************/
{
	$query_get_comments = "SELECT
			pc.user_id,
			pu.nick,
			pc.comment,
			pc.date
		FROM `popot_comment` pc
		LEFT JOIN `popot_user` pu
			ON pc.user_id=pu.user_id
		WHERE (mod_id='" . $iModID . "')
		ORDER BY date";
	$result_get_comments = Query ($query_get_comments);
	while ($row_get_comments = mysqli_fetch_assoc ($result_get_comments))
	{
		$iUserID = $row_get_comments['user_id'];
		$sNick = $row_get_comments['nick'];
		$sComment = nl2br (Sanitize ($row_get_comments['comment']));
		$arTags = array (
			'[spoiler]' => '<span class="spoiler">',
			'[/spoiler]' => '</span>',
		);
		$sComment = str_replace (array_keys ($arTags),
			array_values ($arTags), $sComment);
		$sDate = $row_get_comments['date'];

print ('
<img src="images/quote-start.png" alt="">
' . $sComment . '
<img src="images/quote-end.png" alt="">
<br>
<span class="small">
<a target="_blank" href="profile.php?user_id=' . $iUserID . '">
' . Sanitize ($sNick) . '
</a> (' . $sDate . ' UTC)
</span>
<br>
<br>
');
	}
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	ProcessComment();
} else {
	if (isset ($_GET['mod_id']))
		{ $iModID = intval ($_GET['mod_id']); }
	if (isset ($iModID)) { ShowComment ($iModID); }
	if (isset ($_SESSION['user_id']))
	{
print ('
<hr>
<textarea id="comment" name="comment" style="width:100%; height:200px;"></textarea>
<br>
<span class="small">
Max. 5000 characters. Only BBCode allowed: [spoiler]...[/spoiler]
<br>
If you want to say/ask something about this website instead of this mod, please either contact the <a target="_blank" href="contact_faq.php">webmaster</a> or post in the Princed forum <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=67&amp;t=2887">thread</a>. Thanks.
</span>
<br>
<span style="display:block; padding:10px 0 20px 0;">
<div id="comment-error" style="color:#f00;"></div>
<input id="addbutton" type="button" value="Add Comment">
</span>
<script>
$("#addbutton").click(function(){
	var toadd = $("#comment").val();

	$.ajax({
		type: "POST",
		url: "/comment.php",
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
				$("#poll2").load("comment.php?mod_id=' . $iModID . '");
			} else {
				$("#comment-error").html(error);
			}
		},
		error: function() {
			$("#comment-error").html("Error calling comment.php.");
		}
	});
});
</script>
');
	} else {
		print ('<span style="display:block; color:#f00"><a href="user.php?action=Login"><span style="text-decoration:underline; color:#f00">login</span></a> to comment</span>');
	}
}
?>
