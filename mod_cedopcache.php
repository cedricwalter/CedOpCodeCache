<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_latest
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependencies.
JLoader::register('ModCedOpCacheHelper', __DIR__ . '/helper.php');

$model = ModCedOpCacheHelper::getModel($params);

// Include dependencies.
require JModuleHelper::getLayoutPath('mod_cedopcache', $params->get('layout', 'default'));
