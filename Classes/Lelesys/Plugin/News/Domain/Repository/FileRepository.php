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
 * A repository for Files
 *
 * @Flow\Scope("singleton")
 */
class FileRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 *
	 * @var array
	 */
	protected $defaultOrderings = array('createDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING);

}

?>