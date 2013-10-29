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

	/**
	 * Overide the parent evaluate method to get news object
	 * and assign to template
	 *
	 * @return string
	 */
	public function evaluate() {
		$fluidTemplate = new \TYPO3\TypoScript\TypoScriptObjects\Helpers\FluidView(($this->tsRuntime->getControllerContext()->getRequest() instanceof \TYPO3\Flow\Mvc\ActionRequest) ? $this->tsRuntime->getControllerContext()->getRequest() : NULL);

		$templatePath = $this->tsValue('templatePath');
		if ($templatePath === NULL) {
			throw new \Exception('Template path "' . $templatePath . '" at path "' . $this->path . '"  not found');
		}
		$fluidTemplate->setTemplatePathAndFilename($templatePath);

		$partialRootPath = $this->tsValue('partialRootPath');
		if ($partialRootPath !== NULL) {
			$fluidTemplate->setPartialRootPath($partialRootPath);
		}

		$layoutRootPath = $this->tsValue('layoutRootPath');
		if ($layoutRootPath !== NULL) {
			$fluidTemplate->setLayoutRootPath($layoutRootPath);
		}

			// Template resources need to be evaluated from the templates package not the requests package.
		if (strpos($templatePath, 'resource://') === 0) {
			$templateResourcePathParts = parse_url($templatePath);
			$fluidTemplate->setResourcePackage($templateResourcePathParts['host']);
		}

			// Assign news to template
		$fluidTemplate->assign('news', $this->getNewsFromCurrentRequest());

		$this->initializeView($fluidTemplate);

			// TODO this should be done differently lateron
		$fluidTemplate->assign('fluidTemplateTsObject', $this);

		$sectionName = $this->tsValue('sectionName');

		if ($sectionName !== NULL) {
			return $fluidTemplate->renderSection($sectionName);
		} else {
			return $fluidTemplate->render();
		}
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