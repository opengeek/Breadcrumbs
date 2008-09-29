<?php
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
// get rid of time limit
set_time_limit(0);
$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'assets' => $root . 'assets/',
    'build' => $root . '_build/',
    'lexicon' => $root . '_build/lexicon/',
);

// override with your own defines here (see build.config.sample.php)
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo '<pre>';
$modx->setLogLevel(MODX_LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->create('breadcrumbs','0.9','d');
$builder->registerNamespace('breadcrumbs',false);

$c= $modx->newObject('modSnippet');
$c->set('name', 'Breadcrumbs');
$c->set('description', '<strong>0.9d</strong> Show the path through the various levels of site structure back to the root.');
$c->set('category', 0);
$c->set('snippet', file_get_contents($sources['assets'] . 'snippets/breadcrumbs/breadcrumbs.snippet.php'));

$vehicle = $builder->createVehicle($c);
$vehicle->resolve('file',array(
    'source' => $sources['assets'] . 'snippets/breadcrumbs',
    'target' => "return MODX_ASSETS_PATH . 'snippets/';",
));
$builder->putVehicle($vehicle);
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(MODX_LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit();
