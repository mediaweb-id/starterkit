<?php

namespace AcitJazz\Starterkit\QueryFilters;

use Closure;

class ParentId extends Filter
{
   protected function applyFilter($builder)
   {

     return $builder->where('parent_id',request($this->filterName()));
   }
}
