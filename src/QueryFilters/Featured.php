<?php

namespace AcitJazz\Starterkit\QueryFilters;

use Closure;

class Featured extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('featured', request($this->filterName()));
   }
}
