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

if (isset ($_GET['years']))
{
	switch ($_GET['years'])
	{
		case '2011-2020':
			$sTitle = 'News of 2011-2020';
			$sXML = 'news_2011-2020.xml';
			break;
		default:
			$sTitle = '404 Not Found';
			$sXML = FALSE;
			break;
	}
} else {
	$sTitle = 'News';
	$sXML = 'news.xml';
}

StartHTML ($sTitle, '', '', 'News');

if ($sTitle == 'News')
{
	print ('<p class="lead">Are you new to Prince of Persia modding? Then check out <a href="documentation.php?doc=Video">this video</a> to learn more!</p>');

	$query_new = "SELECT
			mod_id,
			mod_name,
			mod_popversion,
			date_added
		FROM `popot_mod`
		ORDER BY date_added DESC LIMIT 5";
	$result_new = Query ($query_new);
	if (mysqli_num_rows ($result_new) != 0)
	{
		print ('<p class="italic">Most recently added mods</p>' . "\n");
		while ($row_new = mysqli_fetch_assoc ($result_new))
		{
			$sModCode = ModCodeFromID ($row_new['mod_id']);
			$sModName = $row_new['mod_name'];
			switch ($row_new['mod_popversion'])
			{
				case 1: $sModVersion = 'PoP1 for DOS'; break;
				case 2: $sModVersion = 'PoP2 for DOS'; break;
				case 3: $sModVersion = 'PoP3D for Win'; break;
				case 4: $sModVersion = 'PoP1 for SNES'; break;
			}
			$sDate = $row_new['date_added'];
			$sDateH = date ('F j, Y', strtotime ($sDate));

			print ($sModVersion . ' mod <a href="/custom_levels.php?mod=' . $sModCode . '">' . Sanitize ($sModName) . '</a> (' . $sDateH . ')<br>' . "\n");
		}
	}
}

if ($sXML !== FALSE)
{
	$xml = simplexml_load_file ($sXML, 'SimpleXMLElement', LIBXML_NOCDATA);
	$arXML = (array)$xml;
	foreach ($arXML['item'] as $key => $value)
	{
		$sDate = strval ($value['date']);
		$sDateH = date ('F j, Y', strtotime ($sDate));
		$sDateHS = date ('F jS, Y', strtotime ($sDate));
		$sText = strval ($value->html);
		print ('<p class="italic anchor" id="' . $sDate . '">');
		if (strtotime ($sDate) <= strtotime ('2012-01-07'))
		{
			print ($sDateHS);
		} else {
			print ($sDateH);
		}
		print ('</p>' . "\n");
		print ('<p>' . $sText . '</p>' . "\n");
	}
} else {
	print ('<p>Invalid year(s).</p>');
}

if ($sTitle == 'News')
{
print ('
<hr class="basic">
<p>For older entries, see <a href="/index.php?years=2011-2020">news of 2011-2020</a>.</p>
');
}

EndHTML();
?>
