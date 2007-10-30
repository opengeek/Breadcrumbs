<?php
class BreadCrumbs {
	var $crumbs;

	function BreadCrumbs(&$modx,$config) {
		$this->__construct($modx,$config);
	}
	function __construct(&$modx,$config) {
		$this->modx =& $modx;
		$this->config = $config;
		$this->crumbs = array();
	}

	function showCurrentPage($resource) {
		// show current page, as link or not
		if ($this->config['showCurrentCrumb']) {

			$titleToShow = $resource->get($this->config['titleField'])
				? $resource->get($this->config['titleField'])
				: $resource->pagetitle;

			if ($this->config['currentAsLink'] && (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $resource->hidemenu != 1 ))) {

				$descriptionToUse = ($resource->get($this->config['descField']))
					? $resource->get($this->config['descField'])
					: $resource->pagetitle;
				$this->crumbs[] = '<a class="B_currentCrumb" href="[~'.$this->modx->documentIdentifier.'~]" title="'.$descriptionToUse.'">'.$titleToShow.'</a>';

			} else {
				$this->crumbs[] = '<span class="B_currentCrumb">'.$resource->pagetitle.'</span>';
			}
		}
	}

	function getMiddleCrumbs($resource_id,&$count) {
		// insert '...' if maximum number of crumbs exceded
		if ($count >= $this->config['maxCrumbs']) {
			$this->crumbs[] = '<span class="B_hideCrumb">...</span>';
			return false;
		}

		$wa = array(
			'id' => $resource_id,
		);
		if (!$this->config['pathThruUnPub']) {
			$wa['published'] = 1;
			$wa['deleted'] = 0;
		}
		$parent = $this->modx->getObject('modResource',$wa);

		if ($parent->id != $this->modx->config['site_start']) {
			if (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $parent['hidemenu'] != 1)) {
				$titleToShow = $parent->get($this->config['titleField'])
					? $parent->get($this->config['titleField'])
					: $parent->pagetitle;
				$descriptionToUse = $parent->get($this->config['descField'])
					? $parent->get($this->config['descField'])
					: $parent->pagetitle;

				$this->crumbs[] = '<a class="B_crumb" href="[~'.$parent->id.'~]" title="'.$descriptionToUse.'">'.$titleToShow.'</a>';
			}
		} // end if

		$count++;
		if ($parent->parent != 0) {
			$this->getMiddleCrumbs($parent->parent,$count);
		}
	}

	function load() {
		if ($this->config['showCrumbsAtHome']
		|| ($this->modx->documentIdentifier == $this->modx->config['site_start'])) return false;

		// get current resource parent info
		$resource = $this->modx->getObject('modResource',$this->modx->documentIdentifier);

		// assemble intermediate crumbs
		$crumbCount = 0;
		$this->getMiddleCrumbs($resource->id,$crumbCount);

		// add home link if desired
		if ($this->config['showHomeCrumb'] && ($this->modx->documentIdentifier != $this->modx->config['site_start'])) {
			$this->crumbs[] = '<a class="B_homeCrumb" href="[~'.$this->modx->config['site_start'].'~]" title="'.$this->config['homeCrumbDescription'].'">'.$this->config['homeCrumbTitle'].'</a>';
		}

		$this->crumbs = array_reverse($this->crumbs);
		$this->crumbs[0] = '<span class="B_firstCrumb">'.$this->crumbs[0].'</span>';
		$this->crumbs[count($this->crumbs)-1] = '<span class="B_lastCrumb">'.$this->crumbs[count($this->crumbs)-1].'</span>';

		return '<span class="B_crumbBox">'. join($this->crumbs, ' '.$this->config['crumbSeparator'].' ').'</span>';
	}
}
?>