<?php

namespace Lelesys\Plugin\News\Service;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 * A notification service to send emails
 *
 */
class Notification {

	/**
	 * Settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Template view
	 *
	 * @Flow\Inject
	 * @var \TYPO3\Fluid\View\StandaloneView
	 */
	protected $standaloneView;

	/**
	 * Swiftmailer
	 *
	 * @Flow\Inject
	 * @var \TYPO3\SwiftMailer\Message
	 */
	protected $swiftMailer;

	/**
	 * Injects settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Sends email for comment approval
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $comment Comment for approval
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news
	 * @return void
	 */
	public function sendCommentApprovalNotification(\Lelesys\Plugin\News\Domain\Model\Comment $comment, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->standaloneView->setTemplatePathAndFilename(FLOW_PATH_PACKAGES . $this->settings['notifications']['emailTemplatePath']);
		$this->standaloneView->assign('comment', $comment);
		$this->standaloneView->assign('adminEmail', $news->getCreatedBy());
		$this->standaloneView->assign('news', $news);
		$emailBody = $this->standaloneView->render();
		$toEmail = $news->getCreatedBy()->getPrimaryElectronicAddress()->getIdentifier();
		$mail = new \TYPO3\SwiftMailer\Message();
		$mail->setFrom(array($comment->getEmail() => $comment->getName()))
				->setContentType('text/html')
				->setTo($toEmail)
				->setSubject('Comment Approval')
				->setBody($emailBody)
				->send();
	}

}

?>