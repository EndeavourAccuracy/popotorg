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
function ContactFAQ ()
/*****************************************************************************/
{
print ('
<h2>Contact</h2>
<p>
You can contact the webmaster via: <a data-name="info" data-domain="popot" data-tld="org" href="#" class="cryptedmail" onclick="window.location.href = \'mailto:\' + this.dataset.name + \'@\' + this.dataset.domain + \'.\' + this.dataset.tld"></a>
<br>
See also the <a href="/community_forum.php">forum</a>.
</p>

<h2>FAQ</h2>
<p>
Q: The photo of the Persian palace in the header background, where did you get it?
<br>
A: It is the <a target="_blank" href="https://en.wikipedia.org/wiki/Taj_Mahal">Taj Mahal</a>. More information about the image can be found <a target="_blank" href="https://commons.wikimedia.org/wiki/File:Taj_Mahal_reflection_on_Yamuna_river,_Agra.jpg">here</a> (<abbr title="Creative Commons Attribution 2.0 Generic" style="cursor:help;">CC-BY-2.0</abbr>).
</p>
');
}
/*****************************************************************************/

StartHTML ('Contact / FAQ', '', '', 'Misc');

ContactFAQ();

EndHTML();
?>
