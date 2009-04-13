<?php
/**
 * BreadCrumbs
 *
 * @package breadcrumbs
 */
/**
 * BreadCrumbs Class
 *
 * @package breadcrumbs
 */
class BreadCrumbs {
    /**
     * @var array $_crumbs An array of crumbs stored so far.
     * @access private
     */
    var $_crumbs;
    var $_tpls;

    /**#@+
     * The BreadCrumbs constructor.
     *
     * @param modX $modx A reference to the modX constructor.
     * @param array $config A configuration array.
     */
    function BreadCrumbs(&$modx,$config) {
        $this->__construct($modx,$config);
    }
    /** @ignore */
    function __construct(&$modx,$config) {
        $this->modx =& $modx;
        $this->config = $config;
        $this->_crumbs = array();
        $this->_tpls = array();
    }
    /**#@-*/

    /**
     * Initialize the default configuration parameters, allowing overrides
     *
     * @access public
     * @param array $config An array of configuration parameters
     * @return array The newly set config array
     */
    function initialize($config = array()) {
        if (!is_array($config)) $config = array();

        $this->config = array_merge(array(
            /**
             * Max number of elements to have in a path. 100 is an arbitrary
             * high number. If you make it smaller, like say 2, but you are 5
             * levels deep, it will appear as: Home > ... > Level 4 > Level 5 It
             * should be noted that "Home" and the current page do not count.
             * Each of these are configured separately.
             *
             * @var integer $maxCrumbs
             */
            'maxCrumbs' => 100,
            /**
             * When your path includes an unpublished folder, setting this to 1
             * will show all documents in path EXCEPT the unpublished. Example
             * path (unpublished in caps): home > news > CURRENT > SPORTS >
             * skiiing > article $pathThruUnPub = true would give you this: home
             * > news > skiiing > article $pathThruUnPub = false would give you
             * this: home > skiiing > article (assuming you have home crumb
             * turned on)
             *
             * @var boolean $pathThruUnPub
             */
            'pathThruUnPub' => true,
            /**
             * Setting this to 1 will hide items in the breadcrumb list that
             * are set to be hidden in menus.
             *
             * @var boolean $respectHidemenu
             */
            'respectHidemenu' => true,
            /**
             * Would you like your crumb string to start with a link to home?
             * Some would not because a home link is usually found in the site
             * logo or elsewhere in the navigation scheme.
             *
             * @var boolean $showHomeCrumb
             */
            'showHomeCrumb' => true,
            /**
             * You can use this to turn off the breadcrumbs on the home page
             * with 1. grad: actually '1' shows and '0' hides crumbs at
             * homepage.
             *
             * @var boolean $showCrumbsAtHome
             */
            'showCrumbsAtHome' => false,
            /**
             * Show the current page in path with 1 or not with 0.
             *
             * @var boolean $showCurrentCrumb
             */
            'showCurrentCrumb' => true,
            /**
             * If you want the current page crumb to be a link (to itself) then
             * set to 1.
             *
             * @var boolean $currentAsLink
             */
            'currentAsLink' => true,
            /**
             * Define what you want between the crumbs.
             *
             * @var string $crumbSeparator
             */
            'crumbSeparator' => '&raquo;',
            /**
             * Just in case you want to have a home link, but want to call it
             * something else.
             *
             * @var string $homeCrumbTitle
             */
            'homeCrumbTitle' => 'Home',
            /**
             * In case you want to have a custom description of the home link.
             * Defaults to title of home link.
             *
             * @var string $homeCrumbDescription
             */
            'homeCrumbDescription' => 'Home',
            /**
             * To change default page field to be used as a breadcrumb title,
             * default is pagetitle.
             *
             * @var string $titleField
             */
            'titleField' => 'pagetitle',
            /**
             * To change default page field to be used as a breadcrumb
             * description, default is description (GA: falls back to pagetitle
             * if description is empty).
             *
             * @var string $descField
             */
            'descField' => 'description',
            /**
             * The string that will show if the maximum number of breadcrumbs
             * has been shown.
             *
             * @var string $max_delimiter
             */
            'maxDelimiter' => '...',
            'bcTplCrumbCurrent' => '<span class="B_currentCrumb">[[+text]]</span>',
            'bcTplCrumbCurrentLink' => '<a class="B_currentCrumb" href="[[~[[+resource]]]]" title="[[+description]]">[[+text]]</a>',
            'bcTplCrumbFirst' => '<span class="B_firstCrumb">[[+text]]</span>',
            'bcTplCrumbHome' => '<a class="B_homeCrumb" href="[[~[[++site_start]]]]" title="[[+description]]">[[+text]]</a>',
            'bcTplCrumbLast' => '<span class="B_lastCrumb">[[+text]]</span>',
            'bcTplCrumbMax' => '<span class="B_hideCrumb">[[+text]]</span>',
            'bcTplCrumbLink' => '<a class="B_crumb" href="[[~[[+resource]]]]" title="[[+description]]">[[+text]]</a>',
            'bcTplCrumbOuter' => '<span class="B_crumbBox">[[+text]]</span>',
            'bcTplCrumb' => '<span class="B_crumb">[[+text]]</span>',
        ),$config);

        return $this->config;
    }

    /**
     * Show the current resource's breadcrumbs.
     *
     * @access public
     * @param modResource $resource The resource to load.
     */
    function showCurrentPage($resource) {
        /* show current page, as link or not */
        if ($this->config['showCurrentCrumb']) {

            $titleToShow = $resource->get($this->config['titleField'])
                ? $resource->get($this->config['titleField'])
                : $resource->get('pagetitle');

            if ($this->config['currentAsLink'] && (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $resource->get('hidemenu') != 1 ))) {

                $descriptionToUse = ($resource->get($this->config['descField']))
                    ? $resource->get($this->config['descField'])
                    : $resource->get('pagetitle');

                $this->_crumbs[] = $this->getChunk('bcTplCrumbCurrentLink',array(
                    'resource' => $this->modx->resource->get('id'),
                    'description' => $descriptionToUse,
                    'text' => $titleToShow,
                ));
            } else {
                $this->_crumbs[] = $this->getChunk('bcTplCrumbCurrent',array(
                    'text' => $resource->get('pagetitle'),
                ));
            }
        }
    }

    /**
     * Get the mediary crumbs for an object.
     *
     * @access public
     * @param integer $resourceId The ID of the resource to pull from.
     * @param integer &$count
     */
    function getMiddleCrumbs($resourceId,&$count) {
        /* insert '...' if maximum number of crumbs exceded */
        if ($count >= $this->config['maxCrumbs']) {
            $this->_crumbs[] = $this->getChunk('bcTplCrumbMax',array(
                'text' => $this->config['maxDelimiter'],
            ));
            return false;
        }

        $wa = array(
            'id' => $resourceId,
        );
        if (!$this->config['pathThruUnPub']) {
            $wa['published'] = true;
            $wa['deleted'] = false;
        }
        $parent = $this->modx->getObject('modResource',$wa);
        if ($parent == null) return false;

        if ($parent->get('id') != $this->modx->config['site_start']) {
            if (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $parent->get('hidemenu') != 1)) {
                $titleToShow = $parent->get($this->config['titleField'])
                    ? $parent->get($this->config['titleField'])
                    : $parent->get('pagetitle');
                $descriptionToUse = $parent->get($this->config['descField'])
                    ? $parent->get($this->config['descField'])
                    : $parent->get('pagetitle');

                $this->_crumbs[] = $this->getChunk('bcTplCrumbLink',array(
                    'resource' => $parent->get('id'),
                    'description' => $descriptionToUse,
                    'text' => $titleToShow,
                ));
            }
        } /* end if */

        $count++;
        if ($parent->get('parent') != 0) {
            $this->getMiddleCrumbs($parent->get('parent'),$count);
        }
    }

    /**
     * Render the breadcrumbs.
     *
     * @access public
     * @return string The formatting string of crumbs to output
     */
    function run() {
        /* get current resource parent info */
        $resource = $this->modx->resource;

        if ($this->config['showCrumbsAtHome']
        || ($resource->get('id') == $this->modx->config['site_start'])) return false;

        /* assemble intermediate crumbs */
        $crumbCount = 0;
        $this->getMiddleCrumbs($resource->get('id'),$crumbCount);

        /* add home link if desired */
        if ($this->config['showHomeCrumb'] && ($resource->get('id') != $this->modx->config['site_start'])) {
            $this->_crumbs[] = $this->getChunk('bcTplCrumbHome',array(
                'description' => $this->config['homeCrumbDescription'],
                'text' => $this->config['homeCrumbTitle'],
            ));
        }

        $this->_crumbs = array_reverse($this->_crumbs);

        $o = '';
        $idx = 0;
        $crumbCount = count($this->_crumbs)-1;
        foreach ($this->_crumbs as $crumb) {
            if ($idx == 0) {
                $o .= $this->getChunk('bcTplCrumbFirst',array(
                    'text' => $crumb,
                ))."\n";
            } else if ($idx == $crumbCount) {
                $o .= ' '.$this->config['crumbSeparator'].' ';
                $o .= $this->getChunk('bcTplCrumbLast',array(
                    'text' => $crumb,
                ))."\n";
            } else {
                $o .= ' '.$this->config['crumbSeparator'].' ';
                $o .= $this->getChunk('bcTplCrumb',array(
                    'text' => $crumb,
                ))."\n";
            }
            $idx++;
        }
        return $this->getChunk('bcTplCrumbOuter',array('text' => $o));
    }

    /**
     * Helper function for getting chunks that allows for faster grabbing and
     * dynamic insertion
     *
     * @access public
     * @param string $name
     * @param array $properties
     * @return string
     */
    function getChunk($name,$properties = array()) {
        $o = '';
        if (isset($this->_tpls[$name])) {
            return $this->modx->newObject('modChunk')->process($properties,$this->_tpls[$name]);
        } else {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name));
            if (empty($chunk) || $chunk == null) {
                $chunk = $this->modx->newObject('modChunk');
                $chunk->setContent($this->config[$name]);
            }
            $this->_tpls[$name] = $chunk->getContent();
            $o = $chunk->process($properties,$chunk);
        }
        return $o;
    }
}