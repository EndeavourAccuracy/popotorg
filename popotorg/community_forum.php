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
function CommunityForum ()
/*****************************************************************************/
{
print ('
<h2>Princed Forum</h2>
<p>
We use the <a target="_blank" href="https://forum.princed.org/">Princed forum</a>.
<br>
This forum should open in a separate browser tab.
</p>
<h2>Archives</h2>
<p>We\'re also hosting a <a target="_blank" href="popuw_forum_archive/">popuw.com forum archive</a> and <a target="_blank" href="cnu_forum_archive/">cnu.net.ar forum archive</a>.</p>
');
}
/*****************************************************************************/

StartHTML ('Community Forum', '', '', 'Misc');

CommunityForum();

EndHTML();
?>
