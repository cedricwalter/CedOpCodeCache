<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_latest
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$document = JFactory::getDocument();
$document->addScript("https://www.gstatic.com/charts/loader.js");
//https://developers.google.com/chart/interactive/docs/gallery/piechart

?>
<div class="row-striped">
<div>

    <?php if ($model->cache_full) {
      echo '<h2 style="color: red;">Cache is Full</h2>';
    }
    ?>
<!--    <div>-->
<!--        <p>These actions affect all cached opcodes.</p>-->
<!--        <a href="index.php?option=com_cedopcache&amp;task=reset" class="btn btn-primary">Reset</a>-->
<!--    </div>-->
<!--    <a href="index.php?option=com_cedopcache&amp;task=invalidate" class="btn btn-primary">Invalidate</a>-->
<!--    <a href="index.php?option=com_cedopcache&amp;task=forceinvalidate" class="btn btn-primary">Force Invalidate</a>-->

    <div id="memory" style="float:left;"></div>
    <div id="keys" style="float:left;"></div>
    <div id="hits" style="float:left;"></div>
    <div style="clear:both;"></div>

	<?php
	if ($model->active)
	{
		$document->addScriptDeclaration("

        google.charts.load('current', {'packages':['corechart']});
         google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            var memory = new google.visualization.PieChart(document.getElementById('memory'));
            memory.draw(google.visualization.arrayToDataTable([
                ['memory', 'MB'],
                ['Used $model->memUsed MB', $model->memUsed ],
                ['Free $model->memFree MB', $model->memFree],
                ['Wasted $model->memWasted MB', $model->memWasted],
              ]), {
                title: 'Memory (MB)',
                pieSliceText: 'none',
                is3D: $model->is3D,
                width: $model->width,
                pieHole: 0.6,
                slices: {
                    0: { color: 'red' },
                    1: { color: 'green' }
                }
            });
            
            var keys = new google.visualization.PieChart(document.getElementById('keys'));
            keys.draw(google.visualization.arrayToDataTable([
                ['keys', 'MB'],
                ['Used $model->num_cached_keys', $model->num_cached_keys],
                ['Free $model->free_keys', $model->free_keys],
                ['Wasted', 0],
              ]), {
                title: 'Keys',
                pieSliceText: 'none',
                is3D: $model->is3D,
                width: $model->width,
                pieHole: 0.6,
                slices: {
                    0: { color: 'red' },
                    1: { color: 'green' }
                }
            });
            
            var hits = new google.visualization.PieChart(document.getElementById('hits'));
            hits.draw(google.visualization.arrayToDataTable([
                ['memory', 'MB'],
                ['Hits $model->hits', $model->hits],
                ['Misses $model->misses', $model->misses],
                ['Blacklisted $model->blacklist_misses', $model->blacklist_misses],
              ]), {
                title: 'Hits',
                pieSliceText: 'none',
                is3D: $model->is3D,
                width: $model->width,
                pieHole: 0.6,
                slices: {
                    0: { color: 'green' },
                    1: { color: 'red' }
                }
            });
                        
            }
");
	} else {
		echo 'OPCache is disabled in php.ini see <a href="http://php.net/manual/en/opcache.configuration.php" target="_new">Here</a> to activate.';
    }


	/*
$array = {array} [8]
opcache_enabled = true
cache_full = false
restart_pending = false
restart_in_progress = false
memory_usage = {array} [4]
used_memory = 24314856
free_memory = 109902872
wasted_memory = 0
current_wasted_percentage = 0
interned_strings_usage = {array} [4]
buffer_size = 8388608
used_memory = 516376
free_memory = 7872232
number_of_strings = 11761
opcache_statistics = {array} [13]
num_cached_scripts = 205
num_cached_keys = 330
max_cached_keys = 7963
hits = 22
start_time = 1476618654
last_restart_time = 0
oom_restarts = 0
hash_restarts = 0
manual_restarts = 0
misses = 205
blacklist_misses = 0
blacklist_miss_ratio = 0
opcache_hit_rate = 9.6916299559471
*/


	?>
</div>

</div>
