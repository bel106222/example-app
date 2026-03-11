<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\BookResource;
use App\Models\User;
use App\Models\Books;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions; //используем трейт для того, чтобы данные тестов не сохранялись в БД
    public function test_get_list(): void
    {
        $response = $this->get(route('api.books.index'));
        $data = $response->json()['data'];
        $paginatedData = $response->json()['meta'];
        $userSetCount = User::query()->get()->count(); //количество пользователей в наборе из коллекции
        $userDBCount = User::query()->count(); //количество пользователей в таблице БД
        $this->assertEquals($userSetCount, $userDBCount);
        //dd($response->json());
        $response->assertStatus(200);
        $this->assertEquals(count($data), count(BookResource::collection($data)));
        //проверка пагинации
        $this->assertArrayHasKey('last_page', $paginatedData);
        $this->assertArrayHasKey('from', $paginatedData);
        $this->assertArrayHasKey('current_page', $paginatedData);
        $this->assertArrayHasKey('total', $paginatedData);
        $this->assertArrayHasKey('per_page', $paginatedData);
        $this->assertArrayHasKey('links', $paginatedData);
        $this->assertArrayHasKey('path', $paginatedData);
        $this->assertArrayHasKey('per_page', $paginatedData);
        $this->assertArrayHasKey('to', $paginatedData);
        $this->assertArrayHasKey('total', $paginatedData);
        $this->assertArrayHasKey('total', $paginatedData);
        //сравнение данных из запроса с данными в БД
        //$this->assertEquals($paginatedData['total'], $userDBCount);

        $perPage = 10;
        $page = 2;
        $response = $this->get(route('api.books.index', ['page' => $page, 'per_page' => $perPage]));
        $paginatedData = $response->json()['meta'];
        $this->assertEquals($paginatedData['per_page'], $perPage);
        $this->assertEquals($paginatedData['current_page'], $page);

        $book = Books::query()->get()->random(); //получаем случайную книгу из коллекции
        $response = $this->get(route('api.books.index', ['title' => $book->title]));

        //в цикле перебираем массив значений из столбца с наименованиями и сравниваем с полученным случайно
        foreach (array_column($response->json()['data'], 'title') as $title) {
            if(strpos($title, $book->title) !== false){
                $this->assertTrue(true);
            }
        }
    }
    public function test_create_book(): void //тестируем создание книги через API
    {
        //подготавливаем случайные данные
        $title = 'New book ' . Str::random(16);
        $ids = User::query()->pluck('id')->toArray(); // создаём массив из всех id-шников в таблице users
        $user_id = $ids[rand(0,count($ids)-1)]; // из этого массива выбираем случайный id
        $data = [
            'title' => $title,
            'user_id' => $user_id,
        ];

        $response = $this->post(route('api.books.store', $data));

        //ищем в БД запись с тестовыми данными
        $book = Books::query()
            ->where('title', $title)
            ->where('user_id', $user_id)
            ->first();

        //dd($response->getStatusCode());
        $response->assertStatus(201);
        $this->assertNotNull($book);
        $this->assertEquals($book->title, $title);
        $this->assertEquals($book->user_id, $user_id);
        //assertTrue(Hash::check($password,$user->password)); проверка совпадения хешированных паролей
    }
    public function test_update_book(): void //тестируем обновление книги через API
    {
        $book = Books::factory()->create(); //генерируем тестовую книгу
        //подготавливаем случайные данные
        $title = 'New book ' . Str::random(16);
        $data = [
            'title' => $title,
            'user_id' => $book->user_id,
            'books' => $book->id,
        ];

        $response = $this->patch(route('api.books.update', $data));
        $book->refresh(); //после обновления синхронизируем экземпляр модели с БД

        $response->assertStatus(200);
        $this->assertNotNull($book);
        $this->assertEquals($book->title, $title);
    }
    public function test_delete_book(): void //тестируем обновление книги через API
    {
        $ids = Books::query()->pluck('id')->toArray(); // создаём массив из всех id-шников в таблице books
        $bookId = $ids[rand(1,count($ids))]; // из этого массива выбираем случайный id
        //ищем в БД запись с тестовыми данными
        $book = Books::query()
            ->where('id', $bookId)
            ->first();

        $response = $this->delete(route('api.books.destroy', $book));
        $response->assertStatus(200);
    }
}
