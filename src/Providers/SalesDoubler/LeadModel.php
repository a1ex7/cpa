<?php

namespace A1ex7\Cpa\Providers\SalesDoubler;

class LeadModel
{
    /** @var string */
    public $clickId;
    /**
     * Web master identifier
     * @var string
     */
    public $aid;

    public function rules(): array
    {
        return [
            'clickId' => 'required|string',
            'aid'     => 'string'
        ];
    }
}