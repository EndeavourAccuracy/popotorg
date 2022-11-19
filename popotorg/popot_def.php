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

error_reporting (-1);
ini_set ('display_errors', 'On');

ini_set ('output_buffering', 'Off');
while (@ob_end_flush());

date_default_timezone_set ('UTC');

ini_set ('php.internal_encoding', 'UTF-8');
mb_internal_encoding ('UTF-8');

include_once (dirname (__FILE__) . '/../private/popot_settings.php');

/*****************************************************************************/
function ConnectToMySQL ()
/*****************************************************************************/
{
	$GLOBALS['link'] = mysqli_init();
	if ($GLOBALS['link'] == FALSE)
	{
		print ('The website is currently under development (1).');
		exit();
	}
	if (!@mysqli_real_connect ($GLOBALS['link'], $GLOBALS['db_host'],
		$GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_dtbs']))
	{
		print ('The website is currently under development (2).');
		exit();
	}
}
/*****************************************************************************/
function StartSession ($iExpire)
/*****************************************************************************/
{
	if (session_id() == '')
	{
		ini_set ('session.use_trans_sid', 0);
		session_name ('popot');
		if (session_start() == false)
		{
			print ('The website is currently under development (3).');
			exit();
		}
	}
	switch ($iExpire)
	{
		case -1: break;
		case 0: setcookie ('popot', session_id(), 0); break;
		default: setcookie ('popot', session_id(), time() + $iExpire); break;
	}
}
/*****************************************************************************/
function TopPrint ()
/*****************************************************************************/
{
	print ('<div class="topprint_div" style="background-color:#');
	switch ($GLOBALS['top_type'])
	{
		case 'success': print ('efe'); break;
		case 'error': print ('fee'); break;
		case 'normal': print ('eef'); break;
	}
	print (';">');
	print ('<span class="topprint_span" style="color:#');
	switch ($GLOBALS['top_type'])
	{
		case 'success': print ('000'); break;
		case 'error': print ('f00'); break;
		case 'normal': print ('000'); break;
	}
	print (';">');
	print ($GLOBALS['top_text']);
	print ('</span>');
	print ('</div>');
}
/*****************************************************************************/
function CheckExists ($sTable, $sColumn, $sValue)
/*****************************************************************************/
{
	$query_exists = "SELECT
			*
		FROM `" . $sTable . "`
		WHERE (" . $sColumn . "='" . mysqli_real_escape_string
			($GLOBALS['link'], $sValue) . "')";
	$result_exists = Query ($query_exists);
	if (mysqli_num_rows ($result_exists) >= 1)
		{ return (TRUE); } else { return (FALSE); }
}
/*****************************************************************************/
function Sanitize ($sUserInput)
/*****************************************************************************/
{
	$sReturn = htmlentities ($sUserInput, ENT_QUOTES);
	$sReturn = str_ireplace ('javascript', 'JS', $sReturn);

	return ($sReturn);
}
/*****************************************************************************/
function CDATA ($sUserInput)
/*****************************************************************************/
{
	$sReturn = '<![CDATA[' . $sUserInput . ']]>';

	return ($sReturn);
}
/*****************************************************************************/
function NumberToAuthorType ($iNr)
/*****************************************************************************/
{
	switch ($iNr)
	{
		case 1: return ('Author'); break;
		case 2: return ('Co-Author'); break;
		case 3: return ('Musician'); break;
		case 4: return ('Artist'); break;
		case 5: return ('Coder'); break;
		case 6: return ('Other'); break;
	}
}
/*****************************************************************************/
function StartHTML ($sLevel1, $sLevel2, $sParentLink, $sMenu)
/*****************************************************************************/
{
	$arBacks = array ('dungeon', 'palace', 'caverns', 'temple', 'blue', 'fawn', 'silver', 'lava', 'green', 'umber', 'marble');
	$GLOBALS['back'] = $arBacks[array_rand ($arBacks)];
	$GLOBALS['menu'] = $sMenu;
	if ($sLevel2 == '') { $GLOBALS['entry'] = $sLevel1; }
		else { $GLOBALS['entry'] = $sLevel2; }

print ('
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Always start with the above 3 meta tags. -->
');

if (($sLevel1 == 'News') && ($sLevel2 == ''))
{
	print ('<meta name="description" content="Provides an overview of level editors and related tools that can be used to customize the games in the original Prince of Persia trilogy, and makes available for download all known modifications (mods).">');
}

print ('
<meta name="keywords" content="prince of persia, original trilogy, modding community, 1, 2, 3D, 1989, 1993, 1999, shadow, flame, software, download, level editor, graphic, sound, resource, extract, open source, free software, game, play, screenshot, tutorial, video, mod, tool, custom, walkthrough, playthrough, pack, vote, forum, old, pc, pop, modification">
<meta name="author" content="">
<link rel="icon" href="images/favicon_16x16.png" sizes="16x16" type="image/png">
<link rel="icon" href="images/favicon_32x32.png" sizes="32x32" type="image/png">
<link rel="alternate" type="application/rss+xml" title="Recent PoPOT News" href="news_rss.php">
<title>');
	if ($sLevel2 == '') { print ($sLevel1); } else { print ($sLevel2); }
	print (' · Prince of Persia: Original Trilogy</title>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="anythingslider/css/anythingslider.css">
<link rel="stylesheet" type="text/css" href="jquery.feedback_me.css">
<link rel="stylesheet" type="text/css" href="popot.css?v=24">

<!-- JS -->
<script src="jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script src="anythingslider/js/jquery.anythingslider.js"></script>
<script src="js/jquery.feedback_me.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<script src="popot.js?v=5"></script>
');

	if ($sLevel1 == 'Modding Timeline')
	{
		include_once (dirname (__FILE__) . '/timeline.txt');
		print ('</head>');
		print ('<body onload="onLoad();" onresize="onResize();">');
	} else {
		print ('</head>');
		print ('<body>');
	}

	NavBar();

print ('
<div class="container-fluid">

<div class="row">
<div class="visible-lg col-lg-2 fixed" style="background-color:#000; background-image:url(\'images/back/back_' . $GLOBALS['back'] . '_left.png\'); min-height:100%; height:100%; text-align:center;">
<img src="images/back/torch_' . $GLOBALS['back'] . '.gif" alt="torch" style="position:relative; top:calc(50% - 50px); transform:translateY(-50%);">
</div>
<div class="visible-lg col-lg-2 fixed" style="background-color:#000; background-image:url(\'images/back/back_' . $GLOBALS['back'] . '_right.png\'); min-height:100%; height:100%; text-align:center; right:0;">
<img src="images/back/torch_' . $GLOBALS['back'] . '.gif" alt="torch" style="position:relative; top:calc(50% - 50px); transform:translateY(-50%);">
</div>
</div>

<div class="row">
<div class="visible-lg col-lg-2" style="background-color:#000;"></div>
<div class="col-lg-8 col-md-12 nopadding" style="background-color:#fff;">
');

	if ($GLOBALS['top_text'] != '') { TopPrint(); }
	if ($sLevel1 == 'Custom Levels')
	{
		$bShowCar = TRUE;
		if (isset ($_GET['mod']))
		{
			$sModHImg = 'images/headers/' . Sanitize ($_GET['mod']) . '.jpg';
			if (file_exists ($sModHImg))
			{
				print ('<img src="' . $sModHImg . '" alt="' . $sLevel2 . ' header" class="img-responsive">');
				$bShowCar = FALSE;
			}
		}
		if ($bShowCar == TRUE) { Carousel(); }
	} else {
		print ('<a href="/"><img src="images/header_0001.png" alt="Prince of Persia: Original Trilogy" class="img-responsive"></a>');
	}
	print ('<div style="padding:20px; margin-bottom:50px;">');
	print ('<div class="page-header">');
	if ($sLevel2 == '')
	{
		print ('<h1>' . $sLevel1 . '</h1>');
	} else {
		print ('<span style="display:block; text-align:center;">');
		print ('<a href="' . $sParentLink . '">&laquo; ' . $sLevel1 . '</a>');
		print ('</span>');
		print ('<h1>' . $sLevel2 . '</h1>');
	}
	print ('</div>');

	$GLOBALS['html_started'] = 1;
}
/*****************************************************************************/
function GetActiveURL ()
/*****************************************************************************/
{
	/*** This function does not urlencode(). ***/

	$sURL = 'https://';
	$sURL .= $_SERVER['HTTP_HOST'];
	$sURL .= $_SERVER['REQUEST_URI'];

	return ($sURL);
}
/*****************************************************************************/
function EndHTML()
/*****************************************************************************/
{
	/* For the validator, do NOT use "/check?uri=referer", because proxies
	 * may strip out the referrer header.
	 */

print ('
</div>
</div>
<div class="visible-lg col-lg-2" style="background-color:#000;"></div>
</div>

</div>

<footer class="footer">
<div class="container-fluid">
<div class="row">
<div class="visible-lg col-lg-2" style="min-height:50px;"></div>
<div class="col-lg-8 col-md-12" style="min-height:50px; padding:0 20px;">
<p class="footertext">&copy; 2011-' . date ('Y') . ' PoPOT | <a target="_blank" href="https://validator.w3.org/nu/?doc=' . urlencode (GetActiveURL()) . '"><img src="images/W3C_HTML5.png" alt="W3C HTML5"></a> | <a target="_blank" href="https://en.wikipedia.org/wiki/Responsive_web_design"><img src="images/RWD.png" alt="Responsive web design" title="Responsive web design"></a></p>
</div>
<div class="visible-lg col-lg-2" style="min-height:50px;"></div>
</div>
</div>
</footer>


</body>
</html>
');
}
/*****************************************************************************/
function AreaRect ($iX1, $iX2, $sNr, $sType, $sPNG, $sScore, $sPoll, $iModID)
/*****************************************************************************/
{
	/* This area is placed inside the <map> used by the "enjoyment" and
	 * "difficulty" images.
	 */

	$sID = $sType . '_' . $sNr;
	if ($sNr == 'login') { print ('<a href="/user.php?action=Login">'); }
	print ('<area style="cursor:pointer;" shape="rect" coords="' .
		$iX1 . ',0,' . $iX2 . ',20" id="' . $sID .
		'" onmouseover="document.getElementById(\'' . $sType . '\').src=\'images/' .
		$sType . '_' . $sPNG . '.png\'" onmouseout="document.getElementById(\'' .
		$sType . '\').src=\'images/' . $sType . '_' . $sScore . '.png\'">');
	if ($sNr == 'login') { print ('</a>'); }
}
/*****************************************************************************/
function CurrentPageURL ()
/*****************************************************************************/
{
	/* Creates the URL for the W3C HTML5 validator.
	 * A simple "return ('referer');" would also work.
	 */

	$sURL = 'http';
	if (isset ($_SERVER['HTTPS']))
	{
		if ($_SERVER['HTTPS'] == 'on') { $sURL .= 's'; }
	}
	$sURL .= '://' . $_SERVER['SERVER_NAME'];
	if ($_SERVER['SERVER_PORT'] != '80')
		{ $sURL .= ':' . $_SERVER['SERVER_PORT']; }
	$sURL .= $_SERVER['REQUEST_URI'];

	return ($sURL);
}
/*****************************************************************************/
function CreateXML ($iUpdatedMod)
/*****************************************************************************/
{
	global $arUsers;

	$sDate = date ('Y-m-d H:i:s');

	if ($iUpdatedMod != 0)
	{
		$query_updated = "UPDATE `popot_mod` SET
			date_updated='" . $sDate . "'
			WHERE (mod_id='" . $iUpdatedMod . "')";
		$result_updated = Query ($query_updated);
	}

	/*** Some arrays should always exist, for array_key_exists(). ***/
	$arEnjoyment = array();
	$arDifficulty = array();
	$arEnjoymentVotes = array();
	$arDifficultyVotes = array();
	$arComments = array();
	$arReplays = array();

	/*** Votes... ***/
	$query_votes = "SELECT
			mod_id,
			AVG(vote) AS vote,
			COUNT(*) AS votes,
			vote_type AS type
		FROM `popot_vote`
		GROUP BY mod_id, vote_type";
	$result_votes = Query ($query_votes);
	while ($row_votes = mysqli_fetch_assoc ($result_votes))
	{
		$mod_id = $row_votes['mod_id'];
		$vote = $row_votes['vote'];
		$votes = $row_votes['votes'];
		$type = $row_votes['type'];
		switch ($type)
		{
			case 1:
				$arEnjoyment[$mod_id] = $vote;
				$arEnjoymentVotes[$mod_id] = $votes;
				break;
			case 2:
				$arDifficulty[$mod_id] = $vote;
				$arDifficultyVotes[$mod_id] = $votes;
				break;
		}
	}

	/*** $arComments ***/
	$query_comments = "SELECT
			mod_id,
			COUNT(*) AS comments
		FROM `popot_comment`
		GROUP BY mod_id";
	$result_comments = Query ($query_comments);
	while ($row_comments = mysqli_fetch_assoc ($result_comments))
	{
		$mod_id = $row_comments['mod_id'];
		$comments = $row_comments['comments'];
		$arComments[$mod_id] = $comments;
	}

	/*** $arReplays ***/
	$query_replays = "SELECT
			mod_id,
			COUNT(*) AS replays
		FROM `popot_replay`
		GROUP BY mod_id";
	$result_replays = Query ($query_replays);
	while ($row_replays = mysqli_fetch_assoc ($result_replays))
	{
		$mod_id = $row_replays['mod_id'];
		$replays = $row_replays['replays'];
		$arReplays[$mod_id] = $replays;
	}

	/*** $arAuthors ***/
	$query_authors = "SELECT
			user_id,
			nick
		FROM `popot_user`";
	$result_authors = Query ($query_authors);
	while ($row_authors = mysqli_fetch_assoc ($result_authors))
	{
		$author_id = $row_authors['user_id'];
		$author_name = $row_authors['nick'];
		$arAuthors[$author_id] = $author_name;
	}

	/*** $arUsers ***/
	$query_users = "SELECT
			user_id,
			nick
		FROM `popot_user`";
	$result_users = Query ($query_users);
	while ($row_users = mysqli_fetch_assoc ($result_users))
	{
		$user_id = $row_users['user_id'];
		$nick = $row_users['nick'];
		$arUsers[$user_id] = $nick;
	}

	$sXML = 'xml/mods.xml';
	$fpFile = fopen ($sXML, 'w');
	fwrite ($fpFile, '<?xml version="1.0" encoding="UTF-8" ?>' . "\n");
	fwrite ($fpFile, '<!-- https://www.popot.org/xml/mods.xml -->' . "\n");
	fwrite ($fpFile, '<mods version="' . $sDate . '">' . "\n");

	$query_mods = "SELECT
			*
		FROM `popot_mod`
		ORDER BY mod_popversion, mod_nr";
	$result_mods = Query ($query_mods);
	while ($row_mods = mysqli_fetch_assoc ($result_mods))
	{
		$iModID = $row_mods['mod_id'];
		$sModCode = ModCodeFromID ($iModID);
		$sModDescr = $row_mods['mod_description'];

		fwrite ($fpFile, "\t" .
			'<mod id="' . $sModCode . '">' . "\n");

		fwrite ($fpFile, "\t\t" . '<s_name>' .
			CDATA ($row_mods['mod_name']) . '</s_name>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_number>' .
			intval (substr ($sModCode, 1)) . '</i_number>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_number>' .
			$sModCode . '</s_number>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_creation_year>' .
			$row_mods['mod_year'] . '</i_creation_year>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_pop_version>' .
			$row_mods['mod_popversion'] . '</i_pop_version>' . "\n");
		switch ($row_mods['mod_popversion'])
		{
			case 1: $sVersion = 'PoP1'; break;
			case 2: $sVersion = 'PoP2'; break;
			case 3: $sVersion = 'PoP3D'; break;
			case 4: $sVersion = 'PoP1 for SNES'; break;
			default: $sVersion = '?'; break;
		}
		fwrite ($fpFile, "\t\t" . '<s_pop_version>' .
			$sVersion . '</s_pop_version>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_description>' .
			CDATA ($sModDescr) . '</s_description>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_starting_minutes>' .
			$row_mods['mod_minutes'] . '</i_starting_minutes>' . "\n");

		/*** Authors... ***/
		fwrite ($fpFile, "\t\t" . '<i_author1_id>' .
			$row_mods['author1_id'] . '</i_author1_id>' . "\n");
		if (array_key_exists ($row_mods['author1_id'], $arAuthors))
			{ $sAuthorName = $arAuthors[$row_mods['author1_id']]; }
				else { $sAuthorName = '?'; }
		fwrite ($fpFile, "\t\t" . '<s_author1_name>' .
			CDATA ($sAuthorName) . '</s_author1_name>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_author1_type>' .
			$row_mods['author1_type'] . '</i_author1_type>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_author2_id>' .
			$row_mods['author2_id'] . '</i_author2_id>' . "\n");
		if (array_key_exists ($row_mods['author2_id'], $arAuthors))
			{ $sAuthorName = $arAuthors[$row_mods['author2_id']]; }
				else { $sAuthorName = '?'; }
		fwrite ($fpFile, "\t\t" . '<s_author2_name>' .
			CDATA ($sAuthorName) . '</s_author2_name>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_author2_type>' .
			$row_mods['author2_type'] . '</i_author2_type>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_author3_id>' .
			$row_mods['author3_id'] . '</i_author3_id>' . "\n");
		if (array_key_exists ($row_mods['author3_id'], $arAuthors))
			{ $sAuthorName = $arAuthors[$row_mods['author3_id']]; }
				else { $sAuthorName = '?'; }
		fwrite ($fpFile, "\t\t" . '<s_author3_name>' .
			CDATA ($sAuthorName) . '</s_author3_name>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_author3_type>' .
			$row_mods['author3_type'] . '</i_author3_type>' . "\n");

		fwrite ($fpFile, "\t\t" . '<i_altered_graphics>' .
			$row_mods['changed_graphics_yn'] . '</i_altered_graphics>' . "\n");
		fwrite ($fpFile, "\t\t" . '<i_altered_audio>' .
			$row_mods['changed_audio_yn'] . '</i_altered_audio>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_executable>' .
			CDATA ($row_mods['mod_executable']) . '</s_executable>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_executable_sdlpop>' .
			CDATA ($row_mods['mod_executable_s']) . '</s_executable_sdlpop>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_executable_mininim>' .
			CDATA ($row_mods['mod_executable_m']) . '</s_executable_mininim>' . "\n");
		fwrite ($fpFile, "\t\t" . '<s_cheat_code>' .
			CDATA ($row_mods['mod_cheat']) . '</s_cheat_code>' . "\n");

		/*** enjoyment ***/
		if (array_key_exists ($iModID, $arEnjoyment))
			{ $fEnjoyment = $arEnjoyment[$iModID]; }
				else { $fEnjoyment = 0; }
		fwrite ($fpFile, "\t\t" . '<f_enjoyment>' .
			$fEnjoyment . '</f_enjoyment>' . "\n");

		/*** difficulty ***/
		if (array_key_exists ($iModID, $arDifficulty))
			{ $fDifficulty = $arDifficulty[$iModID]; }
				else { $fDifficulty = 0; }
		fwrite ($fpFile, "\t\t" . '<f_difficulty>' .
			$fDifficulty . '</f_difficulty>' . "\n");

		fwrite ($fpFile, "\t\t" . '<i_levels_changed>' .
			$row_mods['changed_levels_nr'] . '</i_levels_changed>' . "\n");

		/*** enjoyment votes ***/
		if (array_key_exists ($iModID, $arEnjoymentVotes))
			{ $iEnjoymentVotes = $arEnjoymentVotes[$iModID]; }
				else { $iEnjoymentVotes = 0; }
		fwrite ($fpFile, "\t\t" . '<i_enjoyment_votes>' .
			$iEnjoymentVotes . '</i_enjoyment_votes>' . "\n");

		/*** difficulty votes ***/
		if (array_key_exists ($iModID, $arDifficultyVotes))
			{ $iDifficultyVotes = $arDifficultyVotes[$iModID]; }
				else { $iDifficultyVotes = 0; }
		fwrite ($fpFile, "\t\t" . '<i_difficulty_votes>' .
			$iDifficultyVotes . '</i_difficulty_votes>' . "\n");

		fwrite ($fpFile, "\t\t" . '<i_screenshots>' .
			$row_mods['mod_nrss'] . '</i_screenshots>' . "\n");

		/*** number of comments ***/
		if (array_key_exists ($iModID, $arComments))
			{ $iComments = $arComments[$iModID]; }
				else { $iComments = 0; }
		fwrite ($fpFile, "\t\t" . '<i_comments>' .
			$iComments . '</i_comments>' . "\n");

		XMLWriteComments ($fpFile, $iModID);

		/*** number of replays ***/
		if (array_key_exists ($iModID, $arReplays))
			{ $iReplays = $arReplays[$iModID]; }
				else { $iReplays = 0; }
		fwrite ($fpFile, "\t\t" . '<i_replays>' .
			$iReplays . '</i_replays>' . "\n");

		XMLWriteReplays ($fpFile, $iModID);

		fwrite ($fpFile, "\t\t" . '<dt_last_update>' .
			$row_mods['date_updated'] . '</dt_last_update>' . "\n");

		fwrite ($fpFile, "\t\t" . '<dt_last_update_zip>' .
			$row_mods['date_updated_zip'] . '</dt_last_update_zip>' . "\n");

		fwrite ($fpFile, "\t" .
			'</mod>' . "\n");
	}

	fwrite ($fpFile, '</mods>');
	fclose ($fpFile);

	/*** modsu.xml ***/
	$sXML = 'xml/modsu.xml';
	$fpFile = fopen ($sXML, 'w');
	fwrite ($fpFile, '<?xml version="1.0" encoding="UTF-8" ?>' . "\n");
	fwrite ($fpFile, '<!-- https://www.popot.org/xml/modsu.xml -->' . "\n");
	fwrite ($fpFile, '<modsu version="' . $sDate . '">' . "\n");
	$query_modsu = "SELECT
			MAX(date_updated) AS dt_last_update,
			MAX(date_updated_zip) AS dt_last_update_zip
		FROM `popot_mod`";
	$result_modsu = Query ($query_modsu);
	$row_modsu = mysqli_fetch_assoc ($result_modsu);
	fwrite ($fpFile, "\t" . '<dt_last_update>' .
		$row_modsu['dt_last_update'] . '</dt_last_update>' . "\n");
	fwrite ($fpFile, "\t" . '<dt_last_update_zip>' .
		$row_modsu['dt_last_update_zip'] . '</dt_last_update_zip>' . "\n");
	fwrite ($fpFile, '</modsu>');
	fclose ($fpFile);
}
/*****************************************************************************/
function XMLWriteComments ($fpFile, $iModID)
/*****************************************************************************/
{
	global $arUsers;

	fwrite ($fpFile, "\t\t" . '<comments>' . "\n");
	$query_comments = "SELECT
			user_id,
			comment,
			date
		FROM `popot_comment`
		WHERE (mod_id='" . $iModID . "')
		ORDER BY date";
	$result_comments = Query ($query_comments);
	while ($row_comments = mysqli_fetch_assoc ($result_comments))
	{
		$iUserId = $row_comments['user_id'];
		if (array_key_exists ($iUserId, $arUsers))
			{ $sUser = $arUsers[$iUserId]; }
				else { $sUser = '?'; }
		$sDateCom = $row_comments['date'];
		$sComment = $row_comments['comment'];

		fwrite ($fpFile, "\t\t\t" . '<comment>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_nick>' .
			CDATA ($sUser) . '</s_nick>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<dt_added>' .
			$sDateCom . '</dt_added>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_comment>' .
			CDATA ($sComment) . '</s_comment>' . "\n");
		fwrite ($fpFile, "\t\t\t" . '</comment>' . "\n");
	}
	fwrite ($fpFile, "\t\t" . '</comments>' . "\n");
}
/*****************************************************************************/
function XMLWriteReplays ($fpFile, $iModID)
/*****************************************************************************/
{
	global $arUsers;

	fwrite ($fpFile, "\t\t" . '<replays>' . "\n");
	$query_replays = "SELECT
			level_nr,
			user_id,
			comment,
			program,
			date
		FROM `popot_replay`
		WHERE (mod_id='" . $iModID . "')
		ORDER BY level_nr";
	$result_replays = Query ($query_replays);
	while ($row_replays = mysqli_fetch_assoc ($result_replays))
	{
		$iLevel = $row_replays['level_nr'];
		$sLevel = LevelNrToString ($iLevel);
		$iUserId = $row_replays['user_id'];
		if (array_key_exists ($iUserId, $arUsers))
			{ $sUser = $arUsers[$iUserId]; }
				else { $sUser = '?'; }
		$sDateRep = $row_replays['date'];
		$sComment = $row_replays['comment'];
		$sProgram = $row_replays['program'];
		$sURL = $GLOBALS['base'] .
			ReplayURL ($iModID, $iLevel, $iUserId, $sProgram);

		fwrite ($fpFile, "\t\t\t" . '<replay>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<i_level>' .
			$iLevel . '</i_level>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_level>' .
			$sLevel . '</s_level>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_program>' .
			$sProgram . '</s_program>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_nick>' .
			CDATA ($sUser) . '</s_nick>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<dt_added>' .
			$sDateRep . '</dt_added>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_comment>' .
			CDATA ($sComment) . '</s_comment>' . "\n");
		fwrite ($fpFile, "\t\t\t\t" . '<s_url>' .
			$sURL . '</s_url>' . "\n");
		fwrite ($fpFile, "\t\t\t" . '</replay>' . "\n");
	}
	fwrite ($fpFile, "\t\t" . '</replays>' . "\n");
}
/*****************************************************************************/
function SendEmail ($arEmail, $sSubject, $sMessage)
/*****************************************************************************/
{
	/*** Returns the number of sent messages. ***/

	if ($GLOBALS['live'] === FALSE) { return (1); /*** Success. ***/ }

	include_once (dirname (__FILE__) . '/swift/lib/swift_required.php');

	$transport = Swift_SmtpTransport::newInstance
		($GLOBALS['mail_host'], 465, 'ssl')
		->setUsername($GLOBALS['mail_from'])
		->setPassword($GLOBALS['mail_pass'])
		;
	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance()
		->setSubject($sSubject)
		->setFrom(array($GLOBALS['mail_from'] => 'popot.org'))
		->setBcc($arEmail)
		->setBody(
			'<html>' .
			'<head></head>' .
			'<body>' .
			$sMessage .
			'</body>' .
			'</html>',
			'text/html'
		);

	try {
		$iSent = $mailer->send($message);
	} catch (Exception $e) {
		file_put_contents (dirname (__FILE__) . '/../private/error_log.txt',
			$e->getMessage(), FILE_APPEND);
		$iSent = 0;
	}

	return ($iSent);
}
/*****************************************************************************/
function LevelNrToString ($iLevel)
/*****************************************************************************/
{
	switch ($iLevel)
	{
		case 0: return ('demo'); break;
		case 1: return ('lvl 1'); break;
		case 2: return ('lvl 2'); break;
		case 3: return ('lvl 3'); break;
		case 4: return ('lvl 4'); break;
		case 5: return ('lvl 5'); break;
		case 6: return ('lvl 6'); break;
		case 7: return ('lvl 7'); break;
		case 8: return ('lvl 8'); break;
		case 9: return ('lvl 9'); break;
		case 10: return ('lvl 10'); break;
		case 11: return ('lvl 11'); break;
		case 12: return ('lvl 12a'); break;
		case 13: return ('lvl 12b'); break;
		case 14: return ('princess'); break;
		case 15: return ('potions'); break;
		case 16: return ('other'); break;
		/***/
		case 20: return ('demo alt.'); break;
		case 21: return ('lvl 1 alt.'); break;
		case 22: return ('lvl 2 alt.'); break;
		case 23: return ('lvl 3 alt.'); break;
		case 24: return ('lvl 4 alt.'); break;
		case 25: return ('lvl 5 alt.'); break;
		case 26: return ('lvl 6 alt.'); break;
		case 27: return ('lvl 7 alt.'); break;
		case 28: return ('lvl 8 alt.'); break;
		case 29: return ('lvl 9 alt.'); break;
		case 30: return ('lvl 10 alt.'); break;
		case 31: return ('lvl 11 alt.'); break;
		case 32: return ('lvl 12a alt.'); break;
		case 33: return ('lvl 12b alt.'); break;
		case 34: return ('princess alt.'); break;
		case 35: return ('potions alt.'); break;
		case 36: return ('other alt.'); break;
	}
}
/*****************************************************************************/
function ReplayURL ($iModID, $iLevel, $iUserId, $sProgram)
/*****************************************************************************/
{
	$sLevelPad = str_pad ($iLevel, 2, '0', STR_PAD_LEFT);
	$sUserIdPad = str_pad ($iUserId, 4, '0', STR_PAD_LEFT);
	switch ($sProgram)
	{
		case 'SDLPoP': $sExtension = 'p1r'; break;
		case 'MININIM': $sExtension = 'mrp'; break;
	}

	$sModCode = ModCodeFromID ($iModID);
	$sURL = 'replays/m' . Sanitize ($sModCode) . '_l' . $sLevelPad . '_u' .
		$sUserIdPad . '.' . $sExtension;

	return ($sURL);
}
/*****************************************************************************/
function AdminLinks ()
/*****************************************************************************/
{
	if (IsAdmin() === TRUE)
	{
		print ('<p style="text-align:center;">');
		print ('[ <a href="admin.php">admin</a> |' .
			' <a href="stats.php">stats</a> |' .
			' <a href="xml.php">xml</a> |' .
			' <a href="un.php">unsubscribe</a> |' .
			' <a href="signin.php">sign in</a> ]');
		print ('</p>');
	}
}
/*****************************************************************************/
function Li ($sText, $sLink)
/*****************************************************************************/
{
	print ('<li');
	if ($sText == $GLOBALS['entry'])
	{
		print (' class="active"');
	}
	print ('><a href="' . $sLink . '">' . $sText . '</a></li>' . "\n");
}
/*****************************************************************************/
function LiMenuStart ($sText)
/*****************************************************************************/
{
	print ('<li class="dropdown');
	if ($sText == $GLOBALS['menu'])
	{
		print (' active');
	}
	print ('">');
	print ('<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $sText . ' <span class="caret"></span></a>');
	print ('<ul class="dropdown-menu">' . "\n");
}
/*****************************************************************************/
function LiMenuEnd ()
/*****************************************************************************/
{
	print ('</ul>');
	print ('</li>' . "\n");
}
/*****************************************************************************/
function LiHeader ($sText)
/*****************************************************************************/
{
	print ('<li class="dropdown-header">' . $sText . '</li>' . "\n");
}
/*****************************************************************************/
function LiSep ()
/*****************************************************************************/
{
	print ('<li role="separator" class="divider"></li>' . "\n");
}
/*****************************************************************************/
function NavBar ()
/*****************************************************************************/
{
print ('
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
<div class="row">
<div class="visible-lg col-lg-2" style="min-height:50px;"></div>
<div class="col-lg-8 col-md-12" style="min-height:50px;">

<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a target="_blank" href="news_rss.php" class="navbar-brand"><img src="images/RSS_feed.png" alt="RSS feed"></a>
</div>
<div id="navbar" class="collapse navbar-collapse">
<ul class="nav navbar-nav">
');

Li ('News', '/');

LiMenuStart ('Play');
LiHeader ('Original Games');
Li ('<span class="italic">Prince of Persia 1</span>', 'get_the_games.php#PoP1');
Li ('<span class="italic">Prince of Persia 2</span>', 'get_the_games.php#PoP2');
Li ('<span class="italic">Prince of Persia 3D</span>', 'get_the_games.php?game=3D');
Li ('more...', 'get_the_games.php#Other');
LiSep();
LiHeader ('Remakes');
Li ('SDLPoP', 'get_the_games.php?game=SDLPoP');
Li ('MININIM', 'get_the_games.php?game=MININIM');
Li ('more...', 'get_the_games.php#Remakes');
LiSep();
LiHeader ('Mods');
Li ('Custom Levels', 'custom_levels.php');
Li ('Search', 'custom_levels.php?action=Search');
Li ('Submit', 'custom_levels.php?action=Submit');
LiMenuEnd();

LiMenuStart ('Edit');
Li ('Level Editors', 'level_editors.php');
Li ('<span class="italic">PoP1</span> Executable (CusPop)', 'other_useful_tools.php?tool=CusPop');
Li ('<span class="italic">PoP1</span> Images and Audio (PR)', 'other_useful_tools.php?tool=PR');
Li ('more...', 'other_useful_tools.php');
LiMenuEnd();

LiMenuStart ('Learn');
Li ('<span class="italic">PoP1</span> Special Events', 'documentation.php?doc=PoP1SpecialEvents');
Li ('<span class="italic">PoP1</span> Tricks', 'documentation.php?doc=Tricks');
Li ('more...', 'documentation.php');
LiMenuEnd();

LiMenuStart ('Misc');
Li ('Comics / Art', 'comics_art.php');
Li ('Modding Timeline', 'modding_timeline.php');
Li ('Chomper Dance', 'chomper_dance.php');
LiSep();
LiHeader ('Social');
Li ('Community Forum', 'community_forum.php');
Li ('Contact / FAQ', 'contact_faq.php');
LiSep();
Li ('Web Links', 'web_links.php');
LiMenuEnd();

LiMenuStart ('Account');
if (isset ($_SESSION['user_id']))
{
	Li ('Settings', 'user.php?action=Settings');
	Li ('Profile', 'profile.php?user_id=' . $_SESSION['user_id']);
	Li ('Logout', 'user.php?action=Logout');
} else {
	Li ('Register', 'user.php?action=Register');
	Li ('Login', 'user.php?action=Login');
}
LiMenuEnd();
print ('
</ul>
</div>

</div>
<div class="visible-lg col-lg-2" style="min-height:50px;"></div>
</div>
</div>
</nav>
');
}
/*****************************************************************************/
function Car ($sID, $sName, $sText, $iActive)
/*****************************************************************************/
{
	print ('<div class="item');
	if ($iActive == 1) { print (' active'); }
	print ('">');
	print ('<a href="custom_levels.php?mod=' . $sID . '">');
	print ('<img src="images/car/car_' . $sID . '.png" alt="' . $sName . '" style="width:100%;">
<div class="carousel-caption">
<h3><span class="opacity italic" style="color:#fff;">' . $sName . '</span></h3>
<p><span class="opacity">' . $sText . '</span></p>
</div>
</a>
</div>
');
}
/*****************************************************************************/
function Carousel ()
/*****************************************************************************/
{
	print ('<div id="carousel_mods" class="carousel slide"' .
		' data-ride="carousel">');

print ('
<ol class="carousel-indicators">
<li data-target="#carousel_mods" data-slide-to="0" class="active"></li>
<li data-target="#carousel_mods" data-slide-to="1"></li>
<li data-target="#carousel_mods" data-slide-to="2"></li>
<li data-target="#carousel_mods" data-slide-to="3"></li>
</ol>
');

	print ('<div class="carousel-inner">');
	Car ('0000156', 'Princess of Persia', 'Play as a princess!', 1);
	Car ('0000036', 'Potion Puzzles', 'Drink all life potions!', 0);
	Car ('0000047', 'Pirates of Persia', 'Defeat captain Jaffar!', 0);
	Car ('0000109', 'Babylon Tower Climb', 'Think before you act!', 0);
	print ('</div>');

/*** prev and next ***/
print ('
<a class="left carousel-control" href="#carousel_mods" data-slide="prev">
<span class="glyphicon glyphicon-chevron-left"></span>
<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#carousel_mods" data-slide="next">
<span class="glyphicon glyphicon-chevron-right"></span>
<span class="sr-only">Next</span>
</a>
');

	print ('</div>');
}
/*****************************************************************************/
function GetIP ()
/*****************************************************************************/
{
	$arServer = array (
		'HTTP_CLIENT_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP',
		'HTTP_FORWARDED_FOR',
		'HTTP_FORWARDED',
		'REMOTE_ADDR'
	);
	foreach ($arServer as $sServer)
	{
		if (array_key_exists ($sServer, $_SERVER) === TRUE)
		{
			foreach (explode (',', $_SERVER[$sServer]) as $sIP)
			{
				if (filter_var ($sIP, FILTER_VALIDATE_IP) !== FALSE)
					{ return ($sIP); }
			}
		}
	}
	return ('unknown');
}
/*****************************************************************************/
function Query ($query)
/*****************************************************************************/
{
	$result = mysqli_query ($GLOBALS['link'], $query);
	if ($result === FALSE)
	{
		print ('Query failed.' . '<br>');
		print ('Query: ' . $query . '<br>');
		print ('Error: ' . mysqli_error ($GLOBALS['link']) . '<br>');
		exit();
	}

	return ($result);
}
/*****************************************************************************/
function ModCodeFromVN ($iPoPVersion, $iModNr)
/*****************************************************************************/
{
	/*** Returns the mod code, or die()s. ***/

	switch ($iPoPVersion)
	{
		case 1: /*** PoP1 for DOS ***/
			$sCode = '0' . str_pad ($iModNr, 6, '0', STR_PAD_LEFT);
			break;
		case 2: /*** PoP2 for DOS ***/
			$sCode = 'F' . str_pad ($iModNr, 6, '0', STR_PAD_LEFT);
			break;
		case 3: /*** PoP3D ***/
			$sCode = 'D' . str_pad ($iModNr, 6, '0', STR_PAD_LEFT);
			break;
		case 4: /*** PoP1 for SNES ***/
			$sCode = 'S' . str_pad ($iModNr, 6, '0', STR_PAD_LEFT);
			break;
		default: die(); break;
	}

	return ($sCode);
}
/*****************************************************************************/
function ModCodeFromID ($iModID)
/*****************************************************************************/
{
	/*** Returns the mod code, or die()s. ***/

	$query_id = "SELECT
			mod_nr,
			mod_popversion
		FROM `popot_mod`
		WHERE (mod_id='" . intval ($iModID) . "')";
	$result_id = Query ($query_id);
	if (mysqli_num_rows ($result_id) == 1)
	{
		$row_id = mysqli_fetch_assoc ($result_id);
		$iModNr = intval ($row_id['mod_nr']);
		$iPoPVersion = intval ($row_id['mod_popversion']);
		$sCode = ModCodeFromVN ($iPoPVersion, $iModNr);
	} else { die(); }

	return ($sCode);
}
/*****************************************************************************/
function ModID ($sModCode)
/*****************************************************************************/
{
	/*** Returns the mod_id value, or die()s. ***/

	switch ($sModCode[0])
	{
		case '0': $iPoPVersion = 1; break;
		case 'F': $iPoPVersion = 2; break;
		case 'D': $iPoPVersion = 3; break;
		case 'S': $iPoPVersion = 4; break;
		default: $iPoPVersion = FALSE; break;
	}

	$iModNr = intval (substr ($sModCode, -6));

	if (($iPoPVersion !== FALSE) && ($iModNr != 0))
	{
		$query_id = "SELECT
				mod_id
			FROM `popot_mod`
			WHERE (mod_nr='" . $iModNr . "')
			AND (mod_popversion='" . $iPoPVersion . "')";
		$result_id = Query ($query_id);
		if (mysqli_num_rows ($result_id) == 1)
		{
			$row_id = mysqli_fetch_assoc ($result_id);
			$iModID = intval ($row_id['mod_id']);
		} else {
			die();
		}
	} else {
		die();
	}

	return ($iModID);
}
/*****************************************************************************/
function QueueEmail ($arEmail, $sSubject, $sMessage)
/*****************************************************************************/
{
	$query_queue = "INSERT INTO `popot_mailqueue` SET
		mailqueue_to='" . base64_encode (serialize ($arEmail)) . "',
		mailqueue_subject='" . $sSubject . "',
		mailqueue_message='" . $sMessage . "',
		mailqueue_sent='0'";
	Query ($query_queue);
}
/*****************************************************************************/
function UnusedModNr ($iPoPVersion)
/*****************************************************************************/
{
	if (($iPoPVersion < 1) || ($iPoPVersion > 4)) { return (FALSE); }

	$query_maxused = "SELECT
			MAX(mod_nr) AS maxused
		FROM `popot_mod`
		WHERE (mod_popversion='" . $iPoPVersion . "')";
	$result_maxused = Query ($query_maxused);
	$row_maxused = mysqli_fetch_assoc ($result_maxused);
	$iMaxUsed = intval ($row_maxused['maxused']);
	$iUnused = $iMaxUsed + 1;

	return ($iUnused);
}
/*****************************************************************************/
function ImageFromFile ($arFile, $sToFile, $sToType, $iToW, $iToH)
/*****************************************************************************/
{
	/*** Returns TRUE or FALSE. ***/

	$sTmpName = $arFile['tmp_name'];

	$arSize = getimagesize ($sTmpName);
	if ($arSize !== FALSE)
	{
		$iWidth = $arSize[0];
		$iHeight = $arSize[1];

		switch ($arFile['type'])
		{
			case 'image/png':
				$rImage = @imagecreatefrompng ($sTmpName);
				break;
			case 'image/jpeg':
				$rImage = @imagecreatefromjpeg ($sTmpName);
				break;
			case 'image/gif':
				$rImage = @imagecreatefromgif ($sTmpName);
				break;
		}

		if ($rImage !== FALSE)
		{
			$rImageTo = imagecreatetruecolor ($iToW, $iToH);
			imagecopyresampled ($rImageTo, $rImage, 0, 0, 0, 0,
				$iToW, $iToH, $iWidth, $iHeight);
			switch ($sToType)
			{
				case 'png': $bCreated = imagepng ($rImageTo, $sToFile, 9); break;
				case 'jpg': $bCreated = imagejpeg ($rImageTo, $sToFile, -1); break;
				default: $bCreated = FALSE;
			}
			imagedestroy ($rImageTo);
			return ($bCreated);
		}
	}

	return (FALSE);
}
/*****************************************************************************/
function GetSizeBytes ($sString)
/*****************************************************************************/
{
	switch (substr ($sString, -1))
	{
		case 'G': case 'g':
			$iBytes = (intval ($sString)) * 1024 * 1024 * 1024;
			break;
		case 'M': case 'm':
			$iBytes = (intval ($sString)) * 1024 * 1024;
			break;
		case 'K': case 'k':
			$iBytes = (intval ($sString)) * 1024;
			break;
	}

	return ($iBytes);
}
/*****************************************************************************/
function GetSizeHuman ($iBytes)
/*****************************************************************************/
{
	if ($iBytes === NULL) { return ('nothing'); }

	$iG = 1024 * 1024 * 1024;
	$iM = 1024 * 1024;
	$iK = 1024;
	if ($iBytes >= $iG)
	{
		$sHuman = str_replace ('.00', '', number_format ($iBytes / $iG, 2)) . 'G';
	} else if ($iBytes >= $iM) {
		$sHuman = str_replace ('.00', '', number_format ($iBytes / $iM, 2)) . 'M';
	} else if ($iBytes >= $iK) {
		$sHuman = str_replace ('.00', '', number_format ($iBytes / $iK, 2)) . 'K';
	} else {
		$sHuman = $iBytes . ' B';
	}

	return ($sHuman);
}
/*****************************************************************************/
function NotifyNew ($iModID)
/*****************************************************************************/
{
	/*** $sColumn and $sPoPVersion ***/
	$query_version = "SELECT
			mod_popversion
		FROM `popot_mod`
		WHERE (mod_id='" . $iModID . "')";
	$result_version = Query ($query_version);
	$row_version = mysqli_fetch_assoc ($result_version);
	$iPoPVersion = intval ($row_version['mod_popversion']);
	switch ($iPoPVersion)
	{
		case 1:
			$sColumn = 'notifynew_pv1_yn';
			$sPoPVersion = 'PoP1 for DOS';
			break;
		case 2:
			$sColumn = 'notifynew_pv2_yn';
			$sPoPVersion = 'PoP2 for DOS';
			break;
		case 4:
			$sColumn = 'notifynew_pv4_yn';
			$sPoPVersion = 'PoP1 for SNES';
			break;
	}

	$query_mod = "SELECT
			mod_name,
			pu1.nick AS nick1,
			pu2.nick AS nick2,
			pu3.nick AS nick3
		FROM `popot_mod` pm
		LEFT JOIN `popot_user` pu1
			ON pm.author1_id = pu1.user_id
		LEFT JOIN `popot_user` pu2
			ON pm.author2_id = pu2.user_id
		LEFT JOIN `popot_user` pu3
			ON pm.author3_id = pu3.user_id
		WHERE (mod_id='" . $iModID . "')";
	$result_mod = Query ($query_mod);
	$row_mod = mysqli_fetch_assoc ($result_mod);
	$sModName = $row_mod['mod_name'];
	$sNick1 = $row_mod['nick1'];
	$sNick2 = $row_mod['nick2'];
	$sNick3 = $row_mod['nick3'];

	/*** $sMessage ***/
	$sMessage = 'User';
	if (($sNick2 != '') || ($sNick3 != '')) { $sMessage .= 's'; }
	$sMessage .= ' "' . Sanitize ($sNick1) . '"';
	if ($sNick2 != '') { $sMessage .= ' and "' . Sanitize ($sNick2) . '"'; }
	if ($sNick3 != '') { $sMessage .= ' and "' . Sanitize ($sNick3) . '"'; }
	$sMessage .= ' added ' . $sPoPVersion . ' mod <a href="https://www.popot.org/custom_levels.php?mod=' . ModCodeFromID ($iModID) . '" style="font-style:italic;">' . Sanitize ($sModName) . '</a>.<br><br>To unsubscribe, change your <a href="https://www.popot.org/user.php?action=Settings">Settings</a>.';

	/*** Notify users. ***/
	$query_to_mail = "SELECT
			nick,
			email
		FROM `popot_user`
		WHERE (" . $sColumn . "='1')";
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
		QueueEmail ($arEmail, '[ PoPOT ] new mod', $sMessage);
	}
}
/*****************************************************************************/
function IsAdmin ()
/*****************************************************************************/
{
	if (isset ($_SESSION['nick']))
	{
		if (in_array ($_SESSION['nick'], $GLOBALS['admins']) === TRUE)
			{ return (TRUE); }
	}
	return (FALSE);
}
/*****************************************************************************/
function VerifyCreate ()
/*****************************************************************************/
{
	$_SESSION['value1'] = rand (10, 99);
	$_SESSION['operator1'] = rand (1, 2);
	$_SESSION['value2'] = rand (10, 99);
	$_SESSION['operator2'] = rand (1, 2);
	$_SESSION['value3'] = rand (10, 99);
}
/*****************************************************************************/
function VerifyShow ()
/*****************************************************************************/
{
	if (!isset ($_SESSION['value1'])) { VerifyCreate(); }

	$sVerify = '';

	$sVerify .= $_SESSION['value1'];
	switch ($_SESSION['operator1'])
	{
		case 1: $sVerify .= ' + '; break;
		case 2: $sVerify .= ' - '; break;
	}
	$sVerify .= $_SESSION['value2'];
	switch ($_SESSION['operator2'])
	{
		case 1: $sVerify .= ' + '; break;
		case 2: $sVerify .= ' - '; break;
	}
	$sVerify .= $_SESSION['value3'];

	return ($sVerify);
}
/*****************************************************************************/
function VerifyAnswer ()
/*****************************************************************************/
{
	if (!isset ($_SESSION['value1'])) { VerifyCreate(); }

	$value1 = $_SESSION['value1'];
	$value2 = $_SESSION['value2'];
	$value3 = $_SESSION['value3'];

	$iAnswer = $value1;
	switch ($_SESSION['operator1'])
	{
		case 1: $iAnswer = $iAnswer + $value2; break;
		case 2: $iAnswer = $iAnswer - $value2; break;
	}
	switch ($_SESSION['operator2'])
	{
		case 1: $iAnswer = $iAnswer + $value3; break;
		case 2: $iAnswer = $iAnswer - $value3; break;
	}

	return ($iAnswer);
}
/*****************************************************************************/
function TagsDDL ($sIdName, $sPickText, $iActiveID)
/*****************************************************************************/
{
	/*** Returns the number of values, or FALSE. ***/

	$query_ddl = "SELECT
			tag_id,
			tag_name
		FROM `popot_tag`
		ORDER BY tag_name";
	$result_ddl = Query ($query_ddl);
	$iNrRows = mysqli_num_rows ($result_ddl);
	if ($iNrRows > 0)
	{
		print ('<select id="' . $sIdName . '" name="' . $sIdName . '">');
		print ('<option value="">' . $sPickText . '</option>');
		while ($row_ddl = mysqli_fetch_assoc ($result_ddl))
		{
			$iTagID = intval ($row_ddl['tag_id']);
			$sTagName = $row_ddl['tag_name'];

			print ('<option value="' . $iTagID . '"');
			if ($iTagID == $iActiveID) { print (' selected'); }
			print ('>' . Sanitize ($sTagName) . '</option>' . "\n");
		}
		print ('</select>');
		return ($iNrRows);
	} else {
		return (FALSE);
	}
}
/*****************************************************************************/
function TagLink ($iTagID)
/*****************************************************************************/
{
	/*** Returns a hyperlink, or FALSE. ***/

	if ($iTagID != 0)
	{
		$query_name = "SELECT
				tag_name
			FROM `popot_tag`
			WHERE (tag_id='" . $iTagID . "')";
		$result_name = Query ($query_name);
		if (mysqli_num_rows ($result_name) == 1)
		{
			$row_name = mysqli_fetch_assoc ($result_name);
			$sTagName = $row_name['tag_name'];
			return ('<a href="/custom_levels.php?action=Search&tag_id=' .
				$iTagID . '&pressed=Search">' . Sanitize ($sTagName) . '</a>');
		} else { return (FALSE); }
	} else { return (FALSE); }
}
/*****************************************************************************/
function TagMods ($iTagID)
/*****************************************************************************/
{
	$query_nr = "SELECT
			COUNT(*) AS nr
		FROM `popot_mod`
		WHERE (tag1_id='" . $iTagID . "')
		OR (tag2_id='" . $iTagID . "')
		OR (tag3_id='" . $iTagID . "')";
	$result_nr = Query ($query_nr);
	$row_nr = mysqli_fetch_assoc ($result_nr);
	return ($row_nr['nr']);
}
/*****************************************************************************/

if (in_array (GetIP(), $GLOBALS['banned_ips']) === TRUE)
{
	print ('Under Construction');
	exit();
}

ConnectToMySQL();
StartSession (-1);
?>
