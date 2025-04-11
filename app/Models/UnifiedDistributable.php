<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnifiedDistributable extends Distributable
{
    use HasFactory;
    // Since this is a concrete class, you can use it to query the distributables table.
    //
}

