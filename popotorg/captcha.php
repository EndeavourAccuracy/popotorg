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

$im = imagecreatetruecolor (180, 180);
$bg = imagecolorallocate ($im, 0xFF, 0xFF, 0xFF);
$fg = imagecolorallocate ($im, 0x00, 0x00, 0x00);
imagefill ($im, 0, 0, $bg);
/*** imagestring ($im, 5, 5, 5, VerifyShow(), $fg); ***/
$font = 'ttf/Vermi_di_Rouge.ttf';
imagettftext ($im, 24, 45, 36, 165, $fg, $font, VerifyShow());
header ('Cache-Control: no-cache, must-revalidate');
header ('Content-type: image/png');
imagepng ($im);
imagedestroy ($im);
?>
