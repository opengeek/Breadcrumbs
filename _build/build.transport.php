<?php
/**
 * @package breadcrumbs
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'lexicon' => $root . '_build/lexicon/',
    'docs' => $root . 'breadcrumbs/docs/',
);

/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo '<pre>';
$modx->setLogLevel(MODX_LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

/* load packagebuilder and transport package */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage('breadcrumbs','0.9','e');
$builder->registerNamespace('breadcrumbs',false);

/* create snippet object */
$c= $modx->newObject('modSnippet');
$c->set('name', 'Breadcrumbs');
$c->set('description', '<strong>0.9e</strong> Show the path through the various levels of site structure back to the root.');
$c->set('category', 0);
$c->set('snippet', file_get_contents($sources['root'] . 'breadcrumbs/breadcrumbs.snippet.php'));

/* create snippet vehicle */
$vehicle = $builder->createVehicle($c);
$vehicle->resolve('file',array(
    'source' => $sources['root'] . 'breadcrumbs',
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$builder->putVehicle($vehicle);


/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
));

/* pack */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(MODX_LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit();