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
	 * List of folders
	 *
	 * @param array $pluginArguments Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll($pluginArguments = NULL) {
		return $this->folderRepository->listAll($pluginArguments);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $newFolder
	 * @return void
	 */
	public function add(\Lelesys\Plugin\News\Domain\Model\Folder $newFolder) {
		$this->folderRepository->add($newFolder);
		$this->emitFolderCreated($newFolder);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {
		$this->folderRepository->update($folder);
		$this->emitFolderUpdated($folder);
	}

	/**
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {
		$this->folderRepository->remove($folder);
		$this->emitFolderDeleted($folder);
	}

	/**
	 * return folder for given identifier
	 *
	 * @param string $identifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findById($identifier) {
		return $this->folderRepository->findByIdentifier($identifier);
	}

	/**
	 * Signal for Folder created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder The Folder
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitFolderCreated(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {

	}

	/**
	 * Signal for Folder updated
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder The Folder
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitFolderUpdated(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {

	}

	/**
	 * Signal for Folder deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder The Folder
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitFolderDeleted(\Lelesys\Plugin\News\Domain\Model\Folder $folder) {

	}

}

?>