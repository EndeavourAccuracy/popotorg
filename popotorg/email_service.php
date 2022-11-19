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
function EmailService ()
/*****************************************************************************/
{
print ('
<h2>Introduction</h2>
<p>This website has an email service that can be used by its registered users. Users who subscribed to one or more mods will receive emails when comments and replays are added to those mods\' pages. Subscribing is optional, and the default is no subscriptions. Users can subscribe to mods individually or to everything.</p>
<p>This page explains how to <a href="#view">view subscriptions</a> and how to <a href="#change">change subscriptions</a>.</p>

<h2 id="view" class="anchor">Viewing Subscriptions</h2>
<p>To see your subscriptions, login and look at your profile.</p>
<img src="images/login_profile.png" alt="login, profile" style="max-width:100%;">
<p>The example below shows a user who is subscribed to everything. The user also subscribed to two individual mods, but these subscriptions have no effect because the user already receives emails about everything.</p>
<img src="images/subscriptions.png" alt="subscriptions" style="max-width:100%; margin-bottom:10px;">

<h2 id="change" class="anchor">Changing Subscriptions</h2>
<p>Users can (un)subscribe to individual mods and to everything.</p>
<p>To (un)subscribe to individual mods, go to their pages and use the related checkbox.</p>
<img src="images/subscription_mod.png" alt="subscription, mod" style="max-width:100%;">
<p>To (un)subscribe to everything, first go to your settings.</p>
<img src="images/login_settings.png" alt="login, settings" style="max-width:100%;">
<p>Then use the related checkbox, and press "Change".</p>
<img src="images/subscription_all.png" alt="subscription, all" style="max-width:100%;">
');
}
/*****************************************************************************/

StartHTML ('Email Service', '', '', 'Account');

EmailService();

EndHTML();
?>
