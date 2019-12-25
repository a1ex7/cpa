<?php

namespace A1ex7\Cpa\DoAffiliate;

class LeadModel
{
    /**
     * Visitor identifier
     * @var string
     */
    public $visitor;

    public function rules(): array
    {
        return [
            'visitor' => 'required|string',
        ];
    }
}