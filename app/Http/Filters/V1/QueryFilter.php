<?php

namespace App\Http\Filters\V1;

use Symfony\Component\HttpFoundation\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = request();
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach (request()->all() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function filter($arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    public function sort($value)
    {

        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if (strpos($sortAttribute, '-') === 0) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if (!in_array($sortAttribute, $this->sortable) && !array_key_exists($sortAttribute, $this->sortable)) {
                continue;
            }

            $column = $this->sortable[$sortAttribute] ?? null;

            if ($column) {
                $this->builder->orderBy($column, $direction);
            }
        }
    }
}
