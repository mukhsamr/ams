<?php

namespace App\Scopes;

use App\Models\Version;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class VersionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $column = $model->getTable() . '.version_id';
        $version = session('version')->id ?? Version::firstWhere('is_used', 1)->id;
        $builder->where($column, $version)->orWhere($column, null);
    }
}
