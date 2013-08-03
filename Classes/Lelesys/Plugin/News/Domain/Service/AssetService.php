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
use \Lelesys\Plugin\News\Domain\Model\Asset;

/**
 * Asset controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class AssetService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\AssetRepository
	 */
	protected $assetRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Shows a list of assets
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Asset
	 */
	public function listAll() {
		return $this->assetRepository->findAll();
	}

	/**
	 * Adds the given new asset object to the asset repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $newAsset A new asset to add
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\Asset $newAsset) {
		$this->assetRepository->add($newAsset);
	}

	/**
	 * Updates the given asset object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assetRepository->update($asset);
	}

	/**
	 * Removes the given asset object from the asset repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assetRepository->remove($asset);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\Asset $asset
	 */
	public function findById($identifier) {
		$asset = $this->assetRepository->findByIdentifier($identifier);
		return $asset;
	}

}

?>
