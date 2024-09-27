<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class ClearTablesController extends Controller
{
    public function destroy(Table $table)
    {
        $table->orders()->delete();

        return [];
    }
}
