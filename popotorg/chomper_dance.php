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

StartHTML ('Chomper Dance', '', '', 'Misc');

print ('
<video src="chomper_dance/videos/start.webm" id="dance" style="width:100%; height:auto;" poster="chomper_dance/images/chomper_dance.png" controls></video>
<span id="next" style="display:none;">chomper_dance/videos/dance.webm</span>
<input id="btnOops" type="submit" value="Wait...">
<span style="float:right; width:calc(100% - 150px); text-align:right;"><a href="chomper_dance/various/Chomper_Dance.zip">song</a> &amp; <a target="_blank" href="https://www.youtube.com/watch?v=ocrLREoboAU">idea</a> by Mateusz Szyma&#324;ski (Jakim)</span>

<script>
$(document).ready(function() {
	$("#dance")[0].onplay = function(){
		$("#dance").attr("poster", "chomper_dance/images/black.png");
	};

	$("#btnOops").prop("disabled", true);
	var myvid = document.getElementById("dance");
	myvid.addEventListener("ended", function(e) {
		next = $("#next").text();
		if (next != "")
		{
			$("#btnOops").prop("disabled", false);
			$("#btnOops").prop("value", "Oops");
			myvid.src = next;
			myvid.play();
		}
	});

	$("#btnOops").click(function(){
		$("#btnOops").prop("disabled", true);
		$("#btnOops").prop("value", "Ouch...");
		$("#next").text("");
		myvid.src = "chomper_dance/videos/end.webm";
		myvid.play();
	});
});
</script>
');

EndHTML();
?>
