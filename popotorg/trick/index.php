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

	$sURL = $_SERVER['REQUEST_URI'];
	$sTrick = substr ($sURL, strrpos ($sURL, '/') + 1);
	$iTrick = intval ($sTrick);
	if (($iTrick >= 1) && ($iTrick <= 40))
	{
		$sDoc = 'Tricks#' . $iTrick;
	} else if (($iTrick >= 41) && ($iTrick <= 80)) {
		$sDoc = 'TricksPage2#' . $iTrick;
	} else if (($iTrick >= 81) && ($iTrick <= 120)) {
		$sDoc = 'TricksPage3#' . $iTrick;
	} else if (($iTrick >= 121) && ($iTrick <= 160)) {
		$sDoc = 'TricksPage4#' . $iTrick;
	} else if (($iTrick >= 161) && ($iTrick <= 169)) {
		$sDoc = 'TricksPage5#' . $iTrick;
	} else {
		$sDoc = 'Tricks';
	}
	header ('Location: ../documentation.php?doc=' . $sDoc);
?>
