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
use \Lelesys\Plugin\News\Domain\Model\File;

/**
 * File controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class FileController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

	/**
	 * Adds the given new file object to the file repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $newFile A new file to add
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\File $newFile) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->fileService->create($newFile);
			$header = 'Created a new file.';
			$message = $this->translator->translateById('lelesys.plugin.news.add.file', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot create file at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.createfile', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
		}
	}

	/**
	 * Updates the given file object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->fileService->update($file);
			$header = 'Updated the file.';
			$message = $this->translator->translateById('lelesys.plugin.news.update.file', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Cannot update file at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.updatefile', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
		}
	}

	/**
	 * Removes the given file object from the file repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$packageKey = $this->settings['flashMessage']['packageKey'];
		try {
			$this->fileService->delete($file);
			$header = 'Deleted a file.';
			$message = $this->translator->translateById('lelesys.plugin.news.delete.file', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>