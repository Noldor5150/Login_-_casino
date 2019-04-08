<?php

namespace App;

class SlotMachine extends Abstracts\SlotMachine {

    public $success = 1;

    public function __construct($bandymo_kaina, $eiluciu_skaicius, $stulpeliu_skaicius, $variantu_celeje_skaicius, $fairness_coficientas) {
        $this->bandymo_kaina = $bandymo_kaina;
        $this->eiluciu_skaicius = $eiluciu_skaicius;
        $this->stulpeliu_skaicius = $stulpeliu_skaicius;
        $this->variantu_celeje_skaicius = $variantu_celeje_skaicius;
        $this->fairness_coficientas = $fairness_coficientas;
    }

    public function Shuffle() {
        $this->state = [];

        for ($i = 0; $i < $this->eiluciu_skaicius; $i++) {
            for ($j = 0; $j < $this->stulpeliu_skaicius; $j++) {
                $this->state[$i][$j] = rand(1, $this->variantu_celeje_skaicius);
            }
        }
        
        return $this->state;
    }

    public function getState() {
        return $this->state;
    }

    public function getMiddleRow() {
        $idx = ceil($this->stulpeliu_skaicius / 2) - 1;
        
        return $this->state[$idx];
    }

    public function Outcome() {
        if ($this->isWin()) {
            return $this->bandymo_kaina * $this->fairness_coficientas * ($this->variantu_celeje_skaicius ** $this->stulpeliu_skaicius);
        }
        
        return (-1) * $this->bandymo_kaina;
    }

    public function isWin() {
        $row = $this->getMiddleRow();
        $prev_val = $row[0];
        
        foreach ($row as $val) {
            if ($prev_val !== $val) {
                return false;
            }

            $prev_val = $val;
        }

        return true;
    }

    public function getBandymoKaina() {
        return $this->bandymo_kaina;
    }

}
