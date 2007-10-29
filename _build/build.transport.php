<?php
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;

// get rid of time limit
set_time_limit(0);

// override with your own defines here (see build.config.sample.php)
require_once ('build.config.php');

require_once (MODX_CORE_PATH . 'model/modx/modx.class.php');
$modx= new modX();
$modx->initialize('mgr');
//$modx->setDebug(true);

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->create('breadcrumbs','0.9','d');

$sources= array (
    'assets' => dirname(dirname(__FILE__)) . '/assets/'
);

// get the source from the actual snippet in your database
// [alternative] you could also manually create the object, grabbing the source from a file
$c= $modx->getObject('modSnippet', array ('name' => 'BreadCrumbs'));
$c->set('category', 0);
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

echo "\nExecution time: {$totalTime}\n";

exit ();
