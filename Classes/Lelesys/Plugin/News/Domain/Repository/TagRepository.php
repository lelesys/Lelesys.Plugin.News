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
 * A repository for Tags
 *
 * @Flow\Scope("singleton")
 */
class TagRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * Get  latest tags
	 *
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledLatestTags() {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('hidden', 0)
						)
						->setOrderings(array('createDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}
}
?>