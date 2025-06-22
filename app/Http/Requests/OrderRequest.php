<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use App\Models\Country;
use App\Rules\Documents\DocumentValidator;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'document' => ['required', 'string', new DocumentValidator],
            'country' => 'required|string|size:3|exists:countries,code',
            'state' => 'nullable|string|size:2|exists:states,code',
            'postal_code' => 'required|string|size:8',
            'city' => 'required|string',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'phone' => 'required|string',
            'order' => 'required|array',
            'order.coupon' => 'nullable|string|unique:orders,coupon|exists:coupons,codigo',
            'order.total' => 'required|numeric|gt:0',
            'order.items' => 'required|array',
            'order.items.*.product_id' => 'required|integer|exists:book,id',
            'order.items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->sometimes('state', 'required', function (Fluent $input) {
            $country = Country::where('code', $input->country)->first();
            return $country && $country->states()->exists();
        });

        // Custom validation: order.total must match sum of items
        $validator->after(function ($validator) {
            $data = $this->all();
            if (!isset($data['order']['items']) || !is_array($data['order']['items']) || !isset($data['order']['total'])) {
                return;
            }
            $itemSum = 0;
            foreach ($data['order']['items'] as $item) {
                if (!isset($item['product_id'], $item['quantity'])) {
                    continue;
                }
                $book = \App\Models\Book::find($item['product_id']);
                if (!$book) {
                    continue;
                }
                $itemSum += $book->price * $item['quantity'];
            }
            // Compare as float with 2 decimals
            if (round($itemSum, 2) !== round($data['order']['total'], 2)) {
                $validator->errors()->add('order.total', 'Order total must match the sum of the items.');
            }
        });
    }
}
