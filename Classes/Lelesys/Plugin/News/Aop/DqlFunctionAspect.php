<?php

namespace Lelesys\Plugin\News\Aop;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */
use TYPO3\Flow\Annotations as Flow;

/**
 *
 * @Flow\Aspect
 * @Flow\Scope("singleton")
 */
class DqlFunctionAspect {

	/**
	 * Add DQL function
	 *
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
	 * @Flow\Before("method(TYPO3\Flow\Persistence\Doctrine\Service->runDql())")
	 * @return void
	 */
	public function addDqlFunction(\TYPO3\Flow\Aop\JoinPointInterface $joinPoint) {
		$entityManager = \TYPO3\Flow\Reflection\ObjectAccess::getProperty($joinPoint->getProxy(), 'entityManager', TRUE);
		$configuration = \TYPO3\Flow\Reflection\ObjectAccess::getProperty($entityManager, 'config', TRUE);
		$configuration->addCustomStringFunction('DAY', 'Lelesys\Plugin\News\Doctrine\Query\Mysql\Day');
		$configuration->addCustomStringFunction('MONTH', 'Lelesys\Plugin\News\Doctrine\Query\Mysql\Month');
		$configuration->addCustomStringFunction('YEAR', 'Lelesys\Plugin\News\Doctrine\Query\Mysql\Year');
	}

}

?>