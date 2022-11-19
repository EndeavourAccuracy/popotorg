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
function ShowProfile ($iUserId, $result_user)
/*****************************************************************************/
{
	$row_user = mysqli_fetch_assoc ($result_user);
	$sNick = $row_user['nick'];

	StartHTML ('User', Sanitize ($sNick), 'user.php', 'Account');

	if ($row_user['email_p'] == 0)
	{
		$sEmail = $row_user['email'];
	} else {
		$sEmail = 'private';
	}
	switch ($row_user['gender'])
	{
		case 0: $sGender = 'private'; break;
		case 1: $sGender = 'male'; break;
		case 2: $sGender = 'female'; break;
	}
	$sRegistered = substr ($row_user['date'], 0, 10);
	if ($row_user['country'] != 0)
	{
		$query_country = "SELECT
				country_name
			FROM `popot_country`
			WHERE (country_id='" . $row_user['country'] . "')";
		$result_country = Query ($query_country);
		$row_country = mysqli_fetch_assoc ($result_country);
		$sCountry = $row_country['country_name'];
	} else {
		$sCountry = 'private';
	}

	/*** website ***/
	$sWebsite = $row_user['website'];
	if (($sWebsite == '') || ($sWebsite == 'https://'))
	{
		$sWebsite = 'none';
	}

	/*** comments ***/
	$query_comments = "SELECT
			COUNT(*) AS `count`
		FROM `popot_comment`
		WHERE (user_id='" . $iUserId . "')";
	$result_comments = Query ($query_comments);
	$row_comments = mysqli_fetch_assoc ($result_comments);
	$iComments = $row_comments['count'];

	/*** replays ***/
	$query_replays = "SELECT
			COUNT(*) AS `count`
		FROM `popot_replay`
		WHERE (user_id='" . $iUserId . "')";
	$result_replays = Query ($query_replays);
	$row_replays = mysqli_fetch_assoc ($result_replays);
	$iReplays = $row_replays['count'];

	$iEnjoyment = 0;
	$iDifficulty = 0;
	$query_votes = "SELECT
			vote_type,
			AVG(vote) AS average,
			COUNT(*) AS votes
		FROM `popot_vote`
		WHERE (user_id='" . $iUserId . "')
		GROUP BY vote_type";
	$result_votes = Query ($query_votes);
	$iVoted = mysqli_num_rows ($result_votes);
	if ($iVoted != 0)
	{
		while ($row_votes = mysqli_fetch_assoc ($result_votes))
		{
			switch ($row_votes['vote_type'])
			{
				case 1:
					$fEnjoyment = $row_votes['average'];
					$iEnjoyment = $row_votes['votes'];
					break;
				case 2:
					$fDifficulty = $row_votes['average'];
					$iDifficulty = $row_votes['votes'];
					break;
			}
		}
	}

	$query_service = "SELECT
			s.mod_id,
			m.mod_name
		FROM `popot_service` s
		LEFT JOIN `popot_mod` m
			ON s.mod_id=m.mod_id
		WHERE (user_id='" . $iUserId . "')
		ORDER BY m.mod_name";
	$result_service = Query ($query_service);
	if (mysqli_num_rows ($result_service) >= 1)
	{
		$arService = array();
		while ($row_service = mysqli_fetch_assoc ($result_service))
		{
			$iModID = intval ($row_service['mod_id']);
			$sModName = $row_service['mod_name'];
			$arService[$iModID] = $sModName;
		}
	} else {
		$arService = false;
	}

print ('
<div class="container-fluid">
<div class="row">
<div class="col-sm-6">
');

	print ('<p>');
	print ('Email: ' . Sanitize ($sEmail));
	print ('<br>');
	print ('Gender: ' . $sGender);
	print ('<br>');
	print ('Registered: ' . $sRegistered);
	print ('<br>');
	print ('Country: ' . $sCountry);
	print ('<br>');
	print ('Website: ' . Sanitize ($sWebsite));
	print ('</p><p>');
	print ('Comments: ' . $iComments);
	print ('<br>');
	print ('Replays: ' . $iReplays);
	print ('<br>');
	print ('Enjoyment votes: ' . $iEnjoyment);
	if ($iEnjoyment != 0)
		{ print (' (' . round ($fEnjoyment, 2) . '/5 avg)'); }
	print ('<br>');
	print ('Difficulty votes: ' . $iDifficulty);
	if ($iDifficulty != 0)
		{ print (' (' . round ($fDifficulty, 2) . '/5 avg)'); }
	print ('</p><p>');
	print ('Email service:');
	print ('<a target="_blank" href="email_service.php"><img src="images/question_mark.png" style="margin-left:5px; vertical-align:middle;" alt="question mark"></a>');
	print ('<br>');
	if ($arService == false)
	{
		print ('<span style="font-weight:bold; color:#333;">nothing</span>');
	} else {
		foreach ($arService as $key => $value)
		{
			if ($key == '0')
			{
				print ('<span style="font-weight:bold; color:#333;">' .
					'everything</span><br>');
			} else {
				print ('<a href="custom_levels.php?mod=' .
					ModCodeFromID ($key) . '" style="font-style:italic;">' .
					Sanitize ($value) . '</a><br>');
			}
		}
	}
	print ('</p>');

print ('
</div>
<div class="col-sm-6">
');

	$query_mods = "SELECT
			mod_id,
			mod_name,
			mod_year
		FROM `popot_mod` m
		WHERE (author1_id='" . $iUserId . "')
		OR (author2_id='" . $iUserId . "')
		OR (author3_id='" . $iUserId . "')
		ORDER BY mod_name";
	$result_mods = Query ($query_mods);
	if (mysqli_num_rows ($result_mods) > 0)
	{
		print ('<h2>Mods by ' . Sanitize ($sNick) . '</h2>');
		print ('<p>');
		while ($row_mods = mysqli_fetch_assoc ($result_mods))
		{
			print ('<a href="custom_levels.php?mod=' .
				ModCodeFromID ($row_mods['mod_id']) .
				'" style="font-style:italic;">' . Sanitize ($row_mods['mod_name']) .
				'</a> <span style="font-size:10px;">(' . $row_mods['mod_year'] .
				')</span>' . "\n" . '<br>' . "\n");
		}
		print ('</p>');
	}

print ('
</div>
</div>
</div>
');
}
/*****************************************************************************/

/*** $iUserId ***/
if (isset ($_GET['user_id']))
{
	$iUserId = intval ($_GET['user_id']);
} else { $iUserId = 0; }

$query_user = "SELECT
		*
	FROM `popot_user`
	WHERE (user_id='" . $iUserId . "')";
$result_user = Query ($query_user);
if (mysqli_num_rows ($result_user) == 0)
{
	StartHTML ('User', '404 Not Found', 'user.php', 'Account');
	print ('<p>Unknown user (' . $iUserId . ').</p>');
} else {
	ShowProfile ($iUserId, $result_user);
}

EndHTML();
?>
