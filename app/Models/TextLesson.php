<?php

namespace App\Models;

use App\Models\Traits\Lessonable;
use Illuminate\Database\Eloquent\Model;

class TextLesson extends Model
{
    use Lessonable;

    protected $fillable = ['content'];
}
