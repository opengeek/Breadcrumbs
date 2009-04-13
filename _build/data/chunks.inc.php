<?php
/**
 * All chunks for Breadcrumbs
 *
 * @package breadcrumbs
 * @subpackage build
 */
$chunks = array();
$tpls = array(
    'bcTplCrumb' => '<span class="B_crumb">[[+text]]</span>',
    'bcTplCrumbCurrent' => '<span class="B_currentCrumb">[[+text]]</span>',
    'bcTplCrumbCurrentLink' => '<a class="B_currentCrumb" href="[[~[[+resource]]]]" title="[[+description]]">[[+text]]</a>',
    'bcTplCrumbFirst' => '<span class="B_firstCrumb">[[+text]]</span>',
    'bcTplCrumbHome' => '<a class="B_homeCrumb" href="[[~[[++site_start]]]]" title="[[+description]]">[[+text]]</a>',
    'bcTplCrumbLast' => '<span class="B_lastCrumb">[[+text]]</span>',
    'bcTplCrumbMax' => '<span class="B_hideCrumb">[[+text]]</span>',
    'bcTplCrumbLink' => '<a class="B_crumb" href="[[~[[+resource]]]]" title="[[+description]]">[[+text]]</a>',
    'bcTplCrumbOuter' => '<span class="B_crumbBox">[[+text]]</span>',
);

$idx = 0;
foreach ($tpls as $key => $val) {
    $chunk = $modx->newObject('modChunk');
    $chunk->set('id',$idx);
    $chunk->set('name',$key);
    $chunk->set('snippet',$val);
    $chunks[] = $chunk;
    $idx++;
}

unset($tpls,$idx);
return $chunks;