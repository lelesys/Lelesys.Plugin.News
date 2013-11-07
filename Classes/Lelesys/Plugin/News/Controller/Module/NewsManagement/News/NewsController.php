<?php

namespace Lelesys\Plugin\News\Controller\Module\NewsManagement\News;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use \Lelesys\Plugin\News\Domain\Model\News;

/**
 * News controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class NewsController extends \Lelesys\Plugin\News\Controller\Module\NewsManagementController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\NewsService
	 */
	protected $newsService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CategoryService
	 */
	protected $categoryService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\TagService
	 */
	protected $tagService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\LinkService
	 */
	protected $linkService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FolderService
	 */
	protected $folderService;

	/**
	 * Shows a list of news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The Category
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder The Folder
	 * @param array $filterId The Filter Id
	 * @return void
	 */
	public function indexAction(\Lelesys\Plugin\News\Domain\Model\Category $category = NULL, \Lelesys\Plugin\News\Domain\Model\Folder $folder = NULL, $filterId = NULL) {
		$allNews = $this->newsService->listAllNewsAdmin($category, $folder);
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('categories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('filter', $filterId);
	}

	/**
	 * Shows a single news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to show
	 * @return void
	 */
	public function showAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$related = $this->newsService->related($news);
		$argumentNamespace = $this->request->getArgumentNamespace();
		$this->view->assign('argumentNamespace', $argumentNamespace);
		$this->view->assign('assets', $related['assets']);
		$this->view->assign('comments', $related['comments']);
		$this->view->assign('relatedFiles', $related['files']);
		$this->view->assign('relatedLinkData', $this->newsService->show($news));
		$this->view->assign('relatedNews', $related['news']);
		$this->view->assign('categories', $related['categories']);
		$this->view->assign('tags', $news->getTags());
		$this->view->assign('news', $news);
	}

	/**
	 * Shows a form for creating a new news object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('related', $this->newsService->getEnabledNews());
		$this->view->assign('newsCategories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('tags', $this->tagService->listAll());
	}

	/**
	 * Set property mapper news creation
	 *
	 * @return void
	 */
	public function initializeCreateAction() {
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('dateTime')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('archiveDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('startDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('endDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
	}

	/**
	 * Adds the given new news object to the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $newNews A new news to add
	 * @param array $media
	 * @param array $file
	 * @param array $tags
	 * @param array $relatedLink
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\News $newNews, $media, $file, $relatedLink, $tags) {
		try {
			$this->newsService->create($newNews, $media, $file, $relatedLink, $tags);
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Created a new news.';
			$message = $this->translator->translateById('lelesys.plugin.news.add.news', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Cannot create news at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.add', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Shows a form for editing an existing news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to edit
	 * @return void
	 */
	public function editAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('relatedNews', $this->newsService->listRelatedNews($news));
		$this->view->assign('newsCategories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('newsTags', $news->getTags());
		$this->view->assign('news', $news);
		$this->view->assign('media', $news->getAssets());
		$this->view->assign('files', $news->getFiles());
		$this->view->assign('relatedLinks', $news->getRelatedLinks());
	}

	/**
	 * Set property mapper news creation
	 *
	 * @return void
	 */
	public function initializeUpdateAction() {
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('dateTime')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('archiveDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('startDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('endDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
	}

	/**
	 * Removes the tag of news
	 *
	 * @param string $newsId
	 * @param string $tagId
	 * @return void
	 */
	public function removeTagAction($newsId, $tagId) {
		try {
			$tag = $this->tagService->findById($tagId);
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeTag($tag, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Updates the given news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to update
	 * @param array $media
	 * @param array $file
	 * @param array $relatedLink
	 * @param array $tags
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\News $news, $media, $file, $relatedLink, $tags) {
		try {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$this->newsService->update($news, $media, $file, $relatedLink, $tags);
			$header = 'Updated the news.';
			$message = $this->translator->translateById('lelesys.plugin.news.update.news', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Cannot update news at this time!!.';
			$message = $this->translator->translateById('lelesys.plugin.news.cannot.update', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given news object from the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$this->newsService->delete($news);
			$header = 'Deleted a news.';
			$message = $this->translator->translateById('lelesys.plugin.news.deleted.news', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param \TYPO3\Media\Domain\Model\Image $assetId
	 * @return void
	 */
	public function removeAssetAction($newsId, $assetId) {
		try {
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeAsset($assetId, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param string $linkId
	 * @return void
	 */
	public function removeRelatedLinkAction($newsId, $linkId) {
		try {
			$link = $this->linkService->findById($linkId);
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeRelatedLink($link, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param \TYPO3\Media\Domain\Model\Document $fileId
	 * @return void
	 */
	public function removeRelatedFileAction($newsId, $fileId) {
		try {
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeRelatedFile($fileId, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * hide's the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function hideNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->hideNews($news);
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'News is Hidden';
			$message = $this->translator->translateById('lelesys.plugin.news.hidden', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}


	/**
	 * show's the hidden news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function showNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->showNews($news);
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'News is Visible';
			$message = $this->translator->translateById('lelesys.plugin.news.visible', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$packageKey= $this->settings['flashMessage']['packageKey'];
			$header = 'Sorry, error occured. Please try again later.';
			$message = $this->translator->translateById('lelesys.plugin.news.try.again', array(), NULL, NULL, 'Main', $packageKey);
			$this->addFlashMessage($message, $header, \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Downloads the file
	 *
	 * @param array $file
	 * @return void
	 */
	public function downloadFileAction(array $file) {
		$this->newsService->downloadFile($file);
	}

}

?>