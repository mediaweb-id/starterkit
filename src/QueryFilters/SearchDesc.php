<?php

namespace AcitJazz\Starterkit\QueryFilters;
use Illuminate\Support\Str;
use Closure;

class SearchDesc extends Filter
{
   protected function applyFilter($builder)
   {
    return $builder->where('description', 'LIKE', '%' . request($this->filterName()) . '%');
   }
}
