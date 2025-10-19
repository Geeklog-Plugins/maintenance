<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Maintenance Plugin 1.0.0                                                  |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin installation |
// | including groups, permissions, and configuration setup.                   |
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

require_once('functions.inc');

function plugin_autoinstall_maintenance($pi_name)
{
    $pi_name         = 'maintenance';
    $pi_display_name = 'Maintenance Mode';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.0.0',
        'pi_gl_version'   => '2.1.1',
        'pi_homepage'     => 'https://geeklog.net'
    );

    $groups = array(
        $pi_admin => 'Users in this group can administer the ' . $pi_display_name . ' plugin'
    );

    $features = array(
        $pi_name . '.admin' => 'Full access to ' . $pi_display_name . ' plugin'
    );

    $mappings = array(
        $pi_name . '.admin' => array($pi_admin)
    );

    $tables = array(); // No custom tables needed

    return array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );
}

/**
 * Load the plugin configuration during installation.
 *
 * Called only when Geeklog installs the plugin.
 */
function plugin_load_configuration_maintenance($pi_name)
{
    global $_CONF;

    $defaults = $_CONF['path'] . 'plugins/' . $pi_name . '/install_defaults.php';

    if (file_exists($defaults)) {
        require_once $defaults;
        if (function_exists('plugin_initconfig_' . $pi_name)) {
            call_user_func('plugin_initconfig_' . $pi_name);
            return true;
        }
    }

    return false;
}

/**
 * Plugin post-install hook for the Maintenance plugin
 *
 * Creates the PHP block "maintenance_check" after installation
 * and registers it in the `gl_topic_assignments` table.
 *
 * Compatible with Geeklog 2.1.1 and newer.
 *
 * @return bool True on success, False if an error occurred
 */
function plugin_postinstall_maintenance($pi_name)
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    // --- Check if the 'tid' column exists in gl_blocks (newer Geeklog versions) ---
    $has_tid = false;
    $result = DB_query("SHOW COLUMNS FROM {$_TABLES['blocks']} LIKE 'tid'");
    if (DB_numRows($result) > 0) {
        $has_tid = true;
    }

    // --- Create the maintenance_check block ---
    if ($has_tid) {
        // Newer Geeklog schema (with 'tid' column)
        $SQL = "INSERT INTO {$_TABLES['blocks']}
            (is_enabled, name, type, title, tid, blockorder, onleft, phpblockfn,
             group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon)
            VALUES
            (1, 'maintenance_check', 'phpblock', '', 'all', 0, 1, 'phpblock_maintenance_check',
             2, 2, 3, 3, 3, 3)";
    } else {
        // Older schema (Geeklog 2.1.x) without 'tid' column
        $SQL = "INSERT INTO {$_TABLES['blocks']}
            (is_enabled, name, type, title, blockorder, onleft, phpblockfn,
             group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon)
            VALUES
            (1, 'maintenance_check', 'phpblock', '', 0, 1, 'phpblock_maintenance_check',
             2, 2, 3, 3, 3, 3)";
    }

    DB_query($SQL, 1);
    if (DB_error()) {
        COM_errorLog("SQL error in Maintenance plugin postinstall, SQL: $SQL");
        return false;
    }

    // --- Retrieve the block ID we just created ---
    $block_id = DB_insertId();

    // --- Register the block in the topic assignment table ---
    // Without this entry, the block will not be displayed on any page.
    $SQL2 = "INSERT INTO {$_TABLES['topic_assignments']}
        (tid, type, id, inherit, tdefault)
        VALUES ('all', 'block', $block_id, 1, 0)";
    DB_query($SQL2, 1);

    if (DB_error()) {
        COM_errorLog("SQL error in Maintenance plugin postinstall (topic assignment), SQL: $SQL2");
        return false;
    }

    COM_errorLog("Maintenance Plugin: PHP Block 'maintenance_check' successfully created and assigned to topic 'all'.");
    return true;
}

?>
