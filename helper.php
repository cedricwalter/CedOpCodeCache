<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_latest
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_latest
 *
 * @since  1.5
 */
abstract class ModCedOpCacheHelper
{
	/**
	 * Get a list of articles.
	 *
	 * @param   \Joomla\Registry\Registry &$params The module parameters.
	 *
	 * @return  mixed  An array of articles, or false on error.
	 */
	public static function getModel(&$params)
	{
		$model = new stdClass();

		$model->active = function_exists("opcache_get_status");

		if ($model->active)
		{
			//var_dump(opcache_get_configuration());
			$model->width = $params->get('width', 250);
			$model->is3D  = 'false';

			$array = opcache_get_status();

			$model->cache_full = $array['cache_full'];

			$model->memUsed   = round($array['memory_usage']['used_memory'] / 1024 / 1024);
			$model->memFree   = round($array['memory_usage']['free_memory'] / 1024 / 1024);
			$model->memWasted = round($array['memory_usage']['wasted_memory'] / 1024 / 1024);

			$model->hits             = $array['opcache_statistics']['hits'];
			$model->misses           = $array['opcache_statistics']['misses'];
			$model->blacklist_misses = $array['opcache_statistics']['blacklist_misses'];

			$model->num_cached_keys = $array['opcache_statistics']['num_cached_keys'];
			$model->max_cached_keys = $array['opcache_statistics']['max_cached_keys'];
			$model->free_keys = $model->max_cached_keys - $model->num_cached_keys;
			//$memWasted = $array['memory_usage']['current_wasted_percentage'];
		}

		return $model;
	}

}
