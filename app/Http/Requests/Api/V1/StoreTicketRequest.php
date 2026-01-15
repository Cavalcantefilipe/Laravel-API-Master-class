<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $authorIdAttribute = $this->routeIs('tickets.store') ? 'data.relationships.author.data.id' : 'author';
        $rules = [
            'data.attributes.title' => 'required|string|max:255',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|in:A,C,H,X',
            $authorIdAttribute => 'required|integer|exists:users,id',

        ];

        $user = $this->user();

        if ($user->tokenCan(Abilities::CreateOwnTicket)) {
            $rules[$authorIdAttribute] .= '|size:' . $user->id;
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->routeIs('authors.tickets.store')) {

            $this->merge([
                'author' => $this->route('author'),

            ]);
        }
    }

    public function messages()
    {
        return [
            'data.attributes.status' =>  'The data.attributes.status value is invalid. Please use one of the following: A (Active), C (Closed), H (On Hold), X (Cancelled).',

        ];
    }
}
