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
use \Lelesys\Plugin\News\Domain\Model\Category;

/**
 * Category service for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CategoryService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Shows a list of categories for admin
	 *
	 * @param array $pluginArguments Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll($pluginArguments = NULL) {
		return $this->categoryRepository->listAll($pluginArguments);
	}

	/**
	 * Shows a list of categories by folder
	 *
	 * @param string $folderId Folder Id to search its categories
	 * @param string $parentCategoryId ParentCategory id
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllByFolderAndCategory($folderId = NULL, $parentCategoryId = NULL) {
		return $this->categoryRepository->listAllByFolderAndCategory($folderId, $parentCategoryId);
	}

	/**
	 * Shows a list of categories by folder and lists the sub-categories if parent category is also selected.
	 *
	 * @param string $folderId Folder Id to search its categories
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllByFolder($folderId = NULL) {
		return $this->categoryRepository->listAllByFolder($folderId);
	}

	/**
	 * Shows a list of categories for admin
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledLatestCategories() {
		return $this->categoryRepository->getEnabledLatestCategories();
	}

	/**
	 * Shows a list of categories for admin
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledParentCategories() {
		return $this->categoryRepository->getEnabledParentCategories();
	}

	/**
	 * Shows a single category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to show
	 * @return \Lelesys\Plugin\News\Domain\Model\News $enabledNews
	 */
	public function getNewsByCategory(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$enabledNews = array();
		foreach ($category->getNews() as $news) {
			if ($news->getHidden() !== TRUE) {
				$enabledNews[] = $news;
			}
		}
		return $enabledNews;
	}

	/**
	 * Adds the given new category object to the category repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $newCategory A new category to add
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\Category $newCategory) {
		$newCategory->setCreateDate(new \DateTime());
		$newCategory->setUpdatedDate(new \DateTime());
		$newCategory->setHidden(0);
		$this->categoryRepository->add($newCategory);
		$this->emitCategoryCreated($newCategory);
	}

	/**
	 * Updates the given category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$category->setUpdatedDate(new \DateTime());
		$this->categoryRepository->update($category);
		$this->emitCategoryUpdated($category);
	}

	/**
	 * Removes the given category object from the category repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		if (count($category->getChildren()) > 0) {
			foreach ($category->getChildren() as $child) {
				$child->setParentCategory(NULL);
				$this->update($child);
			}
		}
		$this->categoryRepository->remove($category);
		$this->emitCategoryDeleted($category);
	}

	/**
	 * List all parent categories
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return array $listCategory
	 */
	public function listParentCategory(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$allCategory = $this->getEnabledLatestCategories();
		$listCategory = array();
		$children = array();
		foreach ($category->getChildren() as $child) {
			$children[] = $child;
		}
		foreach ($allCategory as $singleCategory) {
			if ($category != $singleCategory) {
				if (in_array($singleCategory, $children)) {
				} else {
					$listCategory[] = $singleCategory;
				}
			}
		}
		return $listCategory;
	}

	/**
	 * hide's the category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function hideCategory(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$category->setHidden(1);
		$this->categoryRepository->update($category);
	}

	/**
	 * shows's the hidden category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function showCategory(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$category->setHidden(0);
		$this->categoryRepository->update($category);
	}

	/**
	 * Checks the category title
	 *
	 * @param string $title
	 */
	public function checkTitle($title) {
		return $this->categoryRepository->findOneByTitle(trim($title));
	}

	/**
	 * Signal for category created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The Category
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitCategoryCreated(\Lelesys\Plugin\News\Domain\Model\Category $category) {

	}

	/**
	 * Signal for category updated
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The Category
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitCategoryUpdated(\Lelesys\Plugin\News\Domain\Model\Category $category) {

	}

	/**
	 * Signal for category deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The Category
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitCategoryDeleted(\Lelesys\Plugin\News\Domain\Model\Category $category) {

	}

	/**
	 * Shows a list of categories for admin
	 *
	 * @param $folderId Folder id
	 * @return array The array of parents-categories and its sub-categories
	 */
	public function getCategoriesByFolder($folderId) {
		$results = $this->categoryRepository->getCategoriesByFolder($folderId);
		if (!empty($results)) {
			$categoryTree = array();
			foreach ($results as $result) {
				$subCategories = array();
				$category = array();
				$subCategories = explode(';', $result['value']);
				foreach ($subCategories as $subCategory) {
					$category[] = explode(',', $subCategory);
				}
				unset($result['value']);
				$result['subCatagories'] = $category;
				$categoryTree[] = $result;
			}
			return $categoryTree;
		}
	}

}

?>