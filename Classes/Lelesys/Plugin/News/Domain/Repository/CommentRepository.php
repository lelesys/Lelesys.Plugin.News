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
 * A repository for Comments
 *
 * @Flow\Scope("singleton")
 */
class CommentRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * Get comment entries
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getCommentEntries() {
		$query = $this->createQuery();
		return $query
						->setOrderings(array('createdDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

}
?>