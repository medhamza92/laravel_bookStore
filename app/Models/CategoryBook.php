<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBook extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorybooks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Other model code...
}
