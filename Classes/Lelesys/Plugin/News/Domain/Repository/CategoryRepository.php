<?php

namespace Lelesys\Plugin\News\Domain\Repository;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Categories
 *
 * @Flow\Scope("singleton")
 */
class CategoryRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * Function to see if category already exists
	 *
	 * @param string $title
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findOneByTitle($title) {
		$query = $this->createQuery();
		return $query
						->matching(
								$query->equals('title', $title)
						)
						->execute();
	}

	/**
	 * Get latest categories
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledLatestCategories() {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('hidden', 0)
						)
						->setOrderings(array('createDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

}

?>