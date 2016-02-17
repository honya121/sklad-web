<?php

namespace App\Model;

use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{

	protected $userFacade;


	public function __construct(Facade\UserFacade $userFacade)
	{
		$this->userFacade = $userFacade;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		if (!$this->userFacade->userExist($username)) 
        {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} 
        elseif (!$this->userFacade->checkUser($username, $password)) 
        {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} 

		$user = $this->userFacade->getUserByUsername($username);
		return new Nette\Security\Identity($user->getId(), $user->getRole());
	}
}
