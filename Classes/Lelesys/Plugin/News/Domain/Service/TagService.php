<?php

namespace Lelesys\Plugin\News\Domain\Service;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use Lelesys\Plugin\News\Domain\Model\Tag;

/**
 * Tag service for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class TagService {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\TagRepository
	 */
	protected $tagRepository;

	/**
	 * Shows a list of tags
	 *
	 * @param array $pluginArguments Plugin arguments
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function listAll($pluginArguments = NULL) {
		return $this->tagRepository->listAll($pluginArguments);
	}

	/**
	 * Adds the given new tag object to the tag repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $newTag A new tag to add
	 * @return void
	 */
	public function create(\Lelesys\Plugin\News\Domain\Model\Tag $newTag) {
		$newTag->setCreateDate(new \DateTime());
		$newTag->setUpdatedDate(new \DateTime());
		$this->tagRepository->add($newTag);
		$this->emitTagCreated($newTag);
	}

	/**
	 * Shows a single category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The category to show
	 * @return array $enabledNews
	 */
	public function getNewsByTag(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$enabledNews = array();
		foreach ($tag->getNews() as $news) {
			if ($news->getHidden() !== TRUE) {
				$enabledNews[] = $news;
			}
		}
		return $enabledNews;
	}

	/**
	 * Removes the given tag object from the tag repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$this->tagRepository->remove($tag);
		$this->emitTagDeleted($tag);
	}

	/**
	 * returns an object of tag based on the name provided
	 *
	 * @param string $tagname
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findTagByName($tagname) {
		return $this->tagRepository->findOneByTitle($tagname);
	}

	/**
	 * return tag for given identifier
	 *
	 * @param string $identifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findById($identifier) {
		return $this->tagRepository->findByIdentifier($identifier);
	}

	/**
	 * Signal for Tag created
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The Tag
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitTagCreated(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {

	}

	/**
	 * Signal for Tag deleted
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The Tag
	 * @Flow\Signal
	 * @return void
	 */
	protected function emitTagDeleted(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {

	}

}

?>