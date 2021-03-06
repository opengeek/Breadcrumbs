<?php
/**
 * All properties for the Breadcrumbs snippet
 *
 * @package breadcrumbs
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'crumbSeparator',
        'desc' => 'Define what you want between the crumbs.',
        'type' => 'textfield',
        'options' => '',
        'value' => '&raquo;',
    ),
    array(
        'name' => 'currentAsLink',
        'desc' => 'If you want the current page crumb to be a link (to itself)',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'descField',
        'desc' => 'To change default page field to be used as a breadcrumb description, default is description. Falls back to pagetitle if description is empty.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'description',
    ),
    array(
        'name' => 'homeCrumbDescription',
        'desc' => 'In case you want to have a custom description of the home link. Defaults to title of home link.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'Home',
    ),
    array(
        'name' => 'homeCrumbTitle',
        'desc' => 'Just in case you want to have a home link, but want to call it something else.',
        'type' => '',
        'options' => '',
        'value' => 'Home',
    ),
    array(
        'name' => 'maxCrumbs',
        'desc' => 'Max number of elements to have in a path. 100 is an arbitrary high number. If you make it smaller, like say 2, but you are 5 levels deep, it will appear as: Home > ... > Level 4 > Level 5 It should be noted that "Home" and the current page do not count. Each of these are configured separately.',
        'type' => '',
        'options' => '',
        'value' => '100',
    ),
    array(
        'name' => 'maxDelimiter',
        'desc' => 'The string that will show if the maximum number of breadcrumbs has been shown.',
        'type' => 'textfield',
        'options' => '',
        'value' => '...',
    ),
    array(
        'name' => 'pathThruUnPub',
        'desc' => 'When your path includes an unpublished folder, setting this to true will show all resources in path EXCEPT the unpublished. Example path (unpublished in caps): home > news > CURRENT > SPORTS > skiiing > article $pathThruUnPub = true would give you this: home > news > skiiing > article $pathThruUnPub = false would give you this: home > skiiing > article (assuming you have home crumb turned on)',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'respectHidemenu',
        'desc' => 'If true, will hide items in the breadcrumbs that are set to be hidden in menus.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showCrumbsAtHome',
        'desc' => 'You can use this to toggle the breadcrumbs on the home page.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'showCurrentCrumb',
        'desc' => 'Show the current page in path.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showHomeCrumb',
        'desc' => 'Would you like your crumb string to start with a link to home? Some would not because a home link is usually found in the site logo or elsewhere in the navigation scheme.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'titleField',
        'desc' => 'To change default page field to be used as a breadcrumb title. Defaults to pagetitle.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'pagetitle',
    ),
);

return $properties;