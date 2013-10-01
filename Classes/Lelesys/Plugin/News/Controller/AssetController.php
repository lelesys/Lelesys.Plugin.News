<?php

namespace Lelesys\Plugin\News\Controller;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use \Lelesys\Plugin\News\Domain\Model\Asset;

/**
 * Asset controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class AssetController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * Adds the given new asset object to the asset repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $newAsset A new asset to add
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Asset $newAsset) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->assetService->create($newAsset);
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot create asset at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.createasset', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
		}
	}

	/**
	 * Shows a form for editing an existing asset object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to edit
	 * @return void
	 */
	public function editAction(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->view->assign('asset', $asset);
	}

	/**
	 * Updates the given asset object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->assetService->update($asset);
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot update asset at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.updateasset', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
		}
	}

	/**
	 * Removes the given asset object from the asset repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->assetService->delete($asset);
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>