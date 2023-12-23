<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $appends = ['full_address'];

    protected function fullAddress(): Attribute
    {
        return new Attribute(
            get: fn () => $this->line1 .
                (($this->line2) ? ', ' . $this->line2 : '') . ', ' .
                $this->city . ', ' .
                $this->state . ', ' .
                $this->country . ', ' .
                $this->zip_code,
        );
    }
}
