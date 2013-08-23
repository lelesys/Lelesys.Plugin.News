<?php

namespace Lelesys\Plugin\News\Domain\Repository;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for News
 *
 * @Flow\Scope("singleton")
 */
class NewsRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * Get news entries
	 *
	 * @param string $folderId Folder
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getNewsEntries($folderId = NULL) {
		if (!empty($folderId)) {
			$query = $this->createQuery();
			return $query->matching(
									$query->equals('folder', $folderId)
							)
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->execute();
		} else {
			$query = $this->createQuery();
			return $query
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->execute();
		}
	}

	/**
	 * Get the news list by category
	 *
	 * @param integer $limitNews
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category The category
	 * @param \Lelesys\Plugin\News\Domain\Model\Folder $folder
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledNewsByCategory($limitNews = NULL, \Lelesys\Plugin\News\Domain\Model\Category $category = NULL, \Lelesys\Plugin\News\Domain\Model\Folder $folder = NULL) {
		if ($folder === NULL) {
			$folder = 0;
		}
		if (!empty($limitNews)) {
			$query = $this->createQuery();
			return $query->matching(
									$query->logicalAnd(
											$query->equals('hidden', 0), $query->logicalOr($query->contains('categories', $category), $query->equals('folder', $folder))
									)
							)
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->setLimit($limitNews)
							->execute();
		} else {
			$query = $this->createQuery();
			return $query->matching(
									$query->logicalAnd(
											$query->equals('hidden', 0), $query->logicalOr($query->contains('categories', $category), $query->equals('folder', $folder))
									)
							)
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->execute();
		}
	}

	/**
	 * Get news entries
	 *
	 * @param integer $limitNews
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledNews($limitNews = NULL) {
		if (!empty($limitNews)) {
			$query = $this->createQuery();
			return $query->matching(
									$query->equals('hidden', 0)
							)
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->setLimit($limitNews)
							->execute();
		} else {
			$query = $this->createQuery();
			return $query->matching(
									$query->equals('hidden', 0)
							)
							->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
							->execute();
		}
	}

	/**
	 * Finds all the news by title
	 *
	 * @param string $searchval
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function searchAll($searchval) {
		$query = $this->createQuery();
		return $query->matching(
								$query->logicalAnd(
										$query->equals('hidden', 0), $query->logicalOr(
												$query->like('title', '%' . $searchval . '%'), $query->like('subTitle', '%' . $searchval . '%'), $query->like('description', '%' . $searchval . '%')
										)
								)
						)
						->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

}

?>