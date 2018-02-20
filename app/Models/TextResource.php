<?php

namespace App\Models;

use App\Models\Traits\Resourceable;
use Illuminate\Database\Eloquent\Model;

class TextResource extends Model
{
    use Resourceable;

    protected $fillable = ['content'];
}
