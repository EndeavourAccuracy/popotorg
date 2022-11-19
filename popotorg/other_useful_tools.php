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
function CusPop_and_CusAsm ()
/*****************************************************************************/
{
print ('
<h2>CusPop</h2>
<p>
CusPop allows you to generate a custom PRINCE.EXE file.
<br>
Author: Enrique Calot, later David
</p>
<p>There is a <a href="other_useful_tools.php?tool=CusPop">web-based version</a> available.</p>
<p>
Version 2.2: <a href="other_useful_tools/software/CusPop-2.2.zip">CusPop-2.2.zip</a> (444KB; 2014-11-20)
<br>
Make sure to use the latest <a href="other_useful_tools/software/princehack_004/princehack.xml">princehack.xml</a>.
<br>
To just download its EXEs, use: <a href="other_useful_tools/software/CusPop_exes.zip">CusPop_exes.zip</a> (413KB)
</p>
<hr class="basic">
<p>
Some old versions:
<br>
- Version 2.1: <a href="other_useful_tools/software/CusPop-2.1.zip">CusPop-2.1.zip</a> (441KB; 2013-07-07)
<br>
- Version 2.0: <a href="other_useful_tools/software/cuspop2.0.src.tar.gz">cuspop2.0.src.tar.gz</a> (463KB; 2009-02-18)
<br>
(Version 2.0 is a WordPress plugin. It uses add_action, among other things.)
</p>
<h2>CusAsm</h2>
<p>
CusAsm is a lightweight PRINCE.EXE assembler.
<br>
Author: Enrique Calot, later Norbert, David
</p>
<p>There is a <a target="_blank" href="https://www.princed.org/cusasm/">web-based version</a> available.</p>
<p>Version 2.2.1: <a href="other_useful_tools/software/CusAsm-2.2.1.zip">CusAsm-2.2.1.zip</a> (442KB; 2015-12-31)</p>
<p>Basic tutorial: <a href="documentation/documents/CusAsm_Tutorial.pdf">CusAsm_Tutorial.pdf</a> / <a href="documentation/documents/CusAsm_Tutorial.odt">CusAsm_Tutorial.odt</a></p>
<hr class="basic">
<p>
An old version:
<br>
- Version 2.2: <a href="other_useful_tools/software/CusAsm-2.2.zip">CusAsm-2.2.zip</a> (442KB; 2015-12-30)
</p>
');
}
/*****************************************************************************/
function CusPop ()
/*****************************************************************************/
{
	include_once (dirname (__FILE__) . '/cuspop.php');
}
/*****************************************************************************/
function PrinHackEd ()
/*****************************************************************************/
{
print ('
<p>
This tool allows you to customize PRINCE.EXE.
<br>
Author: Micheal Muniko (mickey96, musa)
<br>
Download for DOS, version 2.1: <a href="other_useful_tools/software/PrinHackEd21.zip">PrinHackEd21.zip</a> (29KB; 2015-05-10)
<br>
(Version 2.1 was released on May 10th, 2015.)
<br>
When using the tool, press "w" to save changes.
</p>
<hr class="basic">
<p>
An old version:
<br>
- Version 1.1: <a href="other_useful_tools/software/PrinHackEd11.zip">PrinHackEd11.zip</a> (15KB; 2009-06-19)
</p>
');
}
/*****************************************************************************/
function pack_unpack ()
/*****************************************************************************/
{
print ('
<p>
It is possible to decompress (unpack) and compress (pack) the PRINCE.EXE file.
<br>
Included are ExePack v4.06 (by Microsoft) and UPackExe v1.00 (by Fabrice Bellard).
<br>
Download: <a href="other_useful_tools/software/pack_unpack.zip">pack_unpack.zip</a> (17KB)
</p>
<p>
Couple more unpackers: <a href="other_useful_tools/software/more_unpack.zip">more_unpack.zip</a> (118KB)
<br>
In the ZIP are DISLITE 1.01, TRON 1.30, UNP 4.12ß and X-TRACT v1.51.
</p>
');
}
/*****************************************************************************/
function diffpop ()
/*****************************************************************************/
{
print ('
<p>
diffpop shows non-default settings of PRINCE.EXE files.
<br>
Its official website can be found <a target="_blank" href="https://www.norbertdejonge.nl/diffpop/">here</a>.
</p>
<p>
Download for Windows: <a href="other_useful_tools/software/diffpop09.zip">diffpop09.zip</a> (45KB)
<br>
Download for GNU/Linux: <a href="other_useful_tools/software/diffpop-0.9.tar.gz">diffpop-0.9.tar.gz</a> (44KB)
<br>
Version 0.9 was released by Norbert de Jonge on 27 March 2011.
</p>
');
}
/*****************************************************************************/
function PR ()
/*****************************************************************************/
{
print ('
<p>
PR is also known as the <a target="_blank" href="https://www.princed.org/">Princed</a> Resource editor.
<br>
It can export and import resources (.bmp, .pal, .wav, .mid) from and to .DAT files.
</p>
<p>
Download latest (binaries <span class="italic">and</span> source code):
<br>
Version 1.3.1: <a href="other_useful_tools/software/PR-1.3.1.zip">PR-1.3.1.zip</a> (447K)
</p>
<p>You can use a script to make things easier: <a href="other_useful_tools/software/PR.bat">Windows batch file</a> or <a href="other_useful_tools/software/PR.sh">Linux shell script</a></p>
<p>
Documentation can be found inside the package\'s doc/ directory.
<br>
See also the page about <a href="documentation.php?doc=ChangingPoP1Images">changing PoP1 images</a>.
<br>
If you want to export/import PoP2 images, use the -spop2.xml command line switch.
</p>
<hr class="basic">
<p>
Some old versions:
<br>
- 1.3.1 pre-release 2: [Windows binary <span class="italic">and</span> source code] <a href="other_useful_tools/software/PR-1.3.1-prerelease2.zip">PR-1.3.1-prerelease2.zip</a> (360K)
<br>
- 1.3: [Windows binary <span class="italic">and</span> source code] <a href="other_useful_tools/software/PR-1.3.zip">PR-1.3.zip</a> (429K)
<br>
- 1.2: [Windows binary] <a href="other_useful_tools/software/pr1.2.win.bin.zip">pr1.2.win.bin.zip</a> (106K) [source code] <a href="other_useful_tools/software/pr1.2.src.tar.bz2">pr1.2.src.tar.bz2</a> (152K)
<br>
- 1.1: [Windows binary] <a href="other_useful_tools/software/pr1.1.win.bin.zip">pr1.1.win.bin.zip</a> (57K) [source code] <a href="other_useful_tools/software/pr1.1.src.tar.bz2">pr1.1.src.tar.bz2</a> (134K)
</p>
');
}
/*****************************************************************************/
function gpl2jascpal ()
/*****************************************************************************/
{
print ('
<p>
This utility converts GIMP gpl palettes to JASC pal palettes.
<br>
Its official website can be found <a target="_blank" href="https://www.norbertdejonge.nl/gpl2jascpal/">here</a>.
</p>
<p>
Download for Windows: <a href="other_useful_tools/software/gpl2jascpal-0.2-win32.zip">gpl2jascpal-0.2-win32.zip</a> (55KB)
<br>
Download for GNU/Linux: <a href="other_useful_tools/software/gpl2jascpal-0.2.tar.gz">gpl2jascpal-0.2.tar.gz</a> (27KB)
<br>
Version 0.2 was released by Norbert de Jonge on 26 December 2017.
</p>
<hr class="basic">
<p>
Old version:
<br>
- 0.1: <a href="other_useful_tools/software/gpl2jascpal-0.1.zip">Windows</a> (27KB), <a href="other_useful_tools/software/gpl2jascpal-0.1.tar.gz">GNU/Linux</a> (21KB)
</p>
');
}
/*****************************************************************************/
function PRM ()
/*****************************************************************************/
{
print ('
<p>
PRM (Princed Resource Manager) is an old wrapper (GUI) for <a href="other_useful_tools.php?tool=PR">PR</a>.
<br>
Its main author is Thraka (Steve - Andy - De George).
</p>
<p><span style="text-decoration:underline;">Note:</span> this wrapper is from 2003; the latest PR was released not long ago.</p>
<p>
Download version 1.2: <a href="other_useful_tools/software/prmv12.zip">prmv12.zip</a> (173KB; from 2003-06-25)
<br>
Download version 1: <a href="other_useful_tools/software/prmv1.zip">prmv1.zip</a> (20KB; from 2003-04-24)
<br>
Download source of version 1: <a href="other_useful_tools/software/prmv1_VB_source.zip">prmv1_VB_source.zip</a> (32KB; from 2003-04-24)
</p>
');
}
/*****************************************************************************/
function Convert ()
/*****************************************************************************/
{
print ('
<p>
This tool converts PoP1 levels to PoP2 levels, and was created by David.
<br>
Download for Windows: <a href="other_useful_tools/software/Pr12Conv.zip">Pr12Conv.zip</a> (286KB)
<br>
Its current forum thread is <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=73&amp;t=1621">here</a>.
<br>
Note: PoP2 levels may have up to 32 rooms, while PoP1 has a 24 room maximum.
</p>
');
}
/*****************************************************************************/
function sav_hof ()
/*****************************************************************************/
{
print ('
<h2>Prince of Persia 1: SAV and HOF editor</h2>
<p>
savof; its official website is <a target="_blank" href="https://www.norbertdejonge.nl/savof/">here</a>.
<br>
Download for Windows: <a href="other_useful_tools/software/savof-0.9-win64.zip">savof-0.9-win64.zip</a> (1.4MB)
<br>
Download for GNU/Linux: <a href="other_useful_tools/software/savof-0.9.tar.gz">savof-0.9.tar.gz</a> (367KB)
</p>
<h2>Prince of Persia 1: SAV editors</h2>
<p>
Download for DOS: <a href="other_useful_tools/software/PoPSGE-1.3.zip">PoPSGE-1.3.zip</a> (6.3KB; by Inferno/CAGE)
<br>
Download for DOS: <a href="other_useful_tools/software/PoPTrain.zip">PoPTrain.zip</a> (6.7KB; by DCE)
<br>
Download for DOS: <a href="other_useful_tools/software/PRINCED-1.0.zip">PRINCED-1.0.zip</a> (23KB; 1993; by Arun Bhalla)
<br>
Download for DOS: <a href="other_useful_tools/software/Prinsav-1.1.zip">Prinsav-1.1.zip</a><span class="endnote">*</span> (6.6KB; 2003; by Enrique P. Calot)
<br>
Download for DOS: <a href="other_useful_tools/software/Save_Editor-1.1.zip">Save_Editor-1.1.zip</a> (4.6KB; 2002; Polish; by Piotr Kochanek)
<br>
Download for DOS: <a href="other_useful_tools/software/savefile_cheater.zip">savefile_cheater.zip</a> (9.3KB; 1990?)
<br>
Download for Windows (.NET): <a href="other_useful_tools/software/PoPSGE.zip">PoPSGE.zip</a> (13KB; 2006?; by Yorick)
<br>
Download for Mac: <a href="other_useful_tools/software/PoPE_10.hfs">PoPE_10.hfs</a> (1.2MB; Prince of Persia Editor 1.0; 29 July 1992; by Roger Plyer)
<br>
Screenshots of PoPE: <a target="_blank" href="other_useful_tools/images/PoPE_10_icon.png">icon</a>, <a target="_blank" href="other_useful_tools/images/PoPE_10_big_0001.png">splash</a>, <a target="_blank" href="other_useful_tools/images/PoPE_10_big_0002.png">main</a>
</p>
<h2>Prince of Persia 1: HOF editor</h2>
<p>Download for DOS: <a href="other_useful_tools/software/Prinhof-1.1.zip">Prinhof-1.1.zip</a><span class="endnote">*</span> (6.8KB; 2003; by Enrique P. Calot)</p>
<h2>Prince of Persia 3: SAV editor</h2>
<p>Download for Windows: <a href="other_useful_tools/software/PoP3_trainer-13.zip">PoP3_trainer-13.zip</a> (12KB; by Vosman)</p>
<hr class="basic">
<p><span class="endnote">*</span> Will give a runtime error if no SAV or HOF file is present.</p>
');
}
/*****************************************************************************/
function drawmap ()
/*****************************************************************************/
{
print ('
<p>Creates simple images from Prince of Persia 1 and 2 level files (PLV).</p>
<p>Source code: <a href="other_useful_tools/software/drawmap-0.4.tar.gz">drawmap-0.4.tar.gz</a> (141KB)</p>
<p>
Download old versions:
<br>
- Binary for Windows: <a href="other_useful_tools/software/drawmap-bin-win32_02Apr2007.zip">drawmap-bin-win32_02Apr2007.zip</a> (1.9M)
<br>
- Binary for Suse: <a href="other_useful_tools/software/drawmap-bin-suse_12Mar2007.tar.gz">drawmap-bin-suse_12Mar2007.tar.gz</a> (15KB)
<br>
- Source code: <a href="other_useful_tools/software/drawmap-src_23Sep2006.tar.gz">drawmap-src_23Sep2006.tar.gz</a> (7.5KB)
</p>
<p>See also its current <a target="_blank" href="https://forum.princed.org/viewtopic.php?t=663">forum thread</a>.</p>
<hr class="basic">
<p>
To compile old versions:
<br>
- sudo apt-get install libmagickwand-dev
<br>
- Remove all "inline" from drawmap.c.
<br>
- gcc drawmap.c `pkg-config --libs MagickWand` `pkg-config --cflags MagickWand` -o drawmap
</p>
');
}
/*****************************************************************************/
function TPC ()
/*****************************************************************************/
{
print ('
<img src="other_useful_tools/images/TPC_10_icon.png" style="float:left; padding-right:10px;" alt="TPC icon">
<p>
Adds a cheat menu with 27 cheat options.
<br>
Download: <a href="other_useful_tools/software/TPC_10.hfs">TPC_10.hfs</a> (1.2MB)
<br>
Version 1.0 was released on 23 June 1994 by Alex Metcalf.
</p>
<p>
The above file is a disk image with uncompressed files, so you don\'t need a (BinHex or StuffIt) expander.
<br>
You will also need <a href="get_the_games.php?game=1_Mac">Prince of Persia 1 for Mac</a>.
</p>
<p>
<a target="_blank" href="other_useful_tools/images/TPC_10_big_0001.png"><img class="image_link" src="other_useful_tools/images/TPC_10_small_0001.png" alt="TPC"></a>
<a target="_blank" href="other_useful_tools/images/TPC_10_big_0002.png"><img class="image_link" src="other_useful_tools/images/TPC_10_small_0002.png" alt="TPC"></a>
</p>
');
}
/*****************************************************************************/
function Total_Packs ()
/*****************************************************************************/
{
print ('
<p>
The Total Packs provide a user-friendly interface for tweaking and playing custom levels.
<br>
Their official forum thread can be found <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=73&amp;t=3085">here</a>.
<br>
Below is an overview of all the Total Packs (PoP1, PoP2, C64).
</p>
<h2>PoP1 Total Pack</h2>
<p>
Download for Windows: <a href="other_useful_tools/software/PoP1_Total_Pack_v3.5.zip">PoP1_Total_Pack_v3.5.zip</a> (15MB)
<br>
Version 3.5 was released by starwindz on 9 April 2017.
</p>
<p style="color:#f00; font-weight:bold;">Important: to fix the "Invalid Enum Value" error, edit ini\mirror_sites.ini and change 3x popot.org\'s http to https.</p>
<p>
<a target="_blank" href="other_useful_tools/images/PoP1_Total_Pack_big_0004.png"><img class="image_link" src="other_useful_tools/images/PoP1_Total_Pack_small_0004.png" alt="PoP1 Total Pack"></a>
<a target="_blank" href="other_useful_tools/images/PoP1_Total_Pack_big_0005.png"><img class="image_link" src="other_useful_tools/images/PoP1_Total_Pack_small_0005.png" alt="PoP1 Total Pack"></a>
<a target="_blank" href="other_useful_tools/images/PoP1_Total_Pack_big_0006.png"><img class="image_link" src="other_useful_tools/images/PoP1_Total_Pack_small_0006.png" alt="PoP1 Total Pack"></a>
</p>
<p>
Some old versions:
<br>
- v3.01 (3 March 2017): <a href="other_useful_tools/software/PoP1_Total_Pack_v3.01.zip">PoP1_Total_Pack_v3.01.zip</a> (14MB)
<br>
- v3.0 (23 September 2013): <a href="other_useful_tools/software/PoP1_Total_Pack_v3.0.zip">PoP1_Total_Pack_v3.0.zip</a> (14MB)
<br>
- v3.0b1 (13 September 2013): <a href="other_useful_tools/software/PoP1_Total_Pack_v3.0b1.zip">PoP1_Total_Pack_v3.0b1.zip</a> (12MB)
<br>
- v2.06 (19 January 2008): <a href="other_useful_tools/software/pop1tp_v206_full.exe">pop1tp_v206_full.exe</a> (20MB)
</p>
<h2>PoP2 Total Pack</h2>
<p>
Download for Windows: <a href="other_useful_tools/software/pop2tp_v011.exe">pop2tp_v011.exe</a> (9.1MB)
<br>
Version 0.11 was released by starwindz on 3 August 2007.
</p>
<p>
<a target="_blank" href="other_useful_tools/images/PoP2_Total_Pack_big_0001.png"><img class="image_link" src="other_useful_tools/images/PoP2_Total_Pack_small_0001.png" alt="PoP2 Total Pack"></a>
<a target="_blank" href="other_useful_tools/images/PoP2_Total_Pack_big_0002.png"><img class="image_link" src="other_useful_tools/images/PoP2_Total_Pack_small_0002.png" alt="PoP2 Total Pack"></a>
</p>
<h2>C64 Total Pack</h2>
<p>
Download for Windows: <a href="other_useful_tools/software/poptp_c64_v1.0.zip">poptp_c64_v1.0.zip</a> (2.8MB)
<br>
Version 1.0 was released by starwindz on 29 December 2011.
</p>
<p><a target="_blank" href="other_useful_tools/images/C64_Total_Pack_big_0001.png"><img class="image_link" src="other_useful_tools/images/C64_Total_Pack_small_0001.png" alt="C64 Total Pack"></a></p>
');
}
/*****************************************************************************/
function poplaun ()
/*****************************************************************************/
{
print ('
<img src="other_useful_tools/images/poplaun_icon.png" style="float:left; padding-right:10px;" alt="poplaun icon">
<p>
A tool to download and launch Prince of Persia mods by parsing popot.org XML files.
<br>
Its official website can be found <a target="_blank" href="https://www.norbertdejonge.nl/poplaun/">here</a>.
<br>
Version 0.4 was released by Norbert de Jonge on 30 December 2020.
</p>
<p>
Download:
<br>
- For Windows: <a href="other_useful_tools/software/poplaun-0.4-win32.zip">poplaun-0.4-win32.zip</a> (14MB)
<br>
- For GNU/Linux: <a href="other_useful_tools/software/poplaun-0.4.tar.gz">poplaun-0.4.tar.gz</a> (117K)
</p>
<a target="_blank" href="other_useful_tools/images/poplaun-0.1.png"><img class="image_link" src="other_useful_tools/images/poplaun-0.1.gif" alt="poplaun"></a>
<hr class="basic">
<p>
Old versions:
<br>
- 0.3: <a href="other_useful_tools/software/poplaun-0.3-win32.zip">Windows</a> (14MB), <a href="other_useful_tools/software/poplaun-0.3.tar.gz">GNU/Linux</a> (117K)
<br>
- 0.2: <a href="other_useful_tools/software/poplaun-0.2-win32.zip">Windows</a> (14MB), <a href="other_useful_tools/software/poplaun-0.2.tar.gz">GNU/Linux</a> (101K)
<br>
- 0.1: <a href="other_useful_tools/software/poplaun-0.1-win32.zip">Windows</a> (14MB), <a href="other_useful_tools/software/poplaun-0.1.tar.gz">GNU/Linux</a> (100K)
</p>
');
}
/*****************************************************************************/
function PoP1_Studio ()
/*****************************************************************************/
{
print ('
<img src="other_useful_tools/images/PoP1_Studio_icon.png" style="float:left; padding-right:10px;" alt="PoP1 Studio icon">
<p>
Contains a database/library of PoP1 game resources.
<br>
Download links can be found <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=73&amp;t=3214">here</a> (70MB).
<br>
Requires the .NET Framework to run.
<br>
Version 1.00 was released in December 2012 by Ahmed Elbahye (hbzlmx).
</p>
<p>
<a target="_blank" href="other_useful_tools/images/PoP1_Studio_big_0001.png"><img class="image_link" src="other_useful_tools/images/PoP1_Studio_small_0001.png" alt="PoP1 Studio"></a>
<a target="_blank" href="other_useful_tools/images/PoP1_Studio_big_0002.png"><img class="image_link" src="other_useful_tools/images/PoP1_Studio_small_0002.png" alt="PoP1 Studio"></a>
<a target="_blank" href="other_useful_tools/images/PoP1_Studio_big_0003.png"><img class="image_link" src="other_useful_tools/images/PoP1_Studio_small_0003.png" alt="PoP1 Studio"></a>
<a target="_blank" href="other_useful_tools/images/PoP1_Studio_big_0004.png"><img class="image_link" src="other_useful_tools/images/PoP1_Studio_small_0004.png" alt="PoP1 Studio"></a>
</p>
');
}
/*****************************************************************************/
function various_old ()
/*****************************************************************************/
{
print ('
<p>
Princed Graphics Extractor (v1 alpha 1) for Windows:
<br>
Download: <a href="other_useful_tools/software/PGE_v1_alpha1.zip">PGE_v1_alpha1.zip</a> (146KB)
</p>
<hr class="basic">
<p>
PoPTools, a PoP launcher and guard hit point editor for Windows:
<br>
Download: <a href="other_useful_tools/software/PoPTools.zip">PoPTools.zip</a> (11KB)
</p>
<hr class="basic">
<p>
Record, a (Pascal) program that captures frames of <a target="_blank" href="https://en.wikipedia.org/wiki/Mode_13h">mode 13h</a> games as BMP files:
<br>
Download: <a href="other_useful_tools/software/Record_v2_beta.zip">Record_v2_beta.zip</a> (42KB)
<br>
This version was released by Piotr Kochanek on 23 December 2003.
<br>
Usage: RECORD.EXE PRINCE.EXE &lt;options&gt;
<br>
In-game, press F11 to start recording and F12 to stop recording. The BMP files will be created after you quit.
</p>
<hr class="basic">
<p>
RunPOP, which starts Prince of Persia at any level (using Ctrl+a) by modifying PRINCE.EXE:
<br>
Download: <a href="other_useful_tools/software/RunPOP.zip">RunPOP.zip</a> (140KB)
<br>
Keys 3 to 0 set health. The screen doesn\'t update until a health-related event occurs.
</p>
');
}
/*****************************************************************************/
function SNES_pass ()
/*****************************************************************************/
{
	include_once (dirname (__FILE__) . '/SNES_pass.php');
print ('
<hr class="basic">
<p>
This tool was created by David. Its current forum thread is <a target="_blank" href="https://forum.princed.org/viewtopic.php?f=122&amp;t=3337">here</a>.
<br>
Download: <a href="other_useful_tools/software/snes_password.zip">snes_password.zip</a> (4KB)
<br>
More information about SNES passwords is available <a href="documentation.php?doc=SNES_pass">here</a>.
</p>
');
}
/*****************************************************************************/
function ShowTools ()
/*****************************************************************************/
{
print ('
<h2>.EXE</h2>
<p>
It is possible to generate a custom PRINCE.EXE with <a href="other_useful_tools.php?tool=CusPop_and_CusAsm">CusPop</a>.
<br>
Another tool to create customizations is <a href="other_useful_tools.php?tool=PrinHackEd">PrinHackEd</a>.
<br>
You may need/want to <a href="other_useful_tools.php?tool=pack_unpack">pack or unpack</a> the file.
<br>
Use <a href="other_useful_tools.php?tool=diffpop">diffpop</a> to find out what changes were made to PRINCE.EXE files.
</p>
<h2>.DAT</h2>
<p>
Use <a href="other_useful_tools.php?tool=PR">PR</a> to export and import resources (.bmp, .pal, .wav, .mid) from and to .DAT files.
<br>
Convert GIMP gpl palettes to JASC pal palettes with <a href="other_useful_tools.php?tool=gpl2jascpal">gpl2jascpal</a>.
<br>
<a href="other_useful_tools.php?tool=PRM">PRM</a> (Princed Resource Manager) is an old wrapper (GUI) for PR.
<br>
There is a PoP1 to PoP2 level <a href="other_useful_tools.php?tool=Convert">converter</a>.
</p>
<h2>.SAV and .HOF</h2>
<p>There are several SAV and HOF file <a href="other_useful_tools.php?tool=sav_hof">editors</a>.</p>
<h2>Miscellaneous</h2>
<p>
The <a href="other_useful_tools.php?tool=drawmap">drawmap</a> utility can create simplified maps from PoP1 and PoP2 level files.
<br>
<a href="other_useful_tools.php?tool=TPC">TPC</a> adds a cheat menu to the Mac version of PoP1.
<br>
The <a href="other_useful_tools.php?tool=Total_Packs">Total Packs</a> and <a href="other_useful_tools.php?tool=poplaun">poplaun</a> provide user-friendly interfaces for tweaking and playing custom levels.
<br>
<a href="other_useful_tools.php?tool=PoP1_Studio">PoP1 Studio</a> contains a database/library of PoP1 game resources.
<br>
See also the various <a href="other_useful_tools.php?tool=various_old">old tools</a>.
<br>
SNES <a href="other_useful_tools.php?tool=SNES_pass">Password Analyser</a>
</p>
');
}
/*****************************************************************************/

if (isset ($_GET['tool']))
{
	$sTool = $_GET['tool'];
	switch ($sTool)
	{
		case 'CusPop_and_CusAsm':
			StartHTML ('Other Useful Tools', 'CusPop and CusAsm',
				'other_useful_tools.php', 'Edit');
			CusPop_and_CusAsm(); break;
		case 'CusPop':
			StartHTML ('Other Useful Tools', 'CusPop',
				'other_useful_tools.php', 'Edit');
			CusPop(); break;
		case 'PrinHackEd':
			StartHTML ('Other Useful Tools', 'PrinHackEd',
				'other_useful_tools.php', 'Edit');
			PrinHackEd(); break;
		case 'pack_unpack':
			StartHTML ('Other Useful Tools', 'pack & unpack',
				'other_useful_tools.php', 'Edit');
			pack_unpack(); break;
		case 'diffpop':
			StartHTML ('Other Useful Tools', 'diffpop',
				'other_useful_tools.php', 'Edit');
			diffpop(); break;
		case 'PR':
			StartHTML ('Other Useful Tools', 'PR',
				'other_useful_tools.php', 'Edit');
			PR(); break;
		case 'gpl2jascpal':
			StartHTML ('Other Useful Tools', 'gpl2jascpal',
				'other_useful_tools.php', 'Edit');
			gpl2jascpal(); break;
		case 'PRM':
			StartHTML ('Other Useful Tools', 'PRM',
				'other_useful_tools.php', 'Edit');
			PRM(); break;
		case 'Convert':
			StartHTML ('Other Useful Tools', 'PoP1-2 Level Converter',
				'other_useful_tools.php', 'Edit');
			Convert(); break;
		case 'sav_hof':
			StartHTML ('Other Useful Tools', 'SAV and HOF editors',
				'other_useful_tools.php', 'Edit');
			sav_hof(); break;
		case 'drawmap':
			StartHTML ('Other Useful Tools', 'drawmap',
				'other_useful_tools.php', 'Edit');
			drawmap(); break;
		case 'TPC':
			StartHTML ('Other Useful Tools', 'TPC (The Persia Cheater)',
				'other_useful_tools.php', 'Edit');
			TPC(); break;
		case 'Total_Packs':
			StartHTML ('Other Useful Tools', 'Total Packs',
				'other_useful_tools.php', 'Edit');
			Total_Packs(); break;
		case 'poplaun':
			StartHTML ('Other Useful Tools', 'poplaun',
				'other_useful_tools.php', 'Edit');
			poplaun(); break;
		case 'PoP1_Studio':
			StartHTML ('Other Useful Tools', 'PoP1 Studio',
				'other_useful_tools.php', 'Edit');
			PoP1_Studio(); break;
		case 'various_old':
			StartHTML ('Other Useful Tools', 'Various Old Tools',
				'other_useful_tools.php', 'Edit');
			various_old(); break;
		case 'SNES_pass':
			StartHTML ('Other Useful Tools', 'SNES Password Analyser',
				'other_useful_tools.php', 'Edit');
			SNES_pass(); break;
		default:
			StartHTML ('Other Useful Tools', '404 Not Found',
				'other_useful_tools.php', 'Edit');
			print ('<p>Unknown tool ("' . Sanitize ($sTool) .
				'").</p>'); break;
	}
} else {
	StartHTML ('Other Useful Tools', '', '', 'Edit');
	ShowTools();
}

EndHTML();
?>
