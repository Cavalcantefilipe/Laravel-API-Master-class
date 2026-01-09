<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{

    public function mappedAttributes(): array
    {
        $attributesMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',

        ];

        $attributesUpdated = [];
        foreach ($attributesMap as $key => $value) {
            if ($this->has($key)) {
                $attributesUpdated[$value] = $this->input($key);
            }
        }

        return $attributesUpdated;
    }
    public function messages()
    {
        return [
            'data.attributes.status' =>  'The data.attributes.status value is invalid. Please use one of the following: A (Active), C (Closed), H (On Hold), X (Cancelled).',

        ];
    }
}
