<?php

namespace Lelesys\Plugin\News\Aop;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 *
 * @Flow\Aspect
 * @Flow\Scope("singleton")
 */
class PaginateAspect {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Set new template for paginator
	 *
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
	 * @Flow\Before("method(TYPO3\Fluid\ViewHelpers\Widget\Controller\PaginateController->indexAction())")
	 * @return void
	 */
	public function setPaginationTemplate(\TYPO3\Flow\Aop\JoinPointInterface $joinPoint) {
		$paginateController = $joinPoint->getProxy();
		$view = \TYPO3\Flow\Reflection\ObjectAccess::getProperty($paginateController, 'view', TRUE);
		$view->setTemplatePathAndFilename($this->settings['paginateTemplatePath']);
	}

}

?>