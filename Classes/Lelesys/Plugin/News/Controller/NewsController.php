<?php

namespace Lelesys\Plugin\News\Controller;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use \Lelesys\Plugin\News\Domain\Model\News;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Routing\UriBuilder;

/**
 * News controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class NewsController extends AbstractNewsController {

	/**
	 * News service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\NewsService
	 */
	protected $newsService;

	/**
	 * Category service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CategoryService
	 */
	protected $categoryService;

	/**
	 * Tag service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\TagService
	 */
	protected $tagService;

	/**
	 * Property Mapper
	 *
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * Asset service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * File service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

	/**
	 * Link service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\LinkService
	 */
	protected $linkService;

	/**
	 * NodeType Manager
	 *
	 * @var \TYPO3\TYPO3CR\Domain\Service\NodeTypeManager
	 * @Flow\Inject
	 */
	protected $nodeTypeManager;

	/**
	 * Folder service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FolderService
	 */
	protected $folderService;

	/**
	 * Comment service
	 *
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CommentService
	 */
	protected $commentService;

	/**
	 * Bootstrap
	 *
	 * @var \TYPO3\Flow\Core\Bootstrap
	 * @Flow\Inject
	 */
	protected $bootstrap;

	/**
	 * Shows a list of news
	 *
	 * @param string $category The category
	 * @param string $folder The folder
	 * @param string $tag The tag
	 * @param integer $year News year
	 * @param string $month News month
	 * @return void
	 */
	public function indexAction($category = NULL, $folder = NULL, $tag = NULL, $year = NULL, $month = NULL) {
		$currentNode = $this->request->getInternalArgument('__node');
		$pluginArguments = $this->request->getPluginArguments();
		if (isset($pluginArguments['itemsPerPage'])) {
			$itemsPerPage = (int) $pluginArguments['itemsPerPage'];
		} else {
			$itemsPerPage = '';
		}
		if ($month !== NULL) {
			$allNews = $this->newsService->archiveNewsList($year, $month, $pluginArguments);
		} else {
			if ($this->request->hasArgument('newsBySelection')) {
				$nodeArgument = $this->request->getArgument('newsBySelection');
				$currentNode->setProperty('categoryId', $nodeArgument['category']);
				$currentNode->setProperty('folderId', $nodeArgument['folder']);
			}
			if (($category === NULL) && ($folder === NULL)) {
				$categoryId = $currentNode->getProperty('categoryId');
				$folderId = $currentNode->getProperty('folderId');

				$this->view->assign('folderId', $folderId);
				$this->view->assign('categoryId', $categoryId);
				if ($categoryId !== NULL) {
					$category = $categoryId;
				}
				if ($folderId !== NULL) {
					$folder = $folderId;
				}
			}
			$allNews = $this->newsService->listAllBySelection($category, $folder, $pluginArguments, $tag);
		}
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
		// To show the list of news category
		$this->view->assign('newsComments', $this->commentService->getEnabledComments($allNews));
		$this->view->assign('itemsPerPage', $itemsPerPage);
		$this->view->assign('categories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('baseUri', $this->bootstrap->getActiveRequestHandler()->getHttpRequest()->getBaseUri());
	}

	/**
	 * Shows Archive Date menu
	 *
	 * @return void
	 */
	public function archiveAction() {
		$currentNode = $this->request->getInternalArgument('__node');
		if ($this->request->hasArgument('newsBySelection')) {
			$nodeArgument = $this->request->getArgument('newsBySelection');
			$currentNode->setProperty('categoryId', $nodeArgument['category']);
			$currentNode->setProperty('folderId', $nodeArgument['folder']);
		}
		$categoryId = $currentNode->getProperty('categoryId');
		$folderId = $currentNode->getProperty('folderId');
		$this->view->assign('folderId', $folderId);
		$this->view->assign('categoryId', $categoryId);
		$category = NULL;
		$folder = NULL;
		if ($categoryId !== NULL) {
			$category = $categoryId;
		}
		if ($folderId !== NULL) {
			$folder = $folderId;
		}
		$this->view->assign('archiveView', $this->newsService->archiveDateView($category, $folder));
		$this->view->assign('categories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('folders', $this->folderService->listAll());
	}

	/**
	 * Shows a list of latest news
	 *
	 * @return void
	 */
	public function latestNewsAction() {
		$currentNode = $this->request->getInternalArgument('__node');
		$pluginArguments = $this->request->getPluginArguments();
		if ($this->request->hasArgument('newsBySelection')) {
			$nodeArgument = $this->request->getArgument('newsBySelection');
			$currentNode->setProperty('categoryId', $nodeArgument['category']);
			$currentNode->setProperty('folderId', $nodeArgument['folder']);
		}
		$categoryId = $currentNode->getProperty('categoryId');
		$folderId = $currentNode->getProperty('folderId');

		$this->view->assign('folderId', $folderId);
		$this->view->assign('categoryId', $categoryId);
		$category = NULL;
		$folder = NULL;
		if ($categoryId !== NULL) {
			$category = $categoryId;
		}
		if ($folderId !== NULL) {
			$folder = $folderId;
		}
		$allNews = $this->newsService->listAllBySelection($category, $folder, $pluginArguments);
		$this->view->assign('newsLatestComments', $this->commentService->getEnabledComments($allNews));
		$this->view->assign('categories', $this->categoryService->getEnabledLatestCategories());
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
		$this->view->assign('baseUri', $this->bootstrap->getActiveRequestHandler()->getHttpRequest()->getBaseUri());
	}

	/**
	 * Shows a single news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to show
	 * @return void
	 */
	public function showAction(\Lelesys\Plugin\News\Domain\Model\News $news = NULL) {
		if ($news !== NULL) {
			$related = $this->newsService->related($news);
			$this->view->assign('assetsdetail', $related['assets']);
			$this->view->assign('comments', $related['comments']);
			$this->view->assign('relatedFiles', $related['files']);
			$this->view->assign('relatedLinkData', $this->newsService->show($news));
			$this->view->assign('relatedNews', $related['news']);
			$this->view->assign('categories', $related['categories']);
			$this->view->assign('tags', $news->getTags());
			$this->view->assign('newsdetail', $news);
			$this->view->assign('currentUri', $this->bootstrap->getActiveRequestHandler()->getHttpRequest()->getUri());
		}
	}

	/**
	 * Shows a form for creating a new news object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('folders', $this->folderService->listAll());
		$this->view->assign('relatedNews', $this->newsService->getEnabledNews());
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
	 * @param array $media The media
	 * @param array $file The file
	 * @param array $tags The tag
	 * @param array $relatedLink News related links
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\News $newNews, $media, $file, $relatedLink, $tags) {
		try {
			$this->newsService->create($newNews, $media, $file, $relatedLink, $tags);
			$this->addFlashMessage('Created a new news.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create news at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('startDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('endDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('archiveDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
	}

	/**
	 * Updates the given news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to update
	 * @param array $media The media
	 * @param array $file The file
	 * @param array $relatedLink News related links
	 * @param array $tags The tag
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\News $news, $media, $file, $relatedLink, $tags) {
		try {
			$this->newsService->update($news, $media, $file, $relatedLink, $tags);
			$this->addFlashMessage('Updated the news.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update news at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
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
			$this->newsService->delete($news);
			$this->addFlashMessage('Deleted a news.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId News identinfier
	 * @param \TYPO3\Media\Domain\Model\Image $assetId News asset
	 * @return void
	 */
	public function removeAssetAction($newsId, $assetId) {
		try {
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeAsset($assetId, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the tag of news
	 *
	 * @param string $newsId News identinfier
	 * @param string $tagId News tag
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
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId News identinfier
	 * @param string $linkId News link
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
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId News identinfier
	 * @param \TYPO3\Media\Domain\Model\Document $fileId News file
	 * @return void
	 */
	public function removeRelatedFileAction($newsId, $fileId) {
		try {
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeRelatedFile($fileId, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * hide's the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News object
	 * @return void
	 */
	public function hideNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->hideNews($news);
			$this->addFlashMessage('News is Hidden', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * show's the hidden news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News object
	 * @return void
	 */
	public function showNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->showNews($news);
			$this->addFlashMessage('News is Visible', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Searches news by title
	 *
	 *
	 *
	 */
	public function searchNewsAction() {

	}

	/**
	 * Shows a list of news
	 *
	 * @param string $search Search value
	 * @param integer $recordLimit record limit for news
	 * @return void
	 */
	public function searchResultAction($search = NULL) {
		$pluginArguments = $this->request->getPluginArguments();
		if (isset($pluginArguments['itemsPerPage'])) {
			$itemsPerPage = (int) $pluginArguments['itemsPerPage'];
		} else {
			$itemsPerPage = '';
		}
		$allNews = $this->newsService->searchResult($search, $pluginArguments);
		$this->view->assign('itemsPerPage', $itemsPerPage);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
		$this->view->assign('newsSearched', $allNews);
	}

	/**
	 * Downloads the file
	 *
	 * @param array $file The News files
	 * @return void
	 */
	public function downloadFileAction(array $file) {
		$this->newsService->downloadFile($file);
	}

}

?>