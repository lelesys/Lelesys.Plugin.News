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
use \Lelesys\Plugin\News\Domain\Model\News;
use \TYPO3\Media\Domain\Model\Image;

/**
 * News controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class NewsService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\NewsRepository
	 */
	protected $newsRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Media\Domain\Repository\ImageRepository
	 */
	protected $imageRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Media\Domain\Repository\AssetRepository
	 */
	protected $assetRepository;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\LinkService
	 */
	protected $linkService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Resource\ResourceManager
	 */
	protected $resourceManager;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\TagService
	 */
	protected $tagService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FolderService
	 */
	protected $folderService;

	/**
	 * @var array
	 */
	protected $settings;

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
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\Doctrine\Service
	 */
	protected $doctrintService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Shows the list of news by category
	 *
	 * @param string $category The category
	 * @param string $folder
	 * @param string $tag
	 * @param array $pluginArguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllBySelection($category = NULL, $folder = NULL, $pluginArguments = array(), $tag = NULL) {
		return $this->newsRepository->getEnabledNewsBySelection($category, $folder, $pluginArguments, $tag);
	}

	/**
	 * Shows the list of news by category
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @param array $pluginArguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllNewsAdmin(\Lelesys\Plugin\News\Domain\Model\Category $category = NULL, \Lelesys\Plugin\News\Domain\Model\Folder $folder = NULL) {
		return $this->newsRepository->getNewsAdmin($category, $folder);
	}

	/**
	 * List of related news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return array $related
	 */
	public function related(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$related = array();
		$assets = array();
		foreach ($news->getAssets() as $singleAsset) {
			$assets[] = $singleAsset;
		}
		$comments = array();
		foreach ($news->getComments() as $singleComment) {
			if ($singleComment->getSetHidden() !== TRUE) {
				$comments[] = $singleComment;
			}
		}
		$categories = array();
		foreach ($news->getCategories() as $singleCategory) {
			if ($singleCategory->getHidden() !== TRUE) {
				$categories[] = $singleCategory;
			}
		}
		$relatedNews = array();
		foreach ($news->getRelatedNews() as $singleNews) {
			if ($singleNews->getHidden() !== TRUE) {
				$relatedNews[] = $singleNews;
			}
		}
		$relatedFiles = array();
		foreach ($news->getFiles() as $singleFile) {
			$relatedFiles[] = $singleFile;
		}
		$related['assets'] = $assets;
		$related['comments'] = $comments;
		$related['news'] = $relatedNews;
		$related['categories'] = $categories;
		$related['files'] = $relatedFiles;
		return $related;
	}

	/**
	 * News assets
	 * @param \Lelesys\Plugin\News\Domain\Model\News $newsObj
	 *
	 * @return array $newsAssets
	 */
	public function assetsForNews($newsObj) {
		$newsAssets = array();
		foreach ($newsObj as $news) {
			$assets = $news->getAssets();
			if (count($assets) > 0) {
				foreach ($assets as $asset) {
					$newsAssets[$news->getUuid()][] = $asset;
				}
			}
		}
		return $newsAssets;
	}

	/**
	 * Shows a list of news
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return array $combineLinkData
	 */
	public function show(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$linkData = array();
		$combineLinkData = array();
		$relatedLinks = $news->getRelatedLinks();
		foreach ($relatedLinks as $relatedLink) {
			if ($relatedLink->getHidden() !== TRUE) {
				$email = $relatedLink->getUri();
				$title = $relatedLink->getTitle();
				$pattern = "/[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})/";
				if (!preg_match($pattern, $email)) {
					$linkData['email'] = $email;
					$linkData['emailTitle'] = '';
				} else {
					$linkData['email'] = 'mailto:' . $email;
					$linkData['emailTitle'] = $email;
				}
				$linkData['title'] = $title;
				$linkData['hidden'] = $relatedLink->getHidden();
				$combineLinkData[] = $linkData;
			}
		}
		return $combineLinkData;
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
	public function create(\Lelesys\Plugin\News\Domain\Model\News $newNews, $media, $file, $relatedLink, $tags) {
		if (!empty($tags['title'])) {
			$tagsArray = array_unique(\TYPO3\Flow\Utility\Arrays::trimExplode(',', strtolower($tags['title'])));
			foreach ($tagsArray as $tag) {
				$existTag = $this->tagService->findTagByName($tag);
				if (!empty($existTag)) {
					$newNews->addTags($existTag);
				} else {
					$newTag = new \Lelesys\Plugin\News\Domain\Model\Tag();
					$newTag->setTitle($tag);
					$this->tagService->create($newTag);
					$newNews->addTags($newTag);
				}
			}
		}
		$mediaPath = $media;
		foreach ($mediaPath as $mediaSource) {
			if (!empty($mediaSource['resource']['name'])) {
				$resource = $this->propertyMapper->convert($mediaSource['resource'], 'TYPO3\Flow\Resource\Resource');
				$media = new \TYPO3\Media\Domain\Model\Image($resource);
				$media->setCaption($mediaSource['caption']);
				$this->imageRepository->add($media);
				$newNews->addAssets($media);
			}
		}
		$filePath = $file;
		$fileName = array();
		foreach ($filePath as $fileSource) {
			if (!empty($fileSource['resource']['name'])) {
				$resource = $this->propertyMapper->convert($fileSource['resource'], 'TYPO3\Flow\Resource\Resource');
				$file = new \TYPO3\Media\Domain\Model\Document($resource);
				$this->assetRepository->add($file);
				$newNews->addFiles($file);
			}
			$resourceFile = $newNews->getFiles();
			foreach ($resourceFile as $file) {

			}
		}
		$related = $relatedLink;
		foreach ($related as $link) {
			if (!empty($link['relatedUri'])) {
				$newLink = new \Lelesys\Plugin\News\Domain\Model\Link();
				$newLink->setTitle($link['relatedUriTitle']);
				$newLink->setUri($link['relatedUri']);
				$newLink->setDescription($link['relatedUriDescription']);
				$this->linkService->create($newLink);
				$newNews->addRelatedLinks($newLink);
			}
		}
		$this->newsRepository->add($newNews);
		$this->emitNewsCreated($newNews);
	}

	/**
	 * Updates the given news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to update
	 * @param array $media
	 * @param array $file
	 * @param array $tags
	 * @param array $relatedLink
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\News $news, $media, $file, $relatedLink, $tags) {
		if (!empty($tags['title'])) {
			$tagsArray = array_unique(\TYPO3\Flow\Utility\Arrays::trimExplode(',', strtolower($tags['title'])));
			foreach ($tagsArray as $tag) {
				$existTag = $this->tagService->findTagByName($tag);
				if (!empty($existTag)) {
					$newsTags = $news->getTags()->toArray();
					if (!in_array($existTag, $newsTags)) {
						$news->addTags($existTag);
					}
				} else {
					$newTag = new \Lelesys\Plugin\News\Domain\Model\Tag();
					$newTag->setTitle($tag);
					$this->tagService->create($newTag);
					$news->addTags($newTag);
				}
			}
		}
		$news->setUpdatedDate(new \DateTime());
		$mediaPath = $media;
		foreach ($mediaPath as $mediaSource) {
			if (!empty($mediaSource['uuid'])) {
				$updateAsset = $this->propertyMapper->convert($mediaSource['uuid']['__identity'], '\TYPO3\Media\Domain\Model\Image');
				$updateAsset->setCaption($mediaSource['caption']);
				$this->imageRepository->update($updateAsset);
			} else {
				if (!empty($mediaSource['resource']['name'])) {
					$resource = $this->propertyMapper->convert($mediaSource['resource'], 'TYPO3\Flow\Resource\Resource');
					$media = new \TYPO3\Media\Domain\Model\Image($resource);
					$media->setCaption($mediaSource['caption']);
					$this->imageRepository->add($media);
					$news->addAssets($media);
				}
			}
		}
		$filePath = $file;
		foreach ($filePath as $fileSource) {
			if (isset($fileSource['uuid'])) {
				$updateFile = $this->propertyMapper->convert($fileSource['uuid']['__identity'], '\TYPO3\Media\Domain\Model\Document');
				$updateFile->setTitle($fileSource['title']);
				$this->assetRepository->update($updateFile);
			} else {
				if (!empty($fileSource['resource']['name'])) {
					$resource = $this->propertyMapper->convert($fileSource['resource'], 'TYPO3\Flow\Resource\Resource');
					$file = new \TYPO3\Media\Domain\Model\Document($resource);
					$this->assetRepository->add($file);
					$news->addFiles($file);
				}
			}
		}
		$related = $relatedLink;
		foreach ($related as $link) {
			if (isset($link['uuid'])) {
				$updateLink = $this->linkService->findById($link['uuid']);
				$updateLink->setUri($link['relatedUri']);
				$updateLink->setTitle($link['relatedUriTitle']);
				$updateLink->setDescription($link['relatedUriDescription']);
				$updateLink->setHidden($link['hidden']);
				$this->linkService->update($updateLink);
			} else {
				if (!empty($link['relatedUri'])) {
					$newLink = new \Lelesys\Plugin\News\Domain\Model\Link();
					$newLink->setTitle($link['relatedUriTitle']);
					$newLink->setUri($link['relatedUri']);
					$newLink->setDescription($link['relatedUriDescription']);
					$newLink->setHidden($link['hidden']);
					$this->linkService->create($newLink);
					$news->addRelatedLinks($newLink);
				}
			}
		}
		$this->newsRepository->update($news);
		$this->emitNewsUpdated($news);
	}

	/**
	 * Removes the given news object from the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->newsRepository->remove($news);
		$this->emitNewsDeleted($news);
	}

	/**
	 * Shows list of news as per month.
	 *
	 * @param integer $year
	 * @param string $month
	 * @param array $pluginArguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function archiveNewsList($year, $month, $pluginArguments) {
		return $this->newsRepository->archiveNewsList($year, $month, $pluginArguments);
	}

	/**
	 * Archive Date menu view according to year and month
	 *
	 * @return array $archiveDate
	 */
	public function archiveDateView() {
		$result = $this->newsRepository->archiveDateView();
		$archiveDate = array();
		foreach ($result as $archive) {
			$archiveDate[$archive['year']][date("F", strtotime(date("d-" . $archive['month'] . "-y")))] = $archive['cnt'];
		}
		return $archiveDate;
	}

	/**
	 * List all related news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return array $listRelatedNews
	 */
	public function listRelatedNews(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$allRelatedNews = $this->newsRepository->getEnabledNews();
		$listRelatedNews = array();
		foreach ($allRelatedNews as $singleNews) {
			if ($news != $singleNews) {
				$listRelatedNews[] = $singleNews;
			}
		}
		return $listRelatedNews;
	}

	/**
	 * removes a tags related to a news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @return void
	 */
	public function removeTag(\Lelesys\Plugin\News\Domain\Model\Tag $tag, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->removeTags($tag);
		$this->newsRepository->update($news);
		$this->persistenceManager->persistAll();
	}

	/**
	 * removes a asset related to a news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param \TYPO3\Media\Domain\Model\Image $asset
	 * @return void
	 */
	public function removeAsset(\TYPO3\Media\Domain\Model\Image $asset, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->removeAssets($asset);
		$this->newsRepository->update($news);
		$this->persistenceManager->persistAll();
	}

	/**
	 * removes a asset related link of the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link
	 * @return void
	 */
	public function removeRelatedLink(\Lelesys\Plugin\News\Domain\Model\Link $link, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->removeRelatedLinks($link);
		$this->newsRepository->update($news);
		$this->persistenceManager->persistAll();
	}

	/**
	 * removes a asset related link of the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param \TYPO3\Media\Domain\Model\Document $file
	 * @return void
	 */
	public function removeRelatedFile(\TYPO3\Media\Domain\Model\Document $File, \Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->removeFiles($File);
		$this->newsRepository->update($news);
		$this->persistenceManager->persistAll();
	}

	/**
	 * hide's the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function hideNews(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->setHidden(1);
		$this->newsRepository->update($news);
	}

	/**
	 * shows's the hidden news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function showNews(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$news->setHidden(0);
		$this->newsRepository->update($news);
	}

	/**
	 * Searches news by title
	 *
	 * @param string $searchval
	 * @param array $pluginArguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function searchResult($searchval, $pluginArguments) {
		if ($searchval !== NULL) {
			return $this->newsRepository->searchAll($searchval, $pluginArguments);
		}
	}

	/**
	 * return news for given identifier
	 *
	 * @param string $identifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findById($identifier) {
		$news = $this->newsRepository->findByIdentifier($identifier);
		return $news;
	}

	/**
	 * return news for given identifier
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll() {
		return $this->newsRepository->getEnabledNewsBySelection();
	}

	/**
	 * return news for given identifier
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledNews() {
		return $this->newsRepository->getEnabledNews();
	}

	/**
	 * Downloads the file
	 *
	 * @param array $file
	 * @return void
	 */
	public function downloadFile(array $file) {
		$fileResource = $this->propertyMapper->convert($file['__identity'], '\TYPO3\Flow\Resource\Resource');
		$filePath = $this->resourceManager->getPersistentResourcesStorageBaseUri() . $fileResource->getResourcePointer()->getHash();
		$fileMimeType = mime_content_type($filePath);
		header('Content-Description: File Transfer');
		header('Content-Type: ' . $fileMimeType);
		header('Content-Disposition: attachment; filename=' . basename($fileResource->getFilename()));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		ob_clean();
		flush();
		readfile($filePath);
	}

	/**
	 * Signal for news created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitNewsCreated(\Lelesys\Plugin\News\Domain\Model\News $news) {

	}

	/**
	 * Signal for news updated
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitNewsUpdated(\Lelesys\Plugin\News\Domain\Model\News $news) {

	}

	/**
	 * Signal for news deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The News
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitNewsDeleted(\Lelesys\Plugin\News\Domain\Model\News $news) {

	}

}

?>