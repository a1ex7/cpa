<?php

namespace A1ex7\Cpa\AdmitAd;

class LeadModel
{
    /**
     * Click identifier
     * @var string
     */
    public $transactionId;

    public function rules(): array
    {
        return [
            'uid' => 'required|string',
        ];
    }
}