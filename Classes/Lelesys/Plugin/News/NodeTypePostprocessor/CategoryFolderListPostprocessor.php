<?php
namespace Lelesys\Plugin\News\NodeTypePostprocessor;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\NodeTypePostprocessor\NodeTypePostprocessorInterface;
use Lelesys\Plugin\News\Domain\Service\CategoryService;
use Lelesys\Plugin\News\Domain\Service\FolderService;
use TYPO3\TYPO3CR\Domain\Model\NodeType;

/**
 * This Processor updates the Lelesys.Plugin.News:Filterable NodeType
 * to fill in the selector boxes for categories and folders
 */
class CategoryFolderListPostprocessor implements NodeTypePostprocessorInterface {

	/**
	 * @var FolderService
	 * @Flow\Inject
	 */
	protected $folderService;

	/**
	 * @var CategoryService
	 * @Flow\Inject
	 */
	protected $categoryService;

	/**
	 * Returns the processed Configuration
	 *
	 * @param \TYPO3\TYPO3CR\Domain\Model\NodeType $nodeType (uninitialized) The node type to process
	 * @param array $configuration input configuration
	 * @param array $options The processor options
	 * @return void
	 */
	public function process(NodeType $nodeType, array &$configuration, array $options) {
		$folders = $this->folderService->listAll();
		if ($folders->count()) {
			foreach ($folders as $folder) {
				/** @var $folder \Lelesys\Plugin\News\Domain\Model\Folder */
				$configuration['properties']['folderId']['ui']['inspector']['editorOptions']['values'][$folder->getUuid()] = array(
					'label' => $folder->getTitle()
				);
			}
		}
		$categories = $this->categoryService->getEnabledLatestCategories();
		if ($categories->count()) {
			foreach ($categories as $category) {
				/** @var $category \Lelesys\Plugin\News\Domain\Model\Category */
				$configuration['properties']['categoryId']['ui']['inspector']['editorOptions']['values'][$category->getUuid()] = array(
					'label' => $category->getTitle()
				);
			}
		}
	}
}
