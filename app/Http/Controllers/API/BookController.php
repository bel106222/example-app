<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class BookController extends Controller
{
    private const PER_PAGE = 10;
    public function index(Request $request) : AnonymousResourceCollection
    {
//        $books = Books::query()
//            ->select([
//                'books.id',
//                'books.title',
//                'books.user_id',
//                'books.created_at'
//            ])
//            ->with([
//                'user:id,name', //в жадной загрузке цепляем только id и имя пользователя
//            ])
//            ->paginate($request->get('per_page',self::PER_PAGE));
//        return response()->json($books);

        $books = Books::query()
            ->with([
                'user:id,name', //в жадной загрузке цепляем только id и имя пользователя
            ])
            ->paginate($request->get('per_page',self::PER_PAGE));
        return BookResource::collection($books);
    }
    public function show(Books $book) : BookResource
    {
        return new BookResource($book->load('user:id,name'));
    }
}
