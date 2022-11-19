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
function Result ($sStatus)
/*****************************************************************************/
{
	switch ($sStatus)
	{
		case 'success':
			http_response_code (200); /*** 200 = OK ***/
			break;
		case 'error':
		default:
			http_response_code (404); /*** 404 = Not Found ***/
			break;
	}
}
/*****************************************************************************/
function FeedbackDB ($arFeedback)
/*****************************************************************************/
{
	/*** Create table. ***/
	$query_table = "CREATE TABLE IF NOT EXISTS `popot_feedback` (
		`feedback_id` INT UNIQUE NOT NULL AUTO_INCREMENT,
		`feedback_name` VARCHAR(255) NOT NULL,
		`feedback_email` VARCHAR(255) NOT NULL,
		`feedback_message` VARCHAR(255) NOT NULL,
		`feedback_website` VARCHAR(255) NOT NULL,
		`feedback_ip` VARCHAR(45) NOT NULL,
		`feedback_date` DATETIME NOT NULL,
		PRIMARY KEY (`feedback_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
	$result_table = Query ($query_table);

	/*** Insert feedback. ***/
	$query_feedback = "INSERT INTO `popot_feedback` SET
		feedback_name='" . mysqli_real_escape_string
			($GLOBALS['link'], $arFeedback['name']) . "',
		feedback_email='" . mysqli_real_escape_string
			($GLOBALS['link'], $arFeedback['email']) . "',
		feedback_message='" . mysqli_real_escape_string
			($GLOBALS['link'], $arFeedback['message']) . "',
		feedback_website='" . $arFeedback['website'] . "',
		feedback_ip='" . $arFeedback['ip'] . "',
		feedback_date='" . $arFeedback['datetime'] . "'";
	$result_feedback = Query ($query_feedback);

	if (mysqli_affected_rows ($GLOBALS['link']) == 1)
	{
		$bResult = TRUE;
	} else {
		$bResult = FALSE;
	}

	return ($bResult);
}
/*****************************************************************************/

if (strtoupper ($_SERVER['REQUEST_METHOD']) === 'POST')
{
	if ((isset ($_POST['name'])) &&
		(isset ($_POST['email'])) &&
		(isset ($_POST['message'])) &&
		($_POST['message'] != ''))
	{
		$arFeedback = array();
		$arFeedback['name'] = $_POST['name'];
		$arFeedback['email'] = $_POST['email'];
		$arFeedback['message'] = $_POST['message'];
		$arFeedback['website'] = 'PoPOT';
		$arFeedback['ip'] = GetIP();
		$arFeedback['datetime'] = date ('Y-m-d H:i:s');

		$bResultDB = FeedbackDB ($arFeedback);

		/*** $arEmail ***/
		$arEmail = array('info@popot.org' => 'PoPOT Webmaster');

		/*** $sSubject. ***/
		$sSubject = '[ ' . $arFeedback['website'] . ' ] feedback';

		/*** $sMessage. ***/
		$sMessage = '';
		if ($arFeedback['name'] != '')
			{ $sMessage .= 'Name: ' . Sanitize ($arFeedback['name']) . '<br>'; }
		if ($arFeedback['email'] != '')
			{ $sMessage .= 'Email: ' . Sanitize ($arFeedback['email']) . '<br>'; }
		$sMessage .= 'IP: ' . $arFeedback['ip'] . '<br>';
		$sMessage .= nl2br (Sanitize ($arFeedback['message']));

		QueueEmail ($arEmail, $sSubject, $sMessage);

		if ($bResultDB != FALSE)
		{
			Result ('success');
		} else {
			Result ('error');
		}
	} else { Result ('error'); }
} else { Result ('error'); }
?>
