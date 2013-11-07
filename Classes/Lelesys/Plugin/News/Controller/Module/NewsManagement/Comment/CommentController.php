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
class CommentController extends \Lelesys\Plugin\News\Controller\Module\NewsManagementController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CommentService
	 */
	protected $commentService;

	/**
	 * Shows a list of comments
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News
	 * @param array $filterFlag The active flag
	 * @param string $selected The select value for comment filter
	 * @return void
	 */
	public function indexAction(\Lelesys\Plugin\News\Domain\Model\News $news = NULL, $filterFlag = NULL, $selected = NULL) {
		$this->view->assign('selectVal', $selected);
		if ($news !== NULL) {
			$this->view->assign('comments', $this->commentService->getCommentsByNews($news));
		} else {
			$this->view->assign('comments', $this->commentService->listAllCommentsAdmin($filterFlag));
		}
	}

	/**
	 * Removes the given comment object from the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The comment to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$this->commentService->delete($comment);
		$packageKey = $this->settings['flashMessage']['packageKey'];
		$header = 'Deleted a comment.';
		$message = $this->translator->translateById('lelesys.plugin.news.delete.comment', array(), NULL, NULL, 'Main', $packageKey);
		$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Comment is not published.';
			$message = $this->translator->translateById('lelesys.plugin.news.unpublish.comment', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Comment is published.';
			$message = $this->translator->translateById('lelesys.plugin.news.publish.comment', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>