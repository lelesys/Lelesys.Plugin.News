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
use \Lelesys\Plugin\News\Domain\Model\File;

/**
 * File controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class FileController extends AbstractNewsController {

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
		try {
			$this->fileService->create($newFile);
			$this->addFlashMessage('Created a new file.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create file at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Updates the given file object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\File $file) {
		try {
			$this->fileService->update($file);
			$this->addFlashMessage('Updated the file.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update file at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given file object from the file repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\File $file) {
		try {
			$this->fileService->delete($file);
			$this->addFlashMessage('Deleted a file.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>