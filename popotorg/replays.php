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
function DropDownLevels ()
/*****************************************************************************/
{
print ('
<select style="width:100px;" id="level" name="level" onkeypress="return event.keyCode!=13">
<option value="no">Choose...</option>
<option value="1">lvl 1</option>
<option value="2">lvl 2</option>
<option value="3">lvl 3</option>
<option value="4">lvl 4</option>
<option value="5">lvl 5</option>
<option value="6">lvl 6</option>
<option value="7">lvl 7</option>
<option value="8">lvl 8</option>
<option value="9">lvl 9</option>
<option value="10">lvl 10</option>
<option value="11">lvl 11</option>
<option value="12">lvl 12a</option>
<option value="13">lvl 12b</option>
<option value="14">princess</option>
<option value="15">potions</option>
<option value="0">demo</option>
<option value="16">other</option>
<option value="21">lvl 1 alt.</option>
<option value="22">lvl 2 alt.</option>
<option value="23">lvl 3 alt.</option>
<option value="24">lvl 4 alt.</option>
<option value="25">lvl 5 alt.</option>
<option value="26">lvl 6 alt.</option>
<option value="27">lvl 7 alt.</option>
<option value="28">lvl 8 alt.</option>
<option value="29">lvl 9 alt.</option>
<option value="30">lvl 10 alt.</option>
<option value="31">lvl 11 alt.</option>
<option value="32">lvl 12a alt.</option>
<option value="33">lvl 12b alt.</option>
<option value="34">princess alt.</option>
<option value="35">potions alt.</option>
<option value="20">demo alt.</option>
<option value="36">other alt.</option>
</select>
');
}
/*****************************************************************************/
function ReplaysList ($iModID)
/*****************************************************************************/
{
	$query_get_replays = "SELECT
			pr.level_nr,
			pr.user_id,
			pr.comment,
			pr.program,
			pr.date,
			pu.nick
		FROM `popot_replay` pr
		LEFT JOIN `popot_user` pu
			ON pr.user_id=pu.user_id
		WHERE (mod_id='" . $iModID . "')
		ORDER BY level_nr";
	$result_get_replays = Query ($query_get_replays);
	while ($row_get_replays = mysqli_fetch_assoc ($result_get_replays))
	{
		$iLevel = $row_get_replays['level_nr'];
		$iUserId = $row_get_replays['user_id'];
		$sComment = $row_get_replays['comment'];
		$sProgram = $row_get_replays['program'];
		$sDate = $row_get_replays['date'];
		$sNick = $row_get_replays['nick'];

		print ('<img src="images/replay_' . $sProgram . '.png" alt="program"> ');

		print ('<a href="' . ReplayURL ($iModID, $iLevel, $iUserId, $sProgram) .
			'">' . LevelNrToString ($iLevel) . '</a>');
		print ('<br>');
		if ($sComment != '')
		{
			print ('<img src="images/quote-start.png" alt="quote">' .
				Sanitize ($sComment) .
				'<img src="images/quote-end.png" alt="unquote">');
			print ('<br>');
		}
		print ('<span class="small">');
		print ('<a href="profile.php?user_id=' . $iUserId .
			'">' . Sanitize ($sNick) . '</a> (' . $sDate . ' UTC)</span><br><br>');
	}
}
/*****************************************************************************/
function AddReplays ($iModID)
/*****************************************************************************/
{
print ('
<hr>
<form method="post" id="fileinfo" name="fileinfo">
<input type="hidden" name="mod" value="' . $iModID . '">
<p>If you re-upload for the same level + program combo, your old replay will be overwritten!</p>
<span class="small">File:</span>
<br>
<input style="display:block; max-width:100px; overflow-x:hidden; margin:0 auto;" type="file" id="file" name="file" accept=".p1r,.mrp" required>
<span style="display:block; width:100%; overflow-x:hidden; margin:0 auto;" id="filename"><span class="required">(none)</span></span>
<br>
<span class="small">Level:</span>
<br>
');
	DropDownLevels();
print ('
<br><br>
<span class="small">Description:</span>
<br>
<input style="width:100px; box-sizing:border-box;" type="text" id="rcomment" name="rcomment" maxlength="15" placeholder="optional">
<br>
<div id="replays-error" style="color:#f00;"></div>
<span style="display:block; padding:10px 0 20px 0;">
<button id="addrbutton" type="button">Add</button>
</span>
</form>

<script>
$("#file").on("change", function(){
	var file = $(this).val();
	$("#filename").html(file);
});
</script>

<script>
$("#addrbutton").click(function(){
	var file = $("#file").prop("files");
	var form_data = new FormData();
	form_data.append ("file", file[0]);
	form_data.append ("mod_id", "' . $iModID . '");
	form_data.append ("level", $("#level").val());
	form_data.append ("rcomment", $("#rcomment").val());

	$.ajax({
		type: "POST",
		url: "/replaysp.php",
		data: form_data,
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			var result = data["result"];
			var error = data["error"];
			if (result == 1)
			{
				$("#replays").load("replays.php?mod_id=' . $iModID . '");
			} else {
				$("#replays-error").html(error);
			}
		},
		error: function() {
			$("#replays-error").html("Error calling replaysp.php.");
		}
	});
});
</script>
');
}
/*****************************************************************************/

if (isset ($_GET['mod_id']))
	{ $iModID = intval ($_GET['mod_id']); }
ReplaysList ($iModID);

if (isset ($_SESSION['user_id']))
{
	if (isset ($iModID)) { AddReplays ($iModID); }
} else {
	print ('<span style="display:block; color:#f00"><a href="user.php?action=Login"><span style="text-decoration:underline; color:#f00">login</span></a> to submit</span>');
}
?>
