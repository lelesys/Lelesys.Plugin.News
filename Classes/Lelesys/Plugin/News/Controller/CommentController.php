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
use \Lelesys\Plugin\News\Domain\Model\Comment;

/**
 * Comment controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CommentController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * Comment service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CommentService
	 */
	protected $commentService;

	/**
	 * Adds the given new comment object to the comment repository
	 *
	 * @Flow\Validate(type="\Lelesys\Captcha\Validators\CaptchaValidator", value="$captcha")
	 * @Flow\Validate(type="NotEmpty", value="$captcha")
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $newComment A new comment to add
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param string $captcha Captcha for comment
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Comment $newComment, \Lelesys\Plugin\News\Domain\Model\News $news, $captcha = NULL) {
		try {
			$this->commentService->create($newComment, $news);
			$array = array("news" => $news);
			$this->addFlashMessage($this->translator->translateById('lelesys.plugin.news.comment.created', array(), NULL, NULL, 'Main', $this->settings['flashMessage']['packageKey']));
			$this->redirect("show", "News", "Lelesys.Plugin.News", $array);
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>