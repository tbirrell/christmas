<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class List extends Model
{
	protected $table = 'list';

  protected $guarded = [
      'id',
  ];
}
