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
use \Lelesys\Plugin\News\Domain\Model\Tag;

/**
 * Tag controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class TagController extends AbstractNewsController {

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
		$this->view->assign('tags', $this->tagService->listAll());
	}

	/**
	 * Shows a list of tags
	 *
	 * @return void
	 */
	public function adminListAction() {
		$this->view->assign('tags', $this->tagService->adminTagList());
	}

	/**
	 * Shows a single tag object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to show
	 * @return void
	 */
	public function showAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$this->view->assign('tagNews', $this->tagService->getNewsByTag($tag));
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
			$this->addFlashMessage('Created a new tag.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create tag at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Shows a form for editing an existing tag object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to edit
	 * @return void
	 */
	public function editAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$this->view->assign('tag', $tag);
	}

	/**
	 * Updates the given tag object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		try {
			$this->tagService->update($tag);
			$this->addFlashMessage('Updated the tag.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update tag at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
			$this->addFlashMessage('Deleted a tag.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessagTagControllere('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * hide's the tag
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @return void
	 */
	public function hideTagAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		try {
			$this->tagService->hideTag($tag);
			$this->addFlashMessage('Tag is Hidden', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * show's the hidden tag
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @return void
	 */
	public function showTagAction(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		try {
			$this->tagService->showTag($tag);
			$this->addFlashMessage('Tag is Visible', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>