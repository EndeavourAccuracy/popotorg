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
function ProcessQueue ()
/*****************************************************************************/
{
	$query_queue = "SELECT
			mailqueue_id,
			mailqueue_to,
			mailqueue_subject,
			mailqueue_message
		FROM `popot_mailqueue`
		WHERE (mailqueue_sent='0')";
	$result_queue = Query ($query_queue);
	if (mysqli_num_rows ($result_queue) != 0)
	{
		while ($row_queue = mysqli_fetch_assoc ($result_queue))
		{
			$iQueueID = intval ($row_queue['mailqueue_id']);
			$arQueueTo = unserialize (base64_decode ($row_queue['mailqueue_to']));
			$sQueueSubject = $row_queue['mailqueue_subject'];
			$sQueueMessage = $row_queue['mailqueue_message'];

			$iCount = count ($arQueueTo);
			$iOffset = 0;
			do {
				$arQueueToP = array_slice ($arQueueTo, $iOffset,
					$GLOBALS['max_recipients']);
				SendEmail ($arQueueToP, $sQueueSubject, $sQueueMessage);
				sleep (5);
				$iOffset+=$GLOBALS['max_recipients'];
			} while ($iOffset < $iCount);

			$query_done = "UPDATE `popot_mailqueue` SET
					mailqueue_sent='1'
				WHERE (mailqueue_id='" . $iQueueID . "')";
			$result_done = Query ($query_done);

			print ('Processed ID #' . $iQueueID . '.' . "\n");
		}
	} else {
		print ('Queue is empty.' . "\n");
	}
}
/*****************************************************************************/

if ((!isset ($_GET['pass'])) || ($_GET['pass'] != $GLOBALS['queue_pass']))
	{ print ('Incorrect password!'); exit(); }

$rLock = fopen (dirname (__FILE__) . '/lock_queue', 'w');
if ($rLock === FALSE)
	{ print ('Could not create lock file!' . "\n"); exit(); }
if (flock ($rLock, LOCK_EX|LOCK_NB))
{
	ProcessQueue();
}
?>
