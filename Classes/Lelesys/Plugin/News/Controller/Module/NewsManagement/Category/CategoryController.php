<?php

namespace Lelesys\Plugin\News\Controller\Module\NewsManagement\Category;

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
 * Category controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class CategoryController extends \Lelesys\Plugin\News\Controller\Module\NewsManagementController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CategoryService
	 */
	protected $categoryService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\NewsService
	 */
	protected $newsService;

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
		$this->view->assign('folders', $this->folderService->listAll());
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$this->categoryService->create($newCategory);
			$header = 'Created a new category.';
			$message = $this->translator->translateById('lelesys.plugin.news.add.category', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Cannot create category at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.category', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Updated the category.';
			$message = $this->translator->translateById('lelesys.plugin.news.update.category', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Cannot update category at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.updatecategory', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Deleted a category.';
			$message = $this->translator->translateById('lelesys.plugin.news.delete.category', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Category is Hidden';
			$message = $this->translator->translateById('lelesys.plugin.category.hidden', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Category is Visible';
			$message = $this->translator->translateById('lelesys.plugin.category.visible', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\NeoNews\Domain\Service\Exception $exception) {
			$packageKey = $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
