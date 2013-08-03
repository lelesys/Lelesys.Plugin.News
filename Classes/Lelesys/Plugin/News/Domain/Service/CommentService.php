<?php

namespace Lelesys\Plugin\News\Domain\Service;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use \Lelesys\Plugin\News\Domain\Model\Comment;

/**
 * Asset controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CommentService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\CommentRepository
	 */
	protected $commentRepository;

	/**
	 * Shows a list of comments
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Comment
	 */
	public function listAll() {
		$this->view->assign('comments', $this->commentRepository->findAll());
	}

	/**
	 * Adds the given new comment object to the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $newComment A new comment to add
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\Comment $newComment, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$newComment->setNews($news);
		$this->commentRepository->add($newComment);
	}

	/**
	 * Updates the given comment object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The comment to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$this->commentRepository->update($comment);
	}

	/**
	 * Removes the given comment object from the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The comment to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$this->commentRepository->remove($comment);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\Comment
	 */
	public function findById($identifier) {
		$comment = $this->commentRepository->findByIdentifier($identifier);
		return $comment;
	}

}

?>
