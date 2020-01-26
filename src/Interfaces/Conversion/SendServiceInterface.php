<?php

namespace A1ex7\Cpa\Interfaces\Conversion;

use A1ex7\Cpa\Conversion\Postback;
use A1ex7\Cpa\Models\Conversion;

interface SendServiceInterface
{
    public function send(Conversion $conversion, array $params): Postback;
}