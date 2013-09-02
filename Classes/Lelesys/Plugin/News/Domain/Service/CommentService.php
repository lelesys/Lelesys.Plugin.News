<?php

namespace Lelesys\Plugin\News\Domain\Service;

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
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll() {
		return $this->commentRepository->findAll();
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
		$this->emitCommentCreated($newComment);
	}

	/**
	 * Removes the given comment object from the comment repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The comment to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$this->commentRepository->remove($comment);
		$this->emitCommentDeleted($comment);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findById($identifier) {
		$comment = $this->commentRepository->findByIdentifier($identifier);
		return $comment;
	}

	/**
	 * hide's the category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment
	 * @return void
	 */
	public function unPublishComment(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$comment->setSetHidden(1);
		$this->commentRepository->update($comment);
	}

	/**
	 * shows's the hidden category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $category
	 * @return void
	 */
	public function publishComment(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {
		$comment->setSetHidden(0);
		$this->commentRepository->update($comment);
	}

	/**
	 * Signal for Comment created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The Comment
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitCommentCreated(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {

	}

	/**
	 * Signal for Comment deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment The Comment
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitCommentDeleted(\Lelesys\Plugin\News\Domain\Model\Comment $comment) {

	}

}

?>
