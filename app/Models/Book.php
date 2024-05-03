<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'name',
        'year',
        'page',
        'publisher_id',
        'category_id', // Add category_id to the fillable array
    ];

    /**
     * Get the publisher for the book.
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class)->withDefault([
            'identifier' => 'WITHOUT ID',
            'fname' => 'NOT FOUND',
            'lname' => 'NOT FOUND',
        ]);
    }

    /**
     * Get the authors for the book.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors')->using(BookAuthor::class);
    }

    /**
     * Get the category that owns the book.
     */
    public function category()
    {
        return $this->belongsTo(CategoryBook::class);
    }
}

