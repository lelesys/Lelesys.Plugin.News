<?php

namespace Lelesys\Plugin\News\Domain\Service;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Lelesys\Plugin\News\Domain\Model\Folder;

class FolderService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\FolderRepository
	 */
	protected $folderRepository;

	/**
	 * @return void
	 */
	public function listAll() {
		return $this->folderRepository->findAll();
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $newFolder
	 * @return void
	 */
	public function add(\Lelesys\Plugin\News\Domain\Model\Folder $newFolder) {
		$this->folderRepository->add($newFolder);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {
		$this->folderRepository->update($folder);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {
		$this->folderRepository->remove($folder);
	}

	/**
	 * return folder for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\Folder
	 */
	public function findById($identifier) {
		return $this->folderRepository->findByIdentifier($identifier);
	}

}

?>