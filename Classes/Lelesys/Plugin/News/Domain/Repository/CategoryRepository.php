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
 * A repository for Categories
 *
 * @Flow\Scope("singleton")
 */
class CategoryRepository extends \TYPO3\Flow\Persistence\Doctrine\Repository {

	/**
	 * DBAL connection
	 *
	 * @var \Doctrine\DBAL\Driver\PDOConnection
	 */
	protected $connection;

	/**
	 * Injected configuration manager dependency
	 *
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 *
	 * @var array
	 */
	protected $defaultOrderings = array('title' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING);

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

	/**
	 * Get latest categories
	 *
	 * @param string $folderId Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllByFolder($folderId = NULL) {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('folder', $folderId)
						)
						->setOrderings(array('createDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Get latest sub categories from folder and parent category
	 *
	 * @param string $folderId Plugin arguments
	 * @param string $parentCategoryId Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAllByFolderAndCategory($folderId = NULL, $parentCategoryId = NULL) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd(
										$query->equals('folder', $folderId),
										$query->equals('parentCategory', $parentCategoryId))
						)
						->setOrderings(array('createDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
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

	/**
	 * Get parent categories
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function getEnabledParentCategories() {
		$query = $this->createQuery();
		return $query->matching(
								$query->equals('parentCategory', NULL)
						)
						->setOrderings(array('createDate' => \TYPO3\Flow\Persistence\Generic\Query::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Get latest categories
	 *
	 * @param string $folderId The folder id
	 * @return array The query result
	 */
	public function getCategoriesByFolder($folderId) {
		// Connect to DB
		$backendOptions = $this->configurationManager->getConfiguration('Settings', 'TYPO3.Flow.persistence.backendOptions');
		$config = new \Doctrine\DBAL\Configuration();
		$this->connection = \Doctrine\DBAL\DriverManager::getConnection($backendOptions, $config);
		// Run query to get categories
		$statement = "SELECT a.`persistence_object_identifier`, a.`title`,( "
				. "SELECT group_concat(concat(`persistence_object_identifier`,',',`title`) separator ';') "
				. "FROM `lelesys_plugin_news_domain_model_category` WHERE `parentcategory` = a.persistence_object_identifier) as value "
				. "FROM `lelesys_plugin_news_domain_model_category` as a where a.`parentcategory`is null AND `folder` ='" . $folderId . "' group by `persistence_object_identifier`";
		$result = $this->connection->query($statement)->fetchAll();
		return $result;
	}
}
?>
