<?php

namespace Lelesys\Plugin\News\Controller;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

/**
 * AbstractShop controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
abstract class AbstractNewsController extends ActionController {

	/**
	 * Settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param \TYPO3\Flow\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	 * @api
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		// set the template paths from the Settings
		// so that it can be changed per project
		// do this only if it is a TemplateView to avoid FATAL errors
		if ($view instanceof \TYPO3\Fluid\View\TemplateView) {
			$view->setTemplateRootPath($this->settings['templateRootPath']);
			$view->setPartialRootPath($this->settings['partialRootPath']);
			$view->setLayoutRootPath($this->settings['layoutRootPath']);
		}
	}

}

?>