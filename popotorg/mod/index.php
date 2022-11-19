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

include_once (dirname (__FILE__) . '/../popot_def.php');

$sURL = $_SERVER['REQUEST_URI'];
$sModCode = substr ($sURL, strrpos ($sURL, '/') + 1);
if (strlen ($sModCode) == 7)
{
	$iModID = ModID ($sModCode); /*** Verify it exists. ***/
	header ('Location: ../custom_levels.php?mod=' . $sModCode);
} else { die(); }
?>
