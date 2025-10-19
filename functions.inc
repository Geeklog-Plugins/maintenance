<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Maintenance Plugin 1.0.0                                                  |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file initializes the Maintenance plugin and provides all the core    |
// | logic to control website access when maintenance mode is enabled.         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2024 by the following authors:                              |
// |                                                                           |
// | Authors: ::Ben - ben AT geeklog DOT fr                                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file cannot be used on its own.');
}

global $_CONF;

// Path to the plugin
$plugin_path = $_CONF['path'] . 'plugins/maintenance/';

// Set language file or fallback to English by default
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

// Load plugin configuration if not already loaded
if (!isset($_MAINTENANCE_CONF['enabled'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $maintenance_config = config::get_instance();
    $_MAINTENANCE_CONF = $maintenance_config->get_config('maintenance');
}


/**
 * PHP Block hook: automatically called if a block named 'maintenance_check' exists.
 * Displays a localized banner for admins and blocks visitors during maintenance.
 */
function phpblock_maintenance_check()
{
    global $_CONF, $_USER, $_MAINTENANCE_CONF, $LANG_MAINTENANCE;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $c = config::get_instance();
    $_MAINTENANCE_CONF = $c->get_config('maintenance');

    if (!is_array($_MAINTENANCE_CONF) || empty($_MAINTENANCE_CONF)) {
        return '';
    }

    $enabled = (int) $_MAINTENANCE_CONF['enabled'];
    $message = $_MAINTENANCE_CONF['message'];

    if ($enabled === 1) {
        $script = basename($_SERVER['PHP_SELF']);

        // --- Case 1: Root admin -> show localized banner ---
        if (SEC_inGroup('Root')) {
            $banner_text = isset($LANG_MAINTENANCE['admin_notice'])
                ? $LANG_MAINTENANCE['admin_notice']
                : 'Maintenance mode active (visible only to administrators).';

            $banner_html = '<div style="background-color:#c00;color:#fff;
                text-align:center;padding:10px;font-weight:bold;font-size:14px;">'
                . $banner_text .
                '</div>';

            echo $banner_html;
            return '';
        }

        // --- Case 2: Non-admin visitor -> show maintenance page ---
        if ($script !== 'users.php') {
            // Return HTTP 503 status
            header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', true, 503);
            header('Retry-After: 3600'); // Conseille aux robots de revenir dans 1h

            require_once $_CONF['path_system'] . 'lib-template.php';
            $T = new Template($_CONF['path'] . 'plugins/maintenance/templates/');
            $T->set_file('page', 'maintenance.thtml');
            $T->set_var('language', $_CONF['language']);
            $T->set_var('maintenance_title', $LANG_MAINTENANCE['page_title']);
            $T->set_var('maintenance_message', $message ?: $LANG_MAINTENANCE['default_message']);
            $T->set_var('current_year', date('Y'));
            $T->set_var('site_name', $_CONF['site_name']);
            $T->set_var('site_slogan', $_CONF['site_slogan']);
            $T->parse('output', 'page');
            echo $T->finish($T->get_var('output'));
            exit;
         }

    }

    return '';
}


/**
 * Check plugin compatibility with the current Geeklog version.
 */
function plugin_compatible_with_this_version_maintenance($pi_name)
{
    if (!function_exists('COM_newTemplate')) {
        return false;
    }
    return true;
}

/**
 * Uninstall Maintenance plugin.
 */
function plugin_autouninstall_maintenance()
{
    return array(
        'tables'    => array(),
        'groups'    => array('Maintenance Mode Admin'),
        'features'  => array('maintenance.admin'),
        'php_blocks'=> array('phpblock_maintenance_check'),
        'vars'      => array() 
    );
}


?>
