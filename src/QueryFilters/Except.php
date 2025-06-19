<?php

namespace AcitJazz\Starterkit\QueryFilters;

use Closure;
use Illuminate\Support\Carbon;

class Except extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->whereNotIn('id',explode(',',request($this->filterName())));
   }
}
