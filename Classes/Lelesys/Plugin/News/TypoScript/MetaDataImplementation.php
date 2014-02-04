<?php

namespace Lelesys\Plugin\News\TypoScript;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".                    *
 *                                                                              *
 * It is free software; you can redistribute it and/or modify it under          *
 * the terms of the GNU Lesser General Public License, either version 3         *
 * of the License, or (at your option) any later version.                       *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TypoScript\TypoScriptObjects\Helpers;

/**
 * MetaData TypoScript object implementation
 *
 * @Flow\Scope("prototype")
 */
class MetaDataImplementation extends \TYPO3\TypoScript\TypoScriptObjects\TemplateImplementation {

	/**
	 * News service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\NewsService
	 */
	protected $newsService;

	protected function initializeView(Helpers\FluidView $view) {
		$view->assign('news', $this->getNewsFromCurrentRequest());
	}

	/**
	 * Checks for the news in the current plugin request
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getNewsFromCurrentRequest() {
		$pluginArguments = $this->tsRuntime->getControllerContext()->getRequest()->getPluginArguments();
		if (!empty($pluginArguments)) {
			foreach ($pluginArguments as $arguments) {
				if (!empty($arguments['@package']) &&
						$arguments['@package'] === 'Lelesys.Plugin.News'
						&& $arguments['@controller'] === 'News'
						&& $arguments['@action'] === 'show'
						&& !empty($arguments['news']['__identity'])) {
					return $this->newsService->findById($arguments['news']['__identity']);
				}
			}
		}
	}

}

?>