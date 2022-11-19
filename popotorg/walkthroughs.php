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
function Submit ()
/*****************************************************************************/
{
print ('
<p>
You can use DOSBox to <a target="_blank" href="https://www.dosbox.com/wiki/Recording_Video">record</a> a video of your skills.
<br>
Please do NOT re-encode your recording (yourself).
<br>
Just upload the AVI somewhere (MediaFire.com, 2shared.com, Uploading.com).
<br>
Then, <a href="contact_faq.php?subject=Submit%20Walkthrough">tell us</a> about the link. Don\'t forget to mention your name and the name and level(s) of the mod.
</p>
');
}
/*****************************************************************************/
function Video0000001_000_001 ()
/*****************************************************************************/
{
print ('
<p>
A playthrough by htamas of all levels of <a href="get_the_games.php?game=1"><span class="italic">Prince of Persia 1</span></a>.
<br>
This video is licensed under the <a target="_blank" href="https://creativecommons.org/licenses/by-sa/2.5/">CC BY-SA 2.5</a> license.
</p>
<div style="width:100%; max-width:640px; height:auto; background-image:url(images/video_error.png); background-size:100% auto;"><video src="walkthroughs/videos/0000001_000_001.ogv" poster="walkthroughs/videos/0000001_000_001.jpg" width="640" height="400" controls preload="metadata" style="width:100%; max-width:640px; height:auto;"></video></div>
');
}
/*****************************************************************************/
function Video0000046_001_001 ()
/*****************************************************************************/
{
print ('
<p>A playthrough by Norbert of level 1 of <a href="custom_levels.php?mod=0000046"><span class="italic">Kid of Persia</span></a>.</p>
<div style="width:100%; max-width:640px; height:auto; background-image:url(images/video_error.png); background-size:100% auto;"><video src="walkthroughs/videos/0000046_001_001.ogv" controls preload="metadata" style="width:100%; max-width:640px; height:auto;"></video></div>
');
}
/*****************************************************************************/
function Walkthroughs ()
/*****************************************************************************/
{
	print ('<p>For the overview, visit <a href="documentation.php#Walkthroughs">documentation.php#Walkthroughs</a>.</p>');
}
/*****************************************************************************/

if (isset ($_GET['show']))
{
	$sWalkthrough = $_GET['show'];
	switch ($sWalkthrough)
	{
		case 'submit':
			StartHTML ('Walkthroughs', 'Submit Walkthrough',
				'walkthroughs.php', 'Learn');
			Submit(); break;
		case '0000001_000_001':
			StartHTML ('Walkthroughs', 'PoP1, All Levels',
				'walkthroughs.php', 'Learn');
			Video0000001_000_001(); break;
		case '0000046_001_001':
			StartHTML ('Walkthroughs', 'Kid of Persia, Level 1',
				'walkthroughs.php', 'Learn');
			Video0000046_001_001(); break;
		default:
			StartHTML ('Walkthroughs', '404 Not Found',
				'walkthroughs.php', 'Learn');
			print ('<p>Unknown walkthrough ("' . Sanitize ($sWalkthrough) .
				'").</p>'); break;
	}
} else {
	StartHTML ('Documentation', 'Walkthroughs',
		'documentation.php#Walkthroughs', 'Learn');
	Walkthroughs();
}

EndHTML();
?>
