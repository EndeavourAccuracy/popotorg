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

/*****************************************************************************/
function StringSize (id, from, to)
/*****************************************************************************/
{
	var check = document.getElementById(id).value.length;
	if ((check < from) || (check > to))
	{
		alert('Incorrect length for ' + id + '!');
		document.getElementById(id).focus();
		return false;
	}
}
/*****************************************************************************/
function Match (id, id2)
/*****************************************************************************/
{
	var check = document.getElementById(id).value;
	var check2 = document.getElementById(id2).value;
	if (check != check2)
	{
		alert('Values for ' + id + ' and ' + id2 + ' don\'t match!');
		document.getElementById(id).focus();
		return false;
	}
}
/*****************************************************************************/
function IsEmail (id)
/*****************************************************************************/
{
	var check = document.getElementById(id).value;
	if ((check.indexOf(".") > 0) && (check.indexOf("@") > 0)) {} else
	{
		alert('Incorrect email address!');
		document.getElementById(id).focus();
		return false;
	}
}
/*****************************************************************************/
function CheckReg ()
/*****************************************************************************/
{
	if (StringSize ('nick', 1, 30) == false) { return false; }
	if (Match ('password1', 'password2') == false) { return false; }
	if (StringSize ('password1', $GLOBALS['password_min_length'], 30) == false)
		{ return false; }
	if (StringSize ('password2', $GLOBALS['password_min_length'], 30) == false)
		{ return false; }
	if (IsEmail ('email') == false) { return false; }
	if (StringSize ('email', 5, 50) == false) { return false; }
	if (StringSize ('website', 0, 100) == false) { return false; }
	if (StringSize ('verify', 1, 4) == false) { return false; }
	return true;
}
/*****************************************************************************/
function CheckChg ()
/*****************************************************************************/
{
	if (Match ('password1', 'password2') == false) { return false; }
	if (StringSize ('password1', $GLOBALS['password_min_length'], 30) == false)
		{ return false; }
	if (StringSize ('password2', $GLOBALS['password_min_length'], 30) == false)
		{ return false; }
	if (IsEmail ('email') == false) { return false; }
	if (StringSize ('email', 5, 50) == false) { return false; }
	if (StringSize ('website', 0, 100) == false) { return false; }
	return true;
}
/*****************************************************************************/
function CheckLogin ()
/*****************************************************************************/
{
	if (StringSize ('nick', 1, 30) == false) { return false; }
	/*** Do NOT use $GLOBALS['password_min_length'] here. ***/
	if (StringSize ('password', 6, 30) == false) { return false; }
	return true;
}
/*****************************************************************************/

$(document).ready(function(){
	fm_options = {
		position : "left-bottom",
		bootstrap : true,
		title_label : "Contact Webmaster",
		trigger_label : "Feedback",
		message_required : true,
		show_asterisk_for_required : true,
		name_placeholder: "optional",
		show_email : true,
		email_placeholder: "optional",
		feedback_url : "send_feedback.php"
	};

	fm.init(fm_options);
});
