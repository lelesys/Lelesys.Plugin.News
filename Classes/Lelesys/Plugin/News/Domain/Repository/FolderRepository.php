<?php

namespace Lelesys\Plugin\News\Domain\Repository;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class FolderRepository extends Repository {

	/**
	 *
	 * @var array
	 */
	protected $defaultOrderings = array('dateTime' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING);

	/**
	 * Get list of folders
	 *
	 * @param array $pluginArguments Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll($pluginArguments = NULL) {
		$query = $this->createQuery();
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