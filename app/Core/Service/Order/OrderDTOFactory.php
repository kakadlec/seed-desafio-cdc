<?php

namespace App\Core\Service\Order;

use App\Core\ValueObjects\Address;
use App\Core\ValueObjects\Customer;
use App\Core\ValueObjects\Document;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Phone;

class OrderDTOFactory
{
    public static function fromValidated(array $data): OrderDTO
    {
        $customer = new Customer(
            firstName: $data['name'],
            lastName: $data['last_name'],
            document: new Document($data['document']),
            email: new Email($data['email']),
            phone: new Phone($data['phone']),
            address: new Address(
                country: $data['country'],
                state: $data['state'] ?? null,
                postalCode: $data['postal_code'],
                city: $data['city'],
                street: $data['address'],
                complement: $data['complement'] ?? null
            )
        );

        return new OrderDTO($customer);
    }
}

