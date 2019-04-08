<?php

namespace App\Abstracts;

abstract class SlotMachine {
    protected $bandymo_kaina;
    protected $eiluciu_skaicius;
    protected $stulpeliu_skaicius;
    protected $variantu_celeje_skaicius;
    protected $fairness_coficientas;
    protected $state;
    
    abstract function __construct($bandymo_kaina, $eiluciu_skaicius, $stulpeliu_skaicius, $variantu_celeje_skaicius, $fairness_coficientas);
}