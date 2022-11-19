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
function ProcessBar ($iVoteType)
/*****************************************************************************/
{
	if ((isset ($_POST['mod_id'])) &&
		(isset ($_POST['toadd'])) &&
		(isset ($_SESSION['user_id'])))
	{
		$iVote = intval ($_POST['toadd']);
		if (($iVote >= 1) && ($iVote <= 5))
		{
			$iModID = intval ($_POST['mod_id']);
			$iUserID = intval ($_SESSION['user_id']);
			$sDate = date ('Y-m-d H:i:s');

			$query_delete = "DELETE FROM `popot_vote`
				WHERE (mod_id='" . $iModID . "')
				AND (user_id='" . $iUserID . "')
				AND (vote_type='" . $iVoteType . "')";
			Query ($query_delete);
			$query_add = "INSERT INTO `popot_vote` SET
				vote_type='" . $iVoteType . "',
				mod_id='" . $iModID . "',
				user_id='" . $iUserID . "',
				date='" . $sDate . "',
				vote='" . $iVote . "'";
			Query ($query_add);

			CreateXML ($iModID);

			$arResult['result'] = 1;
			$arResult['error'] = '';
		} else {
			$arResult['result'] = 0;
			$arResult['error'] = 'Vote must be 1-5.';
		}
	} else {
		$arResult['result'] = 0;
		$arResult['error'] = 'Add data, or login.';
	}

	print (json_encode ($arResult));
}
/*****************************************************************************/
function ShowBar ($iModID, $iVoteType, $sVoteShow)
/*****************************************************************************/
{
	$query_get_votes = "SELECT
			vote
		FROM `popot_vote`
		WHERE (mod_id='" . $iModID . "')
		AND (vote_type='" . $iVoteType . "')";
	$result_get_votes = Query ($query_get_votes);
	$iMatches = mysqli_num_rows ($result_get_votes);
	if ($iMatches > 0)
	{
		$iTotal = 0;
		while ($row_get_votes = mysqli_fetch_assoc ($result_get_votes))
		{
			$iTotal += $row_get_votes['vote'];
		}
		$fScore = $iTotal / $iMatches;
		$fRounded = round ($fScore / 0.5) * 0.5;
	} else {
		$fRounded = 0;
	}
	switch ($fRounded)
	{
		case 0: $sShow = '00'; break;
		case 0.5: $sShow = '05'; break;
		case 1: $sShow = '10'; break;
		case 1.5: $sShow = '15'; break;
		case 2: $sShow = '20'; break;
		case 2.5: $sShow = '25'; break;
		case 3: $sShow = '30'; break;
		case 3.5: $sShow = '35'; break;
		case 4: $sShow = '40'; break;
		case 4.5: $sShow = '45'; break;
		case 5: $sShow = '50'; break;
	}
	print ('<map name="' . $sVoteShow . 'map">');
	if (isset ($_SESSION['user_id']))
	{
		AreaRect (0, 20, '1', $sVoteShow, '10', $sShow, 'poll' .
			$sVoteShow, $iModID);
		AreaRect (20, 40, '2', $sVoteShow, '20', $sShow, 'poll' .
			$sVoteShow, $iModID);
		AreaRect (40, 60, '3', $sVoteShow, '30', $sShow, 'poll' .
			$sVoteShow, $iModID);
		AreaRect (60, 80, '4', $sVoteShow, '40', $sShow, 'poll' .
			$sVoteShow, $iModID);
		AreaRect (80, 100, '5', $sVoteShow, '50', $sShow, 'poll' .
			$sVoteShow, $iModID);
print ('
<div id="' . $sVoteShow . '-error" style="color:#f00;"></div>
<script>
$(\'[id^="' . $sVoteShow . '"]\').click(function(){
	var toadd = $(this).attr("id").substr(-1);

	$.ajax({
		type: "POST",
		url: "/' . $sVoteShow . '.php",
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
				$("#poll' . $sVoteShow . '").load("' .
					$sVoteShow . '.php?mod_id=' . $iModID . '");
			} else {
				$("#' . $sVoteShow . '-error").html(error);
			}
		},
		error: function() {
			$("#' . $sVoteShow . '-error").html("Error calling ' .
				$sVoteShow . '.php.");
		}
	});
});
</script>
');
	} else {
		AreaRect (0, 100, 'login', $sVoteShow, 'login', $sShow, 'poll' .
			$sVoteShow, $iModID);
	}
	print ('</map>');
	print ('<img id="' . $sVoteShow . '" src="images/' . $sVoteShow .
		'_' . $sShow . '.png" usemap="#' . $sVoteShow . 'map" alt="' .
		$sVoteShow . '">');
	print ('<br>');
	print ('<span class="small">');
	switch ($iMatches)
	{
		case 0: print ('not yet rated'); break;
		case 1: print ('rated ' . round ($fScore, 2) . ' by 1 person'); break;
		default: print ('rated ' . round ($fScore, 2) . ' by ' .
			$iMatches . ' people'); break;
	}
	print ('<br>');
	if (isset ($_SESSION['user_id']))
	{
		$query_your_vote = "SELECT
				vote
			FROM `popot_vote`
			WHERE (mod_id='" . $iModID . "')
			AND (user_id='" . $_SESSION['user_id'] . "')
			AND (vote_type='" . $iVoteType . "')";
		$result_your_vote = Query ($query_your_vote);
		$iVoted = mysqli_num_rows ($result_your_vote);
		if ($iVoted == 0)
		{
			print ('your vote: none');
		} else {
			$row_your_vote = mysqli_fetch_assoc ($result_your_vote);
			print ('your vote: ' . $row_your_vote['vote']);
		}
	}
	print ('</span>');
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	ProcessBar (2);
} else {
	if (isset ($_GET['mod_id']))
		{ $iModID = intval ($_GET['mod_id']); }
	if (isset ($iModID)) { ShowBar ($iModID, 2, 'bar'); }
}
?>
