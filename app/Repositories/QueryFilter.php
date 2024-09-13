<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{
    protected $builder;
    protected $request;
    /**
     * Create a new class instance.
     */
    public function __construct(Request $request)
    {
        $this->request =$request;
    }

    protected function filter($arr){
        foreach ($arr as $key => $value) {
            if (method_exists($this,$key)){
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    public function apply(Builder $builder){
        $this->builder =$builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this,$key)){
                $this->$key($value);
            }
        }

        return $this->builder;
    }

}
