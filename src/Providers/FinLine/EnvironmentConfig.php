<?php

namespace A1ex7\Cpa\Providers\FinLine;

use A1ex7\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'FIN_LINE_';

}