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

$GLOBALS['live'] = FALSE;

if ($GLOBALS['live'] === FALSE)
{
	$GLOBALS['base'] = 'http://www.popot-debug.org/';
	$GLOBALS['db_host'] = '127.0.0.1';
	$GLOBALS['db_user'] = 'popotorg';
	$GLOBALS['db_pass'] = 'changethis';
	$GLOBALS['db_dtbs'] = 'popotorg';
} else {
	$GLOBALS['base'] = 'https://www.popot.org/';
	$GLOBALS['db_host'] = '127.0.0.1';
	$GLOBALS['db_user'] = 'popotorg';
	$GLOBALS['db_pass'] = 'changethis';
	$GLOBALS['db_dtbs'] = 'popotorg';
}

$GLOBALS['link'] = FALSE;
$GLOBALS['top_text'] = '';
$GLOBALS['top_type'] = '';
$GLOBALS['html_started'] = 0;
$GLOBALS['admins'] = array ('changethis');
$GLOBALS['mail_host'] = 'changethis';
$GLOBALS['mail_from'] = 'info@popot.org';
$GLOBALS['mail_pass'] = 'changethis';
$GLOBALS['max_recipients'] = 30;
$GLOBALS['banned_ips'] = array();
$GLOBALS['queue_pass'] = 'changethis';
$GLOBALS['password_min_length'] = 8;
?>
