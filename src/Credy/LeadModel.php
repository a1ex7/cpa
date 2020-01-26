<?php

namespace A1ex7\Cpa\Credy;

class LeadModel
{
    /**
     * Transaction identifier
     * @var string
     */
    public $tid;

    public function rules(): array
    {
        return [
            'tid' => 'required|string',
        ];
    }
}