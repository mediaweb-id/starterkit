<?php

namespace MediaWebId\Starterkit\QueryFilters;

class SearchTitle extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('title', 'LIKE', '%' . request($this->filterName()) . '%');
    }
}
