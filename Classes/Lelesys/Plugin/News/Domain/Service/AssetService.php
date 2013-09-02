<?php

namespace Lelesys\Plugin\News\Domain\Service;

/* *
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
	 * @var \TYPO3\Flow\Object\ObjectManagerInterface
	 * @Flow\Inject
	 */
	protected $objectManager;

	/**
	 * @var \TYPO3\Flow\Resource\ResourceManager
	 * @Flow\Inject
	 */
	protected $resourceManager;

	/**
	 * Inject settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Shows a list of assets
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
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
		$this->emitAssetCreated($newAsset);
	}

	/**
	 * Updates the given asset object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assetRepository->update($asset);
		$this->emitAssetUpdated($asset);
	}

	/**
	 * Removes the given asset object from the asset repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The asset to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assetRepository->remove($asset);
		$this->emitAssetDeleted($asset);
	}

	/**
	 * return asset for given identifier
	 *
	 * @param string $identifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findById($identifier) {
		$asset = $this->assetRepository->findByIdentifier($identifier);
		return $asset;
	}

	/**
	 * Sets thumbnail and print resource for given image
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset  $media
	 * @return void
	 */
	public function setThumbnailAndPrint(\Lelesys\Plugin\News\Domain\Model\Asset $media) {
		$fileDimensions = getimagesize(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getResourcePointer());
		$width = $fileDimensions[0];
		$height = $fileDimensions[1];
		if (($width > $height) || ($width === $height)) {
			if ($width > $this->settings['digitalAsset']['carouselWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['carouselWidth'], 1);
			} else {
				// write code to put image on white background and make the total width as 112
				$media->setCarouselResource($media->getOriginalResource());
			}
			if ($width > $this->settings['digitalAsset']['thumbnailWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['thumbnailWidth'], 1);
			} else {
				$media->setThumbnailResource($media->getOriginalResource());
			}
			if ($width > $this->settings['digitalAsset']['iconWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['iconWidth'], 1);
			} else {
				$media->setIconResource($media->getOriginalResource());
			}
		} else {
			// height > width
			if ($height > $this->settings['digitalAsset']['carouselWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['carouselWidth'], 1);
			} else {
				// create image on white background, total width comes to 112
				$media->setCarouselResource($media->getOriginalResource());
			}
			if ($height > $this->settings['digitalAsset']['thumbnailWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['thumbnailWidth'], 1);
			} else {
				$media->setThumbnailResource($media->getOriginalResource());
			}
			if ($height > $this->settings['digitalAsset']['iconWidth']) {
				$this->createThumbnailAndPrint($media, $this->settings['digitalAsset']['iconWidth'], 1);
			} else {
				$media->setIconResource($media->getOriginalResource());
			}
		}
	}

	/**
	 * Creates thumbnail and print resource for given image
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset
	 * @param integer $dimension
	 * @param integer $option
	 * @return void
	 */
	public function createThumbnailAndPrint(\Lelesys\Plugin\News\Domain\Model\Asset $asset, $dimension, $option = NULL) {
		$imagine = $this->objectManager->get('Imagine\Image\ImagineInterface');
		$imagineImage = $imagine->open(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getResourcePointer());
		if ($option === 1) {
			$aspectedHeight = $this->getCalculatedHeight(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getResourcePointer(), $dimension);
			$box = $this->objectManager->get('Imagine\Image\Box', $dimension, $aspectedHeight);
		} else {
			$aspectedWidth = $this->getCalculatedWidth(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getResourcePointer(), $dimension);
			$box = $this->objectManager->get('Imagine\Image\Box', $aspectedWidth, $dimension);
		}
		$imagineImage->thumbnail($box)->save(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getFileName());
		$resource = $this->resourceManager->importResource(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getFileName());
		if ($dimension === $this->settings['digitalAsset']['carouselWidth']) {
			$asset->setCarouselResource($resource);
		}
		if ($dimension === $this->settings['digitalAsset']['thumbnailWidth']) {
			$asset->setThumbnailResource($resource);
		}
		if ($dimension === $this->settings['digitalAsset']['iconWidth']) {
			$asset->setIconResource($resource);
		}
		unlink(FLOW_PATH_DATA . 'Persistent/Resources/' . $asset->getOriginalResource()->getFileName());
	}

	/**
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $media
	 * @param integer $dimension
	 */
	public function createResource(\Lelesys\Plugin\News\Domain\Model\Asset $media, $dimension) {
		$imagine = $this->objectManager->get('Imagine\Image\ImagineInterface');
		$imagineImage = $imagine->open(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getResourcePointer());
		if ($dimension === 150) {
			$aspectedHeight = $this->getCalculatedHeight(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getResourcePointer(), $dimension);
			$box = $this->objectManager->get('Imagine\Image\Box', $dimension, $aspectedHeight);
		} else {
			$aspectedWidth = $this->getCalculatedWidth(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getResourcePointer(), $dimension);
			$box = $this->objectManager->get('Imagine\Image\Box', $aspectedWidth, $dimension);
		}
		$imagineImage->thumbnail($box)->save(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getFileName());
		$resource = $this->resourceManager->importResource(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getFileName());
		$media->setResource($resource);
		unlink(FLOW_PATH_DATA . 'Persistent/Resources/' . $media->getOriginalResource()->getFileName());
	}

	/**
	 * Returns desired height for thumbnail
	 *
	 * @param string $file
	 * @param integer $aspectedWidth
	 * @return integer Desired Height
	 */
	public function getCalculatedHeight($file, $aspectedWidth) {
		$fileDimensions = getimagesize($file);
		$width = $fileDimensions[0];
		$height = $fileDimensions[1];
		$aspectedHeight = ceil($aspectedWidth * $height) / $width;
		return $aspectedHeight;
	}

	/**
	 * Returns desired width for thumbnail
	 *
	 * @param string $file
	 * @param integer $aspectedHeight
	 * @return integer Aspected Width
	 */
	public function getCalculatedWidth($file, $aspectedHeight) {
		$fileDimensions = getimagesize($file);
		$width = $fileDimensions[0];
		$height = $fileDimensions[1];
		$aspectedWidth = ceil($aspectedHeight * $width) / $height;
		return $aspectedWidth;
	}

	/**
	 * Signal for Asset created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The Asset
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitAssetCreated(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {

	}

	/**
	 * Signal for Asset updated
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The Asset
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitAssetUpdated(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {

	}

	/**
	 * Signal for Asset deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset The Asset
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitAssetDeleted(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {

	}

}

?>