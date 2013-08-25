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
use \Lelesys\Plugin\News\Domain\Model\Category;

/**
 * Category controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CategoryController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CategoryService
	 */
	protected $categoryService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FolderService
	 */
	protected $folderService;

	/**
	 * Shows a list of categories
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('categories', $this->categoryService->listAll());
	}

	/**
	 * Shows a list of categories
	 *
	 * @return void
	 */
	public function adminListAction() {
		$this->view->assign('categories', $this->categoryService->AdminCategoryList());
	}

	/**
	 * Shows news list By Category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to show
	 * @return void
	 */
	public function showAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$this->view->assign('categoryNews', $this->categoryService->getNewsByCategory($category));
	}

	/**
	 * Shows a form for creating a new category object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('newsParentCategory', $this->categoryService->listAll());
	}

	/**
	 * Adds the given new category object to the category repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $newCategory A new category to add
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\Category $newCategory) {
		try {
			$this->categoryService->create($newCategory);
			$this->addFlashMessage('Created a new category.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create category at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Shows a form for editing an existing category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to edit
	 * @return void
	 */
	public function editAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('newsParentCategory', $this->categoryService->listParentCategory($category));
		$this->view->assign('category', $category);
	}

	/**
	 * Updates the given category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to update
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		try {
			$this->categoryService->update($category);
			$this->addFlashMessage('Updated the category.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update category at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given category object from the category repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		try {
			$this->categoryService->delete($category);
			$this->addFlashMessage('Deleted a category.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * hide's the category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function hideCategoryAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		try {
			$this->categoryService->hideCategory($category);
			$this->addFlashMessage('Category is Hidden', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * show's the hidden category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function showCategoryAction(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		try {
			$this->categoryService->showCategory($category);
			$this->addFlashMessage('Category is Visible', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * checks the title
	 *
	 * @param string $categoryTitle
	 * @return void
	 */
	public function checkTitleAction($categoryTitle) {
		$title = $this->categoryService->checkTitle($categoryTitle);
		echo count($title);
		exit;
	}

}

?>