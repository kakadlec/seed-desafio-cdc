<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Category;
use App\Core\Infra\CategoryRepositoryInDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewCategory(): void
    {
        $payload = ['name' => 'Category 1'];

        $response = $this->postJson('api/category', $payload);
        $this->assertSame(200, $response->status());
        $this->assertSame(
            '{"id":2,"name":"Category 1"}',
            $response->getContent()
        );
    }

    public function testEmptyCategoryShouldFailGracefully(): void
    {
        $response = $this->postJson('api/category', []);

        $this->assertSame(422, $response->status());
        $this->assertSame(
            '{"message":"The name field is required.","errors":{"name":["The name field is required."]}}',
            $response->getContent()
        );
    }

    public function testOnDuplicatedCategoryShouldFailGracefully(): void
    {
        $categoryRepository = new CategoryRepositoryInDatabase();

        $payload = ['name' => 'Category 1'];

        $category = new Category($payload['name']);
        $categoryRepository->store($category);

        $response = $this->postJson('api/category', $payload);

        $this->assertSame(422, $response->status());
        $this->assertSame(
            '{"message":"The name has already been taken.","errors":{"name":["The name has already been taken."]}}',
            $response->getContent()
        );
    }
}
