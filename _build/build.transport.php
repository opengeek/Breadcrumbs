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
    'root' => dirname(dirname(__FILE__)) . '/',
    'assets' => dirname(dirname(__FILE__)) . '/assets/',
);

// get the source from the actual snippet in your database
// [alternative] you could also manually create the object, grabbing the source from a file
$c= $modx->getObject('modSnippet', array ('name' => 'BreadCrumbs'));
if ( !is_null($c) ) {
	$c->set('category', 0);
}
/*
 * Mod by conseilsweb - you can remove this comment when we know it works
 * If the object isn't found, try to load from source
 */
else
{
	$c= $modx->newObject('modSnippet');
	$c->set('name', 'Breadcrumbs');
	$c->set('description', '<strong>0.9d</strong> Show the path through the various levels of site structure back to the root.');
	$c->set('category', 0);
	$c->set('snippet', file_get_contents($sources['assets'] . 'snippets/breadcrumbs/breadcrumbs.snippet.php'));
}
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
