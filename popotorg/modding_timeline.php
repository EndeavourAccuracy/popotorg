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
function ShowTimeline ()
/*****************************************************************************/
{
print ('
<noscript>
<p><span style="text-decoration:underline; color:#f00; font-weight:bold;">Error:</span> without JavaScript you cannot see and use the timeline!</p>
</noscript>

<div style="width:100%; text-align:center;">

<p>
The timeline contains no entries after September 23, 2013.
<br>
For everything after that date, see the \'highlights documents\' under the timeline.
</p>

<div style="font-size:9px; margin-bottom:7px; color:#000;"><span style="font-weight:bold;">Use:</span> to move the timeline, drag the top (slow) or bottom (faster) bands, or use the arrow keys or scroll wheel. Click any entry for extra information.</div>
<div id="container">
<div id="my-timeline" style="height:300px; width:100%; border:1px solid #aaa"></div>
</div>

<div style="width:100%; margin-top:7px; font-size:7px;">
[ <a href="javascript:centerSimileAjax(1989);">1989</a> |
<a href="javascript:centerSimileAjax(1990);">1990</a> |
<a href="javascript:centerSimileAjax(1991);">1991</a> |
<a href="javascript:centerSimileAjax(1992);">1992</a> |
<a href="javascript:centerSimileAjax(1993);">1993</a> |
<a href="javascript:centerSimileAjax(1994);">1994</a> |
<a href="javascript:centerSimileAjax(1995);">1995</a> |
<a href="javascript:centerSimileAjax(1996);">1996</a> |
<a href="javascript:centerSimileAjax(1997);">1997</a> |
<a href="javascript:centerSimileAjax(1998);">1998</a> |
<a href="javascript:centerSimileAjax(1999);">1999</a> |
<a href="javascript:centerSimileAjax(2000);">2000</a> |
<a href="javascript:centerSimileAjax(2001);">2001</a> |
<a href="javascript:centerSimileAjax(2002);">2002</a> |
<a href="javascript:centerSimileAjax(2003);">2003</a> |
<a href="javascript:centerSimileAjax(2004);">2004</a> |
<a href="javascript:centerSimileAjax(2005);">2005</a> |
<a href="javascript:centerSimileAjax(2006);">2006</a> |
<a href="javascript:centerSimileAjax(2007);">2007</a> |
<a href="javascript:centerSimileAjax(2008);">2008</a> |
<a href="javascript:centerSimileAjax(2009);">2009</a> |
<a href="javascript:centerSimileAjax(2010);">2010</a> |
<a href="javascript:centerSimileAjax(2011);">2011</a> |
<a href="javascript:centerSimileAjax(2012);">2012</a> |
<a href="javascript:centerSimileAjax(2013);">2013</a> ]
</div>

<p>
Highlights documents:
<a href="documentation/documents/PoP_Modding_Community_2012_Highlights.pdf">2012</a>,
<a href="documentation/documents/PoP_Modding_Community_2013_Highlights.pdf">2013</a>,
<a href="documentation/documents/PoP_Modding_Community_2014_Highlights.pdf">2014</a>,
<a href="documentation/documents/PoP_Modding_Community_2015_Highlights.pdf">2015</a>,
<a href="documentation/documents/PoP_Modding_Community_2016_Highlights.pdf">2016</a>,
<a href="documentation/documents/PoP_Modding_Community_2017_Highlights.pdf">2017</a>,
<a href="documentation/documents/PoP_Modding_Community_2018_Highlights.pdf">2018</a>,
<a href="documentation/documents/PoP_Modding_Community_2019+2020_Highlights.pdf">2019+2020</a>
</p>

<div class="controls" id="controls" style="width:100%; overflow-x:auto;"></div>

<div style="width:100%; text-align:left; padding-left:10px; padding-bottom:10px;">
<h2>Alphabetical Legend</h2>
<img src="timeline/timeline_js/images/dull-blue-circle.png" alt="circle"> apoplexy <a href="javascript:centerSimileAjax(\'April 3 2008 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a>
<br>
<img src="timeline/timeline_js/images/dark-blue-circle.png" alt="circle"> documentation (publications)
<br>
<img src="timeline/timeline_js/images/dull-green-circle.png" alt="circle"> FreePrince <a href="javascript:centerSimileAjax(\'July 21 2004 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a>
<br>
<img src="timeline/timeline_js/images/dark-green-circle.png" alt="circle"> POPMAP <a href="javascript:centerSimileAjax(\'January 10 2000 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a>
<br>
<img src="timeline/timeline_js/images/dull-red-circle.png" alt="circle"> PR
<br>
<img src="timeline/timeline_js/images/dark-red-circle.png" alt="circle"> Pr1SnesLevEd <a href="javascript:centerSimileAjax(\'July 20 2009 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a>
<br>
<img src="timeline/timeline_js/images/teal-circle.png" alt="circle"> Princed
<br>
<img src="timeline/timeline_js/images/orange-circle.png" alt="circle"> PRINCE.EXE tools
<br>
<img src="timeline/timeline_js/images/yellow-circle.png" alt="circle"> research (reverse engineering)
<br>
<img src="timeline/timeline_js/images/purple-circle.png" alt="circle"> RoomShaker I <a href="javascript:centerSimileAjax(\'June 4 2002 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a> and II <a href="javascript:centerSimileAjax(\'October 8 2007 00:00:00 GMT-0600\');"><img src="images/timeline_first.png" alt="rewind"></a>
<br>
<img src="timeline/timeline_js/images/gray-circle.png" alt="circle"> SAV and HOF editors
<br>
<img src="timeline/timeline_js/images/black-circle.png" alt="circle"> various
</div>

</div>
');
}
/*****************************************************************************/

StartHTML ('Modding Timeline', '', '', 'Misc');

ShowTimeline();

EndHTML();
?>
