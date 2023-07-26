<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class EventsByOrganizationId implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('organization_id', '=', Auth::user()->getAuthIdentifier());
    }
}
