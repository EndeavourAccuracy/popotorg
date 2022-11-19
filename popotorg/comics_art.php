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
function Image ($sNumber, $sExt, $sAuthor, $iSection)
/*****************************************************************************/
{
	if ($sAuthor == '')
		{ $sAuthor = '<span style="font-style:italic;">(unknown)</span>'; }
	switch ($iSection)
	{
		case 1: $sBase = 'comics_art/comical/'; break;
		case 2: $sBase = 'comics_art/regular/'; break;
		case 3: $sBase = 'comics_art/magazine/'; break;
	}

print ('
<span class="comic">
<span class="image"><a target="_blank" href="' . $sBase . $sNumber .
	'.' . $sExt . '"><img src="' . $sBase . $sNumber . '_small.' . $sExt .
	'" class="image_link img-responsive" title="' . $sNumber . '" alt="image ' .
	$sNumber . '"></a></span>
<span class="caption">by: ' . $sAuthor . '</span>
</span>
');
}
/*****************************************************************************/

StartHTML ('Comics / Art', '', '', 'Misc');

print ('
<p style="text-align:center;">Please <a href="contact_faq.php?subject=Comics%20%2F%20Art">tell us</a> if you found or made other images or animations.<br>The images in the sections below are <span class="italic">unordered</span>.</p>

<hr class="basic">
<h2>Comical</h2>
');

Image ('0001', 'jpg', 'Coco', 1);
Image ('0002', 'gif', '', 1);
Image ('0003', 'jpg', 'yaqxsw', 1);
Image ('0004', 'jpg', 'Marc O\'Donoghue', 1);
Image ('0005', 'gif', 'doppelganger', 1);
Image ('0006', 'jpg', 'yaqxsw', 1);
Image ('0007', 'jpg', 'yaqxsw', 1);
Image ('0008', 'jpg', 'theEyZmaster', 1);
Image ('0009', 'png', '', 1);
Image ('0010', 'jpg', 'Marc O\'Donoghue', 1);
Image ('0011', 'png', 'Norbert', 1);
Image ('0012', 'jpg', 'yaqxsw', 1);
Image ('0013', 'jpg', '', 1);
Image ('0014', 'jpg', 'yaqxsw', 1);
Image ('0015', 'png', 'SpideyHog (Elios1986)', 1);
Image ('0016', 'gif', 'Cameron Davis', 1);
Image ('0017', 'jpg', 'Marc O\'Donoghue', 1);
Image ('0018', 'jpg', 'yaqxsw', 1);
Image ('0019', 'jpg', 'yaqxsw', 1);
Image ('0020', 'png', 'yaqxsw', 1);
Image ('0021', 'jpg', 'yaqxsw', 1);
Image ('0022', 'jpg', 'yaqxsw', 1);
Image ('0023', 'png', 'David', 1);
Image ('0024', 'jpg', '', 1);
Image ('0025', 'jpg', 'sumangal16', 1);
Image ('0026', 'jpg', 'xiks', 1);
Image ('0027', 'jpg', 'yaqxsw', 1);
Image ('0028', 'jpg', 'yaqxsw', 1);
Image ('0029', 'jpg', 'yaqxsw', 1);
Image ('0030', 'jpg', 'yaqxsw', 1);
Image ('0031', 'jpg', 'yaqxsw', 1);
Image ('0032', 'jpg', 'yaqxsw', 1);
Image ('0033', 'jpg', 'yaqxsw', 1);
Image ('0034', 'jpg', 'yaqxsw', 1);
Image ('0035', 'jpg', 'yaqxsw', 1);
Image ('0036', 'jpg', 'yaqxsw', 1);
Image ('0037', 'jpg', 'yaqxsw', 1);

print ('
<hr class="basic">
<h2>Regular</h2>
');

Image ('0001', 'gif', 'Rob Kwasowski', 2);
Image ('0002', 'jpg', 'BiT 12/91 (December 1991)', 2);
Image ('0003', 'jpg', 'Coco', 2);
Image ('0004', 'jpg', 'Jeff Menges', 2);
Image ('0005', 'jpg', 'Jeff Menges', 2);
Image ('0006', 'png', 'Matej Jan', 2);
Image ('0007', 'jpg', 'Rob Kwasowski', 2);
Image ('0008', 'png', 'yaqxsw', 2);
Image ('0009', 'png', 'yaqxsw', 2);
Image ('0010', 'jpg', 'theEyZmaster', 2);
Image ('0011', 'png', 'thewoodenboy', 2);
Image ('0012', 'jpg', 'Ray-Ki', 2);
Image ('0013', 'png', 'itsskoobi / Skoobi', 2);
Image ('0014', 'png', 'Maya-Plisetskaya', 2);
Image ('0015', 'jpg', 'RawGraff', 2);

print ('
<hr class="basic">
<h2>Magazine Ads and Reviews</h2>
');

Image ('0001', 'jpg', 'Compute (December 1990)', 3);
Image ('0002', 'jpg', 'CGW (December 1989)', 3);

print ('
<hr class="basic">
<p>See also <a href="get_the_games.php?extra=PoP1_drawings">Mechner\'s drawings</a> and <a href="get_the_games.php?extra=PoP1_rotoscoping">rotoscoping frames</a>.</p>
');

EndHTML();
?>
