<?php

namespace Lelesys\Plugin\News\Controller;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use \Lelesys\Plugin\News\Domain\Model\User;

/**
 * User controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class UserController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * Shows a list of users
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('users', $this->userRepository->findAll());
	}

	/**
	 * Shows a single user object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $user The user to show
	 * @return void
	 */
	public function showAction(User $user) {
		$this->view->assign('user', $user);
	}

	/**
	 * Shows a form for creating a new user object
	 *
	 * @return void
	 */
	public function newAction() {

	}

	/**
	 * Adds the given new user object to the user repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $newUser A new user to add
	 * @return void
	 */
	public function createAction(User $newUser) {
		try {
			$this->userRepository->add($newUser);
			$this->addFlashMessage('Created a new user.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create user at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Shows a form for editing an existing user object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $user The user to edit
	 * @return void
	 */
	public function editAction(User $user) {
		$this->view->assign('user', $user);
	}

	/**
	 * Updates the given user object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $user The user to update
	 * @return void
	 */
	public function updateAction(User $user) {
		try {
			$this->userRepository->update($user);
			$this->addFlashMessage('Updated the user.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update user at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given user object from the user repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\User $user The user to delete
	 * @return void
	 */
	public function deleteAction(User $user) {
		try {
			$this->userRepository->remove($user);
			$this->addFlashMessage('Deleted a user.');
			$this->redirect('index');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

}

?>