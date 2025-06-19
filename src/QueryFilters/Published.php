<?php

namespace AcitJazz\Starterkit\QueryFilters;

use Closure;
use Illuminate\Support\Carbon;

class Published extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('published_at','<=',Carbon::now());
   }
}
