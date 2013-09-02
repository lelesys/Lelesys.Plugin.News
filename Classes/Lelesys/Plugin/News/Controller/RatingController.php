<?php
namespace Lelesys\Plugin\News\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Lelesys\Plugin\News\Domain\Model\Rating;

class RatingController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\RatingService
	 */
	protected $ratingService;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('ratings', $this->ratingService->listAll());
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function showAction(Rating $rating) {
		$this->view->assign('rating', $rating);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $newRating
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Rating $newRating) {
		$news = $newRating->getNews();
		$this->ratingService->add($newRating);
		$this->addFlashMessage('Created a new rating.');
		$this->redirect('show', 'News', NULL, array('news' => $news));
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function editAction(Rating $rating) {
		$this->view->assign('rating', $rating);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function updateAction(Rating $rating) {
		$this->ratingService->update($rating);
		$this->addFlashMessage('Updated the rating.');
		$this->redirect('index');
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function deleteAction(Rating $rating) {
		$this->ratingService->delete($rating);
		$this->addFlashMessage('Deleted a rating.');
		$this->redirect('index');
	}

}

?>