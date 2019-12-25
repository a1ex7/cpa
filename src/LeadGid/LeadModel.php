<?php

namespace A1ex7\Cpa\LeadGid;

class LeadModel
{
    /**
     *  Transaction id
     * @var string
     */
    public $click_id;

    /**
     * Web master identifier
     * @var string
     */
    public $wm_id;

    public function rules(): array
    {
        return [
            'click_id' => 'required|string',
            'wm_id'    => 'string',
        ];
    }
}