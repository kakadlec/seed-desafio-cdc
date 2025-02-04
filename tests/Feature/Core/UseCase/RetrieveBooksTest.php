<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveBooksTest extends TestCase
{
    use RefreshDatabase;

    public function testApiBooks(): void
    {
        Book::factory(2)->create();

        $response = $this->getJson('api/books');
        $responseData = $response->json();

        $this->assertSame(200, $response->status());
        $this->assertCount(2, $responseData);
        $this->assertArrayHasKey('id', $responseData[0]);
        $this->assertArrayHasKey('title', $responseData[0]);
    }
}
