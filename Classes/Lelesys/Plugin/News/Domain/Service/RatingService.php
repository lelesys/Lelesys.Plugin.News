<?php

namespace Lelesys\Plugin\News\Domain\Service;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Lelesys\Plugin\News\Domain\Model\Rating;

/**
 * News controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class RatingService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\RatingRepository
	 */
	protected $ratingRepository;

	/**
	 * @return void
	 */
	public function listAll() {
		return $this->ratingRepository->findAll();
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $newRating
	 * @return void
	 */
	public function add(\Lelesys\Plugin\News\Domain\Model\Rating $newRating) {
		$this->ratingRepository->add($newRating);
		$this->emitRatingCreated($newRating);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Rating $rating) {
		$this->ratingRepository->update($rating);
		$this->emitRatingUpdated($rating);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Rating $rating) {
		$this->ratingRepository->remove($rating);
		$this->emitRatingDeleted($rating);
	}

	/**
	 * Signal for Rating created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating The Rating
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitRatingCreated(\Lelesys\Plugin\News\Domain\Model\Rating $rating) {

	}

	/**
	 * Signal for Rating updated
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating The Rating
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitRatingUpdated(\Lelesys\Plugin\News\Domain\Model\Rating $rating) {

	}

	/**
	 * Signal for Rating deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating The Rating
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitRatingDeleted(\Lelesys\Plugin\News\Domain\Model\Rating $rating) {

	}

}

?>