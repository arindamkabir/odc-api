<?php

namespace Database\Factories;

use App\Models\CashTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cashTxn = new CashTransaction();
        $cashTxn->save();

        return [
            'transactable_type' => 'App\Models\CashTransaction',
            'transactable_id' => $cashTxn->id
        ];
    }
}
