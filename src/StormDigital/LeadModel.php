<?php

namespace A1ex7\Cpa\StormDigital;

class LeadModel
{
    /**
     * Click identifier
     * @var string
     */
    public $clickId;
    /**
     * Web master identifier
     * @var string
     */
    public $pid;

    public function rules(): array
    {
        return [
            'clickId' => 'required|string',
            'pid'     => 'integer'
        ];
    }
}