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
function ShowSearchResults ()
/*****************************************************************************/
{
	global $arSearch;
	global $iMatches;

	if (isset ($_GET['author_id']))
		{ $arSearch['author_id'] = intval ($_GET['author_id']); }
	if (isset ($_GET['mod_minutes']))
		{ $arSearch['mod_minutes'] = intval ($_GET['mod_minutes']); }
	if (isset ($_GET['mod_popversion']))
		{ $arSearch['mod_popversion'] = intval ($_GET['mod_popversion']); }
	if (isset ($_GET['changed_levels_nr']))
		{ $arSearch['changed_levels_nr'] = intval ($_GET['changed_levels_nr']); }
	if (isset ($_GET['mod_year']))
		{ $arSearch['mod_year'] = intval ($_GET['mod_year']); }
	if (isset ($_GET['changed_graphics_yn']))
	{
		$arSearch['changed_graphics_yn'] = $_GET['changed_graphics_yn'];
	} else {
		$arSearch['changed_graphics_yn'] = 'off';
	}
	if (isset ($_GET['changed_audio_yn']))
	{
		$arSearch['changed_audio_yn'] = $_GET['changed_audio_yn'];
	} else {
		$arSearch['changed_audio_yn'] = 'off';
	}
	if (isset ($_GET['with_text']))
		{ $arSearch['with_text'] = $_GET['with_text']; }
			else { $arSearch['with_text'] = ''; }
	if (isset ($_GET['tag_id']))
		{ $arSearch['tag_id'] = intval ($_GET['tag_id']); }

	$sWhere = '(1=1)';
	if ($arSearch['author_id'] != 0)
	{
		$sWhere = $sWhere . " AND (author1_id = '" . $arSearch['author_id'] .
			"' OR author2_id = '" . $arSearch['author_id'] .
			"' OR author3_id = '" . $arSearch['author_id'] . "')";
	}
	switch ($arSearch['mod_minutes'])
	{
		case 1: $sWhere = $sWhere . " AND (mod_minutes < 10)"; break;
		case 2: $sWhere = $sWhere .
			" AND (mod_minutes >= 10) AND (mod_minutes < 30)"; break;
		case 3: $sWhere = $sWhere .
			" AND (mod_minutes >= 30) AND (mod_minutes < 60)"; break;
		case 4: $sWhere = $sWhere . " AND (mod_minutes = 60)"; break;
		case 5: $sWhere = $sWhere . " AND (mod_minutes > 60)"; break;
		case 6: $sWhere = $sWhere . " AND (mod_minutes = 0)"; break;
	}
	if ($arSearch['mod_popversion'] != 0)
	{
		$sWhere = $sWhere . " AND (mod_popversion = '" .
			$arSearch['mod_popversion'] . "')";
	}
	switch ($arSearch['changed_levels_nr'])
	{
		case 1: $sWhere = $sWhere . " AND (changed_levels_nr = 1)"; break;
		case 2: $sWhere = $sWhere .
			" AND (changed_levels_nr >= 2) AND (changed_levels_nr < 5)"; break;
		case 3: $sWhere = $sWhere .
			" AND (changed_levels_nr >= 5) AND (changed_levels_nr < 10)"; break;
		case 4: $sWhere = $sWhere . " AND (changed_levels_nr >= 10)"; break;
	}
	switch ($arSearch['mod_year'])
	{
		case 1: $sWhere = $sWhere .
			" AND (mod_year < 2000) AND (mod_year != 0)"; break;
		case 2: $sWhere = $sWhere .
			" AND (mod_year >= 2000) AND (mod_year <= 2004)"; break;
		case 3: $sWhere = $sWhere . " AND (mod_year = 2005)"; break;
		case 4: $sWhere = $sWhere . " AND (mod_year = 2006)"; break;
		case 5: $sWhere = $sWhere . " AND (mod_year = 2007)"; break;
		case 6: $sWhere = $sWhere . " AND (mod_year = 2008)"; break;
		case 7: $sWhere = $sWhere . " AND (mod_year = 2009)"; break;
		case 8: $sWhere = $sWhere . " AND (mod_year = 2010)"; break;
		case 9: $sWhere = $sWhere . " AND (mod_year = 2011)"; break;
		case 10: $sWhere = $sWhere . " AND (mod_year = 2012)"; break;
		case 11: $sWhere = $sWhere . " AND (mod_year = 2013)"; break;
		case 12: $sWhere = $sWhere . " AND (mod_year = 2014)"; break;
		case 13: $sWhere = $sWhere . " AND (mod_year >= 2015)"; break;
		case 14: $sWhere = $sWhere . " AND (mod_year = 0)"; break;
	}
	if ($arSearch['changed_graphics_yn'] == 'on')
		{ $sWhere = $sWhere . " AND (changed_graphics_yn = 1)"; }
	if ($arSearch['changed_audio_yn'] == 'on')
		{ $sWhere = $sWhere . " AND (changed_audio_yn = 1)"; }
	if ($arSearch['with_text'] != '')
	{
		$sWhere = $sWhere . " AND ((mod_name LIKE '%" . mysqli_real_escape_string ($GLOBALS['link'], $arSearch['with_text']) . "%') OR (mod_description LIKE '%" . mysqli_real_escape_string ($GLOBALS['link'], $arSearch['with_text']) . "%'))";
	}
	if ($arSearch['tag_id'] != 0)
	{
		$sWhere = $sWhere . " AND ((tag1_id='" . $arSearch['tag_id'] . "') OR (tag2_id='" . $arSearch['tag_id'] . "') OR (tag3_id='" . $arSearch['tag_id'] . "'))";
	}

	$query_search = "SELECT
			mod_id,
			mod_name
		FROM `popot_mod`
		WHERE " . $sWhere . "
		ORDER BY mod_name";
	$GLOBALS['result_search'] = Query ($query_search);
	$iMatches = mysqli_num_rows ($GLOBALS['result_search']);
	if ($iMatches != 0)
	{
		if ($iMatches == 1)
		{
			$GLOBALS['top_text'] = 'Found exactly one match.';
			$GLOBALS['top_type'] = 'success';
		} else {
			$GLOBALS['top_text'] = 'There are ' . $iMatches . ' matches.';
			$GLOBALS['top_type'] = 'success';
		}
	} else {
		$GLOBALS['top_text'] = 'There are no matches!';
		$GLOBALS['top_type'] = 'error';
	}
}
/*****************************************************************************/
function PoPVersion ($iVersion, $iFull)
/*****************************************************************************/
{
	switch ($iVersion)
	{
		case 1:
			if ($iFull == 1) { return ('Prince of Persia 1'); }
				else { return ('PoP1'); } break;
		case 2:
			if ($iFull == 1) { return ('Prince of Persia 2'); }
				else { return ('<span style="color:#00f;">PoP2</span>'); } break;
		case 3:
			if ($iFull == 1) { return ('Prince of Persia 3D'); }
				else { return ('PoP3D'); } break;
		case 4:
			if ($iFull == 1) { return ('Prince of Persia 1 for SNES'); }
				else { return ('PoP1 <span style="color:#00f;">' .
					'for SNES</span>'); } break;
	}
}
/*****************************************************************************/
function GetAuthor ($iAuthorId)
/*****************************************************************************/
{
	$query_get_author = "SELECT
			nick
		FROM `popot_user`
		WHERE (user_id = '" . $iAuthorId . "')";
	$result_get_author = Query ($query_get_author);
	$iMatches = mysqli_num_rows ($result_get_author);
	if ($iMatches == 1)
	{
		$row_get_author = mysqli_fetch_assoc ($result_get_author);
		return (Sanitize ($row_get_author['nick']));
	} else {
		return ('Unknown');
	}
}
/*****************************************************************************/
function ShowScreenshots ($sModCode)
/*****************************************************************************/
{
	print ('<div class="screenshots_div" style="max-width:100%; ');
	if (substr (Sanitize ($sModCode), 0, 1) == 'S')
		{ print ('width:276px; height:224px;'); }
			else { print ('width:340px; height:200px;'); }
	print ('">');
	$sPNGFiles = 'custom_levels/screenshots/' . $sModCode . '_?.png';
	foreach (glob ($sPNGFiles, GLOB_NOCHECK) as $sFilename)
	{
		print ('<img src="' . $sFilename . '" alt="screenshot"' .
			' class="img-responsive">');
	}
	print ('</div>');
}
/*****************************************************************************/
function SelectOption ($xValue, $xSet, $sText)
/*****************************************************************************/
{
	print ('<option value="' . $xValue . '"');
	if ($xSet == $xValue) { print (' selected'); }
	print ('>' . $sText . '</option>');
}
/*****************************************************************************/
function SearchForm ($arSearch)
/*****************************************************************************/
{
print ('
<form name="input" action="custom_levels.php" method="get">
<input type="hidden" id="action" name="action" value="Search">
<table style="margin:0 auto;">

<tr>
<td>By Author:</td>
<td colspan="2">
<select id="author_id" name="author_id">
<option value="0">Any</option>
');

		$query_get_authors = "SELECT
				*
			FROM `popot_user`
			ORDER BY nick";
		$result_get_authors = Query ($query_get_authors);
		while ($row_get_authors = mysqli_fetch_assoc ($result_get_authors))
		{
			print ('<option value="' . $row_get_authors['user_id'] . '"');
			if (isset ($arSearch['author_id']))
			{
				if ($row_get_authors['user_id'] == $arSearch['author_id'])
					{ print (' selected'); }
			}
			print ('>' . Sanitize ($row_get_authors['nick']) . '</option>');
		}

print ('
</select>
</td>
</tr>

<tr>
<td>Starting Minutes:</td>
<td colspan="2">
<select id="mod_minutes" name="mod_minutes">
');
SelectOption (0, $arSearch['mod_minutes'], 'Any');
SelectOption (1, $arSearch['mod_minutes'], 'Under 10');
SelectOption (2, $arSearch['mod_minutes'], '10 - 29');
SelectOption (3, $arSearch['mod_minutes'], '30 - 59');
SelectOption (4, $arSearch['mod_minutes'], '60');
SelectOption (5, $arSearch['mod_minutes'], 'Over 60');
SelectOption (6, $arSearch['mod_minutes'], 'Unknown');
print ('
</select>
</td>
</tr>

<tr>
<td>PoP Version:</td>
<td colspan="2">
<select id="mod_popversion" name="mod_popversion">
');
SelectOption (0, $arSearch['mod_popversion'], 'Any');
SelectOption (1, $arSearch['mod_popversion'], '1');
SelectOption (2, $arSearch['mod_popversion'], '2');
/*** SelectOption (3, $arSearch['mod_popversion'], '3D'); ***/
SelectOption (4, $arSearch['mod_popversion'], '1 SNES');
print ('
</select>
</td>
</tr>

<tr>
<td># Changed Levels:</td>
<td colspan="2">
<select id="changed_levels_nr" name="changed_levels_nr">
');
SelectOption (0, $arSearch['changed_levels_nr'], 'Any');
SelectOption (1, $arSearch['changed_levels_nr'], '1');
SelectOption (2, $arSearch['changed_levels_nr'], '2 - 4');
SelectOption (3, $arSearch['changed_levels_nr'], '5 - 9');
SelectOption (4, $arSearch['changed_levels_nr'], '10 or more');
print ('
</select>
</td>
</tr>

<tr>
<td>Creation Year:</td>
<td colspan="2">
<select id="mod_year" name="mod_year">
');
SelectOption (0, $arSearch['mod_year'], 'Any');
SelectOption (1, $arSearch['mod_year'], 'Before 2000');
SelectOption (2, $arSearch['mod_year'], '2000 - 2004');
SelectOption (3, $arSearch['mod_year'], '2005');
SelectOption (4, $arSearch['mod_year'], '2006');
SelectOption (5, $arSearch['mod_year'], '2007');
SelectOption (6, $arSearch['mod_year'], '2008');
SelectOption (7, $arSearch['mod_year'], '2009');
SelectOption (8, $arSearch['mod_year'], '2010');
SelectOption (9, $arSearch['mod_year'], '2011');
SelectOption (10, $arSearch['mod_year'], '2012');
SelectOption (11, $arSearch['mod_year'], '2013');
SelectOption (12, $arSearch['mod_year'], '2014');
SelectOption (13, $arSearch['mod_year'], '2015 or later');
SelectOption (14, $arSearch['mod_year'], 'Unknown');
print ('
</select>
</td>
</tr>

<tr>
<td>Has Altered:</td>
<td>
<input type="checkbox" id="changed_graphics_yn" name="changed_graphics_yn"');
	if (isset ($arSearch['changed_graphics_yn']))
	{
		if ($arSearch['changed_graphics_yn'] == 'on') { print (' checked'); }
	}
print ('> graphics
</td>
<td>
<input type="checkbox" id="changed_audio_yn" name="changed_audio_yn"');
	if (isset ($arSearch['changed_audio_yn']))
	{
		if ($arSearch['changed_audio_yn'] == 'on') { print (' checked'); }
	}
print ('> audio
</tr>

<tr>
<td>With Text:</td>
<td colspan="2">
<input type="text" id="with_text" name="with_text" maxlength="200"');
	if (isset ($arSearch['with_text']))
	{
		if ($arSearch['with_text'] != '')
			{ print (' value="' . Sanitize ($arSearch['with_text']) . '"'); }
	}
print ('>
<br>
<span class="small italic">In its name or description.</span>
</td>
</tr>

<tr>
<td>With Tag:</td>
<td colspan="2">
');
	TagsDDL ('tag_id', 'Any', $arSearch['tag_id']);
print ('
</td>
</tr>

<tr>
<td class="dotted" colspan="3">
<p style="text-align:center;">
<input name="pressed" type="submit" value="Search">
<input type="button" onclick="location=\'custom_levels.php?action=Search\'" value="Clear">
</p>
</td>
</tr>

</table>
</form>
');
}
/*****************************************************************************/
function ModList ($sSort)
/*****************************************************************************/
{
	switch ($sSort)
	{
		case 'name': $sSortCol = 'mod_name'; break;
		case 'id': $sSortCol = 'mod_popversion, mod_nr'; break;
		case 'year': $sSortCol = 'mod_year = "0", mod_year, mod_name'; break;
		case 'version': $sSortCol = 'mod_popversion, mod_name'; break;
		case 'minutes':
			$sSortCol = 'mod_minutes = "0", mod_minutes, mod_name';
			break;
		case 'levels': $sSortCol = 'changed_levels_nr, mod_name'; break;
	}

print ('
<img src="images/prince_icon.gif" style="float:left; padding-right:10px;" alt="prince icon">
<p>
This is a list of all available (known) mods.
<br>
It is also possible to <a href="custom_levels.php?action=Search">search</a> for specific mods.
<br>
The <a href="other_useful_tools.php?tool=Total_Packs">Total Packs</a> and <a href="other_useful_tools.php?tool=poplaun">poplaun</a> provide user-friendly interfaces for tweaking and playing custom levels.
<br>
These tools use <a target="_blank" href="xml/mods.xml">mods.xml</a> (and <a target="_blank" href="xml/modsu.xml">modsu.xml</a>).
<br>
Is your mod not yet listed here, then please <a href="custom_levels.php?action=Submit">submit</a> it.
<br>
This website can suggest to you a <a href="custom_levels.php?action=Random" rel="nofollow"><img src="images/dice_small.png" alt="small dice"> random</a> mod and level.
<br>
Custom graphics: <a href="custom_levels.php?action=VDUNGEON.DAT">VDUNGEON.DAT</a> | <a href="custom_levels.php?action=VPALACE.DAT">VPALACE.DAT</a> | <a href="custom_levels.php?action=KID.DAT">KID.DAT</a> | <a href="custom_levels.php?action=FAT.DAT">FAT.DAT</a> | <a href="custom_levels.php?action=SHADOW.DAT">SHADOW.DAT</a> | <a href="custom_levels.php?action=VIZIER.DAT">VIZIER.DAT</a> | <a href="custom_levels.php?action=SKEL.DAT">SKEL.DAT</a> | <a href="custom_levels.php?action=PRINCE.DAT">PRINCE.DAT</a> | <a href="custom_levels.php?action=GUARD.DAT">GUARD.DAT</a>
<br>
There are also <a href="/custom_levels.php?action=Other_mods">other mods</a>, that are <span class="italic">not</span> for DOS or SNES.
</p>
<hr class="basic">
');

	print ('<p style="text-align:center;">');
	print ('Sort by: ');

	/*** name ***/
	if ($sSort != 'name')
		{ print ('<a href="custom_levels.php?sort=name">name</a>'); }
			else { print ('<span class="italic">name</span>'); }

	print (' | ');

	/*** id ***/
	if ($sSort != 'id')
		{ print ('<a href="custom_levels.php?sort=id">id</a>'); }
			else { print ('<span class="italic">id</span>'); }

	print (' | ');

	/*** year ***/
	if ($sSort != 'year')
		{ print ('<a href="custom_levels.php?sort=year">year</a>'); }
			else { print ('<span class="italic">year</span>'); }

	print (' | ');

	/*** version ***/
	if ($sSort != 'version')
		 { print ('<a href="custom_levels.php?sort=version">version</a>'); }
				else { print ('<span class="italic">version</span>'); }

	print (' | ');

	/*** minutes ***/
	if ($sSort != 'minutes')
		{ print ('<a href="custom_levels.php?sort=minutes">minutes</a>'); }
			else { print ('<span class="italic">minutes</span>'); }

	print (' | ');

	/*** levels ***/
	if ($sSort != 'levels')
		{ print ('<a href="custom_levels.php?sort=levels">levels ch.</a>'); }
			else { print ('<span class="italic">levels ch.</span>'); }

	print ('</p>');

	print ('<p>');
	$query_get_mods = "SELECT
			*
		FROM `popot_mod`
		ORDER BY " . $sSortCol;
	$result_get_mods = Query ($query_get_mods);
	while ($row_get_mods = mysqli_fetch_assoc ($result_get_mods))
	{
		$sPModName = $row_get_mods['mod_name'];
		$iPModNr = intval ($row_get_mods['mod_nr']);
		$iPModYear = intval ($row_get_mods['mod_year']);
		$iPPoPVersion = intval ($row_get_mods['mod_popversion']);
		$iPModMinutes = intval ($row_get_mods['mod_minutes']);
		$iPModLevels = intval ($row_get_mods['changed_levels_nr']);
		print ('<a href="custom_levels.php?mod=' .
			ModCodeFromVN ($iPPoPVersion, $iPModNr) . '">' .
			Sanitize ($sPModName) . '</a> (' .
			PoPVersion ($iPPoPVersion, 0) . ')');
		if ($sSort == 'year')
		{
			print (' - ');
			if ($iPModYear != 0) { print ($iPModYear); }
				else { print ('unknown year'); }
		}
		if ($sSort == 'minutes')
		{
			print (' - ');
			if ($iPModMinutes != 0) { print ($iPModMinutes); }
				else { print ('?'); }
			print (' min.');
		}
		if ($sSort == 'levels') { print (' - ' . $iPModLevels . ' ch.'); }
		print ('<br>');
	}
	print ('</p>');
}
/*****************************************************************************/
function ShowMod ($iModID, $row_get_mod)
/*****************************************************************************/
{
	$sModCode = ModCodeFromID ($iModID);
	$sModCh = $row_get_mod['mod_cheat'];
	$sModEXED = $row_get_mod['mod_executable'];
	$sModEXES = $row_get_mod['mod_executable_s'];
	$sModEXEM = $row_get_mod['mod_executable_m'];
	$sModEXE = $sModEXED;
	if ($sModEXE == '') { $sModEXE = $sModEXES; }
	if ($sModEXE == '') { $sModEXE = $sModEXEM; }

	if (isset ($_SESSION['user_id']))
	{
		if ($_SESSION['user_id'] == $row_get_mod['author1_id'])
		{
print ('
<p style="text-align:center;">
[ <a href="/custom_levels.php?action=Edit&mod=' . $sModCode . '">edit mod</a> ]
</p>
');
		}
		if (($_SESSION['user_id'] == $row_get_mod['author2_id']) ||
			($_SESSION['user_id'] == $row_get_mod['author3_id']))
		{
print ('
<p style="text-align:center;">
[ User "' . GetAuthor ($row_get_mod['author1_id']) . '" can edit this mod. ]
</p>
');
		}
	}

	print ('<br>');

	/*** Left div. ***/
	print ('<div style="float:left; width:55%;">');
	if ($sModCh != '?')
	{
		print ('<span style="float:right; color:#eee;">Cheat: ' .
			Sanitize ($sModEXE) . ' ' . Sanitize ($sModCh) . '</span>');
	}
	print ('Released in: ');
	switch ($row_get_mod['mod_year'])
	{
		case 0: print ('unknown year'); break;
		default: print ($row_get_mod['mod_year']); break;
	}
	print ('<br>');
	print ('PoP version: ' .
		PoPVersion ($row_get_mod['mod_popversion'], 1) . '<br>');
	print ('Description: "' . Sanitize ($row_get_mod['mod_description']) . '"<br>');
	if (($row_get_mod['tag1_id'] != 0) || ($row_get_mod['tag2_id'] != 0) ||
		($row_get_mod['tag3_id'] != 0))
	{
		print ('Tags: ');
		$arTags = array();
		$sLink1 = TagLink ($row_get_mod['tag1_id']);
		if ($sLink1 !== FALSE) { array_push ($arTags, $sLink1); }
		$sLink2 = TagLink ($row_get_mod['tag2_id']);
		if ($sLink2 !== FALSE) { array_push ($arTags, $sLink2); }
		$sLink3 = TagLink ($row_get_mod['tag3_id']);
		if ($sLink3 !== FALSE) { array_push ($arTags, $sLink3); }
		print (implode (', ', $arTags));
		print ('<br>');
	}
	print ('Starting time: ');
	switch ($row_get_mod['mod_minutes'])
	{
		case 0: print ('?'); break;
		default: print ($row_get_mod['mod_minutes']); break;
	}
	print (' minutes<br>');
	print ('By: <a target="_blank" href="/profile.php?user_id=' .
		$row_get_mod['author1_id'] . '">' .
		GetAuthor ($row_get_mod['author1_id']) . '</a> (' .
		NumberToAuthorType ($row_get_mod['author1_type']) . ')');
	if ($row_get_mod['author2_id'] != 0)
	{
		print (', <a target="_blank" href="/profile.php?user_id=' .
			$row_get_mod['author2_id'] . '">' .
			GetAuthor ($row_get_mod['author2_id']) . '</a> (' .
			NumberToAuthorType ($row_get_mod['author2_type']) . ')');
	}
	if ($row_get_mod['author3_id'] != 0)
	{
		print (', <a target="_blank" href="/profile.php?user_id=' .
			$row_get_mod['author3_id'] . '">' .
			GetAuthor ($row_get_mod['author3_id']) . '</a> (' .
			NumberToAuthorType ($row_get_mod['author3_type']) . ')');
	}
	print ('<br>');
	print ('Has altered: <img src="images/checkbox_');
	if ($row_get_mod['changed_graphics_yn'] == 1)
		{ print ('yes'); } else { print ('no'); }
	print ('.png" alt="checkbox"> graphics <img src="images/checkbox_');
	if ($row_get_mod['changed_audio_yn'] == 1)
		{ print ('yes'); } else { print ('no'); }
	print ('.png" alt="checkbox"> audio<br>');
	print ('Custom levels: ' . $row_get_mod['changed_levels_nr'] . '<br>');
	print ('Download: ');
	$sZIPFile = 'custom_levels/software/' . $sModCode . '.zip';
	if (file_exists ($sZIPFile) == true)
	{
		print ('<a href="' . $sZIPFile . '">' . $sModCode . '.zip</a>');
	} else {
		print ('not available');
	}
	switch ($row_get_mod['mod_popversion'])
	{
		case 2: print (' <span style="color:#00f;">(PoP2 mod!)</span>'); break;
		case 4: print (' <span style="color:#00f;">(SNES mod!)</span>'); break;
	}
	print ('<br>');
	if ($sModEXED != '')
	{
		print ('<span class="italic" style="margin-left:10px;">');
		switch ($row_get_mod['mod_popversion'])
		{
			case 1:
			case 2:
				print ('Use <a href="https://www.dosbox.com/">DOSBox</a> to start its executable "' . Sanitize ($sModEXED) . '".');
				break;
			case 4:
				print ('Use <a href="https://www.zsnes.com/">ZSNES</a> or <a href="https://www.snes9x.com/">Snes9x</a> to start its ROM "' . Sanitize ($sModEXED) . '".');
				break;
		}
		print ('</span>');
	}
	print ('</div>');

	/*** Right div. ***/
	print ('<div style="float:left; width:45%;">');
	print ('<div style="margin-left:20px;">');
	ShowScreenshots ($sModCode);
	if ($row_get_mod['mod_popversion'] == 1)
	{
		print ('<br>');
		print ('<img src="images/icon_DOS_');
		if ($sModEXED != '') { print ('yes'); } else { print ('no'); }
		print ('.png" alt="DOS" title="DOS">');
		print ('<img src="images/icon_SDLPoP_');
		if ($sModEXES != '') { print ('yes'); } else { print ('no'); }
		print ('.png" alt="SDLPoP" title="SDLPoP">');
		print ('<img src="images/icon_MININIM_');
		if ($sModEXEM != '') { print ('yes'); } else { print ('no'); }
		print ('.png" alt="MININIM" title="MININIM">');
	}
	print ('</div>');
	print ('</div>');

	print ('<span style="display:block; clear:both;"></span>');

	print ('<hr class="basic" style="margin:20px 0;">');

	print ('<div class="row">');

	/*** Left span. ***/
	print ('<span class="col-sm-3">');

print ('
<span class="side">
<span style="display:block; padding-bottom:10px;">enjoyment:</span>
<span id="pollstars">');
	include_once (dirname (__FILE__) . '/stars.php');
print ('</span>
</span>
<span class="side">
<span style="display:block; padding:10px 0;">difficulty:</span>
<span id="pollbar">');
	include_once (dirname (__FILE__) . '/bar.php');
print ('</span>
</span>
<span class="side">
<span style="display:block; padding:10px 0;">email service:</span>
<span id="pollservice">');
	include_once (dirname (__FILE__) . '/service.php');
print ('</span>
</span>
');

	print ('</span>');

	/*** Middle span. ***/
	print ('<span class="col-sm-6">');

print ('
<span style="display:block; border:1px solid #000; padding:20px; margin:0 20px;">
<span style="display:block; padding-bottom:10px; text-align:center;">comments:</span>
<span id="poll2">');
	include_once (dirname (__FILE__) . '/comment.php');
print ('</span>
</span>
');

	print ('</span>');

	/*** Right span. ***/
	print ('<span class="col-sm-3">');
	print ('<span class="side">');

	if ($row_get_mod['mod_popversion'] == 1)
	{
		print ('<span style="display:block; padding-bottom:10px;">replays:<a target="_blank" href="custom_levels.php?action=Replays"><img src="images/question_mark.png" style="margin-left:5px; vertical-align:middle;" alt="question mark"></a></span>');
		print ('<span id="replays">');
		include_once (dirname (__FILE__) . '/replays.php');
		print ('</span>');
	}

	print ('</span>');
	print ('</span>');

	print ('</div>'); /*** row end ***/
}
/*****************************************************************************/
function Vdungeon ($sName, $sAuthor, $sYear, $sNr, $iExtra, $iWarning)
/*****************************************************************************/
{
print ('
<span style="display:block; width:100%;">
<span style="float:left; width:33%;">
<img class="img-responsive" src="VDUNGEON.DAT/' . $sNr . '/1.png" alt="screenshot">
</span>
<span style="float:left; width:33%;">
<img class="img-responsive" src="VDUNGEON.DAT/' . $sNr . '/2.png" alt="screenshot">
</span>
<span class="span_info">
<a href="VDUNGEON.DAT/' . $sNr . '/VDUNGEON.DAT"><img src="images/download.png" alt="download"></a>
<br>
<span class="italic">"' . $sName . '"</span>
<br>
by: ' . $sAuthor . '
<br>
' . $sYear);

	if ($iExtra == 1)
	{
		print ('<br><a target="_blank" href="VDUNGEON.DAT/' . $sNr . '/extra.png"><img src="VDUNGEON.DAT/' . $sNr . '/extra.png" width="40" height="40" class="image_link" alt="extra"></a>');
	}
	if ($iWarning == 1)
	{
		print ('<br><img src="images/warning.png" alt="warning"> <span style="font-size:10px; color:#f00;">Warning: heavily redefines the meaning of some graphics.</span>');
	}

print ('
</span>
<span style="display:block; clear:both;"></span>
</span>
');
}
/*****************************************************************************/
function Vpalace ($sName, $sAuthor, $sYear, $sNr, $iExtra, $iWDA, $iWarning)
/*****************************************************************************/
{
print ('
<span style="display:block; width:100%;">
<span style="float:left; width:50%;">
<img class="img-responsive" src="VPALACE.DAT/' . $sNr . '/1.png" alt="screenshot">
</span>
<span style="float:left; width:50%;">
<img class="img-responsive" src="VPALACE.DAT/' . $sNr . '/2.png" alt="screenshot">
</span>
<span style="display:block; clear:both;"></span>
</span>
<span style="display:block; width:100%;">
<span style="float:left; width:50%;">
<img class="img-responsive" src="VPALACE.DAT/' . $sNr . '/3.png" alt="screenshot">
</span>
<span style="float:left; width:50%;">
<span class="span_info_pal">
<a href="VPALACE.DAT/' . $sNr . '/VPALACE.DAT"><img src="images/download.png" alt="download"></a>
<br>
<span class="italic">"' . $sName . '"</span>
<br>
by: ' . $sAuthor . '
<br>
' . $sYear);

	if ($iExtra == 1)
	{
		print ('<br><a target="_blank" href="VPALACE.DAT/' . $sNr . '/extra.png"><img src="VPALACE.DAT/' . $sNr . '/extra.png" width="40" height="40" class="image_link" alt="extra"></a>');
	}
	if ($iWDA == 1)
	{
		print ('<br><span style="color:#f00;">WDA</span>');
	}
	if ($iWarning == 1)
	{
		print ('<br><img src="images/warning.png" alt="warning"> <span style="font-size:10px; color:#f00;">Warning: heavily redefines the meaning of some graphics.</span>');
	}

print ('
</span>
</span>
<span style="display:block; clear:both;"></span>
</span>
');
}
/*****************************************************************************/
function DATLink ($sFile, $sNr, $sFirstMod, $sAuthor)
/*****************************************************************************/
{
	print ('<span class="kid">');
	print ('<img src="' . $sFile . '.DAT/' . $sNr . '/1.gif" alt="animation"><br>');
	print ('<a href="' . $sFile . '.DAT/' . $sNr . '/' . $sFile . '.DAT"><img src="images/download.png" alt="download"></a><br>');
	print ('<span style="color:#fff;">by ' . $sAuthor . '</span><br>');
	print ('<span style="font-size:12px; color:#fff;">');
	if ($sFirstMod != '')
	{
		print ('<a href="custom_levels.php?mod=' . $sFirstMod . '" style="color:#fff;">first mod</a>');
	} else {
		print ('-');
	}
	print ('</span>');
	print ('</span>' . "\n");
}
/*****************************************************************************/
function ShowSearch ($arSearch)
/*****************************************************************************/
{
	global $iMatches;

	StartHTML ('Custom Levels', 'Search', 'custom_levels.php', 'Play');

	if ($iMatches != 0)
	{
		$iFirst = 1;
		print ('<div style="text-align:center;"><p>');
		while ($row_search = mysqli_fetch_assoc ($GLOBALS['result_search']))
		{
			if ($iFirst != 1) { print ('<br>'); } else { $iFirst = 0; }
			print ('<a target="_blank" href="custom_levels.php?mod=' .
				ModCodeFromID ($row_search['mod_id']) . '">' .
				Sanitize ($row_search['mod_name']) . '</a>');
		}
		print ('</p></div>');
	}

	SearchForm ($arSearch);
}
/*****************************************************************************/
function ShowVDUNGEON ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'VDUNGEON.DAT', 'custom_levels.php', 'Play');

	print ('<p>This overview is based on David\'s <a href="custom_levels/various/all-graphics.zip">all-graphics.zip</a> (1.4MB), and has since been expanded.<br>Last updated: 5 March 2022</p>');

	print ('<span style="display:block; max-height:200px; overflow-y:scroll; margin-bottom:10px;">');
	Vdungeon ('SNES blue diff more', 'brain?', '????', '002', 0, 0);
	Vdungeon ('PoP: Lost on Small Bricks', 'Sweaty Scout (ten_z_palacu)', '2012', '003', 0, 0);
	Vdungeon ('Battle Hardened 2: Battle Hardened with Vengeance', 'Kor Jiek (KJ; kj-5349)', '2011', '004', 0, 0);
	Vdungeon ('Prince of Wateria', 'Norbert', '2013', '005', 0, 1);
	Vdungeon ('An Hour in the Prison', 'Maurice Kaltofen (mk1995)', '2007', '006', 0, 0);
	Vdungeon ('Levels08 / Brown', 'Steven Fayers (ecco)', '2004', '007', 1, 1);
	Vdungeon ('Blue', 'Steven Fayers', '2004', '008', 0, 0);
	Vdungeon ('Dark Brown / KX - Out of Time', 'Darth Marsden', '2004/2005?', '009', 0, 0);
	Vdungeon ('Flying Prince', 'mmitch', '2007', '010', 0, 0);
	Vdungeon ('Green', 'Steven Fayers? Guido?', '2004', '011', 0, 0);
	Vdungeon ('Stone (ice?) / hwdun01', 'hanswurst', '2006', '012', 0, 0);
	Vdungeon ('The Naughty Little Buddy', 'Micheal Muniko (mickey96, musa)', '2008', '013', 0, 0);
	Vdungeon ('Pirates of Persia / Wooden / hwdun02', 'hanswurst', '2006', '014', 0, 0);
	Vdungeon ('Repetition of Time', 'KingOfPersia', '2006', '015', 0, 1);
	Vdungeon ('SNES level 1-3 v1', 'brain', '2008', '016', 0, 0);
	Vdungeon ('SNES level 1-3 v2', 'brain', '2008', '017', 0, 0);
	Vdungeon ('SNES level 1-3 v3', 'brain', '2008', '018', 0, 0);
	Vdungeon ('SNES Level 8 v1.0', 'brain', '2007', '019', 0, 0);
	Vdungeon ('SNES Level 8 v1.3', 'brain', '2007', '020', 0, 0);
	Vdungeon ('SNES Level 8 newest', 'brain', '????', '021', 0, 0);
	Vdungeon ('SNES Level 11 v1.1', 'brain', '2007', '022', 0, 0);
	Vdungeon ('Dungeon gfx that have less flicker on a tv screen.', 'Steven Fayers', '2004', '023', 0, 0);
	Vdungeon ('Prince of Venus', 'Micheal Muniko (mickey96, musa)', '2008', '024', 0, 0);
	Vdungeon ('Yellow', 'Wirus2', '2004', '025', 0, 0);
	Vdungeon ('?', 'Steven Fayers?', '????', '026', 1, 0);
	Vdungeon ('?', 'hanswurst', '????', '027', 0, 0);
	Vdungeon ('Endless tomb', 'the_mad_joob', '2007', '028', 0, 0);
	Vdungeon ('Endless tomb (older)', 'the_mad_joob', '????', '029', 0, 0);
	Vdungeon ('New trick bootcamp', '?', '????', '030', 0, 0);
	Vdungeon ('cga, palette 0, low intensity', 'hbzlmx', '2012', '031', 0, 0);
	Vdungeon ('cga, palette 0, high intensity', 'hbzlmx', '2012', '032', 0, 0);
	Vdungeon ('cga, palette 1, low intensity', 'hbzlmx', '2012', '033', 0, 0);
	Vdungeon ('cga, palette 1, high intensity', 'hbzlmx', '2012', '034', 0, 0);
	Vdungeon ('cga, palette 2, low intensity', 'hbzlmx', '2012', '035', 0, 0);
	Vdungeon ('cga, palette 2, high intensity', 'hbzlmx', '2012', '036', 0, 0);
	Vdungeon ('ega style', 'hbzlmx', '2012', '037', 0, 0);
	Vdungeon ('Fixed dungeon graphics from Levels of Illusion', 'Youran Tumayel', '2020', '038', 0, 0);
	Vdungeon ('Adventures in Hopeless Sites', 'Emiliano', '2020', '039', 0, 0);
	Vdungeon ('Greyscale graphics', 'Emiliano', '2020', '040', 0, 0);
	Vdungeon ('2D neon', 'Norbert', '2019', '041', 0, 0);
	Vdungeon ('The Resurrection of Jaffar New graphics', 'SuavePrince', '2015', '042', 0, 0);
	Vdungeon ('Root Planet', 'Emiliano', '2020', '043', 0, 0);
	Vdungeon ('King of Persia', 'xhul', '2014', '044', 0, 0);
	Vdungeon ('0B99\'s Levels 1', 'Emiliano', '2020', '045', 0, 0);
	Vdungeon ('Golden dungeons from PoP 1.3', 'Emiliano', '2020', '046', 0, 0);
	Vdungeon ('Princess of Persia', 'jeminacek', '2015', '047', 0, 0);
	Vdungeon ('ghost', 'Norbert', '2017', '048', 0, 1);
	Vdungeon ('Orange-Brown dungeons from PoP 1.3', 'Emiliano', '2020', '049', 0, 0);
	Vdungeon ('Green dungeons from PoP 1.3', 'Emiliano', '2020', '050', 0, 0);
	Vdungeon ('Welcome to the darkness graphics', 'Emiliano', '2020', '051', 0, 0);
	Vdungeon ('Levels of Illusion', '4DPlayer', '2019', '052', 0, 0);
	Vdungeon ('Lihinghntom\'s Palace', 'Emiliano', '2019', '053', 0, 0);
	Vdungeon ('Brown-yellow dungeon graphics', 'Youran Tumayel', '2020', '054', 0, 0);
	Vdungeon ('No Chance for Escaping', 'Emiliano', '2020', '055', 0, 0);
	Vdungeon ('The Dungeons of a Dark Magician', 'DKM', '2008', '056', 0, 0);
	Vdungeon ('Dark brown', 'Youran Tumayel', '2020', '057', 0, 0);
	Vdungeon ('0B99\'s Levels 2', 'Emiliano', '2020', '058', 0, 0);
	Vdungeon ('Water Graphics', 'Emiliano', '2020', '059', 0, 0);
	print ('</span>');
	print ('<span style="display:block; overflow-y:scroll;">');
	Vdungeon ('Original', 'Jordan Mechner', '1990', '001', 0, 0);
	print ('</span>');
	print ('<span style="display:block; clear:both; margin-bottom:20px;"></span>');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
06786a53957640ecea2f87b6e0ac0b14
0aea3ddabc0d94a3891e71939c6f316e
0ebbec94fca9f830618a007fd90debf6
15c758bc2a412e10db78c75385836568
1c156bebf54d640d51e34a90535e0d91
1ce3f5e32ae4ee65cdaa9ccb063241eb
201950f4a5c9eb9fe70d528db8f147a6
20fdd7345b0186571ad5354e7e032b53
25aee8be0aa93301e980be4fc850bf93
29ccb1134b61a736edc7a80ae44bf8ce
29f2d4645bc7567f35d2ad0f1ede486f
2e41e16f99f174f1d801122277290a76
307ba12d42cf51cc18c6e54de8fae8ee
35383e73ee449fe2b3eee17a4ea4ba55
3cc1ead1ce6ce4fde6cb9bbcfa25fe2f
452126aad7335b885a90c1288cabf0ec
4eca86600cf3f9f357ac76df43d0a132
50328caa70bbfafc44964ca68aad035c
50408e60557953eb6aabc700e07ed69d
509243f97a846503f873b62484176457
5120db2ca878400ab8bb64bf6233e466
52b23ff2918c81f84550428e9fa19e47
581d7f130950c97f7925d137cfb9881d
590632bf53c0995a8522ce8b0fe537a8
666221564e79dbedff69ad2c73f183b2
66ac7de1b1057d5c49c369f6b942d6ab
69c6887c6f248dbe9a2abeccf48419ad
6c10358489dd2f3db4e20f63a67cf2dd
6c4083bf96f98710d46bf41a7c901467
71a2c1301f74fd2ae0af2f28e91c2b5f
752521ce5896b29a6e34a781f7d4d1ed
79d88ca47f6093ed81d2e7bb06fb4ba6
7d089b9b285dc83919b8e2fba64ee1f2
7dc0d2d1ce602e6939c3f46f4b680107
8194b5b9a51cd84378938c514eae4bf5
846baaa409b3d08139f0cfab9ee315b6
87057d0b720e925b88ac999f1620cd4a
8ca337228eb41fbf9e246dcfa3da1b6f
8d6b3e17509f7d350404dfe4d915e08b
91b6583db1f596b8d320b36b9cd790bf
921ac09a08ab85837443230d7e78fc78
957f95d7451dbe56431dfe0f4bfe4ad6
963550e5c98983c641daf12bcf82ae5d
969dfee07587f63c990dad26fb31cdb8
9776047fe3343a3698275da78adb48f3
a2372efc687d06fb50cf3ce152090232
a6953b84b37649c7aa3fa08fd9cb8ee4
ad05d4c38533b435282a3716b5a95c02
b26b2f953840db9c336e3517609bd839
b3b3e49b4460ccf2233fa0ea285e46a8
b85f1ba024161df46e85f271f78097c1
b87bd71d20df5783059f71c710d08790
c001853e26b26df5b7762a6ad66b1d64
c00a8830abeb568dda822438611a4d59
c2e164644dbcb194014140d057c00dee
dd3ce411dba02c09f1242c56918fac51
e444841b9996eeafc25f321f68cad3b3
ea65d2a8f00390be9d08cb75455fcad9
f86f559f8a57c614260d85e7ee868774
</span>
');
}
/*****************************************************************************/
function ShowVPALACE ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'VPALACE.DAT', 'custom_levels.php', 'Play');

	print ('<p>This overview is based on David\'s <a href="custom_levels/various/all-graphics.zip">all-graphics.zip</a> (1.4MB), and has since been expanded.<br>Last updated: 5 March 2022</p>');

	print ('<span style="display:block; max-height:400px; overflow-y:scroll; margin-bottom:10px;">');
	Vpalace ('An Hour in the Prison', 'Maurice Kaltofen (mk1995)', '2007', '002', 0, 0, 0);
	Vpalace ('Blue Marble', 'hanswurst', '????', '003', 0, 1, 0);
	Vpalace ('Brain', 'brain', '????', '004', 0, 0, 0);
	Vpalace ('Brain v1.1', 'brain', '????', '005', 0, 0, 0);
	Vpalace ('Flying Prince', 'mmitch', '2007', '006', 0, 0, 0);
	Vpalace ('KX - Out of Time', 'Darth Marsden', '2005', '007', 0, 0, 0);
	Vpalace ('Repetition of Time', 'KingOfPersia', '2006', '008', 0, 0, 1);
	Vpalace ('SNES Level 13-15', 'brain', '????', '009', 0, 1, 0);
	Vpalace ('SNES Level 13-15 v1', 'brain', '????', '010', 0, 1, 0);
	Vpalace ('SNES Level 13-15 v1.3', 'brain', '????', '011', 0, 1, 0);
	Vpalace ('SNES Level 13-15', 'brain', '????', '012', 0, 0, 0);
	Vpalace ('Prince of Venus', 'Micheal Muniko (mickey96, musa)', '2008', '013', 0, 1, 0);
	Vpalace ('Prince of Wateria', 'Norbert', '2013', '014', 0, 0, 1);
	Vpalace ('Pirates of Persia', 'hanswurst', '2006', '015', 0, 1, 0);
	Vpalace ('The Dragon Temple', 'the_mad_joob', '????', '016', 0, 0, 0);
	Vpalace ('cga, palette 0, low intensity', 'hbzlmx', '2012', '017', 0, 1, 0);
	Vpalace ('cga, palette 0, high intensity', 'hbzlmx', '2012', '018', 0, 1, 0);
	Vpalace ('cga, palette 1, low intensity', 'hbzlmx', '2012', '019', 0, 1, 0);
	Vpalace ('cga, palette 1, high intensity', 'hbzlmx', '2012', '020', 0, 1, 0);
	Vpalace ('cga, palette 2, low intensity', 'hbzlmx', '2012', '021', 0, 1, 0);
	Vpalace ('cga, palette 2, high intensity', 'hbzlmx', '2012', '022', 0, 1, 0);
	Vpalace ('ega style', 'hbzlmx', '2012', '023', 0, 1, 0);
	Vpalace ('fixed palace for Sting', 'Youran Tumayel', '2020', '024', 0, 0, 0);
	Vpalace ('Monsters of Persia', 'Emiliano', '2019', '025', 0, 0, 0);
	Vpalace ('Adventures in Hopeless Sites', 'Emiliano', '2020', '026', 0, 0, 0);
	Vpalace ('Wood', '?', '2007', '027', 0, 0, 0);
	Vpalace ('micro', 'Norbert', '2014', '028', 0, 0, 0);
	Vpalace ('Sun graphics', 'Emiliano', '2020', '029', 0, 0, 0);
	Vpalace ('Dark brown', 'Youran Tumayel', '2020', '030', 0, 0, 0);
	Vpalace ('Mysterious Castle 2', 'Aram', '2018', '031', 0, 0, 0);
	Vpalace ('Greyscale graphics', 'Emiliano', '2020', '032', 0, 0, 0);
	Vpalace ('2D neon', 'Norbert', '2019', '033', 0, 0, 0);
	Vpalace ('Lost in the darkness', 'Emiliano', '2020', '034', 0, 0, 0);
	Vpalace ('Brown palace from PoP 1.3', 'Emiliano', '2020', '035', 0, 0, 0);
	Vpalace ('Space Nightmares', 'Emiliano', '2020', '036', 0, 0, 0);
	Vpalace ('Orange-Brown palace from PoP 1.3', 'Emiliano', '2020', '037', 0, 0, 0);
	Vpalace ('0B99\'s Levels 1', 'Emiliano', '2020', '038', 0, 0, 0);
	Vpalace ('Orange-Brown palace from PoP 1.3 fixed', 'Emiliano', '2020', '039', 0, 0, 0);
	Vpalace ('Golden palace from PoP 1.3 fixed', 'Emiliano', '2020', '040', 0, 0, 0);
	print ('</span>');
	print ('<span style="display:block; overflow-y:scroll;">');
	Vpalace ('Original', 'Jordan Mechner', '1990', '001', 0, 0, 0);
	print ('</span>');
	print ('<span style="display:block; clear:both; margin-bottom:20px;"></span>');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
034eb395ee02ae20c0b085462e4fdd3a
10dd5467a8410040ecfc916a18c2e5ac
1ff0ef441d3a0a026a693bfa7ab27089
23cec36dc68fe2af80231fa8004dbc3f
2836f9fc4eb0cd9bcdb31d635fa18a81
2b1e0e3bf06e951aebbe7b73a3b2cf7f
2e803e3abd59896e3e29635ebd8876c0
2f8539e569abc888c8d3de931485fb2b
33d81b0e47989dfd9c8cd4c74d2eb517
4e03c8f1c0a9c26f7bdea6c343268eaa
4e3bba84d7e7a93b803fe2052f529aaf
503dd48181a2a6dc874e0929bbb71067
5127964af402f6a2a9d72f9fc377baab
62f5a6d8fdc4a1dace52ba6fe0547fc9
635888701eb420743ee787be0a4fea71
6375aebd78f4b6842c381b6c0246d9e7
66867792a655f5c2cc983a15a6255e78
66a41aa7a78e258df75940bca90cb3c4
681af896cc1ff792b4ed467b5b124713
6c82d58ee7c14f21647db7ea5d269795
6e7954b1e021a12fbc7c209d3d682ae3
6e9537d97e4b49ae72e01f045663e30e
750b6fc0d325627b50536eacf0a249b9
764be932affb9b82762bfe17961217ae
79bb1cce98be54fd05dee7d563f935f7
80b4bd7e651cbbf67c76d82f938da88c
8b26eb9ca2c65bdfc384f91f217c556a
904eadcb179018f04537545a3d49e5ec
95d9812456ff77bcbc81cb1eaaa0e1db
9c9d7456eed0b98f11633eb272dfe8a8
9d69f652a8983a4ab9477a9e38f734c7
9e825fee0fa7dc16937873dbeacfffd1
afdaf362a3948029464bd01195185320
bfca4ef6a8b967aa2af2a5c7f8b4fdbe
c77ad13eb4035740096ab964624ae9d0
ce0fd575d9d219bde1de32dd76bf8787
de452030b502ce6350a5d9b3c951b494
e1d14ebf317466aaa3fabb2ddd038414
e5dfd63aea127644f53716eed2d9ee6d
ed326f819f4c1474c0837aaecdea1ac4
</span>
');
}
/*****************************************************************************/
function ShowKID ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'KID.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor, e.g. just the hair or feet color.<br>Some variants only modified a handful of frames of existing modifications, e.g. just the mouse.<br>Also, note that some graphical changes may impact which tricks are possible (<a href="documentation.php?doc=TricksPage3#83">example</a>).<br>Last updated: 5 March 2022</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=KID KID.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center KID/kid/normal.bmp KID/kid/*/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('KID', '001', '0000001', 'Jordan Mechner');
	DATLink ('KID', '002', '0000004', 'Jalal Noureddine');
	DATLink ('KID', '003', '0000007', 'programmer');
	DATLink ('KID', '004', '0000009', 'tV2');
	DATLink ('KID', '005', '0000010', 'KingOfPersia');
	DATLink ('KID', '006', '0000012', 'Darth Marsden');
	DATLink ('KID', '007', '0000016', 'Brain');
	DATLink ('KID', '008', '0000017', 'BlackChar');
	DATLink ('KID', '009', '0000024', 'the_mad_joob');
	DATLink ('KID', '010', '0000038', 'Brain');
	DATLink ('KID', '011', '0000041', 'Veke');
	DATLink ('KID', '012', '0000058', 'mmitch');
	DATLink ('KID', '013', '0000072', 'KJ');
	DATLink ('KID', '014', '0000073', 'KJ');
	DATLink ('KID', '015', '0000074', 'KJ');
	DATLink ('KID', '016', '0000075', 'KJ');
	DATLink ('KID', '017', '0000082', 'musa');
	DATLink ('KID', '018', '0000084', 'musa');
	DATLink ('KID', '019', '0000088', 'Brain');
	DATLink ('KID', '020', '0000089', 'musa');
	DATLink ('KID', '021', '0000093', 'Brain');
	DATLink ('KID', '022', '0000108', 'Norbert');
	DATLink ('KID', '023', '0000120', 'Jakim/yaqxsw');
	DATLink ('KID', '024', '0000121', 'The Edster');
	DATLink ('KID', '025', '0000122', 'DKM');
	DATLink ('KID', '026', '0000127', 'Norbert');
	DATLink ('KID', '027', '0000156', 'jeminacek');
	DATLink ('KID', '028', '0000157', 'elmaton');
	DATLink ('KID', '029', '', 'hellgenocid');
	DATLink ('KID', '030', '', 'the_mad_joob');
	DATLink ('KID', '031', '', 'mk1995');
	DATLink ('KID', '032', '', 'Brain');
	DATLink ('KID', '033', '', 'Brain');
	DATLink ('KID', '034', '', 'Brain');
	DATLink ('KID', '035', '0000182', 'Norbert');
	DATLink ('KID', '036', '', 'Emiliano');
	DATLink ('KID', '037', '0000259', 'Emiliano');
	DATLink ('KID', '038', '0000224', 'Emiliano');
	DATLink ('KID', '039', '0000216', '4DPlayer');
	DATLink ('KID', '040', '0000226', 'Youran Tumayel');
	DATLink ('KID', '041', '', 'Emiliano');
	DATLink ('KID', '042', '', 'Emiliano');
	DATLink ('KID', '043', '0000214', 'Atrueprincefanfrom18');
	DATLink ('KID', '044', '0000197', '4DPlayer');
	DATLink ('KID', '045', '', 'Emiliano');
	DATLink ('KID', '046', '0000203', 'Emiliano');
	DATLink ('KID', '047', '0000141', 'xhul');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
05c014133ea7b8dd9bc4b8f7cac74fe2
1023aa71ac45b489913ad33cd9096ac1
117261066339d798852d06117c659c11
1dea336d845bdcf7b9c77b293d2cd9b2
260fcd3dd873a8d4b5aae2a64d5b9b91
289f0c0e7142baa88a87ef2c49d32c03
2f5e2a39e20314929341667857318881
31b290e21bc5b5c1048e72e5fb71f462
32a89a4f95fa034806cbc8c21e0a20bd
33b5c9e21ce2c170ef2a5402a69008ca
34464f072e56f757db29bf9b8f60b2d2
3a0652d11c52f62ffbd27304d386350e
3fdac7c3de1caca43d1ddc982a10f845
4028d6849917497018bf0ea933ae6184
41362b083901fd4dc003c060409b585c
52690adad184f061591c859b544711fc
53123dbbaf1498f9316d2864f98920d9
574a8eae708a78daffaf0d60d9077cb9
5897f60ea04fdff1763b9cf25897d9f7
61a0abd320ccd0e4cbca02ccee02f637
6b06b3644daee2400e2c9129a93ffaa4
6ea7713968eae5f767fa8199130d3b07
775b6315d046e23d774bacc54f8173e8
7b146a71d1b513e937aa1e7a5bfae053
84838460a01f1167801fc082181dbceb
85033ff3666495e3b74b3e2791357397
8d259368b038568afaabcd99fc3a760e
8dada1990092f7f27bb995c63254bedf
98f2f41beee0a9bbe55b01271eb31c92
9ba879fe14cf0f77839e7c3e46ac677a
9f6de8b8dbdd0c5ecf302049d36c65b1
ac756510eed98acc6f3e0aa5eb610a14
acdedb1cbf9504b86754cbbb1f8c00aa
af7a50e8a6a8774f9d5cde4ae9397eb3
b0d6485ee7438d7a0b490c06f9f3dfd3
b6f0e8591dc0e317d9ef6427b04e19ad
b74c8f19f8a8a6b88d9eeb18ebf734f2
b924fae811474ab084ae1f469a20c6bd
bc6be6f34da47d5ad37bab3bb31c0ab8
bec610e4b8bb1f9b8da8537a932d4f63
bf03829e16d8f4b3c5b221edcb888080
cd3c73def9f9402ed3552683c6d17506
d43c6749ab787318d5f69c3259f0e9f8
dfe4445c459fa6f5107f7fcc89e7bf9c
e370ce6659776645c5315a25d407f71e
f133ff90d5f7c2e47c24dd396869d3c8
f4ea6195c2b0473cdea531d4aa63be7c
</span>
');
}
/*****************************************************************************/
function ShowFAT ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'FAT.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor, e.g. just the HP indicator frame.<br>Last updated: 5 March 2022</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=FAT FAT.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center FAT/fat/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('FAT', '001', '0000001', 'Jordan Mechner');
	DATLink ('FAT', '002', '0000007', 'programmer');
	DATLink ('FAT', '003', '0000010', 'KingOfPersia');
	DATLink ('FAT', '004', '0000012', 'Darth Marsden');
	DATLink ('FAT', '005', '0000017', 'BlackChar');
	DATLink ('FAT', '006', '0000058', 'mmitch');
	DATLink ('FAT', '007', '0000059', 'mk1995');
	DATLink ('FAT', '008', '0000072', 'KJ');
	DATLink ('FAT', '009', '0000073', 'KJ');
	DATLink ('FAT', '010', '0000075', 'Brain');
	DATLink ('FAT', '011', '0000082', 'musa');
	DATLink ('FAT', '012', '0000084', 'musa');
	DATLink ('FAT', '013', '0000089', 'musa');
	DATLink ('FAT', '014', '0000105', 'KJ');
	DATLink ('FAT', '015', '0000108', 'Norbert');
	DATLink ('FAT', '016', '0000121', 'AuraDragon/The Edster');
	DATLink ('FAT', '017', '0000127', 'Norbert');
	DATLink ('FAT', '018', '0000136', 'ArmFly');
	DATLink ('FAT', '019', '0000156', 'jeminacek');
	DATLink ('FAT', '020', '0000169', 'KJ');
	DATLink ('FAT', '021', '0000173', 'Damian0');
	DATLink ('FAT', '022', '0000179', 'Damian0');
	DATLink ('FAT', '023', '0000182', 'Norbert');
	DATLink ('FAT', '024', '', 'mk1995');
	DATLink ('FAT', '025', '0000197', '4DPlayer');
	DATLink ('FAT', '026', '0000232', 'dmitrys');
	DATLink ('FAT', '027', '', 'Emiliano');
	DATLink ('FAT', '028', '0000200', 'Norbert');
	DATLink ('FAT', '029', '', 'Youran Tumayel');
	DATLink ('FAT', '030', '', '?');
	DATLink ('FAT', '031', '', 'Emiliano');
	DATLink ('FAT', '032', '', 'Youran Tumayel');
	DATLink ('FAT', '033', '', 'Emiliano');
	DATLink ('FAT', '034', '', 'Emiliano');
	DATLink ('FAT', '035', '0000221', 'Emiliano');
	DATLink ('FAT', '036', '', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
0881a2abb38e1c35bc56c0804413dbd3
12af67c69d53048884c3bdf9571ac1f8
165776ca56b49883610b28c60161d1d4
21c97cf61446a92df26bfa500346dcbf
247aaeca301ea14558937ae2042cda8e
30ac5544df7896b0fda0ec180c2129f0
34adcb2e478d1f52b81d31516672fd3e
38f4db6f505793f60d22f013672f5d18
39b90fb6b78a1f3eb0fe528f2ecd701a
3ba2560a70e9bc45accf1197f377faba
463f70385bb2d29ae459aedde89c93c1
5e53f7153142c16f9e2dbe2467464212
60e8040bbb39b47b74a63ed4829019e1
62c1522839b6f009688a84ad59ef23a3
62dbfa916c88cdb9ce601b0ba821d180
631b091438d3176575163dfe2539618b
6573d2389cd3f9259d5bf1dea8da5e0f
6a3019c1fd7141118ac05d02e10374b6
6b4d062b506cb32a0972c8f32f4e32d6
76fbe9d57589efa5488be65e6bb411b3
812d3e619d8f2fbe9656ff661698d68a
861a8a2d1e92be0d0634f93bc1b41d67
93d37838f7448cd122ac91f7cf4303dd
9e9fc64849b8bc971ecf1de7355eb84b
a816258ce3089ad6dce9d17340ac355d
b5d1b2e6b3c767904ba84363910c200d
b6cc47b76d1f9e242713b43459dd2844
bc6e267f8bdb9ccbb287e6e59bf03e8d
c0d4d9d8dacd94b9d65f585f8c64fe5a
c7145b333d1b82840afe273199127641
d3114219daa44d0b14c0a6404724f8c9
d88746eb0e5d2bf0785d881983a2cc39
eeeb7e46afdfee2ba51f63293b10d55b
f44b38317a90f5911853285ef122532f
f8410eb398774a6d4b95fad1b489716e
ff7332fd580c11439cdb92320cfdf4bb
</span>
');
}
/*****************************************************************************/
function ShowSHADOW ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'SHADOW.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor, e.g. just the HP indicator frame.<br>Last updated: 5 March 2022</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=SHADOW SHADOW.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center SHADOW/shadow/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('SHADOW', '001', '0000001', 'Jordan Mechner');
	DATLink ('SHADOW', '002', '0000007', 'programmer');
	DATLink ('SHADOW', '003', '0000010', 'KingOfPersia');
	DATLink ('SHADOW', '004', '0000012', 'Darth Marsden');
	DATLink ('SHADOW', '005', '0000017', 'BlackChar');
	DATLink ('SHADOW', '006', '0000058', 'mmitch');
	DATLink ('SHADOW', '007', '0000059', 'mk1995');
	DATLink ('SHADOW', '008', '0000075', 'Brain');
	DATLink ('SHADOW', '009', '0000082', 'musa');
	DATLink ('SHADOW', '010', '0000084', 'musa');
	DATLink ('SHADOW', '011', '0000089', 'musa');
	DATLink ('SHADOW', '012', '0000108', 'Norbert');
	DATLink ('SHADOW', '013', '0000121', 'AuraDragon/The Edster');
	DATLink ('SHADOW', '014', '0000127', 'Norbert');
	DATLink ('SHADOW', '015', '0000136', 'ArmFly');
	DATLink ('SHADOW', '016', '0000156', 'jeminacek');
	DATLink ('SHADOW', '017', '0000157', 'elmaton');
	DATLink ('SHADOW', '018', '0000169', 'KJ');
	DATLink ('SHADOW', '019', '0000182', 'Norbert');
	DATLink ('SHADOW', '020', '', 'mk1995');
	DATLink ('SHADOW', '021', '', 'Emiliano');
	DATLink ('SHADOW', '022', '', 'Emiliano');
	DATLink ('SHADOW', '023', '0000221', 'Emiliano');
	DATLink ('SHADOW', '024', '0000216', '4DPlayer');
	DATLink ('SHADOW', '025', '0000197', '4DPlayer');
	DATLink ('SHADOW', '026', '', 'Emiliano');
	DATLink ('SHADOW', '027', '', 'Emiliano');
	DATLink ('SHADOW', '028', '', '?');
	DATLink ('SHADOW', '029', '', 'Emiliano');
	DATLink ('SHADOW', '030', '', 'Emiliano');
	DATLink ('SHADOW', '031', '', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
0163c73287f822882a7b2b2d37f334e0
01d5c4b154bf71dc8335d64419df7099
0961c754156294944a5776c853f4053c
1b9e6956f54dac1a679fd8b6ef740029
2220904ab2024867b7b53961a180a822
283cae70fbec541da100327589f6cfc0
30fa2dfc1e6e27ed6ccdd8a5722ed013
34e1b3f66adb6036025d3bb743f2a20e
4455e21597874c3373ea0f3dfd4a8dc3
45fb26c8bca6677e0040ca565751b6c0
461c5748b318d1504108d7386d5e1922
52d9ae28872370515db6a3c79d7403ee
57ff17566e048740a1cb63dd49ab2967
5c3c7cd883a72e0eaa92e5ad340e5d17
6da31783d7915007e059a1cd6d8623e7
6f3e8e1d5ab5df8d8d1b11807dece814
7194898c16aab3ef9394d935964baa34
720779cd1d72a035d28752fbebef6312
72b66d731e73541bda5aa5316524ff97
7393d8d01e84a1d0fbd54d9abadc0112
74ef2108014df475dd393a1dd86bf2f7
79ca5648941b5e2fc422ceeb81c2db2b
877f476bff9934603b6bb7671c1f7dfd
90b7aa13f795ae9b11cdbc3c234ff2cd
ae0438795add24faf8d93a7da858a33d
b1c358dc830bb739a57adbed466597bf
cd938ce3f4e7849b27a7df6ff2c3714f
cdf1af61e2ce056173456f260735e437
f6d203f438122bdf0e1b1db30007e1d1
f880d64f426b732126b509cbb629daa8
fdfc30c76befeb4d1f458ef9a779ad02
</span>
');
}
/*****************************************************************************/
function ShowVIZIER ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'VIZIER.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor, e.g. just the HP indicator frame.<br>Last updated: 5 March 2022</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=VIZIER VIZIER.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center VIZIER/vizier/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('VIZIER', '001', '0000001', 'Jordan Mechner');
	DATLink ('VIZIER', '002', '0000003', 'Jalal');
	DATLink ('VIZIER', '003', '0000004', 'Jalal');
	DATLink ('VIZIER', '004', '0000009', 'tV2/programmer');
	DATLink ('VIZIER', '005', '0000010', 'KingOfPersia');
	DATLink ('VIZIER', '006', '0000016', 'Nicolas Normand');
	DATLink ('VIZIER', '007', '0000034', 'Darth Marsden');
	DATLink ('VIZIER', '008', '0000038', 'Nicolas Normand');
	DATLink ('VIZIER', '009', '0000058', 'mmitch');
	DATLink ('VIZIER', '010', '0000072', 'KJ');
	DATLink ('VIZIER', '011', '0000075', 'Brain');
	DATLink ('VIZIER', '012', '0000084', 'Brain');
	DATLink ('VIZIER', '013', '0000086', 'lignux');
	DATLink ('VIZIER', '014', '0000089', 'musa');
	DATLink ('VIZIER', '015', '0000105', 'KJ');
	DATLink ('VIZIER', '016', '0000108', 'Norbert');
	DATLink ('VIZIER', '017', '0000121', 'AuraDragon/The Edster');
	DATLink ('VIZIER', '018', '0000122', 'DKM');
	DATLink ('VIZIER', '019', '0000127', 'Norbert');
	DATLink ('VIZIER', '020', '0000141', 'xhul');
	DATLink ('VIZIER', '021', '0000156', 'jeminacek');
	DATLink ('VIZIER', '022', '0000157', 'elmaton');
	DATLink ('VIZIER', '023', '0000169', 'KJ');
	DATLink ('VIZIER', '024', '0000182', 'Norbert');
	DATLink ('VIZIER', '025', '', 'Emiliano');
	DATLink ('VIZIER', '026', '0000225', 'Youran Tumayel');
	DATLink ('VIZIER', '027', '', 'Emiliano');
	DATLink ('VIZIER', '028', '0000216', '4DPlayer');
	DATLink ('VIZIER', '029', '0000197', '4DPlayer');
	DATLink ('VIZIER', '030', '0000226', 'Youran Tumayel');
	DATLink ('VIZIER', '031', '', '?');
	DATLink ('VIZIER', '032', '', 'Emiliano');
	DATLink ('VIZIER', '033', '', 'Emiliano');
	DATLink ('VIZIER', '034', '0000203', 'Emiliano');
	DATLink ('VIZIER', '035', '0000214', 'atrueprincefanfrom2018');
	DATLink ('VIZIER', '036', '', 'Emiliano');
	DATLink ('VIZIER', '037', '0000230', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
042a8743f9541be302061982ee9b3f05
05b60afc80f6c6d36e2a79760a07b9d6
21772da8719d6f73447c039315536a97
2220904ab2024867b7b53961a180a822
2fb6c9cc1c4e838fbe25f179ddf65f19
33a910991b0afb800868b631efaca1f3
35836082dd45ea473facfeed5a351fd5
360e5aaec40eebb51eaaf1bff439be3e
3702f52bf7c5d44b9e323e4e2c841b1e
3ebbe7e47f0c3b336ad80556dbe80191
41e88b13124865dd4d041d501a3a8d47
4d5886c471210b2e460790913a07aca2
5714bd1372e195830d8f547cb2d087d7
64d0647fc0a780345fadc9cf6b14ce72
7c2d0a33bc531d4dd7345d1c7e771da6
83d3bdd23a34456d161856cc844b2e4d
84b56f8b6c469abfe745484ef47d5d28
86d8d67f53540aca4c73ce172fa45111
8b96980cdabd8588eb299558c07fe52f
947a8657567ae388bef5052cc60d495c
96eef42952d733cd368ebbb47c9f57ae
996e886f19e49e866807d86780169eed
a381d7f7fc71fb882a2dbb9840faf61f
a4918101f4d972687fcba8f3c1fef1f4
a570638f6f00a1f304ab72699567813e
ab39c1c23e6d24e0593136fa59f3fbc1
ac790d485d17476f4cc900b8a8fecd9a
c22700fb4fd8aa99387febc863f4accb
c55c7cd5b7917b532efbb923e0455907
c68bae0b861d456f0edbfedc333bb6bc
d9227ec4850ff654b5b445e1a680b0b4
ed0bed9100f302db08166b5f3237ca0b
edadb02fbd1314ba5dc8e247f698fbe5
ee258c2fae42f9c07d75ff1090b299d3
f163fef4f042414380ed8fb8d55914de
f17bf59a2207c1608fd7e748ba5bc6aa
f8988fdadb0ac579155b01c6f2c613c4
</span>
');
}
/*****************************************************************************/
function ShowSKEL ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'SKEL.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor.<br>Last updated: 5 March 2022</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=SKEL SKEL.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center SKEL/skel/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('SKEL', '001', '0000001', 'Jordan Mechner');
	DATLink ('SKEL', '002', '0000010', 'KingOfPersia');
	DATLink ('SKEL', '003', '0000017', 'BlackChar');
	DATLink ('SKEL', '004', '0000058', 'mmitch');
	DATLink ('SKEL', '005', '0000072', 'KJ');
	DATLink ('SKEL', '006', '0000073', 'KJ');
	DATLink ('SKEL', '007', '0000075', 'Brain');
	DATLink ('SKEL', '008', '0000086', 'lignux');
	DATLink ('SKEL', '009', '0000108', 'Norbert');
	DATLink ('SKEL', '010', '0000122', 'DKM');
	DATLink ('SKEL', '011', '0000127', 'Norbert');
	DATLink ('SKEL', '012', '0000136', 'ArmFly');
	DATLink ('SKEL', '013', '0000182', 'Norbert');
	DATLink ('SKEL', '014', '', 'mk1995');
	DATLink ('SKEL', '015', '', 'Emiliano');
	DATLink ('SKEL', '016', '', 'Emiliano');
	DATLink ('SKEL', '017', '0000216', '4DPlayer');
	DATLink ('SKEL', '018', '', 'Emiliano');
	DATLink ('SKEL', '019', '0000200', 'Norbert');
	DATLink ('SKEL', '020', '0000221', 'Emiliano');
	DATLink ('SKEL', '021', '', 'Emiliano');
	DATLink ('SKEL', '022', '', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
1a39934a7444360fba6ad109f8634be1
1e2d4bd6efdfe4d38f91a1ca65522c02
258051afe13d5aac6baadc0657583aa8
2c64a3ce0f076d1b1e09b2f3bc3a1af4
33a910991b0afb800868b631efaca1f3
3843b9bc212fe9e4e92ab48deea87150
4fd958fd2d09b737cc08d3acb9e8cb06
63e96977e1398040d6a775cc661678eb
646ec114cb0d2cd1877dafc7e0e3d09b
69185947233a54b058d26763a3b4d218
7b3dd3c26af49ff06ac147140ed8b2f7
85d7bf44344df510b9f372f80f3626e6
97624e1269395b1eac2b46fd2f6c7574
97c4bf48dd433fe619f9d75329819e4b
9d9b195d0664975476c82eaaae4b00cf
a816258ce3089ad6dce9d17340ac355d
b3985580e42d0ce09a8867d90bc9a4ac
b3dc4e12a8f87c5dc8646fd3ba1d40a6
d117c539f3fce4bb47b5b8faf12fa3f9
d7886a3598c984ce3e38d3c50faba339
ece99b55a4d639cbf46008d707f37358
f056dcc645cbc06850f230c60aa201f7
</span>
');
}
/*****************************************************************************/
function ShowPRINCE ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'PRINCE.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor.<br>Last updated: 5 March 2022</p>');
	print ('<p style="color:#f00; font-size:16px;">Note that this file also contains 7 palettes that are used with <a href="/custom_levels.php?action=GUARD.DAT" style="color:#f00;">GUARD.DAT</a>.<br>In "guard palettes.pal", with 16 lines for each of the 7 guards (that you see on, for example, apoplexy\'s tiles screen).</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=PRINCE PRINCE.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 20 -extent 50x75 -background black -gravity center PRINCE/prince/fire/*.bmp PRINCE/prince/potions/*/*.bmp PRINCE/prince/sword/fighting/sword24.bmp PRINCE/prince/sword/*floor*/*.bmp -loop 0 -scale 200% 1.gif</span></p>' . "\n");

	DATLink ('PRINCE', '001', '0000001', 'Jordan Mechner');
	DATLink ('PRINCE', '002', '0000007', 'programmer');
	DATLink ('PRINCE', '003', '0000009', 'tV2/programmer');
	DATLink ('PRINCE', '004', '0000010', 'KingOfPersia');
	DATLink ('PRINCE', '005', '0000012', 'Darth Marsden');
	DATLink ('PRINCE', '006', '0000016', 'Brain');
	DATLink ('PRINCE', '007', '0000058', 'mmitch');
	DATLink ('PRINCE', '008', '0000072', 'KJ');
	DATLink ('PRINCE', '009', '0000074', 'KJ');
	DATLink ('PRINCE', '010', '0000084', 'musa');
	DATLink ('PRINCE', '011', '0000088', 'Brain');
	DATLink ('PRINCE', '012', '0000108', 'Norbert');
	DATLink ('PRINCE', '013', '0000122', 'DKM');
	DATLink ('PRINCE', '014', '0000127', 'Norbert');
	DATLink ('PRINCE', '015', '0000156', 'jeminacek');
	DATLink ('PRINCE', '016', '0000182', 'Norbert');
	DATLink ('PRINCE', '017', '', 'mk1995');
	DATLink ('PRINCE', '018', '', 'Emiliano');
	DATLink ('PRINCE', '019', '0000197', '4DPlayer');
	DATLink ('PRINCE', '020', '0000223', 'Youran Tumayel');
	DATLink ('PRINCE', '021', '0000203', 'Emiliano');
	DATLink ('PRINCE', '022', '0000216', '4DPlayer');
	DATLink ('PRINCE', '023', '', 'Emiliano');
	DATLink ('PRINCE', '024', '0000226', 'Youran Tumayel');
	DATLink ('PRINCE', '025', '0000259', 'Emiliano');
	DATLink ('PRINCE', '026', '', 'Emiliano');
	DATLink ('PRINCE', '027', '', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
1201a1d098239489907152a7baaea89d
21f4de3af7f4668c33c06a1d46b1d945
2491b5e65469919504e2504608647081
2523fa450caca44831845f03d3238b42
2ef2e1cb5b631ea182668ccfbd0a997d
2f5c294a7ea2cb6e0f3f816e2b426e54
335232de13d1d8d7e5f9f9cc2261f972
34639097751c7cf5de3b81322d886d6e
4511be5b57aabb97f341cf18e18d4945
59badae1af66262046c6f396ffcdff57
620dc0d1a73418d488664a3a9700de01
68506d24f653b899c4e90323f109dd88
6bcb747c53dccb10b0ded4de780a2c68
76104617a510a0168d95ad5912d055a6
860ce4252b111cebd11493a0d21e9eaf
86cedb42f1b0d091642418669507b842
896808239363ad1bafd6d570a1b8c9c5
8c5d1141ff8ecd557f4b153953a7e3ae
936b62857fb90c353eb17cf830b722d4
9c8ca71a9d70899731bf03358aaf39c4
a99e5e8086e3e33c8ddc563af092c819
acf7ac667562900d53fd24fa92f3fe02
b83a5ddcb146796ad39f48fe3dc17040
d20635859aab528789a8d742223f1f54
e3bf050774cbc66b51b686b13505da37
f40db0b7c19b6ca9b53b843cf888c156
f48b3f67931992497ff3d0091680df86
</span>
');
}
/*****************************************************************************/
function ShowGUARD ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'GUARD.DAT', 'custom_levels.php', 'Play');

	print ('<p>In some cases the differences are minor, e.g. just the HP indicator frame.<br>Last updated: 5 March 2022</p>');
	print ('<p style="color:#f00; font-size:16px;">Note that this file only changes the sprites (shapes) and not the in-game palette (colors).<br>The colors are set with <a href="/custom_levels.php?action=PRINCE.DAT" style="color:#f00;">PRINCE.DAT</a>, in "guard palettes.pal".</p>');
	print ('<p>The animations below were created with:<br><span style="font-family:monospace;"><a href="other_useful_tools.php?tool=PR">pr</a> -f --export=GUARD GUARD.DAT<br><a target="_blank" href="https://www.imagemagick.org/">convert</a> -delay 10 -extent 50x75 -background black -gravity center GUARD/guards/*.bmp -loop 0 -scale 200% -colorspace Gray 1.gif</span></p>' . "\n");

	DATLink ('GUARD', '001', '0000001', 'Jordan Mechner');
	DATLink ('GUARD', '002', '0000007', 'programmer');
	DATLink ('GUARD', '003', '0000009', 'tV2/programmer');
	DATLink ('GUARD', '004', '0000010', 'KingOfPersia');
	DATLink ('GUARD', '005', '0000012', 'Darth Marsden');
	DATLink ('GUARD', '006', '0000016', 'Brain');
	DATLink ('GUARD', '007', '0000017', 'BlackChar');
	DATLink ('GUARD', '008', '0000059', 'mk1995');
	DATLink ('GUARD', '009', '0000072', 'KJ');
	DATLink ('GUARD', '010', '0000075', 'KJ');
	DATLink ('GUARD', '011', '0000084', 'musa');
	DATLink ('GUARD', '012', '0000089', 'musa');
	DATLink ('GUARD', '013', '0000108', 'Norbert');
	DATLink ('GUARD', '014', '0000121', 'AuraDragon/The Edster');
	DATLink ('GUARD', '015', '0000127', 'Norbert');
	DATLink ('GUARD', '016', '0000136', 'ArmFly');
	DATLink ('GUARD', '017', '0000156', 'jeminacek');
	DATLink ('GUARD', '018', '0000169', 'KJ');
	DATLink ('GUARD', '019', '0000173', 'Damian0');
	DATLink ('GUARD', '020', '0000182', 'Norbert');
	DATLink ('GUARD', '021', '', 'mk1995');
	DATLink ('GUARD', '022', '', 'KJ');
	DATLink ('GUARD', '023', '', 'KJ');
	DATLink ('GUARD', '024', '', 'KJ');
	DATLink ('GUARD', '025', '', 'KJ');
	DATLink ('GUARD', '026', '', 'KJ');
	DATLink ('GUARD', '027', '0000201', 'Emiliano');
	DATLink ('GUARD', '028', '0000214', 'Atrueprincefanfrom18');
	DATLink ('GUARD', '029', '0000232', 'dmitrys');
	DATLink ('GUARD', '030', '', 'Emiliano');

	print ('<span style="display:block; clear:both;"></span>');

print ('
<span style="display:block; height:100px; width:400px; max-width:100%; overflow:auto; white-space:pre; font-family:monospace; background-color:#eee;">
0309e360356302e75f048b077aa0ee1c
16a6be3864f19c2f0486f84248bfd622
17c22372466cfa12457664e7ed7ddfc1
18d77b54bfe260e1a10f52c5e1cd83f1
1b3ff02252360c15011432002e6f4897
27a45a2b2cc5ff2cc6589137572e3d33
3ba2560a70e9bc45accf1197f377faba
5054f1a39d99d0ef78e64b95e6c57f13
578228db88c8b795a509939c38f373d4
59d22056a6e43ee9bd3b8c0bf50a8d69
5bfbce609b9807a14d1c98d8b721ff75
65bb64cfe30872260ada8d274b2db19a
7cf26084f308c8de4cda13863b26cb00
8381d91edbafcc5b60985d11d03223c0
870ec0bdc9a3d0e9618e1ef9d81cd845
8bc49448bea2a071716e73e06f9e5450
92dd585c293bf10b85d012dd2d9710ae
9ae4e59db68b763f376c9d342ec70389
ba440a4e3602905414c19c95631a2cd8
c19c07b6319ab3398633d63fcee256c2
c7145b333d1b82840afe273199127641
cda325a7cb2341bf12cf0586e1c24a18
cda325a7cb2341bf12cf0586e1c24a18
d5f4e4ee5281d9098360e186e6c38c11
d60fc0526264c18eeccfde0ab61789de
de137f305cad6fd4820133a1d73d9e3c
ea24eeddbed3af1a70bae63fefe07638
f1c43e86e7a65e14926e203d2c45758e
f28ab572349395a43c2bce00a8c6192d
f82b7e0ac7156a7e174077ae9ba16f89
</span>
');
}
/*****************************************************************************/
function OldImage ($sPathFile, $iWidth, $iHeight)
/*****************************************************************************/
{
	/*** Used by ShowSubmitEdit(). ***/

	if (file_exists (dirname (__FILE__) . $sPathFile))
	{
print ('
<img src="' . $sPathFile . '" style="width:' . $iWidth . 'px; height:' . $iHeight . 'px;">
<span style="display:block; color:#f00;">
To keep this current image, simply do not select a file.
</span>
');
	}
}
/*****************************************************************************/
function ShowSubmitEdit ($iModID)
/*****************************************************************************/
{
	if ($iModID == 0)
	{
		$sAction = 'submit';
		$sButton = 'Submit';
		/*** $sModCode ***/
	} else {
		$sAction = 'edit';
		$sButton = 'Save';
		$sModCode = ModCodeFromID ($iModID);
	}
	StartHTML ('Custom Levels', ucfirst ($sAction), 'custom_levels.php', 'Play');

	if (!isset ($_SESSION['user_id']))
	{
		print ('To ' . $sAction . ' your mod, first' .
			' <a href="/user.php?action=Login">login</a>.');
		return;
	} else if ($sAction == 'edit') {
		$query_auth = "SELECT
				pm.author1_id,
				pu.nick
			FROM `popot_mod` pm
			LEFT JOIN `popot_user` pu
				ON pm.author1_id = pu.user_id
			WHERE (mod_id='" . $iModID . "')";
		$result_auth = Query ($query_auth);
		$row_auth = mysqli_fetch_assoc ($result_auth);
		if ($_SESSION['user_id'] != intval ($row_auth['author1_id']))
		{
			print ('Only user "' . Sanitize ($row_auth['nick']) .
				'" can edit this mod.');
			return;
		}
	}

	if (!extension_loaded ('zip'))
	{
		print ('Ask <a href="/contact_faq.php">the webmaster</a> to install' .
			' the "php-zip" extension.');
		return;
	}

	$iMaxUpload = GetSizeBytes (ini_get ('upload_max_filesize'));
	if ($iMaxUpload < (1024 * 1024 * 20))
	{
		print ('Ask <a href="/contact_faq.php">the webmaster</a> to increase' .
			' upload_max_filesize from ' . GetSizeHuman ($iMaxUpload) .
			' to 20M.');
		return;
	}

	$iMaxPost = GetSizeBytes (ini_get ('post_max_size'));
	if ($iMaxPost < (1024 * 1024 * 20))
	{
		print ('Ask <a href="/contact_faq.php">the webmaster</a> to increase' .
			' post_max_size from ' . GetSizeHuman ($iMaxPost) .
			' to 20M.');
		return;
	}

	/*** $row_mod ***/
	if ($iModID != 0)
	{
		$query_mod = "SELECT
				*
			FROM `popot_mod`
			WHERE (mod_id='" . $iModID . "')";
		$result_mod = Query ($query_mod);
		if (mysqli_num_rows ($result_mod) == 1)
		{
			$row_mod = mysqli_fetch_assoc ($result_mod);
			/***/
			$arEdit['mod_name'] = $row_mod['mod_name'];
			$arEdit['mod_year'] = $row_mod['mod_year'];
			$arEdit['mod_popversion'] = intval ($row_mod['mod_popversion']);
			$arEdit['mod_description'] = $row_mod['mod_description'];
			$arEdit['tag1_id'] = intval ($row_mod['tag1_id']);
			$arEdit['tag2_id'] = intval ($row_mod['tag2_id']);
			$arEdit['tag3_id'] = intval ($row_mod['tag3_id']);
			$arEdit['mod_minutes'] = intval ($row_mod['mod_minutes']);
			$arEdit['author1_type'] = intval ($row_mod['author1_type']);
			$arEdit['author2_id'] = intval ($row_mod['author2_id']);
			$arEdit['author2_type'] = intval ($row_mod['author2_type']);
			$arEdit['author3_id'] = intval ($row_mod['author3_id']);
			$arEdit['author3_type'] = intval ($row_mod['author3_type']);
			$arEdit['changed_graphics_yn'] =
				intval ($row_mod['changed_graphics_yn']);
			$arEdit['changed_audio_yn'] = intval ($row_mod['changed_audio_yn']);
			$arEdit['changed_levels_nr'] = intval ($row_mod['changed_levels_nr']);
			$arEdit['mod_executable'] = $row_mod['mod_executable'];
			$arEdit['mod_executable_s'] = $row_mod['mod_executable_s'];
			$arEdit['mod_executable_m'] = $row_mod['mod_executable_m'];
			$arEdit['mod_cheat'] = $row_mod['mod_cheat'];
		} else {
			print ('<p>Mod not found?</p>');
			return;
		}
	} else {
		$arEdit['mod_name'] = '';
		$arEdit['mod_year'] = '';
		$arEdit['mod_popversion'] = 0;
		$arEdit['mod_description'] = '';
		$arEdit['tag1_id'] = 0;
		$arEdit['tag2_id'] = 0;
		$arEdit['tag3_id'] = 0;
		$arEdit['mod_minutes'] = ''; /*** Do NOT use 0. ***/
		$arEdit['author1_type'] = 0;
		$arEdit['author2_id'] = 0;
		$arEdit['author2_type'] = 0;
		$arEdit['author3_id'] = 0;
		$arEdit['author3_type'] = 0;
		$arEdit['changed_graphics_yn'] = ''; /*** Do NOT use 0. ***/
		$arEdit['changed_audio_yn'] = ''; /*** Do NOT use 0. ***/
		$arEdit['changed_levels_nr'] = ''; /*** Do NOT use 0. ***/
		$arEdit['mod_executable'] = '';
		$arEdit['mod_executable_s'] = '';
		$arEdit['mod_executable_m'] = '';
		$arEdit['mod_cheat'] = '';
	}

	if ($iModID == 0)
	{
print ('
<p>
Please only submit the mod if you are its (co-)creator.
<br>
To <i>modify</i> a mod, visit its page and press "edit mod".
<br>
If you have a question, <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=67&t=2887">post here</a> or <a target="_blank" href="/contact_faq.php">email us</a>.
</p>
');
	} else {
print ('
<p>
If you have a question, <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=67&t=2887">post here</a> or <a target="_blank" href="/contact_faq.php">email us</a>.
</p>
');
	}

	print ('<input type="hidden" id="mod_id" value="' . $iModID . '">');

	if ($iModID == 0)
	{
print ('
<h2>Game version and platform</h2>
<p>For SDLPoP or MININIM, select: PoP1 for DOS</p>
<select id="mod_popversion">
<option value="">Select...</option>
<option value="1">PoP1 for DOS</option>
<option value="2">PoP2 for DOS</option>
<option value="4">PoP1 for SNES</option>
<option value="999">Other</option>
</select>
<script>
$("#mod_popversion").change(function(){
	var mod_popversion = $(this).find("option:selected").val();
	if ((mod_popversion == 1) || (mod_popversion == 2) ||
		(mod_popversion == 4))
	{
		$("#post").css("display", "block");
		$("#mail").css("display", "none");
		if ((mod_popversion == 1) || (mod_popversion == 2))
		{
			$(\'[name^="hintd"]\').css("display", "block");
			$(\'[name^="hints"]\').css("display", "none");
		} else {
			$(\'[name^="hintd"]\').css("display", "none");
			$(\'[name^="hints"]\').css("display", "block");
		}
	} else if (mod_popversion == 999) {
		$("#post").css("display", "none");
		$("#mail").css("display", "block");
	} else {
		$("#post").css("display", "none");
		$("#mail").css("display", "none");
	}
});
</script>
');
	} else {
		print ('<input type="hidden" id="mod_popversion" value="' .
			$arEdit['mod_popversion'] . '">');
	}

	if ($iModID == 0)
	{
		print ('<div id="post" style="display:none;">');
	} else {
		print ('<div id="post">');
	}

print ('
<h2>ZIP file</h2>

<input type="file" id="file_zip" accept=".zip">
');

	if ($iModID != 0)
	{
print ('
<span style="display:block; color:#f00;">
To keep the <a target="_blank" href="/custom_levels/software/' . $sModCode . '.zip" style="color:#f00;">current ZIP</a>, simply do not select a file.
</span>
');
	}

print ('
<h2>Data</h2>

<h3>Mod name</h3>
<input type="text" id="mod_name" value="' . Sanitize ($arEdit['mod_name']) . '" maxlength="100">

<h3>Mod description</h3>
<input type="text" id="mod_description" value="' . Sanitize ($arEdit['mod_description']) . '" style="width:100%;" maxlength="200">

<h3>You</h3>
<p>Your role.</p>
<select id="author1_type">
<option value="">Select...</option>
');
for ($iLoopType = 1; $iLoopType <= 6; $iLoopType++)
{
	print ('<option value="' . $iLoopType . '"');
	if ($arEdit['author1_type'] == $iLoopType) { print (' selected'); }
	print ('>' . NumberToAuthorType ($iLoopType) . '</option>');
}
print ('
</select>

<h3>Others</h3>
<p>
Select only if the mod was co-created by others.
<br>
Do not include people who merely gave you hints/advice.
<br>
If the person is not listed, simply do not select anyone.
</p>
<p>Other person #1.</p>
<select id="author2_id">
<option value="">Select...</option>
');
	$query_get_authors = "SELECT
			user_id,
			nick
		FROM `popot_user`
		ORDER BY nick";
	$result_get_authors = Query ($query_get_authors);
	while ($row_get_authors = mysqli_fetch_assoc ($result_get_authors))
	{
		$iUserID = intval ($row_get_authors['user_id']);
		$sNick = $row_get_authors['nick'];
		print ('<option value="' . $iUserID . '"');
		if ($arEdit['author2_id'] == $iUserID) { print (' selected'); }
		print ('>' . Sanitize ($sNick) . '</option>');
	}
print ('
</select>
<p>Their role.</p>
<select id="author2_type">
<option value="">Select...</option>
');
for ($iLoopType = 1; $iLoopType <= 6; $iLoopType++)
{
	print ('<option value="' . $iLoopType . '"');
	if ($arEdit['author2_type'] == $iLoopType) { print (' selected'); }
	print ('>' . NumberToAuthorType ($iLoopType) . '</option>');
}
print ('
</select>
<p>Other person #2.</p>
<select id="author3_id">
<option value="">Select...</option>
');
	$query_get_authors = "SELECT
			user_id,
			nick
		FROM `popot_user`
		ORDER BY nick";
	$result_get_authors = Query ($query_get_authors);
	while ($row_get_authors = mysqli_fetch_assoc ($result_get_authors))
	{
		$iUserID = intval ($row_get_authors['user_id']);
		$sNick = $row_get_authors['nick'];
		print ('<option value="' . $iUserID . '"');
		if ($arEdit['author3_id'] == $iUserID) { print (' selected'); }
		print ('>' . Sanitize ($sNick) . '</option>');
	}
print ('
</select>
<p>Their role.</p>
<select id="author3_type">
<option value="">Select...</option>
');
for ($iLoopType = 1; $iLoopType <= 6; $iLoopType++)
{
	print ('<option value="' . $iLoopType . '"');
	if ($arEdit['author3_type'] == $iLoopType) { print (' selected'); }
	print ('>' . NumberToAuthorType ($iLoopType) . '</option>');
}
print ('
</select>

<br>

<h3>Modified graphics</h3>
<p>Does your mod use modified graphics.</p>
<select id="changed_graphics_yn">
<option value="">Select...</option>
');

	print ('<option value="0"');
	if ($arEdit['changed_graphics_yn'] == 0) { print (' selected'); }
	print ('>No</option>');

	print ('<option value="1"');
	if ($arEdit['changed_graphics_yn'] == 1) { print (' selected'); }
	print ('>Yes</option>');

print ('
</select>

<h3>Modified audio</h3>
<p>Does your mod use modified audio.</p>
<select id="changed_audio_yn">
<option value="">Select...</option>
');

	print ('<option value="0"');
	if ($arEdit['changed_audio_yn'] == 0) { print (' selected'); }
	print ('>No</option>');

	print ('<option value="1"');
	if ($arEdit['changed_audio_yn'] == 1) { print (' selected'); }
	print ('>Yes</option>');

print ('
</select>

<h3>Creation year</h3>
<select id="mod_year">
<option value="">Select...</option>
');
for ($iLoopYear = date ('Y'); $iLoopYear >= 1990; $iLoopYear--)
{
	print ('<option value="' . $iLoopYear . '"');
	if ($arEdit['mod_year'] == $iLoopYear) { print (' selected'); }
	print ('>' . $iLoopYear . '</option>');
}
print ('
</select>

<h3>Cheat code</h3>
');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">The default for v1.0 is: megahit</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">For SNES, simply enter: ?</p>'); }

	print ('<input type="text" id="mod_cheat" value="' . Sanitize ($arEdit['mod_cheat']) . '" maxlength="100">');

print ('
<h3>Minutes</h3>
');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">The default is: 60</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">The default is: 120</p>'); }

print ('
<input type="text" id="mod_minutes" value="' . $arEdit['mod_minutes'] . '">

<h3>Number of modified levels</h3>
<select id="changed_levels_nr">
<option value="">Select...</option>
');
for ($iLoopLev = 0; $iLoopLev <= 30; $iLoopLev++)
{
	print ('<option value="' . $iLoopLev . '"');
	if ($arEdit['changed_levels_nr'] == $iLoopLev) { print ('selected'); }
	print ('>' . $iLoopLev . '</option>');
}
print ('
</select>

<h3>Executable name(s)</h3>
<p>
This is cAsE sEnSiTiVe.
<br>
Leave unused executables empty.
</p>
');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">The .EXE for DOS.</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">Enter here.</p>'); }

	print ('<input type="text" id="mod_executable" value="' . Sanitize ($arEdit['mod_executable']) . '" maxlength="100">');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">The SDLPoP .EXE.</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">For SNES, leave this empty.</p>'); }

	print ('<input type="text" id="mod_executable_s" value="' . Sanitize ($arEdit['mod_executable_s']) . '" maxlength="100">');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">The MININIM .EXE.</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">For SNES, leave this empty.</p>'); }

	print ('<input type="text" id="mod_executable_m" value="' . Sanitize ($arEdit['mod_executable_m']) . '" maxlength="100">');

print ('
<h3>Tags</h3>

<p>Optionally, you may select up to three <a target="_blank" href="/tags.php">tags</a> below, that summarize your mod.</p>
');

	TagsDDL ('tag1_id', 'Select...', $arEdit['tag1_id']);
	TagsDDL ('tag2_id', 'Select...', $arEdit['tag2_id']);
	TagsDDL ('tag3_id', 'Select...', $arEdit['tag3_id']);

print ('
<h2>Screenshot(s)</h2>

<p>Only 1 screenshot is required.</p>
');

	if (($arEdit['mod_popversion'] == 1) ||
		($arEdit['mod_popversion'] == 2) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hintd">You may use Ctrl+F5 in DOSBox.<br>The image(s) will be resized to 320x200 PNG.</p>'); }

	if (($arEdit['mod_popversion'] == 4) ||
		($arEdit['mod_popversion'] == 0))
		{ print ('<p name="hints">You may use F1 in ZSNES.<br>The image(s) will be resized to 256x224 PNG.</p>'); }

	/*** $iSSWidth and $iSSHeight ***/
	switch ($arEdit['mod_popversion'])
	{
		case 1: $iSSWidth = 320; $iSSHeight = 200; break;
		case 2: $iSSWidth = 320; $iSSHeight = 200; break;
		case 4: $iSSWidth = 256; $iSSHeight = 224; break;
		default: $iSSWidth = 0; $iSSHeight = 0; break;
	}

print ('
<p>
Screenshot 1:
<br>
<input type="file" id="file_ss1" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_1.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 2 (optional):
<br>
<input type="file" id="file_ss2" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_2.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 3 (optional):
<br>
<input type="file" id="file_ss3" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_3.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 4 (optional):
<br>
<input type="file" id="file_ss4" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_4.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 5 (optional):
<br>
<input type="file" id="file_ss5" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_5.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 6 (optional):
<br>
<input type="file" id="file_ss6" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_6.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 7 (optional):
<br>
<input type="file" id="file_ss7" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_7.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 8 (optional):
<br>
<input type="file" id="file_ss8" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_8.png', $iSSWidth, $iSSHeight); }

print ('
<br>
Screenshot 9 (optional):
<br>
<input type="file" id="file_ss9" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/custom_levels/screenshots/' .
		$sModCode . '_9.png', $iSSWidth, $iSSHeight); }

print ('
</p>

<h2>Optional Header Image</h2>
<p>If you want - this is not mandatory - you may also provide us with a header image that will be displayed at the top of your mod\'s page instead of the usual carousel slider. The image will be resized to 1280x256 JPEG. The website will automatically scale this image down (make it smaller) depending on the visitor\'s viewport (display) size.</p>
<img src="images/header_img_dim.png" alt="header image dimensions" style="max-width:100%;">
<p>Examples of mods with custom header images are <a target="_blank" href="custom_levels.php?mod=0000108" style="font-style:italic;">Prince of Wateria</a> and <a target="_blank" href="custom_levels.php?mod=0000127" style="font-style:italic;">Micro Palace</a>.</p>
<input type="file" id="file_header" accept="image/png, image/jpeg, image/gif">
');

	if ($iModID != 0) { OldImage ('/images/headers/' .
		$sModCode . '.jpg', 320, 64); }

print ('
<h2>Ready?</h2>
<div id="submit-error" style="color:#f00;"></div>
<input type="button" id="submit" value="' . $sButton . '" style="margin-top:10px; padding:10px 20px;">
<script>
$("#submit").click(function(){
	var form_data = new FormData();
	form_data.append ("mod_id", $("#mod_id").val());
	form_data.append ("mod_popversion", $("#mod_popversion").val());
	form_data.append ("file_zip", $("#file_zip").prop("files")[0]);
	form_data.append ("mod_name", $("#mod_name").val());
	form_data.append ("mod_description", $("#mod_description").val());
	form_data.append ("tag1_id", $("#tag1_id").val());
	form_data.append ("tag2_id", $("#tag2_id").val());
	form_data.append ("tag3_id", $("#tag3_id").val());
	form_data.append ("author1_type", $("#author1_type").val());
	form_data.append ("author2_id", $("#author2_id").val());
	form_data.append ("author2_type", $("#author2_type").val());
	form_data.append ("author3_id", $("#author3_id").val());
	form_data.append ("author3_type", $("#author3_type").val());
	form_data.append ("changed_graphics_yn", $("#changed_graphics_yn").val());
	form_data.append ("changed_audio_yn", $("#changed_audio_yn").val());
	form_data.append ("mod_year", $("#mod_year").val());
	form_data.append ("mod_cheat", $("#mod_cheat").val());
	form_data.append ("mod_minutes", $("#mod_minutes").val());
	form_data.append ("changed_levels_nr", $("#changed_levels_nr").val());
	form_data.append ("mod_executable", $("#mod_executable").val());
	form_data.append ("mod_executable_s", $("#mod_executable_s").val());
	form_data.append ("mod_executable_m", $("#mod_executable_m").val());
	form_data.append ("file_ss1", $("#file_ss1").prop("files")[0]);
	form_data.append ("file_ss2", $("#file_ss2").prop("files")[0]);
	form_data.append ("file_ss3", $("#file_ss3").prop("files")[0]);
	form_data.append ("file_ss4", $("#file_ss4").prop("files")[0]);
	form_data.append ("file_ss5", $("#file_ss5").prop("files")[0]);
	form_data.append ("file_ss6", $("#file_ss6").prop("files")[0]);
	form_data.append ("file_ss7", $("#file_ss7").prop("files")[0]);
	form_data.append ("file_ss8", $("#file_ss8").prop("files")[0]);
	form_data.append ("file_ss9", $("#file_ss9").prop("files")[0]);
	form_data.append ("file_header", $("#file_header").prop("files")[0]);

	$.ajax({
		type: "POST",
		url: "/submit.php",
		data: form_data,
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			var result = data["result"];
			var error = data["error"];
			var code = data["code"];
			if (result == 1)
			{
				window.location.href = "/custom_levels.php?mod=" + code;
			} else {
				$("#submit-error").html(error);
			}
		},
		error: function() {
			$("#submit-error").html("Error calling submit.php.");
		}
	});
});
</script>
</div>

<div id="mail" style="display:none;">
<p>
Other mods, such as for Apple II, are added to the <a href="/custom_levels.php?action=Other_mods">other mods</a> page.
<br>
<a href="/contact_faq.php">Contact us</a> via email to submit your mod.
</p>
</div>
');
}
/*****************************************************************************/
function ShowReplays ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'Replays', 'custom_levels.php', 'Play');

	print ('<p>This website allows its users to share replays.</p>');

print ('
<p>PoP1 for DOS implementations <a target="_blank" href="get_the_games.php?game=SDLPoP">SDLPoP</a> and <a target="_blank" href="get_the_games.php?game=MININIM">MININIM</a> both have a replay functionality.</p>

<div style="float:left; width:50%;">
<div style="border:1px solid #000; padding:10px;">
<span style="display:block; margin-bottom:10px; font-style:italic;"><img src="images/replay_SDLPoP.png" alt="SDLPoP replay"> SDLPoP</span>
To start and stop recording, press Ctrl+Tab in-game.
<br>
To view replays, press Tab on the title screen.
<br>
Replays (.p1r files) are saved in the <span style="font-family:monospace;">replays/</span> directory.
<p style="text-decoration:underline;">Requires SDLPoP 1.17 or newer!</p>
</div>
</div>

<div style="float:left; width:50%;">
<div style="border:1px solid #000; padding:10px; margin-left:10px;">
<span style="display:block; margin-bottom:10px; font-style:italic;"><img src="images/replay_MININIM.png" alt="MININIM replay"> MININIM</span>
To start and stop recording, press Alt+F7 in-game.
<br>
To view replays, and stop replay playback, press F7. You may select multiple replays at once.
<br>
Replays (.mrp files) are saved in the directory you specify.
<p>
To check replays for validity, use:
<br>
<span style="font-family:monospace;">mininim --time-frequency=0 --rendering=NONE &lt;file(s)&gt;</span>
</p>
</div>
</div>

<span style="display:block; clear:both;"></span>
<p>If you have any questions, please visit the <a target="_blank" href="https://forum.princed.org/">Princed forum</a>.</p>
');
}
/*****************************************************************************/
function ShowRandom ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'Random', 'custom_levels.php', 'Play');

	print ('<a href="custom_levels.php?action=Random" rel="nofollow"><img src="images/dice.png" alt="dice"></a>');
	print ('<p>I suggest you play...</p>');

	/*** Total number of mods. ***/
	$query_count = "SELECT
			COUNT(*) AS count
		FROM `popot_mod`";
	$result_count = Query ($query_count);
	$row_count = mysqli_fetch_assoc ($result_count);

	/*** Random row. ***/
	$iRow = rand (1, $row_count['count']) - 1;

	/*** Select row. ***/
	$query_row = "SELECT
			mod_id,
			mod_name,
			mod_popversion,
			changed_levels_nr
		FROM `popot_mod`
		LIMIT " . $iRow . ", 1";
	$result_row = Query ($query_row);
	$row_row = mysqli_fetch_assoc ($result_row);

	/*** Random level. ***/
	$iLevel = rand (1, $row_row['changed_levels_nr']);

	print ('<p>');
	print ('<a target="_blank" href="custom_levels.php?mod=' . ModCodeFromID ($row_row['mod_id']) . '">' . Sanitize ($row_row['mod_name']) . '</a>, level ' . $iLevel);
	switch ($row_row['mod_popversion'])
	{
		case 1:
			$sVer = ' (PoP1 for DOS)'; break;
		case 2:
			$sVer = ' (<span style="color:#00f;">PoP2</span> for DOS)'; break;
		case 4:
			$sVer = ' (PoP1 for <span style="color:#00f;">SNES</span>)'; break;
	}
	print ('<br>' . $sVer);
	print ('<p>Click the dice to reroll.</p>');
}
/*****************************************************************************/
function ShowOtherMods ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', 'Other mods', 'custom_levels.php', 'Play');

print ('
<p>
Below are mods that are <span class="italic">not</span> for DOS or SNES.
<br>
Many <a href="/custom_levels.php">DOS and SNES mods</a> are available.
</p>
<hr class="basic">
<p><a href="/custom_levels/software/O000001.zip"><span class="italic">First One</span></a> (2016), a Game Boy Color mod by Norbert</p>
<p><a href="/custom_levels/software/O000002.zip"><span class="italic">Jaffar24\'s Levels</span></a> (2018), an Apple II mod by Jaffar24</p>
<p><a href="/custom_levels/software/O000003.zip"><span class="italic">PoP Hack</span></a> (2019), a Mega Drive mod by "Let\'s play Gamer"</p>
<p><a href="/custom_levels/software/O000004.zip"><span class="italic">PoP: Special Edition</span></a> (1990), an Apple II mod by The Doppleganger</p>
');
}
/*****************************************************************************/
function ShowModOne ()
/*****************************************************************************/
{
	$iModID = ModID ($_GET['mod']);
	$query_get_mod = "SELECT
			*
		FROM `popot_mod`
		WHERE (mod_id='" . $iModID . "')";
	$result_get_mod = Query ($query_get_mod);
	$iMatches = mysqli_num_rows ($result_get_mod);
	if ($iMatches == 1)
	{
		$row_get_mod = mysqli_fetch_assoc ($result_get_mod);
		$sModName = $row_get_mod['mod_name'];
		StartHTML ('Custom Levels', Sanitize ($sModName),
			'custom_levels.php', 'Play');
		ShowMod ($iModID, $row_get_mod);
	} else {
		StartHTML ('Custom Levels', '404 Not Found',
			'custom_levels.php', 'Play');
		print ('<p>Unknown mod "' . Sanitize ($_GET['mod']) . '".</p>');
	}
}
/*****************************************************************************/
function ShowModList ()
/*****************************************************************************/
{
	StartHTML ('Custom Levels', '', '', 'Play');

	$sSort = 'name';
	if (isset ($_GET['sort']))
	{
		$arSort = array ('name', 'id', 'year', 'version', 'minutes', 'levels');
		$sSort = $_GET['sort'];
		if (!in_array ($sSort, $arSort)) { $sSort = 'name'; }
	}
	ModList ($sSort);
}
/*****************************************************************************/

/*** Setting some defaults. ***/
$arSearch = array();
$arSearch['author_id'] = 0;
$arSearch['mod_minutes'] = 0;
$arSearch['mod_popversion'] = 0;
$arSearch['changed_levels_nr'] = 0;
$arSearch['mod_year'] = 0;
$arSearch['tag_id'] = 0;
$iMatches = 0;

if (isset ($_GET['pressed']))
{
	switch ($_GET['pressed'])
	{
		case 'Search': ShowSearchResults(); break;
	}
}

if (isset ($_GET['action']))
{
	switch ($_GET['action'])
	{
		case 'Search': ShowSearch ($arSearch); break;
		case 'VDUNGEON.DAT': ShowVDUNGEON(); break;
		case 'VPALACE.DAT': ShowVPALACE(); break;
		case 'KID.DAT': ShowKID(); break;
		case 'FAT.DAT': ShowFAT(); break;
		case 'SHADOW.DAT': ShowSHADOW(); break;
		case 'VIZIER.DAT': ShowVIZIER(); break;
		case 'SKEL.DAT': ShowSKEL(); break;
		case 'PRINCE.DAT': ShowPRINCE(); break;
		case 'GUARD.DAT': ShowGUARD(); break;
		case 'Submit': ShowSubmitEdit (0); break;
		case 'Edit':
			if (isset ($_GET['mod']))
			{
				$iModID = ModID ($_GET['mod']);
				ShowSubmitEdit ($iModID);
			} else {
				StartHTML ('Custom Levels', '404 Not Found',
					'custom_levels.php', 'Play');
				print ('<p>To edit a mod, press "edit mod" on its page.</p>');
			}
			break;
		case 'Replays': ShowReplays(); break;
		case 'Random': ShowRandom(); break;
		case 'Other_mods': ShowOtherMods(); break;
		default:
			StartHTML ('Custom Levels', '404 Not Found',
				'custom_levels.php', 'Play');
			print ('<p>Unknown action "' . Sanitize ($_GET['action']) . '".</p>');
			break;
	}
} else if (isset ($_GET['mod'])) {
	ShowModOne();
} else {
	ShowModList();
}

EndHTML();
?>
