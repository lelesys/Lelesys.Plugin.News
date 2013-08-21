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
	 * @return \Lelesys\Plugin\News\Domain\Model\Tag
	 */
	public function listAll() {
		return $this->tagRepository->getEnabledLatestTags();
	}

	/**
	 * Shows a list of tags
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Tag
	 */
	public function adminTagList() {
		return $this->tagRepository->findAll();
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
	}

	/**
	 * Shows a single category object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The category to show
	 * @return \Lelesys\Plugin\News\Domain\Model\News $enabledNews
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
	 * Updates the given tag object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to update
	 * @return void
	 */
	public function update(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$tag->setUpdatedDate(new \DateTime());
		$this->tagRepository->update($tag);
	}

	/**
	 * Removes the given tag object from the tag repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag The tag to delete
	 * @return void
	 */
	public function delete(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$this->tagRepository->remove($tag);
	}

	/**
	 * hide's the Tag
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @return void
	 */
	public function hideTag(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$tag->setHidden(1);
		$this->tagRepository->update($tag);
	}

	/**
	 * shows's the hidden Tag
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 * @return void
	 */
	public function showTag(\Lelesys\Plugin\News\Domain\Model\Tag $tag) {
		$tag->setHidden(0);
		$this->tagRepository->update($tag);
	}

	/**
	 * returns an object of tag based on the name provided
	 *
	 * @param string $tagname
	 * @return \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 */
	public function findTagByName($tagname) {
		return $this->tagRepository->findOneByTitle($tagname);
	}

	/**
	 * return tag for given identifier
	 *
	 * @param string $identifier
	 * @return \Lelesys\Plugin\News\Domain\Model\Tag $tag
	 */
	public function findById($identifier) {
		return $this->tagRepository->findByIdentifier($identifier);
	}

}

?>