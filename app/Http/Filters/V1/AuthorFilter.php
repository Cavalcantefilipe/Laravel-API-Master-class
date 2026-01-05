<?php

namespace App\Http\Filters\V1;

class AuthorFilter extends QueryFilter
{
    public function include($value)
    {
        return $this->builder->with($value);
    }

    public function id($value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function email($value)
    {
        return $this->builder->where('email', 'like', '%' . $value . '%');
    }

    public function name($value)
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }

    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        $this->builder->whereDate('created_at', $value);
    }

    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        $this->builder->whereDate('updated_at', $value);
    }
}
