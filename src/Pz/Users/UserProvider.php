<?php

namespace Pz\Users;

use Pz\Common\Utils;
use Site\DAOs\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;

class UserProvider implements UserProviderInterface
{

    private $conn;

    public function __construct(EntityManager $conn)
    {
        $this->conn = $conn;
    }

    public function loadUserByUsername($username)
    {
        $dao = \Site\DAOs\User::findByTitle($this->conn, $username);
        if (!$dao) {
            throw new UsernameNotFoundException(sprintf('Login "%s" does not exist.', $username));
        }
        return $dao;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
//        return $class === 'Symfony\Component\Security\Core\User\User';
        return $class === 'Site\DAOs\User';
    }
}