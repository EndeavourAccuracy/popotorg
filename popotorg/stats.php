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
function Service ()
/*****************************************************************************/
{
	print ('<h2>Recent Subscriptions</h2>');
	$query_service = "SELECT
			s.mod_id,
			m.mod_name,
			u.nick
		FROM `popot_service` s
		LEFT JOIN `popot_mod` m
			ON s.mod_id=m.mod_id
		LEFT JOIN `popot_user` u
			ON s.user_id=u.user_id
		ORDER BY s.service_id DESC
		LIMIT 10";
	$result_service = Query ($query_service);
	if (mysqli_num_rows ($result_service) != 0)
	{
		while ($row_service = mysqli_fetch_assoc ($result_service))
		{
			$iModID = $row_service['mod_id'];
			$sModName = $row_service['mod_name'];
			$sNick = $row_service['nick'];

			if ($iModID == 0)
			{
				print ('<span style="font-weight:bold; color:#333;">' .
					'everything</span>');
			} else {
				$sModCode = ModCodeFromID ($iModID);
				print ('<a href="custom_levels.php?mod=' .
					$sModCode . '">' . Sanitize ($sModName) . '</a>');
			}
			print (' by ' . Sanitize ($sNick) . '<br>');
		}
	}
}
/*****************************************************************************/
function Registered ()
/*****************************************************************************/
{
	print ('<h2>Recent Registrations</h2>');
	$query_users = "SELECT
			user_id,
			nick,
			date
		FROM `popot_user`
		ORDER BY date DESC
		LIMIT 10";
	$result_users = Query ($query_users);
	if (mysqli_num_rows ($result_users) != 0)
	{
		while ($row_users = mysqli_fetch_assoc ($result_users))
		{
			print ('<a href="profile.php?user_id=' . $row_users['user_id'] .
				'">' . Sanitize ($row_users['nick']) . '</a> <span class="small">(' .
				substr ($row_users['date'], 0, 10) . ')</span><br>');
		}
	}
}
/*****************************************************************************/
function Comments ()
/*****************************************************************************/
{
	print ('<h2>Recent Comments</h2>');
	$query_comments = "SELECT
			m.mod_id,
			m.mod_name,
			c.comment,
			u.nick,
			c.date
		FROM `popot_comment` c
		INNER JOIN `popot_user` u
			ON c.user_id=u.user_id
		INNER JOIN `popot_mod` m
			ON c.mod_id=m.mod_id
		ORDER BY c.date DESC
		LIMIT 10";
	$result_comments = Query ($query_comments);
	if (mysqli_num_rows ($result_comments) != 0)
	{
		while ($row_comments = mysqli_fetch_assoc ($result_comments))
		{
			$iModID = $row_comments['mod_id'];
			$sModCode = ModCodeFromID ($iModID);

			print ('About <a href="custom_levels.php?mod=' .
				$sModCode . '">' . Sanitize ($row_comments['mod_name']) .
				'</a>, by ' . Sanitize ($row_comments['nick']) .
				' <span class="small">(' . substr ($row_comments['date'], 0, 10) .
				')</span>:<br><img src="images/quote-start.png" alt="quote">' .
				nl2br (Sanitize ($row_comments['comment'])) .
				'<img src="images/quote-end.png" alt="unquote"><br>');
		}
	}
}
/*****************************************************************************/
function Votes ()
/*****************************************************************************/
{
	print ('<h2>Recent Votes</h2>');
	print ('<span style="display:block; margin-bottom:20px;">');
	$query_votes = "SELECT
			m.mod_id,
			m.mod_name,
			v.vote,
			v.vote_type,
			u.nick,
			v.date
		FROM `popot_vote` v
		INNER JOIN `popot_user` u
			ON v.user_id=u.user_id
		INNER JOIN `popot_mod` m
			ON v.mod_id=m.mod_id
		ORDER BY v.date DESC
		LIMIT 10";
	$result_votes = Query ($query_votes);
	if (mysqli_num_rows ($result_votes) != 0)
	{
		while ($row_votes = mysqli_fetch_assoc ($result_votes))
		{
			$iModID = $row_votes['mod_id'];
			$sModCode = ModCodeFromID ($iModID);

			print ('About <a href="custom_levels.php?mod=' .
				$sModCode . '">' . Sanitize ($row_votes['mod_name']) .
				'</a>, by ' . Sanitize ($row_votes['nick']) .
				' <span class="small">(' . substr ($row_votes['date'], 0, 10) .
				')</span>: <img src="images/');
			switch ($row_votes['vote_type'])
			{
				case 1: print ('stars_'); break;
				case 2: print ('bar_'); break;
			}
			print ($row_votes['vote'] . '0.png" style="vertical-align:middle;"' .
				' alt="score"><br>');
		}
	}
	print ('</span>');
}
/*****************************************************************************/

StartHTML ('User', 'Stats', 'user.php', 'Account');

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

	Service();
	Registered();
	Comments();
	Votes();
}

EndHTML();
?>
