<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Accepts:
        // - 8 digits starting with 2/4/5/7/9 (e.g. 55123456)
        // - Spaced format: 55 123 456
        // - Optional country code: +216 55 123 456 or 21655123456, with/without spaces
        $tnPattern = '^(?:\+?216)?\s*[24579](?:\s*\d){7}$';

        return [
            'full_name'     => ['required', 'string', 'max:120'],
            'phone'         => ['required', 'string', 'max:30', "regex:/{$tnPattern}/"],
            'phone_alt'     => ['nullable', 'string', 'max:30', "regex:/{$tnPattern}/"],
            'email'         => ['nullable', 'email', 'max:150'],
            'city'          => ['required', 'string', 'max:100'],
            'address'       => ['required', 'string', 'max:500'],
            'postal_code'   => ['nullable', 'string', 'max:10'],
            'customer_note' => ['nullable', 'string', 'max:2000'],
            'quantity'      => ['required', 'integer', 'min:1', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Le téléphone est obligatoire.',
            'phone.regex'    => 'Le numéro de téléphone doit être un numéro tunisien valide (ex : 55 123 456 ou +216 55 123 456).',
            'phone_alt.regex'=> 'Le téléphone secondaire doit être un numéro tunisien valide (ex : 55 123 456).',
        ];
    }

    protected function prepareForValidation(): void
    {
        $normalize = function ($value) {
            if (!is_string($value)) return $value;
            $v = trim($value);
            return $v === '' ? null : preg_replace('/\s+/', ' ', $v);
        };

        $this->merge([
            'full_name'   => $normalize($this->input('full_name')),
            'phone'       => $normalize($this->input('phone')),
            'phone_alt'   => $normalize($this->input('phone_alt')),
            'email'       => $normalize($this->input('email')),
            'city'        => $normalize($this->input('city')),
            'address'     => $normalize($this->input('address')),
            'postal_code' => $normalize($this->input('postal_code')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'full_name'     => 'nom complet',
            'phone'         => 'téléphone',
            'phone_alt'     => 'téléphone secondaire',
            'email'         => 'email',
            'city'          => 'ville',
            'address'       => 'adresse',
            'postal_code'   => 'code postal',
            'customer_note' => 'commentaire',
            'quantity'      => 'quantité',
        ];
    }
}
