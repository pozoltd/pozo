<?php

/**
 * 2016-02-02 21:26:20
 */
namespace Pz\DAOs;

use Pz\Common\Utils;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends \Pz\DAOs\Generated\User implements UserInterface {

    public function save() {
        if ($this->password_) {
            $encoder = new MessageDigestPasswordEncoder();
            $this->password = $encoder->encodePassword ($this->password_, '');
        }
        $this->password_ = null;
        parent::save();
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function eraseCredentials()
    {
        return $this;
    }

    public function getUsername()
    {
        return $this->title;
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function getSalt()
    {
        return '';
    }
}