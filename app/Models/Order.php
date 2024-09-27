<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menuEntry()
    {
        return $this->belongsTo(MenuEntry::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
