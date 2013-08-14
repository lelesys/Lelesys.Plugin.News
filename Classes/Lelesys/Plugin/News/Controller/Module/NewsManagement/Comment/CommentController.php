<?php

namespace Lelesys\Plugin\News\Controller\Module\NewsManagement\Comment;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use \Lelesys\Plugin\News\Domain\Model\Comment;

/**
 * Comment controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CommentController extends \TYPO3\Neos\Controller\Module\AbstractModuleController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CommentService
	 */
	protected $commentService;

	/**
	 * Shows a list of comments
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('comments', $this->commentService->listAll());
	}

	/**
	 * Removes the given comment object from the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The comment to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$this->commentService->delete($comment);
		$this->addFlashMessage('Deleted a comment.');
		$this->redirect('index');
	}

	/**
	 * hide's the category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment
	 * @return void
	 */
	public function unPublishAction(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		try {
			$this->commentService->unPublishComment($comment);
			$this->addFlashMessage('Comment is not published', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * show's the hidden category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment
	 * @return void
	 */
	public function publishAction(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		try {
			$this->commentService->publishComment($comment);
			$this->addFlashMessage('Comment is published', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>