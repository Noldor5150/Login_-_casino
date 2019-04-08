<?php

namespace App;

class Player {
    
    public $balansas;
    public $cookie;
    
    public function __construct(\Core\Cookie $cookie) {
        
        $this->cookie = $cookie;
        
        if ($this->cookie->exists()) {
            $this->balansas = $this->cookie->read()[0];
        } else {
            $this->cookie->save([0]);
        }
    }
    
    public function getBalance() {
        return $this->balansas;
    }
    
    public function setBalance(int $money_added) {
        $this->cookie->save([$this->balansas + $money_added]);
    }
}
