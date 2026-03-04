<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Books;
use App\Models\User;
use App\Repository\BookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;


class BookController extends Controller
{
    private const PER_PAGE = 10;
    private readonly BookRepository $bookRepository;

    public function __construct(
        BookRepository $bookRepository
    )
    {
        $this->bookRepository = $bookRepository;
    }

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
    public function show(Books $books) : BookResource
    {
        //$id = Books::query()->first();
        //dd($books->id);
        //return new BookResource($books->load('user:id,name'));
        return new BookResource($books->load('user:id,name'));
    }
    public function store(Request $request) : BookResource
    {
        return new BookResource($this->bookRepository->store($request));
    }
    public function update(Request $request, Books $books) : BookResource
    {
        return new BookResource($this->bookRepository->update($request, $books));
    }
    public function destroy(Books $books) : JsonResponse
    {
        return response()->json([
            'status' => $this->bookRepository->destroy($books) ? 'success' : 'error'
            ], JsonResponse::HTTP_OK);
    }
}
