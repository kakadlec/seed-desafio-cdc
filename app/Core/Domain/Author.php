<?php

declare(strict_types=1);

namespace App\Core\Domain;

use DateTimeImmutable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Author
{
    private string $name;
    private string $email;
    private string $description;
    private DateTimeImmutable $createdAt;

    /**
     * @throws ValidationException
     */
    public function __construct(string $name, string $email, string $description)
    {
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        $this->createdAt  = new DateTimeImmutable();

        $this->validate();
    }

    public function toArray(): array
    {
        return ["name" => $this->name, "email" => $this->email, "description" => $this->description, "created_at" => $this->createdAt];
    }

    /**
     * @throws ValidationException
     */
    private function validate(): void
    {
        Validator::make($this->toArray(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'required|string|max:400',
            'created_at' => 'required|date',
        ])->validate();
    }
}
