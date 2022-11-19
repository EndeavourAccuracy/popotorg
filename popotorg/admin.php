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

/*** Maybe, one day, I will make this file better looking. ***/

	if (isset ($_SESSION['nick']))
	{
		if (in_array ($_SESSION['nick'], $GLOBALS['admins']) === FALSE)
			{ die ('#1'); }
	} else {
		die ('#2');
	}

	global $sChanging;
	global $arEdit;

	/*** Setting some defaults. ***/
	$sChanging = 'nothing';
	$xEditNr = 0;
	$arEdit['author1_id'] = 0;
	$arEdit['author1_type'] = 0;
	$arEdit['author2_id'] = 0;
	$arEdit['author2_type'] = 0;
	$arEdit['author3_id'] = 0;
	$arEdit['author3_type'] = 0;

	/*** Edit mod. ***/
	if (isset ($_GET['mod_edit']))
	{
		$xEditNr = $_GET['mod_edit'];

		$query_get_mod = "SELECT
				*
			FROM `popot_mod`
			WHERE (mod_id='" . mysqli_real_escape_string
				($GLOBALS['link'], $xEditNr) . "')";
		$result_get_mod = Query ($query_get_mod);
		$iMatches = mysqli_num_rows ($result_get_mod);
		if ($iMatches == 1)
		{
			$sChanging = 'mod';
			$row_get_mod = mysqli_fetch_assoc ($result_get_mod);
			$arEdit = $row_get_mod;
			/*** We don't need $arEdit['date_updated']. ***/
			/*** Nor do we need $arEdit['date_updated_zip']. ***/
			$GLOBALS['top_text'] = 'Modifying mod "' .
				Sanitize ($arEdit['mod_name']) . '".';
			$GLOBALS['top_type'] = 'normal';
		} else {
			$xEditNr = 0;
			$GLOBALS['top_text'] = 'Unknown mod!';
			$GLOBALS['top_type'] = 'error';
		}
	}

	/*** Edit author. ***/
	if (isset ($_GET['author_edit']))
	{
		$xEditNr = intval ($_GET['author_edit']);
		$query_get_author = "SELECT
				*
			FROM `popot_user`
			WHERE (user_id='" . mysqli_real_escape_string
				($GLOBALS['link'], $xEditNr) . "')";
		$result_get_author = Query ($query_get_author);
		$iMatches = mysqli_num_rows ($result_get_author);
		if ($iMatches == 1)
		{
			$sChanging = 'author';
			$row_get_author = mysqli_fetch_assoc ($result_get_author);
			$arEdit['author_id'] = $row_get_author['user_id'];
			$arEdit['author_name'] = $row_get_author['nick'];
			$GLOBALS['top_text'] = 'Modifying author "' .
				Sanitize ($arEdit['author_name']) . '".';
			$GLOBALS['top_type'] = 'normal';
		} else {
			$xEditNr = 0;
			$GLOBALS['top_text'] = 'Unknown author!';
			$GLOBALS['top_type'] = 'error';
		}
	}
?>
<?php
/*****************************************************************************/
function AuthorNameList ($sIdName, $iEdit)
/*****************************************************************************/
{
	print ('<select id="' . $sIdName . '" name="' . $sIdName . '">');
	print ('<option selected>Select...</option>');
	$query_authors = "SELECT
			*
		FROM `popot_user`
		ORDER BY nick";
	$result_authors = Query ($query_authors);
	while ($row_authors = mysqli_fetch_assoc ($result_authors))
	{
		$iAuthorId = $row_authors['user_id'];
		print ('<option value="' . $iAuthorId . '"');
		if ($iEdit == $iAuthorId) { print (' selected'); }
		print ('>' . Sanitize ($row_authors['nick']) . '</option>');
	}
	print ('</select>');
}
/*****************************************************************************/
function AuthorTypeList ($sIdName, $iEdit)
/*****************************************************************************/
{
	print ('<select id="' . $sIdName . '" name="' . $sIdName . '">');
	print ('<option selected>Select...</option>');
	for ($iType = 1; $iType <= 6; $iType++)
	{
		print ('<option value="' . $iType . '"');
		if ($iEdit == $iType) { print (' selected'); }
		print ('>' . NumberToAuthorType ($iType) . '</option>');
	}
	print ('</select>');
}
/*****************************************************************************/
function ActionMod ()
/*****************************************************************************/
{
	if ($_POST['update_id'] == '0')
	{
		$iAction = 1; /*** Adding. ***/
	} else {
		$iAction = 2; /*** Updating. ***/
	}
	$mod_name = $_POST['mod_name'];
	$mod_year = intval ($_POST['mod_year']);
	$mod_popversion = intval ($_POST['mod_popversion']);
	$mod_description = $_POST['mod_description'];
	$mod_minutes = intval ($_POST['mod_minutes']);
	$author1_id = intval ($_POST['author1_id']);
	$author1_type = intval ($_POST['author1_type']);
	if (isset ($_POST['author2_id']))
	{
		$author2_id = intval ($_POST['author2_id']);
		$author2_type = intval ($_POST['author2_type']);
	} else {
		$author2_id = 0;
		$author2_type = 0;
	}
	if (isset ($_POST['author3_id']))
	{
		$author3_id = intval ($_POST['author3_id']);
		$author3_type = intval ($_POST['author3_type']);
	} else {
		$author3_id = 0;
		$author3_type = 0;
	}
	if (isset ($_POST['changed_graphics_yn']))
		{ $changed_graphics_yn = 1; } else { $changed_graphics_yn = 0; }
	if (isset ($_POST['changed_audio_yn']))
		{ $changed_audio_yn = 1; } else { $changed_audio_yn = 0; }
	$changed_levels_nr = intval ($_POST['changed_levels_nr']);
	$mod_executable = $_POST['mod_executable'];
	$mod_executable_s = $_POST['mod_executable_s'];
	$mod_executable_m = $_POST['mod_executable_m'];
	$mod_cheat = $_POST['mod_cheat'];
	$mod_nrss = intval ($_POST['mod_nrss']);
	$date_added = $_POST['date_added'];
	if (isset ($_POST['changed_zip']))
		{ $changed_zip = 1; } else { $changed_zip = 0; }

	/*** Check for incorrect values. ***/
	if (($mod_name == '') ||
		((CheckExists ('popot_mod', 'mod_name', $mod_name) === TRUE) &&
			($iAction == 1)) ||
		($mod_popversion == 0))
	{
		$GLOBALS['top_text'] = 'Incorrect value(s).';
		$GLOBALS['top_type'] = 'error';
		return;
	}

	/*** Add mod. ***/
	if ($_POST['pressed'] == 'Add Mod')
	{
		$iModNr = UnusedModNr ($mod_popversion);

		$date_updated = $date_added;
		$date_updated_zip = $date_added;
		$query_add = "INSERT INTO `popot_mod` SET
			mod_nr='" . $iModNr . "',
			mod_name='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_name) . "',
			mod_year='" . $mod_year . "',
			mod_popversion='" . $mod_popversion . "',
			mod_description='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_description) . "',
			mod_minutes='" . $mod_minutes . "',
			author1_id='" . $author1_id . "',
			author1_type='" . $author1_type . "',
			author2_id='" . $author2_id . "',
			author2_type='" . $author2_type . "',
			author3_id='" . $author3_id . "',
			author3_type='" . $author3_type . "',
			changed_graphics_yn='" . $changed_graphics_yn . "',
			changed_audio_yn='" . $changed_audio_yn . "',
			changed_levels_nr='" . $changed_levels_nr . "',
			mod_executable='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable) . "',
			mod_executable_s='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable_s) . "',
			mod_executable_m='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable_m) . "',
			mod_cheat='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_cheat) . "',
			mod_nrss='" . $mod_nrss . "',
			date_added='" . mysqli_real_escape_string
				($GLOBALS['link'], $date_added) . "',
			date_updated='" . mysqli_real_escape_string
				($GLOBALS['link'], $date_updated) . "',
			date_updated_zip='" . mysqli_real_escape_string
				($GLOBALS['link'], $date_updated_zip) . "'";
		Query ($query_add);
		$iModID = intval (mysqli_insert_id ($GLOBALS['link']));
		$GLOBALS['top_text'] = 'Added the mod.';
		$GLOBALS['top_type'] = 'success';
		CreateXML (0); /*** 0, because we already set date_updated. ***/
		NotifyNew ($iModID);
	}

	/*** Update mod. ***/
	if ($_POST['pressed'] == 'Update Mod')
	{
		$date_updated = date ('Y-m-d H:i:s');
		/*** Do not add mod_id or mod_nr here. ***/
		$query_update = "UPDATE `popot_mod` SET
			mod_name='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_name) . "',
			mod_year='" . $mod_year . "',
			mod_popversion='" . $mod_popversion . "',
			mod_description='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_description) . "',
			mod_minutes='" . $mod_minutes . "',
			author1_id='" . $author1_id . "',
			author1_type='" . $author1_type . "',
			author2_id='" . $author2_id . "',
			author2_type='" . $author2_type . "',
			author3_id='" . $author3_id . "',
			author3_type='" . $author3_type . "',
			changed_graphics_yn='" . $changed_graphics_yn . "',
			changed_audio_yn='" . $changed_audio_yn . "',
			changed_levels_nr='" . $changed_levels_nr . "',
			mod_executable='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable) . "',
			mod_executable_s='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable_s) . "',
			mod_executable_m='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_executable_m) . "',
			mod_cheat='" . mysqli_real_escape_string
				($GLOBALS['link'], $mod_cheat) . "',
			mod_nrss='" . $mod_nrss . "',
			date_added='" . mysqli_real_escape_string
				($GLOBALS['link'], $date_added) . "',
			date_updated='" . $date_updated . "'";
		if ($changed_zip == 1)
		{
			$query_update .= ", date_updated_zip='" . $date_updated . "'";
		}
		$query_update .= " WHERE (mod_id='" . $_POST['update_id'] . "')";
		Query ($query_update);
		$GLOBALS['top_text'] = 'Modified the mod.';
		$GLOBALS['top_type'] = 'success';
		CreateXML (0); /*** 0, because we already set date_updated. ***/
	}
}
/*****************************************************************************/
function ActionAuthor ()
/*****************************************************************************/
{
	$author_name = $_POST['author_name'];

	if ($_POST['pressed'] == 'Add Author')
	{
		$query_add = "INSERT INTO `popot_user` SET
			nick='" . mysqli_real_escape_string
				($GLOBALS['link'], $author_name) . "',
			password='" . rand (0, getrandmax()) . "',
			gender='0',
			email='" . rand (0, getrandmax()) . "',
			email_p='1',
			country='0',
			website='',
			ip='" . rand (0, getrandmax()) . "',
			date='" . date ('Y-m-d H:i:s') . "'";
		Query ($query_add);
		$GLOBALS['top_text'] = 'Added the author.';
		$GLOBALS['top_type'] = 'success';
	}

	if ($_POST['pressed'] == 'Update Author')
	{
		$query_update = "UPDATE `popot_user` SET
			nick='" . mysqli_real_escape_string
				($GLOBALS['link'], $author_name) . "'
			WHERE (user_id='" . $_POST['update_id'] . "')";
		Query ($query_update);
		$GLOBALS['top_text'] = 'Modified the author.';
		$GLOBALS['top_type'] = 'success';
		CreateXML (0); /*** 0, because date_updated does not change. ***/
	}
}
/*****************************************************************************/
function DropDownMods ($sChanging, $sEditNr)
/*****************************************************************************/
{
	/* sChanging is either "nothing", "mod" or "author".
	 * sEditNr is either 0 or a mod or author number.
	 * OnChange() receives the select itself.
	 */

	print ('<select id="mods" name="mods" onchange="' .
		'OnChange(this.form.mods);" onkeypress="return event.keyCode!=13"' .
		' style="display:block; margin:0 auto; text-align:center;">');
	print ('<option selected>Mods in the database</option>');
	$query_mods = "SELECT
			mod_id,
			mod_name
		FROM `popot_mod`
		ORDER BY mod_name";
	$result_mods = Query ($query_mods);
	while ($row_mods = mysqli_fetch_assoc ($result_mods))
	{
		$iModID = $row_mods['mod_id'];

		print ('<option value="' . $iModID . '"');
		if (($sChanging == 'mod') && ($iModID == $sEditNr))
			{ print (' selected'); }
		print ('>' . Sanitize ($row_mods['mod_name']) . '</option>');
	}
	print ('</select>');
}
/*****************************************************************************/
function DropDownAuthors ($sChanging, $sEditNr)
/*****************************************************************************/
{
	/* sChanging is either "nothing", "mod" or "author".
	 * sEditNr is either 0 or a mod or author number.
	 * OnChange() receives the select itself.
	 */

	print ('<select id="authors" name="authors" onchange="' .
		'OnChange(this.form.authors);" onkeypress="return event.keyCode!=13"' .
		' style="display:block; margin:0 auto; text-align:center;">');
	print ('<option selected>Authors in the database</option>');
	$query_authors = "SELECT
			*
		FROM `popot_user`
		ORDER BY nick";
	$result_authors = Query ($query_authors);
	while ($row_authors = mysqli_fetch_assoc ($result_authors))
	{
		$iAuthorNr = $row_authors['user_id'];
		print ('<option value="' . $iAuthorNr . '"');
		if (($sChanging == 'author') && ($iAuthorNr == $sEditNr))
			{ print (' selected'); }
		print ('>' . Sanitize ($row_authors['nick']) . '</option>');
	}
	print ('</select>');
}
/*****************************************************************************/
function InputText ($sLabel, $sIdName, $iLength, $sNote)
/*****************************************************************************/
{
	global $sChanging;
	global $arEdit;

	print ('<tr>');
	print ('<td>' . $sLabel . '</td>');
	print ('<td colspan="2"><input type="text" id="' . $sIdName . '" name="' .
		$sIdName . '" maxlength="' . $iLength . '"');
	if ($sChanging == 'mod')
	{
		print (' value="' . $arEdit[$sIdName] . '"');
	}
	print ('>');
	if (strcmp ($sNote, "") != 0)
	{
		print ('<br>');
		print ('<span class="small italic">' . $sNote . '</span>');
	}
	print ('</td>');
	print ('</tr>');
}
/*****************************************************************************/
?>
<?php
	if (isset ($_POST['pressed']))
	{
		if (($_POST['pressed'] == 'Add Mod') ||
			($_POST['pressed'] == 'Update Mod'))
		{
			ActionMod ();
		}
		if (($_POST['pressed'] == 'Add Author') ||
			($_POST['pressed'] == 'Update Author'))
		{
			ActionAuthor ();
		}
	}

	StartHTML ('User', 'Admin', 'user.php', 'Account');

print ('
<script>
/************************************************/
function OnChange (dropdown)
/************************************************/
{
	var myname = dropdown.name;
	var myindex = dropdown.selectedIndex;
	var SelValue = dropdown.options[myindex].value;
	var baseURL = \'' . $GLOBALS['base'] . 'admin.php?\' +
		myname.slice(0,-1) + \'_edit=\' + SelValue;
	top.location.href = baseURL;

	return true;
}
/************************************************/
</script>
');

	AdminLinks();
?>

<?php
	print ('<div style="display:block; border:1px solid #bbb; background-color:#eee; padding:20px; padding-bottom:0;">');
	print ('<form name="edit" action="/admin.php" method="post">');
	DropDownMods ($sChanging, $xEditNr);
	print ('</form>');
?>

<hr class="basic">

<form name="input" action="/admin.php" method="post">
<input type="hidden" name="update_id" value="<?php print (Sanitize ($xEditNr)); ?>">
<table style="margin:0 auto;">

<tr>
<td>Mod Name:</td>
<td colspan="2"><input type="text" id="mod_name" name="mod_name" maxlength="100"<?php
	if ($sChanging == 'mod')
		{ print (' value="' . Sanitize ($arEdit['mod_name']) . '"'); }
?>></td>
</tr>

<tr>
<td>Creation Year:</td>
<td colspan="2"><input type="text" id="mod_year" name="mod_year" maxlength="4"<?php
	if ($sChanging == 'mod')
		{ print (' value="' . $arEdit['mod_year'] . '"'); }
?>>
<br>
<span class="small italic">Unknown? Use '0'.</span>
</td>
</tr>

<tr>
<td>PoP Version:</td>
<td colspan="2">
<select id="mod_popversion" name="mod_popversion">
<option selected>Select...</option>
<option value="1"<?php
	if (($sChanging == 'mod') && ($arEdit['mod_popversion'] == 1))
		{ print (' selected'); }
?>>PoP1 for DOS</option>
<option value="2"<?php
	if (($sChanging == 'mod') && ($arEdit['mod_popversion'] == 2))
		{ print (' selected'); }
?>>PoP2 for DOS</option>
<option value="3"<?php
	if (($sChanging == 'mod') && ($arEdit['mod_popversion'] == 3))
		{ print (' selected'); }
?>>PoP3D for Win</option>
<option value="4"<?php
	if (($sChanging == 'mod') && ($arEdit['mod_popversion'] == 4))
		{ print (' selected'); }
?>>PoP1 for SNES</option>
</select>
</td>
</tr>

<tr>
<td>Description:</td>
<td colspan="2"><input type="text" id="mod_description" name="mod_description" maxlength="200"<?php
	if ($sChanging == 'mod')
		{ print (' value="' . Sanitize ($arEdit['mod_description']) . '"'); }
?>>
<br>
<span class="small italic">Max. 200 characters.</span>
</td>
</tr>

<tr>
<td>Minutes:</td>
<td colspan="2"><input type="text" id="mod_minutes" name="mod_minutes" maxlength="4"<?php
	if ($sChanging == 'mod')
		{ print (' value="' . $arEdit['mod_minutes'] . '"'); }
?>>
<br>
<span class="small italic">Unknown? Use '0'.</span>
</td>
</tr>

<tr>
<td>Author #1:</td>
<td><?php AuthorNameList ('author1_id', $arEdit['author1_id']); ?></td>
<td><?php AuthorTypeList ('author1_type', $arEdit['author1_type']); ?></td>
</tr>

<tr>
<td>Author #2:</td>
<td><?php AuthorNameList ('author2_id', $arEdit['author2_id']); ?></td>
<td><?php AuthorTypeList ('author2_type', $arEdit['author2_type']); ?></td>
</tr>

<tr>
<td>Author #3:</td>
<td><?php AuthorNameList ('author3_id', $arEdit['author3_id']); ?></td>
<td><?php AuthorTypeList ('author3_type', $arEdit['author3_type']); ?></td>
</tr>

<tr>
<td>Changed:</td>
<td><input type="checkbox" id="changed_graphics_yn" name="changed_graphics_yn"<?php
	if ($sChanging == 'mod')
		{ if ($arEdit['changed_graphics_yn'] == 1) { print (' checked'); } }
?>> graphics</td>
<td><input type="checkbox" id="changed_audio_yn" name="changed_audio_yn"<?php
	if ($sChanging == 'mod')
		{ if ($arEdit['changed_audio_yn'] == 1) { print (' checked'); } }
?>> audio</td>
</tr>

<tr>
<td># Changed Levels:</td>
<td colspan="2">
<select id="changed_levels_nr" name="changed_levels_nr">
<option selected>Select...</option>
<?php
	for ($iLvl = 0; $iLvl <= 30; $iLvl++)
	{
		print ('<option value="' . $iLvl . '"');
		if (($sChanging == 'mod') && ($arEdit['changed_levels_nr'] == $iLvl))
			{ print (' selected'); }
		print ('>' . $iLvl . '</option>');
	}
?>
</select>
</td>
</tr>

<?php
	InputText ("Exec. DOS/SNES:", "mod_executable", 100,
		"Not applicable? Keep empty.");
	InputText ("Exec. SDLPoP:", "mod_executable_s", 100,
		"Not applicable? Keep empty.");
	InputText ("Exec. MININIM:", "mod_executable_m", 100,
		"Not applicable? Keep empty.");
	InputText ("Cheat Code:", "mod_cheat", 100, "Unknown? Use '?'.");
	InputText ("Number of Screenshots:", "mod_nrss", 1, "");
?>

<tr>
<td>Added On:</td>
<td colspan="2">
<input type="text" id="date_added" name="date_added" maxlength="20" value="<?php
	if ($sChanging == 'mod')
		{ print ($arEdit['date_added']); }
			else { print (date ('Y-m-d H:i:s')); }
?>"></td>
</tr>

<?php
	if ($sChanging == 'mod')
	{
print ('
<tr>
<td>ZIP Updated?</td>
<td colspan="2"><input type="checkbox" id="changed_zip" name="changed_zip"> yes</td>
</tr>
');
	}
?>

<tr>
<td class="dotted" colspan="3">
<p style="text-align:center;">
<?php
	print ('<input name="pressed" type="submit" value="');
	if ($sChanging == 'mod')
		{ print ('Update Mod'); }
			else { print ('Add Mod'); }
	print ('">');
	if ($sChanging == 'mod')
	{
		print ('<input type="button" onclick="location=\'admin.php\'"' .
			' value="Cancel">');
	}
?>
</p>
</td>
</tr>

</table>
</form>
</div>

<?php
	print ('<div style="display:block; border:1px solid #bbb; background-color:#eee; padding:20px; padding-bottom:0; margin:20px 0;">');
	print ('<form name="edit" action="/admin.php" method="post">');
	DropDownAuthors ($sChanging, $xEditNr);
	print ('</form>');
?>

<hr class="basic">

<form name="input" action="/admin.php" method="post">
<input type="hidden" name="update_id" value="<?php print (Sanitize ($xEditNr)); ?>">
<table style="margin:0 auto;">

<tr>
<td>Author Name:</td>
<td><input type="text" id="author_name" name="author_name" maxlength="50"<?php
	if ($sChanging == 'author')
		{ print (' value="' . Sanitize ($arEdit['author_name']) . '"'); }
?>></td>
</tr>

<tr>
<td class="dotted" colspan="2">
<p style="text-align:center;">
<?php
	print ('<input name="pressed" type="submit" value="');
	if ($sChanging == 'author')
		{ print ('Update Author'); }
			else { print ('Add Author'); }
	print ('">');
	if ($sChanging == 'author')
	{
		print ('<input type="button" onclick="location=\'admin.php\'"' .
			' value="Cancel">');
	}
?>
</p>
</td>
</tr>

</table>
</form>
</div>

<?php EndHTML(); ?>
