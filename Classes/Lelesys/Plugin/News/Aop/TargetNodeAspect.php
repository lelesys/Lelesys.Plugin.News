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
 * @Flow\Aspect
 */
class TargetNodeAspect {

	/**
	 * @var \TYPO3\TYPO3CR\Domain\Repository\NodeDataRepository
	 * @Flow\Inject
	 */
	protected $nodeDataRepository;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\TYPO3CR\Domain\Service\ContextFactoryInterface
	 */
	protected $contextFactory;

	/**
	 * Injects the configuration settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @Flow\Before("method(TYPO3\Flow\Mvc\Routing\UriBuilder->build())")
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
	 * @return void
	 */
	public function addTargetNodeToArguments(\TYPO3\Flow\Aop\JoinPointInterface $joinPoint) {
		if (!isset($this->settings['targetNodeMappings']) || !is_array($this->settings['targetNodeMappings'])) {
			return;
		}
		$uriBuilder = $joinPoint->getProxy();
		$arguments = $joinPoint->getMethodArgument('arguments');

		foreach ($this->settings['targetNodeMappings'] as $pluginNamespace => $pluginTargetNodeMappings) {
			$pluginNamespace = '--' . $pluginNamespace;
			if (!isset($arguments[$pluginNamespace]) || !is_array($arguments[$pluginNamespace])) {
				continue;
			}
			$pluginArguments = $arguments[$pluginNamespace];
			foreach ($pluginTargetNodeMappings as $pluginTargetNodeMapping) {
				if (isset($pluginTargetNodeMapping['package'])
						&& (!isset($pluginArguments['@package']) || strtolower($pluginArguments['@package']) !== strtolower($pluginTargetNodeMapping['package']))
				) {
					continue;
				}
				if (isset($pluginTargetNodeMapping['controller'])
						&& (!isset($pluginArguments['@controller']) || strtolower($pluginArguments['@controller']) !== strtolower($pluginTargetNodeMapping['controller']))
				) {
					continue;
				}
				if (isset($pluginTargetNodeMapping['action'])
						&& (!isset($pluginArguments['@action']) || strtolower($pluginArguments['@action']) !== strtolower($pluginTargetNodeMapping['action']))
				) {
					continue;
				}
				$nodeIdentifier = $pluginTargetNodeMapping['targetNode'];

				$contextProperties = array(
					'workspaceName' => 'live'
				);
				$contentContext = $this->contextFactory->create($contextProperties);

				$node = $this->nodeDataRepository->findOneByIdentifier($nodeIdentifier, $contentContext->getWorkspace());

				if ($node === NULL) {
					throw new \TYPO3\Flow\Exception('no node with identifier "' . $nodeIdentifier . '" found', 1334172725);
				}

				$arguments['node'] = $node->getContextPath();
				$arguments['@package'] = 'TYPO3.Neos';
				$arguments['@controller'] = 'Frontend\Node';
				$arguments['@format'] = 'html';
				$arguments['@action'] = 'show';
				$uriBuilder->setArguments($arguments);
				return;
			}
		}
	}

}

?>