<?php

namespace Core\User;

class Session extends \Core\User\Abstracts\Session{
    
    
    
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
        
    }

    public function loginViaCookie() {
        
    }

    public function logout() {
        
    }

}