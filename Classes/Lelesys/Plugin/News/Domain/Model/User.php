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
 * A User
 *
 * @Flow\Entity
 */
class User extends \TYPO3\Party\Domain\Model\Person {

	/**
	 * The gender
	 * @var integer
	 */
	protected $gender;

	/**
	 * The address
	 * @var string
	 */
	protected $address;

	/**
	 * The phone no
	 * @var string
	 */
	protected $phoneNo;

	/**
	 * The profile image
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist", "detach"})
	 */
	protected $profileImage;

	/**
	 * The create date
	 * @var \DateTime
	 */
	protected $createDate;

	/**
	 * The updated date
	 * @var \DateTime
	 */
	protected $updatedDate;

	/**
	 * The news
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\News>
	 * @ORM\OneToMany(mappedBy="createdBy")
	 */
	protected $news;


	/**
	 * Get the User's gender
	 *
	 * @return integer The User's gender
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * Sets this User's gender
	 *
	 * @param integer $gender The User's gender
	 * @return void
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * Get the User's address
	 *
	 * @return string The User's address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets this User's address
	 *
	 * @param string $address The User's address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Get the User's phone no
	 *
	 * @return string The User's phone no
	 */
	public function getPhoneNo() {
		return $this->phoneNo;
	}

	/**
	 * Sets this User's phone no
	 *
	 * @param string $phoneNo The User's phone no
	 * @return void
	 */
	public function setPhoneNo($phoneNo) {
		$this->phoneNo = $phoneNo;
	}

	/**
	 * Get the User's profile image
	 *
	 * @return \TYPO3\Flow\Resource\Resource The User's profile image
	 */
	public function getProfileImage() {
		return $this->profileImage;
	}

	/**
	 * Sets this User's profile image
	 *
	 * @param \TYPO3\Flow\Resource\Resource $profileImage The User's profile image
	 * @return void
	 */
	public function setProfileImage($profileImage) {
		$this->profileImage = $profileImage;
	}

	/**
	 * Get the User's create date
	 *
	 * @return \DateTime The User's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this User's create date
	 *
	 * @param \DateTime $createDate The User's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the User's updated date
	 *
	 * @return \DateTime The User's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this User's updated date
	 *
	 * @param \DateTime $updatedDate The User's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the User's news
	 *
	 * @return \Doctrine\Common\Collections\Collection The User's news
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * Sets this User's news
	 *
	 * @param \Doctrine\Common\Collections\Collection $news The User's news
	 * @return void
	 */
	public function setNews(\Doctrine\Common\Collections\Collection $news) {
		$this->news = $news;
	}

}
?>