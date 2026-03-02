<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index() : View
    {
        $books = Books::query()->paginate(10);
        $users = User::all();
        $trashedBooks = Books::onlyTrashed()->paginate(10);
        return view('books.index',[
            'books' => $books,
            'users' => $users,
            'trashedBooks' => $trashedBooks
        ]);
    }
    public function create() : View
    {

        return view('books.create');
    }
    public function edit(Books $book) : View
    {
        return view('books.edit',[
            'book' => $book,
        ]);
    }

    public function update(Books $book, Request $request) : RedirectResponse
    {
        $book->title = $request->input('label');
        $book->save();
        return redirect()->route('books.index')->with('success', 'Наименование изменено.');
    }

    public function destroy(Books $book) : RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книга удалена.');
    }
    public function restore(string $bookId): RedirectResponse
    {
        Books::withTrashed()->where('id', $bookId)->firstOrFail()->restore();

        return redirect()->route('books.index')->with('success', 'Книга восстановлена.');
    }
}
