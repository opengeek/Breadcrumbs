<?php
/**
 * @name BreadCrumbs
 * @version 0.9f
 * @created 2006-06-12
 * @since 2009-05-11
 * @author Jared <jaredc@honeydewdesign.com>
 * @editor Bill Wilson
 * @editor wendy@djamoer.net
 * @editor grad
 * @editor Shaun McCormick <shaun@collabpad.com>
 * @package breadcrumbs
 *
 * This snippet was designed to show the path through the various levels of site
 * structure back to the root. It is NOT necessarily the path the user took to
 * arrive at a given page.
 *
 * @see breadcrumbs.class.php for config settings
 *
 * Included classes
 * .B_crumbBox Span that surrounds all crumb output
 * .B_hideCrumb Span surrounding the "..." if there are more crumbs than will be shown
 * .B_currentCrumb Span or A tag surrounding the current crumb
 * .B_firstCrumb Span that always surrounds the first crumb, whether it is "home" or not
 * .B_lastCrumb Span surrounding last crumb, whether it is the current page or not .
 * .B_crumb Class given to each A tag surrounding the intermediate crumbs (not home, or
 * hide)
 * .B_homeCrumb Class given to the home crumb
 */
/* Check for home page */
$path = $modx->getOption('core_path').'components/breadcrumbs/';
$modx->loadClass('breadcrumbs',$path,true,true);
$bc = new BreadCrumbs($modx,$scriptProperties);

return $bc->run();