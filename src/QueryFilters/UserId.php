<?php

namespace MediaWebId\Starterkit\QueryFilters;

use Closure;

class UserId extends Filter
{
   protected function applyFilter($builder)
   {
     return $builder->where('user_id', request($this->filterName()));
   }
}
