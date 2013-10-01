<?php

namespace Lelesys\Plugin\News\Controller;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Lelesys\Plugin\News\Domain\Model\Rating;

class RatingController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

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
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$news = $newRating->getNews();
			$this->ratingService->add($newRating);
			$header = 'Created a new rating.';
			$message = $this->translator->translateById('lelesys.plugin.news.create.rating', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('show', 'News', NULL, array('news' => $news));
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot create rating at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.createrating', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
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
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->ratingService->update($rating);
			$header = 'Updated the rating.';
			$message = $this->translator->translateById('lelesys.plugin.news.update.rating', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot update rating at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.updaterating', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Rating $rating
	 * @return void
	 */
	public function deleteAction(Rating $rating) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->ratingService->delete($rating);
			$header = 'Deleted a rating.';
			$message = $this->translator->translateById('lelesys.plugin.news.delete.rating', array(), NULL, NULL, 'Main', $packageKey);
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