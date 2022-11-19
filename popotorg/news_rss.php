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

	header ('content-type: text/xml');
	ini_set ('short_open_tag', 0);

	/*** Do not move this down, or short_open_tag will cause problems. ***/
	print ('<?xml version="1.0" encoding="UTF-8" ?>' . "\n");
?>
<!-- https://www.popot.org/news_rss.php -->
<rss version="2.0" xml:base="https://www.popot.org/" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Recent PoPOT News</title>
		<link>https://www.popot.org/</link>
		<atom:link href="https://www.popot.org/news_rss.php" rel="self" type="application/rss+xml" />
		<language>en-us</language>
		<description>PoPOT provides an overview of level editors and related tools that can be used to customize the games in the original Prince of Persia trilogy, and makes available for download all known modifications (mods).</description>
<?php
$xml = simplexml_load_file ('news.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
$arXML = (array)$xml;
$iNews = 0;
foreach ($arXML['item'] as $key => $value)
{
	$sDate = strval ($value['date']);
	$sDateH = date ('F j, Y', strtotime ($sDate));
	$sText = strval ($value->html);
	$sRSSDate = date ('r', strtotime ($sDate));

	if ($iNews == 0)
	{
		print ("\t\t" . '<pubDate>' . $sRSSDate . '</pubDate>' . "\n");
		print ("\t\t" . '<lastBuildDate>' . $sRSSDate . '</lastBuildDate>' . "\n");
	}

	print ("\t\t" . '<item>' . "\n");
	print ("\t\t\t" . '<title>News for ' . $sDateH . '</title>' . "\n");
	print ("\t\t\t" . '<link>https://www.popot.org/#' . $sDate . '</link>' . "\n");
	print ("\t\t\t" . '<description><![CDATA[' . $sText . ']]></description>' . "\n");
	print ("\t\t\t" . '<pubDate>' . $sRSSDate . '</pubDate>' . "\n");
	print ("\t\t\t" . '<guid>https://www.popot.org/#' . $sDate . '</guid>' . "\n");
	print ("\t\t" . '</item>' . "\n");

	$iNews++;
	if ($iNews == 10) { break; }
}
?>
	</channel>
</rss>
