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
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");
include_once dirname(dirname(__FILE__)) . '/include/common.php';

function b_xnewsletter_subscrinfo($options) {
    xoops_loadLanguage('modinfo', 'xNewsletter');
    $unique_id = uniqid(mt_rand());
    $subscrinfo = array();
    $subscrinfo['formname'] = "formsubscrinfo_{$unique_id}";
    $subscrinfo['formaction'] = XOOPS_URL . '/modules/xNewsletter/subscription.php';
    $subscrinfo['infotext'] = _MI_XNEWSLETTER_SUBSCRINFO_TEXT_BLOCK;
    $subscrinfo['buttontext'] = _MI_XNEWSLETTER_SUBSCRIBE;

    return $subscrinfo;
}
