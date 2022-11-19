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
function ProcessMod ()
/*****************************************************************************/
{
	if (isset ($_SESSION['user_id']))
	{
		$iAuthor1ID = intval ($_SESSION['user_id']);
		if ((isset ($_POST['mod_id'])) &&
			(isset ($_POST['mod_popversion'])) &&
			((isset ($_FILES['file_zip'])) || ($_POST['mod_id'] != 0)) &&
			(isset ($_POST['mod_name'])) &&
			(isset ($_POST['mod_description'])) &&
			(isset ($_POST['tag1_id'])) &&
			(isset ($_POST['tag2_id'])) &&
			(isset ($_POST['tag3_id'])) &&
			(isset ($_POST['author1_type'])) &&
			(isset ($_POST['author2_id'])) &&
			(isset ($_POST['author2_type'])) &&
			(isset ($_POST['author3_id'])) &&
			(isset ($_POST['author3_type'])) &&
			(isset ($_POST['changed_graphics_yn'])) &&
			(isset ($_POST['changed_audio_yn'])) &&
			(isset ($_POST['mod_year'])) &&
			(isset ($_POST['mod_cheat'])) &&
			(isset ($_POST['mod_minutes'])) &&
			(isset ($_POST['changed_levels_nr'])) &&
			(isset ($_POST['mod_executable'])) &&
			(isset ($_POST['mod_executable_s'])) &&
			(isset ($_POST['mod_executable_m'])) &&
			((isset ($_FILES['file_ss1'])) || ($_POST['mod_id'] != 0)))
		{
			$sError = '';
			$iModID = intval ($_POST['mod_id']);
			if ($iModID == 0)
			{
				$sAction = 'submit';
			} else {
				$sAction = 'edit';
				$query_owner = "SELECT
						author1_id
					FROM `popot_mod`
					WHERE (mod_id='" . $iModID . "')";
				$result_owner = Query ($query_owner);
				if (mysqli_num_rows ($result_owner) == 0)
				{
					$sError = 'Unknown mod.';
				} else {
					$row_owner = mysqli_fetch_assoc ($result_owner);
					if ($_SESSION['user_id'] != $row_owner['author1_id'])
					{
						$sError = 'You may not edit this mod.';
					}
				}
			}
			$iPoPVersion = intval ($_POST['mod_popversion']);
			if (($iPoPVersion != 1) && ($iPoPVersion != 2) && ($iPoPVersion != 4))
				{ $sError = 'Invalid version/platform.'; }
			if (isset ($_FILES['file_zip']))
			{
				if (($_FILES['file_zip']['type'] != 'application/zip') &&
					($_FILES['file_zip']['type'] != 'application/octet-stream') &&
					($_FILES['file_zip']['type'] != 'application/x-zip-compressed') &&
					($_FILES['file_zip']['type'] != 'multipart/x-zip'))
					{ $sError = 'Not a ZIP file. It is "' .
						Sanitize ($_FILES['file_zip']['type']) . '".'; }
				if ($_FILES['file_zip']['size'] > (1024 * 1024 * 20)) /*** 20MB ***/
					{ $sError = 'ZIP is too large (>20MB).'; }
				if ($_FILES['file_zip']['error'] != 0)
					{ $sError = 'ZIP returned error.'; }
				if (!file_exists ($_FILES['file_zip']['tmp_name']))
					{ $sError = 'ZIP file not found.'; }
			}
			$sModName = $_POST['mod_name'];
			if ($sModName == '')
				{ $sError = 'Mod name is missing.'; }
			if (strlen ($sModName) > 100)
				{ $sError = 'Name is too large (>100).'; }
			$query_exists = "SELECT
					*
				FROM `popot_mod`
				WHERE (mod_name='" . mysqli_real_escape_string
					($GLOBALS['link'], $sModName) . "')
				AND (mod_id<>'" . $iModID . "')";
			$result_exists = Query ($query_exists);
			if (mysqli_num_rows ($result_exists) >= 1)
			{
				$sError = 'A mod with this name already exists.';
			}
			$sModDescr = $_POST['mod_description'];
			if ($sModDescr == '')
				{ $sError = 'Mod description is missing.'; }
			if (strlen ($sModDescr) > 200)
				{ $sError = 'Description is too large (>200).'; }
			$iTag1ID = intval ($_POST['tag1_id']);
			$iTag2ID = intval ($_POST['tag2_id']);
			$iTag3ID = intval ($_POST['tag3_id']);
			/*** $iAuthor1ID ***/
			$iAuthor1Type = intval ($_POST['author1_type']);
			if (($iAuthor1Type < 1) || ($iAuthor1Type > 6))
				{ $sError = 'Your role is invalid.'; }
			$iAuthor2ID = intval ($_POST['author2_id']);
			$iAuthor2Type = intval ($_POST['author2_type']);
			if (($iAuthor2Type < 0) || ($iAuthor2Type > 6))
				{ $sError = 'Person #1 role is invalid.'; }
			$iAuthor3ID = intval ($_POST['author3_id']);
			$iAuthor3Type = intval ($_POST['author3_type']);
			if (($iAuthor3Type < 0) || ($iAuthor3Type > 6))
				{ $sError = 'Person #2 role is invalid.'; }
			$iChangedG = intval ($_POST['changed_graphics_yn']);
			if (($iChangedG != 0) && ($iChangedG != 1))
				{ $sError = 'Invalid modified graphics value.'; }
			$iChangedA = intval ($_POST['changed_audio_yn']);
			if (($iChangedA != 0) && ($iChangedA != 1))
				{ $sError = 'Invalid modified audio value.'; }
			$iModYear = intval ($_POST['mod_year']);
			if (($iModYear < 1990) || ($iModYear > intval (date ('Y'))))
				{ $sError = 'Invalid year.'; }
			$sCheat = $_POST['mod_cheat'];
			if ($sCheat == '')
				{ $sError = 'Cheat code is missing.'; }
			if (strlen ($sCheat) > 100)
				{ $sError = 'Cheat code is too long (>100).'; }
			$iModMin = intval ($_POST['mod_minutes']);
			if (($iModMin < 0) || ($iModMin > 1000)) /*** 0 = 'unknown' ***/
				{ $sError = 'Invalid minutes.'; }
			$iChangedL = intval ($_POST['changed_levels_nr']);
			if (($iChangedL < 0) || ($iChangedL > 30))
				{ $sError = 'Invalid number of modified levels.'; }
			$sModEXE = $_POST['mod_executable'];
			if (strlen ($sModEXE) > 100)
				{ $sError = 'Executable name #1 is too long (>100).'; }
			$sModEXES = $_POST['mod_executable_s'];
			if (strlen ($sModEXES) > 100)
				{ $sError = 'Executable name #2 is too long (>100).'; }
			$sModEXEM = $_POST['mod_executable_m'];
			if (strlen ($sModEXEM) > 100)
				{ $sError = 'Executable name #3 is too long (>100).'; }
			$sDate = date ('Y-m-d H:i:s');
			for ($iLoopSS = 1; $iLoopSS <= 9; $iLoopSS++)
			{
				if (isset ($_FILES['file_ss' . $iLoopSS]))
				{
					$sType = $_FILES['file_ss' . $iLoopSS]['type'];
					if (($sType != 'image/png') &&
						($sType != 'image/jpeg') &&
						($sType != 'image/gif'))
					{
						$sError = 'Screenshot ' . $iLoopSS . ' is not PNG, JPEG or GIF.';
					}
					if ($_FILES['file_ss' . $iLoopSS]['size'] > (1024 * 1024 * 1))
						{ $sError = 'Screenshot ' . $iLoopSS . ' is too large (>1MB).'; }
					if ($_FILES['file_ss' . $iLoopSS]['error'] != 0)
						{ $sError = 'Screenshot ' . $iLoopSS . ' returned error.'; }
					if (!file_exists ($_FILES['file_ss' . $iLoopSS]['tmp_name']))
						{ $sError = 'Screenshot ' . $iLoopSS . ' file not found.'; }
				}
			}
			if (isset ($_FILES['file_header']))
			{
				$sType = $_FILES['file_header']['type'];
				if (($sType != 'image/png') &&
					($sType != 'image/jpeg') &&
					($sType != 'image/gif'))
				{
					$sError = 'Header image is not PNG, JPEG or GIF.';
				}
				if ($_FILES['file_header']['size'] > (1024 * 1024 * 1))
					{ $sError = 'Header image is too large (>1MB).'; }
				if ($_FILES['file_header']['error'] != 0)
					{ $sError = 'Header image returned error.'; }
				if (!file_exists ($_FILES['file_header']['tmp_name']))
					{ $sError = 'Header image file not found.'; }
			}

			if ($sError == '')
			{
				if ($sAction == 'submit')
				{
					$iModNr = UnusedModNr ($iPoPVersion);
					$sModCode = ModCodeFromVN ($iPoPVersion, $iModNr);
				} else {
					/*** $iModNr ***/
					$sModCode = ModCodeFromID ($iModID);
				}

				/*** Create ZIP file ($sZipFile). ***/
				if (isset ($_FILES['file_zip']))
				{
					$zZip = new ZipArchive();
					$zRes = $zZip->open($_FILES['file_zip']['tmp_name']);
					if ($zRes === TRUE)
					{
						$sZipTmp = '/tmp/' . $sModCode . '-tmp-' . time();
						$sZipTmpF = $sZipTmp . '/' . $sModCode;
						if (file_exists ($sZipTmp) === FALSE)
						{
							if (mkdir ($sZipTmp, 0775) === FALSE)
								{ $sError = 'Cannot create "' . $sZipTmp . '".'; }
						}
						if (file_exists ($sZipTmpF) === FALSE)
						{
							if (mkdir ($sZipTmpF, 0775) === FALSE)
								{ $sError = 'Cannot create "' . $sZipTmpF . '".'; }
						}
						if ($sError == '')
						{
							$zZip->extractTo($sZipTmpF);
							$zZip->close();

							/*** $sZipPath and $sZipFile ***/
							if ((count (scandir ($sZipTmpF)) - 2) == 1)
							{
								$arFiles = array_diff (scandir ($sZipTmpF), array ('.', '..'));
								$sFile = reset ($arFiles);
								if (is_dir ($sZipTmpF . '/' . $sFile) === TRUE)
								{
									$bInDir = TRUE;
								} else {
									$bInDir = FALSE;
								}
							} else { $bInDir = FALSE; }
							if ($bInDir === TRUE)
							{
								$sZipPath = $sZipTmpF;
								rename ($sZipTmpF . '/' . $sFile, $sZipTmpF . '/' . $sModCode);
							} else {
								$sZipPath = $sZipTmp;
							}
							$sZipFile = $sZipTmp . '/' . $sModCode . '.zip';

							$zip = new ZipArchive();
							$zip->open ($sZipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE);
							$files = new RecursiveIteratorIterator
								(new RecursiveDirectoryIterator ($sZipPath),
								RecursiveIteratorIterator::SELF_FIRST);
							$files->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
							foreach ($files as $name => $file)
							{
								$filePath = $file->getRealPath();
								$relativePath = substr ($filePath, strlen ($sZipPath) + 1);
								if (is_dir ($file) === FALSE)
								{
									$zip->addFile ($filePath, $relativePath);
								} else {
									$zip->addEmptyDir ($relativePath);
								}
							}
							$zip->close();
						}
					} else {
						$sError = 'Cannot open ZIP file.';
					}
				}
			}

			if ($sError == '')
			{
				/*** Move ZIP file. ***/
				if (isset ($sZipFile))
				{
					rename ($sZipFile,
						dirname (__FILE__) . '/custom_levels/software/' .
							$sModCode . '.zip');
					/***/
					$sDateZIP = $sDate;
				} else {
					/*** No rename. ***/
					/***/
					$query_date = "SELECT
							date_updated_zip
						FROM `popot_mod`
						WHERE (mod_id='" . $iModID . "')";
					$result_date = Query ($query_date);
					$row_date = mysqli_fetch_assoc ($result_date);
					$sDateZIP = $row_date['date_updated_zip'];
				}

				/*** Screenshots. ***/
				switch ($iPoPVersion)
				{
					case 1: $iToW = 320; $iToH = 200; break;
					case 2: $iToW = 320; $iToH = 200; break;
					case 4: $iToW = 256; $iToH = 224; break;
				}
				$iNrSS = 0;
				for ($iLoopSS = 1; $iLoopSS <= 9; $iLoopSS++)
				{
					if (isset ($_FILES['file_ss' . $iLoopSS]))
					{
						$iNrSS++;
						ImageFromFile ($_FILES['file_ss' . $iLoopSS],
							dirname (__FILE__) . '/custom_levels/screenshots/' .
							$sModCode . '_' . $iNrSS . '.png', 'png', $iToW, $iToH);
					} else {
						$sPathFile = dirname (__FILE__) . '/custom_levels/screenshots/' .
							$sModCode . '_' . ($iNrSS + 1) . '.png';
						if (file_exists ($sPathFile)) { $iNrSS++; }
					}
				}

				/*** Header image. ***/
				if (isset ($_FILES['file_header']))
				{
					ImageFromFile ($_FILES['file_header'],
						dirname (__FILE__) . '/images/headers/' . $sModCode .
						'.jpg', 'jpg', 1280, 256);
				}

				if ($sAction == 'submit')
				{
					$query_add = "INSERT INTO `popot_mod` SET
						mod_nr='" . $iModNr . "',
						mod_name='" . mysqli_real_escape_string
							($GLOBALS['link'], $sModName) . "',
						mod_year='" . $iModYear . "',
						mod_popversion='" . $iPoPVersion . "',
						mod_description='" . mysqli_real_escape_string
							($GLOBALS['link'], $sModDescr) . "',
						tag1_id='" . $iTag1ID . "',
						tag2_id='" . $iTag2ID . "',
						tag3_id='" . $iTag3ID . "',
						mod_minutes='" . $iModMin . "',
						author1_id='" . $iAuthor1ID . "',
						author1_type='" . $iAuthor1Type . "',
						author2_id='" . $iAuthor2ID . "',
						author2_type='" . $iAuthor2Type . "',
						author3_id='" . $iAuthor3ID . "',
						author3_type='" . $iAuthor3Type . "',
						changed_graphics_yn='" . $iChangedG . "',
						changed_audio_yn='" . $iChangedA . "',
						changed_levels_nr='" . $iChangedL . "',
						mod_executable='" . mysqli_real_escape_string
							($GLOBALS['link'], $sModEXE) . "',
						mod_executable_s='" . mysqli_real_escape_string
							($GLOBALS['link'], $sModEXES) . "',
						mod_executable_m='" . mysqli_real_escape_string
							($GLOBALS['link'], $sModEXEM) . "',
						mod_cheat='" . mysqli_real_escape_string
							($GLOBALS['link'], $sCheat) . "',
						mod_nrss='" . $iNrSS . "',
						date_added='" . $sDate . "',
						date_updated='" . $sDate . "',
						date_updated_zip='" . $sDate . "'";
					Query ($query_add);
					$iModID = intval (mysqli_insert_id ($GLOBALS['link']));

					CreateXML (0); /*** 0, because we already set date_updated. ***/
					/***/
					NotifyNew ($iModID);
				} else {
					/* Do NOT include mod_id, mod_nr, mod_popversion,
					 * author1_id, date_updated.
					 */
					$query_update = "UPDATE `popot_mod` SET
							mod_name='" . mysqli_real_escape_string
								($GLOBALS['link'], $sModName) . "',
							mod_year='" . $iModYear . "',
							mod_description='" . mysqli_real_escape_string
								($GLOBALS['link'], $sModDescr) . "',
							tag1_id='" . $iTag1ID . "',
							tag2_id='" . $iTag2ID . "',
							tag3_id='" . $iTag3ID . "',
							mod_minutes='" . $iModMin . "',
							author1_type='" . $iAuthor1Type . "',
							author2_id='" . $iAuthor2ID . "',
							author2_type='" . $iAuthor2Type . "',
							author3_id='" . $iAuthor3ID . "',
							author3_type='" . $iAuthor3Type . "',
							changed_graphics_yn='" . $iChangedG . "',
							changed_audio_yn='" . $iChangedA . "',
							changed_levels_nr='" . $iChangedL . "',
							mod_executable='" . mysqli_real_escape_string
								($GLOBALS['link'], $sModEXE) . "',
							mod_executable_s='" . mysqli_real_escape_string
								($GLOBALS['link'], $sModEXES) . "',
							mod_executable_m='" . mysqli_real_escape_string
								($GLOBALS['link'], $sModEXEM) . "',
							mod_cheat='" . mysqli_real_escape_string
								($GLOBALS['link'], $sCheat) . "',
							mod_nrss='" . $iNrSS . "',
							date_updated='" . $sDate . "',
							date_updated_zip='" . $sDateZIP . "'
						WHERE (mod_id='" . $iModID . "')";
					Query ($query_update);

					CreateXML (0); /*** 0, because we already set date_updated. ***/
					/***/
					$arEmail = array('info@popot.org' => 'PoPOT Webmaster');
					$sMessage = 'Mod <a href="https://www.popot.org/custom_levels.php?mod=' . $sModCode . '" style="font-style:italic;">' . Sanitize ($sModName) . '</a> was edited.';
					QueueEmail ($arEmail, '[ PoPOT ] edit', $sMessage);
				}

				$arResult['result'] = 1;
				$arResult['error'] = '';
				$arResult['code'] = $sModCode;
			} else {
				$arResult['result'] = 0;
				$arResult['error'] = $sError;
				$arResult['code'] = '';
			}
		} else {
			$arResult['result'] = 0;
			$arResult['error'] = 'Some data is still missing.';
			$arResult['code'] = '';
		}
	} else {
		$arResult['result'] = 0;
		$arResult['error'] = 'You are not logged in.';
		$arResult['code'] = '';
	}

	print (json_encode ($arResult));
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	ProcessMod();
} else {
	StartHTML ('Custom Levels', '404 Not Found', 'custom_levels.php', 'Play');
	print ('You may <a href="/custom_levels.php?action=Submit">submit</a> mods.');
	EndHTML();
}
?>
