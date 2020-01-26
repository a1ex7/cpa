<?php

namespace A1ex7\Cpa\Conversion;

use A1ex7\Cpa\Models\Conversion;

interface SendServiceInterface
{
    public function send(Conversion $conversion, array $params): Postback;
}