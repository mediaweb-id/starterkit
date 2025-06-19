<?php

namespace AcitJazz\Starterkit\QueryFilters;

use Closure;

class Qty extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('qty', request($this->filterName()));
   }
}
