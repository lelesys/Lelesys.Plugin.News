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
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

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
	 * Shows a list of news
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function adminNewsList() {
		$limitNews = $this->settings['limitAdminListNews'];
		return $this->newsRepository->getNewsEntries($limitNews);
	}

	/**
	 * Shows a list of news
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function listAll() {
		$limitNews = $this->settings['limitListNews'];
		return $this->newsRepository->getEnabledNews($limitNews);
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
			if ($singleAsset->getHidden() !== TRUE) {
				$assets[] = $singleAsset;
			}
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
			if ($singleFile->getHidden() !== TRUE) {
				$relatedFiles[] = $singleFile;
			}
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
					if ($asset->getHidden() !== TRUE) {
						$newsAssets[$news->getUuid()][] = $asset;
					}
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
	 * Shows Latest News
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function latestNews() {
		$limitNews = $this->settings['limitLatestNews'];
		return $this->newsRepository->getEnabledNews($limitNews);
	}

	/**
	 * Adds the given new news object to the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $newNews A new news to add
	 * @param array $media
	 * @param array $file
	 * @param array $relatedLink
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\News $newNews, $media, $file, $relatedLink) {
		$mediaPath = $media;
		foreach ($mediaPath as $mediaSource) {
			if (!empty($mediaSource['originalResource']['name'])) {
				$media = $this->propertyMapper->convert($mediaSource, 'Lelesys\Plugin\News\Domain\Model\Asset');
				$this->assetService->create($media);
				$newNews->addAssets($media);
			}
		}
		$filePath = $file;
		$fileName = array();
		foreach ($filePath as $fileSource) {
			if (!empty($fileSource['originalFileResource']['name'])) {
				$file = $this->propertyMapper->convert($fileSource, 'Lelesys\Plugin\News\Domain\Model\File');
				$extension = $file->getOriginalFileResource()->getFileExtension();

				if ($extension == 'pdf' || $extension == 'PDF') {
					$this->pdfToPng($file);
				}
				$this->fileService->create($file);
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
		if ($newNews->getArchiveDate() === NULL) {
			$newNews->setArchiveDate(new \DateTime());
		}
		$this->newsRepository->add($newNews);
	}

	/**
	 * Converts the pdf to png view
	 *
	 * @param type $file
	 */
	public function pdfToPng($file) {
		$PDF_TO_PNG = FLOW_PATH_DATA . 'Persistent/Resources/';
		$myPdf = FLOW_PATH_DATA . 'Persistent/Resources/' . $file->getOriginalFileResource()->getResourcePointer();
		$image = new \Imagick($myPdf);
		$image->thumbnailimage(100, 100, FALSE);
		$image->setResolution(500, 500);
		$image->setImageFormat("png");
		$path = $PDF_TO_PNG . $file->getOriginalFileResource()->getResourcePointer() . '.png';
		$image->writeImage($path);
		unlink($PDF_TO_PNG . $file->getOriginalFileResource()->getResourcePointer() . '.png');
	}

	/**
	 * Updates the given news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to update
	 * @param array $media
	 * @param array $file
	 * @param array $relatedLink
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\News $news, $media, $file, $relatedLink) {
		$news->setUpdatedDate(new \DateTime());
		$mediaPath = $media;
		foreach ($mediaPath as $mediaSource) {
			if (isset($mediaSource['uuid'])) {
				$updateAsset = $this->assetService->findById($mediaSource['uuid']);
				$updateAsset->setCaption($mediaSource['caption']);
				$updateAsset->setCopyRight($mediaSource['copyRight']);
				$updateAsset->setHidden($mediaSource['hidden']);
				$this->assetService->update($updateAsset);
			} else {
				if (!empty($mediaSource['originalResource']['name'])) {
					$media = $this->propertyMapper->convert($mediaSource, 'Lelesys\Plugin\News\Domain\Model\Asset');
					$this->assetService->create($media);
					$news->addAssets($media);
				}
			}
		}
		$filePath = $file;
		foreach ($filePath as $fileSource) {
			if (isset($fileSource['uuid'])) {
				$updateFile = $this->fileService->findById($fileSource['uuid']);
				$updateFile->setTitle($fileSource['title']);
				$updateFile->setDescription($fileSource['description']);
				$updateFile->setHidden($fileSource['hidden']);
				$this->fileService->update($updateFile);
			} else {
				if (!empty($fileSource['originalFileResource']['name'])) {
					$file = $this->propertyMapper->convert($fileSource, 'Lelesys\Plugin\News\Domain\Model\File');
					$this->fileService->create($file);
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
		if ($news->getArchiveDate() === NULL) {
			$news->setArchiveDate(new \DateTime());
		}
		$this->newsRepository->update($news);
	}

	/**
	 * Removes the given news object from the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->newsRepository->remove($news);
	}

	/**
	 * Shows list of news as per month.
	 *
	 * @param integer $year
	 * @param string $month
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function archiveNewsList($year, $month) {
		$nmonth = date('m', strtotime($month));
		$dql = 'SELECT n'
				. ' FROM  Lelesys\Plugin\News\Domain\Model\News n'
				. ' WHERE n.hidden = 0 AND YEAR(n.archiveDate) = ' . $year . ' AND MONTH(n.archiveDate)=' . $nmonth
				. 'ORDER BY n.dateTime DESC';
		$result = $this->doctrintService->runDql($dql, \Doctrine\ORM\Query::HYDRATE_OBJECT);
		return $result;
	}

	/**
	 * Archive Date menu view according to year and month
	 *
	 * @return array $archiveDate
	 */
	public function archiveDateView() {
		$dql = 'SELECT YEAR(n.archiveDate) year, MONTH(n.archiveDate) month, COUNT(n) cnt'
				. ' FROM  Lelesys\Plugin\News\Domain\Model\News n'
				. ' WHERE n.hidden = 0'
				. ' GROUP BY year, month ORDER BY year DESC';

		$result = $this->doctrintService->runDql($dql, \Doctrine\ORM\Query::HYDRATE_ARRAY);
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
		$allRelatedNews = $this->listAll();
		$listRelatedNews = array();
		foreach ($allRelatedNews as $singleNews) {
			if ($news != $singleNews) {
				$listRelatedNews[] = $singleNews;
			}
		}
		return $listRelatedNews;
	}

	/**
	 * removes a asset related to a news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset
	 * @return void
	 */
	public function removeAsset(\Lelesys\Plugin\News\Domain\Model\Asset $asset, \Lelesys\Plugin\News\Domain\Model\News $news) {
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
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file
	 * @return void
	 */
	public function removeRelatedFile(\Lelesys\Plugin\News\Domain\Model\File $File, \Lelesys\Plugin\News\Domain\Model\News $news) {
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
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function searchResult($searchval) {
		if ($searchval !== NULL) {
			return $this->newsRepository->searchAll($searchval);
		}
	}

	/**
	 * return news for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\News $news
	 */
	public function findById($identifier) {
		$news = $this->newsRepository->findByIdentifier($identifier);
		return $news;
	}

}

?>