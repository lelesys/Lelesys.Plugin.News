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
use \Lelesys\Plugin\News\Domain\Model\Link;

/**
 * Link controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class LinkController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\LinkService
	 */
	protected $linkService;

	/**
	 * Adds the given new link object to the link repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $newLink A new link to add
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Link $newLink) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->linkService->create($newLink);
			$header = 'Created a new link.';
			$message = $this->translator->translateById('lelesys.plugin.news.create.link', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot create link at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.createlink', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Updates the given link object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link The link to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->linkService->update($link);
			$header = 'Updated the link.';
			$message = $this->translator->translateById('lelesys.plugin.news.update.link', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot update link at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.updatelink', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given link object from the link repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link The link to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->linkService->delete($link);
			$header = 'Deleted a link.';
			$message = $this->translator->translateById('lelesys.plugin.news.delete.link', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>