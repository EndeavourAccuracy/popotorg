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
function ShowOverview ()
/*****************************************************************************/
{
	print ('<p>Three tags can be added to each mod by their authors, and <a href="/custom_levels.php?action=Search">mod search</a> allows filtering by tag. The available tags are limited to the controlled vocabulary listed alphabetically on this page. Tags must not contain spaces or more than two hyphenated words. You may <a href="/contact_faq.php">contact us</a> to suggest additional tags.</p>');

	$query_list = "SELECT
			tag_id
		FROM `popot_tag`
		ORDER BY tag_name";
	$result_list = Query ($query_list);
	$iNrRows = mysqli_num_rows ($result_list);
	if ($iNrRows > 0)
	{
		$iRow = 0;
		while ($row_list = mysqli_fetch_assoc ($result_list))
		{
			$iTagID = $row_list['tag_id'];

			print ("\n" . TagLink ($iTagID) . ' (' . TagMods ($iTagID) . ')');
			$iRow++;
			if ($iRow != $iNrRows) { print ('<br>'); }
		}
	} else {
		print ('No tags found.');
	}
}
/*****************************************************************************/
function ShowAdd ()
/*****************************************************************************/
{
print ('
<span style="display:block; text-align:center;">
<input type="text" name="tag_add" maxlength="100" placeholder="tag">
<input name="pressed" type="submit" value="Add">
</span>
');
}
/*****************************************************************************/
function ShowRemove ()
/*****************************************************************************/
{
	print ('<span style="display:block; margin-top:10px; text-align:center;">');
	if (TagsDDL ('tag_remove', 'Select...', 0) !== FALSE)
	{
		print ('<input name="pressed" type="submit" value="Remove"' .
			' style="margin-left:5px;">');
	} else {
		print ('No tags to remove.');
	}
	print ('</span>');
}
/*****************************************************************************/
function DoAdd ()
/*****************************************************************************/
{
	$sTag = $_POST['tag_add'];

	if ((strlen ($sTag) >= 1) && (strlen ($sTag) <= 100))
	{
		$query_exists = "SELECT
				tag_id
			FROM `popot_tag`
			WHERE (tag_name='" . mysqli_real_escape_string
				($GLOBALS['link'], $sTag) . "')";
		$result_exists = Query ($query_exists);
		if (mysqli_num_rows ($result_exists) == 0)
		{
			$query_add = "INSERT INTO `popot_tag` SET
				tag_name='" . mysqli_real_escape_string
					($GLOBALS['link'], $sTag) . "'";
			$result_add = Query ($query_add);
			if (mysqli_affected_rows ($GLOBALS['link']) == 1)
			{
				$GLOBALS['top_text'] = 'Added "' . Sanitize ($sTag) . '".';
				$GLOBALS['top_type'] = 'success';
			} else {
				$GLOBALS['top_text'] = 'Could not add "' . Sanitize ($sTag) . '".';
				$GLOBALS['top_type'] = 'error';
			}
		} else {
			$GLOBALS['top_text'] = 'Tag "' . Sanitize ($sTag) . '" already exists.';
			$GLOBALS['top_type'] = 'normal';
		}
	} else {
		$GLOBALS['top_text'] = 'Tag has an invalid size.';
		$GLOBALS['top_type'] = 'error';
	}
}
/*****************************************************************************/
function DoRemove ()
/*****************************************************************************/
{
	$iTagID = intval ($_POST['tag_remove']);

	if ($iTagID != 0)
	{
		$query_hits = "SELECT
				COUNT(*) AS hits
			FROM `popot_mod`
			WHERE (tag1_id='" . $iTagID . "')
			OR (tag2_id='" . $iTagID . "')
			OR (tag3_id='" . $iTagID . "')";
		$result_hits = Query ($query_hits);
		$row_hits = mysqli_fetch_assoc ($result_hits);
		if ($row_hits['hits'] == 0)
		{
			$query_remove = "DELETE FROM `popot_tag`
				WHERE (tag_id='" . $iTagID . "')";
			$result_remove = Query ($query_remove);
			if (mysqli_affected_rows ($GLOBALS['link']) == 1)
			{
				$GLOBALS['top_text'] = 'Removed tag.';
				$GLOBALS['top_type'] = 'success';
			} else {
				$GLOBALS['top_text'] = 'Could not remove tag.';
				$GLOBALS['top_type'] = 'error';
			}
		} else {
			$GLOBALS['top_text'] = 'Tag is in use.';
			$GLOBALS['top_type'] = 'error';
		}
	} else {
		$GLOBALS['top_text'] = 'No tag selected.';
		$GLOBALS['top_type'] = 'normal';
	}
}
/*****************************************************************************/

if ((isset ($_POST['pressed'])) && (IsAdmin() === TRUE))
{
	$sPressed = $_POST['pressed'];
	switch ($sPressed)
	{
		case 'Add': DoAdd(); break;
		case 'Remove': DoRemove(); break;
	}
}

StartHTML ('Custom Levels', 'Tags', 'custom_levels.php', 'Play');

if (IsAdmin() === FALSE)
{
	ShowOverview();
} else {
	AdminLinks();

	print ('<form name="input" action="tags.php" method="POST">');
	ShowAdd();
	ShowRemove();
	print ('</form>');
}

EndHTML();
?>
