<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CategoryBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param  Model $book
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        $items = $this->model->with('authors', 'publisher', 'category')->get();
        return response(['data' => $items, 'status' => 200]);
    }

    /**
     * @param  Request $request
     * @return Collection
     */
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|digits:13|integer|unique:books,isbn',
            'name' => 'required|min:3',
            'year' => 'required|integer|digits:4',
            'page' => 'required|integer',
            'publisher_id' => 'exists:publishers,id',
            'authors' => 'exists:authors,id',
            'category_id' => 'exists:categorybooks,id', // Add validation for category_id
        ]);

        $item = $this->model->create($request->all());

        $authors = $request->get('authors');
        $item->authors()->sync($authors);

        $category = $request->get('category_id');
        $item->category()->associate(CategoryBook::find($category)); // Associate the book with the category

        return $this->index();
    }

    /**
     * @param  mixed $id
     * @return Collection
     */
    public function destroy($id)
    {
        try {
            $item = $this->model->with('authors', 'publisher', 'category')->findOrFail($id);
            $item->authors()->detach();
            $item->delete();
            return $this->index();
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    /**
     * @param  mixed $id
     * @return Model
     */
    public function show($id)
    {
        try {
            $item = $this->model->with('authors', 'publisher', 'category')->findOrFail($id);
            return response(['data' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    /**
     * @param  mixed $id
     * @param  mixed $request
     * @return Collection
     */
    public function update($id, Request $request)
    {
        try {
            $item = $this->model->with('authors', 'publisher', 'category')->findOrFail($id);
            $item->update($request->all());

            $authors = $request->get('authors');
            $item->authors()->sync($authors);

            $category = $request->get('category_id');
            $item->category()->associate(CategoryBook::find($category)); // Associate the book with the category

            return response(['data' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}
