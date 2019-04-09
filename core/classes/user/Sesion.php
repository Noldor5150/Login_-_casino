<?php

namespace Core\User;

class Session extends \Core\User\Abstracts\Session {

    public function __construct(\Core\Modules\User\Repository $repo) {
        $this->repo = $repo;
        return $this->is_logged_in = false;
    }

    public function getUser(): Abstracts\User {
        
    }

    public function isLoggedIn() {
        return $this->is_logged_in;
    }

    public function login($email, $password): int {
        $user = $this->repo->load($email);
        if ($user) {
            if ($user->getPassword() === $password) {
                if ($user->getIsActive()) {
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    $this->user = $user;

                    return self::LOGIN_SUCCESS;
                } else {
                    return self::LOGIN_ERR_NOT_ACTIVE;
                }
            }
        }
        return self::LOGIN_ERR_CREDENTIALS;
    }

    public function loginViaCookie() {
        
    }

    public function logout() {
        
    }

}
