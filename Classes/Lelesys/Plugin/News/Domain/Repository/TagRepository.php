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
 * A repository for Tags
 *
 * @Flow\Scope("singleton")
 */
class TagRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 *
	 * @var array
	 */
	protected $defaultOrderings = array('createDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING);

	/**
	 * Get list of tags
	 *
	 * @param array $pluginArguments Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll($pluginArguments = NULL) {
		$query = $this->createQuery();
		$query->matching($query->equals('hidden', 0));
		if (!empty($pluginArguments['orderBy'])) {
			if ($pluginArguments['sortBy'] === 'DESC') {
				$query->setOrderings(array($pluginArguments['orderBy'] => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING));
			} else {
				$query->setOrderings(array($pluginArguments['orderBy'] => \TYPO3\Flow\Persistence\Generic\Query::ORDER_ASCENDING));
			}
		}
		return $query->execute();
	}

}

?>