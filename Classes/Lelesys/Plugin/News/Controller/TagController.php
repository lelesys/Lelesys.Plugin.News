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
use \Lelesys\Plugin\News\Domain\Model\Tag;

/**
 * Tag controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class TagController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\TagService
	 */
	protected $tagService;

	/**
	 * Shows a list of tags
	 *
	 * @return void
	 */
	public function indexAction() {
		$pluginArguments = $this->request->getPluginArguments();
		if (isset($pluginArguments['itemsPerPage'])) {
			$itemsPerPage = (int) $pluginArguments['itemsPerPage'];
		} else {
			$itemsPerPage = '';
		}
		$this->view->assign('itemsPerPage', $itemsPerPage);
		$this->view->assign('tags', $this->tagService->listAll($pluginArguments));
	}

	/**
	 * Shows a form for creating a new tag object
	 *
	 * @return void
	 */
	public function newAction() {

	}

	/**
	 * Adds the given new tag object to the tag repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $newTag A new tag to add
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Tag $newTag) {
		try {
			$this->tagService->create($newTag);
			$header = 'Created a new tag.';
			$message = $this->translator->translateById('lelesys.plugin.news.create.tag', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot create tag at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.createtag', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given tag objTagControllerect from the tag repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		try {
			$this->tagService->delete($tag);
			$header = 'Deleted a tag.';
			$message = $this->translator->translateById('lelesys.plugin.news.delete.tag', array(), NULL, NULL, 'Main', $packageKey);
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