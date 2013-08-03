<?php
namespace Lelesys\Plugin\News\Domain\Model;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A News
 *
 * @Flow\Entity
 */
class News {

	/**
	 * The title
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $title;

	/**
	 * The sub title
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $subTitle;

	/**
	 * The alternative title
	 * @var string
	 */
	protected $alternativeTitle;

	/**
	 * The author name
	 * @var string
	 */
	protected $authorName;

	/**
	 * The author email
	 * @var string
	 * @Flow\Validate(type="EmailAddress")
	 */
	protected $authorEmail;

	/**
	 * The created date
	 * @var \DateTime
	 */
	protected $createdDate;

	/**
	 * The hidden
	 * @var boolean
	 */
	protected $hidden;

	/**
	 * The deleted
	 * @var boolean
	 */
	protected $deleted;

	/**
	 * The created by
	 * @var \Lelesys\Plugin\News\Domain\Model\User
	 * @ORM\ManyToOne(inversedBy="news")
	 */
	protected $createdBy;

	/**
	 * The description
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $description;

	/**
	 * The date time
	 * @var \DateTime
	 */
	protected $dateTime;

	/**
	 * The archive date
	 * @var \DateTime
	 * @ORM\Column(nullable=true)
	 */
	protected $archiveDate;

	/**
	 * The categories
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\Category>
	 * @ORM\ManyToMany(inversedBy="news", cascade={"persist"})
	 */
	protected $categories;

	/**
	 * The tags
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\Tag>
	 * @ORM\ManyToMany(inversedBy="news", cascade={"persist"})
	 */
	protected $tags;

	/**
	 * The keywords
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $keywords;

	/**
	 * The assets
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\Asset>
	 * @ORM\ManyToMany
	 */
	protected $assets;

	/**
	 * The files
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\File>
	 * @ORM\ManyToMany
	 */
	protected $files;

	/**
	 * The related links
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\Link>
	 * @ORM\ManyToMany
	 */
	protected $relatedLinks;

	/**
	 * The end date
	 * @var \DateTime
	 */
	protected $endDate;

	/**
	 * The related news
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\News>
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(name="related_news_id")})
	 */
	protected $relatedNews;

	/**
	 * The is top news
	 * @var boolean
	 */
	protected $isTopNews;

	/**
	 * The updated date
	 * @var \DateTime
	 */
	protected $updatedDate;

	/**
	 * The comments
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\Comment>
	 * @ORM\OneToMany(mappedBy="news")
	 * @ORM\OrderBy({"createdDate" = "DESC"})
	 */
	protected $comments;

	public function __construct() {
		$this->relatedNews = new \Doctrine\Common\Collections\ArrayCollection();
		$this->relatedLinks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->assets = new \Doctrine\Common\Collections\ArrayCollection();
		$this->categories = new \Doctrine\Common\Collections\ArrayCollection();
		$this->files = new \Doctrine\Common\Collections\ArrayCollection();
		$this->tags = new \Doctrine\Common\Collections\ArrayCollection();
		$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
		$this->setCreatedDate(new \DateTime());
		$this->setHidden(0);
		$this->setDeleted(0);
		$this->setUpdatedDate(new \DateTime());
		$this->setEndDate(new \DateTime());
		$this->setIsTopNews(0);
	}

	/**
	 * Get the News's title
	 *
	 * @return string The News's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this News's title
	 *
	 * @param string $title The News's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the News's sub title
	 *
	 * @return string The News's sub title
	 */
	public function getSubTitle() {
		return $this->subTitle;
	}

	/**
	 * Sets this News's sub title
	 *
	 * @param string $subTitle The News's sub title
	 * @return void
	 */
	public function setSubTitle($subTitle) {
		$this->subTitle = $subTitle;
	}

	/**
	 * Get the News's alternative title
	 *
	 * @return string The News's alternative title
	 */
	public function getAlternativeTitle() {
		return $this->alternativeTitle;
	}

	/**
	 * Sets this News's alternative title
	 *
	 * @param string $alternativeTitle The News's alternative title
	 * @return void
	 */
	public function setAlternativeTitle($alternativeTitle) {
		$this->alternativeTitle = $alternativeTitle;
	}

	/**
	 * Get the News's author name
	 *
	 * @return string The News's author name
	 */
	public function getAuthorName() {
		return $this->authorName;
	}

	/**
	 * Sets this News's author name
	 *
	 * @param string $authorName The News's author name
	 * @return void
	 */
	public function setAuthorName($authorName) {
		$this->authorName = $authorName;
	}

	/**
	 * Get the News's author email
	 *
	 * @return string The News's author email
	 */
	public function getAuthorEmail() {
		return $this->authorEmail;
	}

	/**
	 * Sets this News's author email
	 *
	 * @param string $authorEmail The News's author email
	 * @return void
	 */
	public function setAuthorEmail($authorEmail) {
		$this->authorEmail = $authorEmail;
	}

	/**
	 * Get the News's created date
	 *
	 * @return \DateTime The News's created date
	 */
	public function getCreatedDate() {
		return $this->createdDate;
	}

	/**
	 * Sets this News's created date
	 *
	 * @param \DateTime $createdDate The News's created date
	 * @return void
	 */
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}

	/**
	 * Get the News's hidden
	 *
	 * @return boolean The News's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this News's hidden
	 *
	 * @param boolean $hidden The News's hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Get the News's deleted
	 *
	 * @return boolean The News's deleted
	 */
	public function getDeleted() {
		return $this->deleted;
	}

	/**
	 * Sets this News's deleted
	 *
	 * @param boolean $deleted The News's deleted
	 * @return void
	 */
	public function setDeleted($deleted) {
		$this->deleted = $deleted;
	}

	/**
	 * Get the News's created by
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\User The News's created by
	 */
	public function getCreatedBy() {
		return $this->createdBy;
	}

	/**
	 * Sets this News's created by
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $createdBy The News's created by
	 * @return void
	 */
	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
	}

	/**
	 * Get the News's description
	 *
	 * @return string The News's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this News's description
	 *
	 * @param string $description The News's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Get the News's date time
	 *
	 * @return \DateTime The News's date time
	 */
	public function getDateTime() {
		return $this->dateTime;
	}

	/**
	 * Sets this News's date time
	 *
	 * @param \DateTime $dateTime The News's date time
	 * @return void
	 */
	public function setDateTime($dateTime) {
		$this->dateTime = $dateTime;
	}

	/**
	 * Get the News's archive date
	 *
	 * @return \DateTime The News's archive date
	 */
	public function getArchiveDate() {
		return $this->archiveDate;
	}

	/**
	 * Sets this News's archive date
	 *
	 * @param \DateTime $archiveDate The News's archive date
	 * @return void
	 */
	public function setArchiveDate($archiveDate) {
		$this->archiveDate = $archiveDate;
	}

	/**
	 * Get the News's categories
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Sets this News's categories
	 *
	 * @param \Doctrine\Common\Collections\Collection $categories The News's categories
	 * @return void
	 */
	public function setCategories(\Doctrine\Common\Collections\Collection $categories) {
		$this->categories = $categories;
	}

	/**
	 * Get the News's tags
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Sets this News's tags
	 *
	 * @param \Doctrine\Common\Collections\Collection $tags The News's tags
	 * @return void
	 */
	public function setTags(\Doctrine\Common\Collections\Collection $tags) {
		$this->tags = $tags;
	}

	/**
	 * Get the News's keywords
	 *
	 * @return string The News's keywords
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * Sets this News's keywords
	 *
	 * @param string $keywords The News's keywords
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Get the News's assets
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's assets
	 */
	public function getAssets() {
		return $this->assets;
	}

	/**
	 * Sets this News's assets
	 *
	 * @param \Doctrine\Common\Collections\Collection $assets The News's assets
	 * @return void
	 */
	public function setAssets(\Doctrine\Common\Collections\Collection $assets) {
		$this->assets = $assets;
	}

	/**
	 * Adds a News's assets
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset
	 * @return void
	 */
	public function addAssets(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assets->add($asset);
	}

	/**
	 * Removes a News's assets
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Asset $asset
	 * @return void
	 */
	public function removeAssets(\Lelesys\Plugin\News\Domain\Model\Asset $asset) {
		$this->assets->removeElement($asset);
	}

	/**
	 * Get the News's files
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets this News's files
	 *
	 * @param \Doctrine\Common\Collections\Collection $files The News's files
	 * @return void
	 */
	public function setFiles(\Doctrine\Common\Collections\Collection $files) {
		$this->files = $files;
	}

	/**
	 * Adds a News's files
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $file
	 * @return void
	 */
	public function addFiles(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$this->files->add($file);
	}

	/**
	 * Removes a News's files
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\File $asset
	 * @return void
	 */
	public function removeFiles(\Lelesys\Plugin\News\Domain\Model\File $file) {
		$this->files->removeElement($file);
	}

	/**
	 * Get the News's related links
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's related links
	 */
	public function getRelatedLinks() {
		return $this->relatedLinks;
	}

	/**
	 * Sets this News's related links
	 *
	 * @param \Doctrine\Common\Collections\Collection $relatedLinks The News's related links
	 * @return void
	 */
	public function setRelatedLinks(\Doctrine\Common\Collections\Collection $relatedLinks) {
		$this->relatedLinks = $relatedLinks;
	}

	/**
	 * Adds a related link
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link
	 * @return void
	 */
	public function addRelatedLinks(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$this->relatedLinks->add($link);
	}

	/**
	 * Removes a related link
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Link $link
	 * @return void
	 */
	public function removeRelatedLinks(\Lelesys\Plugin\News\Domain\Model\Link $link) {
		$this->relatedLinks->removeElement($link);
	}

	/**
	 * Get the News's end date
	 *
	 * @return \DateTime The News's end date
	 */
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	 * Sets this News's end date
	 *
	 * @param \DateTime $endDate The News's end date
	 * @return void
	 */
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
	}

	/**
	 * Get the News's related news
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's related news
	 */
	public function getRelatedNews() {
		return $this->relatedNews;
	}

	/**
	 * Sets this News's related news
	 *
	 * @param \Doctrine\Common\Collections\Collection $relatedNews The News's related news
	 * @return void
	 */
	public function setRelatedNews(\Doctrine\Common\Collections\Collection $relatedNews) {
		$this->relatedNews = $relatedNews;
	}


	/**
	 * Get the News's is top news
	 *
	 * @return boolean The News's is top news
	 */
	public function getIsTopNews() {
		return $this->isTopNews;
	}

	/**
	 * Sets this News's is top news
	 *
	 * @param boolean $isTopNews The News's is top news
	 * @return void
	 */
	public function setIsTopNews($isTopNews) {
		$this->isTopNews = $isTopNews;
	}

	/**
	 * Get the News's updated date
	 *
	 * @return \DateTime The News's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this News's updated date
	 *
	 * @param \DateTime $updatedDate The News's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the News's comments
	 *
	 * @return \Doctrine\Common\Collections\Collection The News's comments
	 */
	public function getcomments() {
		return $this->comments;
	}

	/**
	 * Sets this News's comments
	 *
	 * @param \Doctrine\Common\Collections\Collection $comments The News's comments
	 * @return void
	 */
	public function setComments(\Doctrine\Common\Collections\Collection $comments) {
		$this->comments = $comments;
	}

	/**
	 * Returns uuid of this object
	 *
	 * @return string
	 */
	public function getUuid() {
		return $this->Persistence_Object_Identifier;
	}

}
?>