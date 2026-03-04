<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\BookResource;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function test_get_list(): void
    {
        $response = $this->get(route('api.books.index'));
        $data = $response->json()['data'];
        //dd($response->json());
        $response->assertStatus(200);
        $this->assertCount(count($data), BookResource::collection($data));
    }
}
