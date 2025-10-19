<?php

###############################################################################
# english.php
#
# This is the English language file for the Geeklog Maintenance plugin
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################


// Localization of the Admin Configuration UI
$LANG_configsections['maintenance'] = array(
    'label' => 'Maintenance',
    'title' => 'Maintenance Plugin Configuration'
);

$LANG_confignames['maintenance'] = array(
    'enabled' => 'Enable maintenance mode',
    'message' => 'Maintenance message displayed to visitors'
);

$LANG_configsubgroups['maintenance'] = array(
    'sg_0' => 'Main Settings'
);

$LANG_fs['maintenance'] = array(
    'fs_01' => 'Maintenance Plugin Settings'
);

// Configuration options (0 and 1 are standard True/False lists)
$LANG_configselects['maintenance'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('Enabled' => 1, 'Disabled' => 0)
);

// Language strings for the plugin itself
$LANG_MAINTENANCE = array(
    'plugin_name'      => 'Maintenance',
    'page_title'       => 'Website Under Maintenance',
    'default_message'  => 'The website is currently under maintenance. Please come back later.',
    'admin_notice' => '⚠️ The site is currently in maintenance mode — visible only to administrators.'

);

?>
