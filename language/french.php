<?php

###############################################################################
# french.php
#
# Fichier de langue française pour le plugin Maintenance de Geeklog
#
# Ce programme est un logiciel libre ; vous pouvez le redistribuer et/ou le
# modifier selon les termes de la GNU General Public License publiée par la
# Free Software Foundation ; soit la version 2, soit (à votre choix) toute
# version ultérieure.
#
# Ce programme est distribué dans l’espoir qu’il sera utile, mais SANS AUCUNE
# GARANTIE ; sans même la garantie implicite de QUALITÉ MARCHANDE ou
# D’ADÉQUATION À UN USAGE PARTICULIER. Consultez la licence GNU GPL pour plus
# de détails.
#
# Vous devez avoir reçu une copie de la GNU General Public License avec ce
# programme ; sinon, écrivez à la Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
#
###############################################################################


// Localisation de l’interface de configuration admin
$LANG_configsections['maintenance'] = array(
    'label' => 'Maintenance',
    'title' => 'Configuration du plugin Maintenance'
);

$LANG_confignames['maintenance'] = array(
    'enabled' => 'Activer le mode maintenance',
    'message' => 'Message affiché aux visiteurs'
);

$LANG_configsubgroups['maintenance'] = array(
    'sg_0' => 'Paramètres principaux'
);

$LANG_fs['maintenance'] = array(
    'fs_01' => 'Paramètres du plugin Maintenance'
);

// Options de configuration (0 et 1 = listes standard Vrai/Faux)
$LANG_configselects['maintenance'] = array(
    0 => array('Vrai' => 1, 'Faux' => 0),
    1 => array('Activé' => 1, 'Désactivé' => 0)
);

// Chaînes de langue utilisées par le plugin
$LANG_MAINTENANCE = array(
    'plugin_name'      => 'Maintenance',
    'page_title'       => 'Site en maintenance',
    'default_message'  => 'Le site est actuellement en maintenance. Merci de revenir plus tard.',
    'admin_notice' => '⚠️ Le site est actuellement en mode maintenance — visible uniquement pour les administrateurs.'

);

?>
