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
use \Lelesys\Plugin\News\Domain\Model\File;

/**
 * File controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class FileService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\FileRepository
	 */
	protected $fileRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Shows a list of files
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\File
	 */
	public function listAll() {
		return $this->fileRepository->findAll();
	}

	/**
	 * Adds the given new file object to the file repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $newFile A new file to add
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\File $newFile) {
		$this->fileRepository->add($newFile);
	}

	/**
	 * Updates the given file object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$this->fileRepository->update($file);
	}

	/**
	 * Removes the given file object from the file repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file The file to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$this->fileRepository->remove($file);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\File $asset
	 */
	public function findById($identifier) {
		$asset = $this->fileRepository->findByIdentifier($identifier);
		return $asset;
	}

}

?>