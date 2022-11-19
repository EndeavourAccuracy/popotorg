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
function ProcessReplays ()
/*****************************************************************************/
{
	if ((isset ($_POST['mod_id'])) &&
		(isset ($_POST['level'])) &&
		(isset ($_POST['rcomment'])) &&
		(isset ($_SESSION['user_id'])))
	{
		$iModID = intval ($_POST['mod_id']);
		$sLevel = $_POST['level'];
		if (strcmp ($sLevel, 'no') != 0)
		{
			$iLevel = intval ($sLevel);
			if ((($iLevel >= 0) && ($iLevel <= 16)) ||
				(($iLevel >= 20) && ($iLevel <= 36)))
			{
				$sLevelPad = str_pad (Sanitize ($sLevel), 2, '0', STR_PAD_LEFT);
				$sComment = substr ($_POST['rcomment'], 0, 15);
				$iUserID = intval ($_SESSION['user_id']);
				/***/
				$sUserIDPad = str_pad ($iUserID, 4, '0', STR_PAD_LEFT);
				$sDate = date ('Y-m-d H:i:s');
				$sUserNick = $_SESSION['nick'];

				if (count ($_FILES) == 1)
				{
					/*** $sModName ***/
					$query_mod = "SELECT
							mod_name
						FROM `popot_mod`
						WHERE (mod_id='" . $iModID . "')";
					$result_mod = Query ($query_mod);
					$row_mod = mysqli_fetch_assoc ($result_mod);
					$sModName = $row_mod['mod_name'];

					/*** Save file. ***/
					$allowedExts = array ('p1r', 'mrp');
					$temp = explode ('.', $_FILES['file']['name']);
					$extension = end ($temp);
					if (($_FILES['file']['size'] < 200000) &&
						in_array ($extension, $allowedExts))
					{
						if ($_FILES['file']['error'] == 0)
						{
							$fReplay = fopen ($_FILES['file']['tmp_name'], "rb");
							if ($fReplay !== FALSE)
							{
								$sProgramAndVersion = fread ($fReplay, 30);
								fclose ($fReplay);
								if (0 === mb_strpos ($sProgramAndVersion, 'P1R'))
								{
									/*** SDLPoP ***/
									$sExtension = 'p1r';
									$sProgram = 'SDLPoP';
									$sVersion = $sProgramAndVersion[5];
								} else if (0 === strpos ($sProgramAndVersion, 'MININIM REPLAY')) {
									/*** MININIM ***/
									$sExtension = 'mrp';
									$sProgram = 'MININIM';
									$sVersion = $sProgramAndVersion[15];
								} else {
									$sProgram = FALSE;
								}

								if ($sProgram !== FALSE)
								{
									$sModCode = ModCodeFromID ($iModID);

									$sToPathFile = 'replays/m' . $sModCode . '_l' .
										$sLevelPad . '_u' . $sUserIDPad . '.' . $sExtension;
									move_uploaded_file ($_FILES['file']['tmp_name'], $sToPathFile);

									/*** MySQL. ***/
									$query_remove_replay = "DELETE FROM `popot_replay`
										WHERE (mod_id='" . $iModID . "')
										AND (level_nr='" . mysqli_real_escape_string
											($GLOBALS['link'], $sLevel) . "')
										AND (user_id='" . $iUserID . "')
										AND (program='" . $sProgram . "')";
									Query ($query_remove_replay);
									/***/
									$query_add_replay = "INSERT INTO `popot_replay` SET
										mod_id='" . $iModID . "',
										level_nr='" . mysqli_real_escape_string
											($GLOBALS['link'], $sLevel) . "',
										user_id='" . $iUserID . "',
										format_version='',
										comment='" . mysqli_real_escape_string
											($GLOBALS['link'], $sComment) . "',
										program='" . $sProgram . "',
										version='" . $sVersion . "',
										date='" . $sDate . "'";
									Query ($query_add_replay);

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
										$sMessage = 'User "' . $sUserNick . '" added a replay to <a href="https://www.popot.org/custom_levels.php?mod=' . $sModCode . '" style="font-style:italic;">' . Sanitize ($sModName) . '</a>.<br><br>To unsubscribe, read the <a href="https://www.popot.org/email_service.php">Email Service</a> page.';
										QueueEmail ($arEmail, '[ PoPOT ] new replay', $sMessage);
									}

									$arResult['result'] = 1;
									$arResult['error'] = '';
								} else {
									$arResult['result'] = 0;
									$arResult['error'] = 'Invalid file.';
								}
							} else {
								$arResult['result'] = 0;
								$arResult['error'] = 'Cannot open file.';
							}
						} else {
							$arResult['result'] = 0;
							$arResult['error'] = 'File returned error.';
						}
					} else {
						$arResult['result'] = 0;
						$arResult['error'] = 'Too large or invalid ext.';
					}
				} else {
					$arResult['result'] = 0;
					$arResult['error'] = 'No files found.';
				}
			} else {
				$arResult['result'] = 0;
				$arResult['error'] = 'Invalid level.';
			}
		} else {
			$arResult['result'] = 0;
			$arResult['error'] = 'No level selected.';
		}
	} else {
		$arResult['result'] = 0;
		$arResult['error'] = 'Add data, or login.';
	}

	print (json_encode ($arResult));
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	ProcessReplays();
}
?>
