<?php
/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( http://www.xoops.org )
 * ****************************************************************************
 *  XNEWSLETTER - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  Goffy ( wedega.com )
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  ---------------------------------------------------------------------------
 *  @copyright  Goffy ( wedega.com )
 *  @license    GPL 2.0
 *  @package    xNewsletter
 *  @author     Goffy ( webmaster@wedega.com )
 *
 *  Version : 1 Mon 2012/11/05 14:31:32 :  Exp $
 * ****************************************************************************
 */

function xoops_module_update_xNewsletter(&$module, $oldversion = null) {
    $oldversion = $module->getVar('version');
    if ($oldversion == 100) {
        xoops_module_update_xNewsletter_101();
    }
    if ($oldversion < 103) {
        xoops_module_update_xNewsletter_103();
    }
    if ($oldversion < 104) {
        xoops_module_update_xNewsletter_104();
    }

    return TRUE;
}

function xoops_module_update_xNewsletter_104() {
    global $xoopsDB;

    $sql = sprintf("DROP TABLE IF EXISTS `" . $xoopsDB->prefix('mod_xnewsletter_task') . "`");
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _AM_XNEWSLETTER_UPGRADEFAILED . ": 'DROP TABLE 'mod_xnewsletter_task'";

    $sql = sprintf(
        "CREATE TABLE `" . $xoopsDB->prefix('mod_xnewsletter_task') . "` (
        `task_id` int(8) NOT NULL AUTO_INCREMENT,
        `task_letter_id` int(8) NOT NULL DEFAULT '0',
        `task_subscr_id` int(8) NOT NULL DEFAULT '0',
        `task_starttime` int(8) NOT NULL DEFAULT '0',
        `task_submitter` int(8) NOT NULL DEFAULT '0',
        `task_created` int(8) NOT NULL DEFAULT '0',
        PRIMARY KEY (`task_id`),
        KEY `idx_task_starttime` (`task_starttime`)
        ) ENGINE=MyISAM;"
        );
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _MI_XNEWSLETTER_UPGRADEFAILED . ": CREATE TABLE 'mod_xnewsletter_task'";

    unlink(XOOPS_ROOT_PATH . "/modules/xNewsletter/include/sendletter.php");

    return true;
}

function xoops_module_update_xNewsletter_103() {
    global $xoopsDB;

    $sql = sprintf("DROP TABLE IF EXISTS `" . $xoopsDB->prefix('mod_xnewsletter_import') . "`");
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _MI_XNEWSLETTER_UPGRADEFAILED . ": 'DROP TABLE 'mod_xnewsletter_import'";

        $sql = sprintf(
            "CREATE TABLE `" . $xoopsDB->prefix('mod_xnewsletter_import') . "` (
            `import_id` int (8)   NOT NULL  auto_increment,
            `import_email` varchar (100)   NOT NULL default ' ',
            `import_firstname` varchar (100)   NULL default ' ',
            `import_lastname` varchar (100)   NULL default ' ',
            `import_sex` varchar (100)   NULL default ' ',
            `import_cat_id` int (8)   NOT NULL default '0',
            `import_subscr_id` int (8)   NOT NULL default '0',
            `import_catsubscr_id` int (8)   NOT NULL default '0',
            `import_status` tinyint (1)   NOT NULL default '0',
            PRIMARY KEY (`import_id`),
            KEY `idx_email` (`import_email`),
            KEY `idx_subscr_id` (`import_subscr_id`),
            KEY `idx_import_status` (`import_status`)
            ) ENGINE=MyISAM;"
            );
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _MI_XNEWSLETTER_UPGRADEFAILED . ": CREATE TABLE 'mod_xnewsletter_import'";

    $sql = sprintf("ALTER TABLE `" . $xoopsDB->prefix('mod_xnewsletter_subscr') . "` ADD INDEX `idx_subscr_email` ( `subscr_email` )");
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _MI_XNEWSLETTER_UPGRADEFAILED . ": ADD INDEX `idx_subscr_email`";

    $sql = sprintf("ALTER TABLE `" . $xoopsDB->prefix('mod_xnewsletter_catsubscr') . "` ADD UNIQUE `idx_subscription` ( `catsubscr_catid` , `catsubscr_subscrid` )");
    $result = $xoopsDB->queryF($sql);
    if (!$result)
        echo '<br />' . _MI_XNEWSLETTER_UPGRADEFAILED . ": ADD INDEX `idx_subscription`";

    return true;
}

function xoops_module_update_xNewsletter_101() {
    global $xoopsDB;

    //rename tables to new xoops naming scheme
    xoops_module_update_xNewsletter_rename_table("xnewsletter_accounts");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_cat");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_subscr");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_catsubscr");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_letter");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_protocol");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_attachment");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_mailinglist");
    xoops_module_update_xNewsletter_rename_table("xnewsletter_bmh");

    return true;
}

function xoops_module_update_xNewsletter_rename_table($tablename) {
    global $xoopsDB;

    if (tableExists($xoopsDB->prefix($tablename))) {
        $sql = sprintf('ALTER TABLE ' . $xoopsDB->prefix($tablename) . ' RENAME ' . $xoopsDB->prefix('mod_' . $tablename));
        $result = $xoopsDB->queryF($sql);
        if (!$result) {
            echo "<br />" . _MI_XNEWSLETTER_UPGRADEFAILED . ": RENAME table '" . $tablename . "'";
            $errors++;
        }
    }

    return true;
}

function tableExists($tablename) {
    global $xoopsDB;
    $result=$xoopsDB->queryF("SHOW TABLES LIKE '{$tablename}'");

    return($xoopsDB->getRowsNum($result) > 0);
}
