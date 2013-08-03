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
use \Lelesys\Plugin\News\Domain\Model\Comment;

/**
 * Comment controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CommentController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CommentService
	 */
	protected $commentService;

	/**
	 * Adds the given new comment object to the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $newComment A new comment to add
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Comment $newComment, \Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->commentService->create($newComment, $news);
			$array = array("news" => $news);
			$this->redirect("show", "News", "Lelesys.Plugin.News", $array);
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot add comment at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>