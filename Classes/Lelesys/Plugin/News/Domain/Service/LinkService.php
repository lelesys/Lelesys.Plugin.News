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
use \Lelesys\Plugin\News\Domain\Model\Link;

/**
 * Link controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class LinkService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\LinkRepository
	 */
	protected $linkRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Shows a list of links
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Link
	 */
	public function listAll() {
		return $this->linkRepository->findAll();
	}

	/**
	 * Adds the given new link object to the link repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $newLink A new link to add
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\Link $newLink) {
		$this->linkRepository->add($newLink);
	}

	/**
	 * Updates the given link object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link The link to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$this->linkRepository->update($link);
	}

	/**
	 * Removes the given link object from the link repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link The link to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$this->linkRepository->remove($link);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\Link
	 */
	public function findById($identifier) {
		$asset = $this->linkRepository->findByIdentifier($identifier);
		return $asset;
	}

}

?>