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
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface The query result
	 */
	public function getNewsEntries() {
		$query = $this->createQuery();
		return $query
						->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Get news entries
	 *
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledNews() {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('hidden', 0)
						)
						->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Get latest news entries
	 *
	 * @param integer $limitNews
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledLatestNews($limitNews) {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('hidden', 0)
						)
						->setOrderings(array('dateTime' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->setLimit($limitNews)
						->execute();
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