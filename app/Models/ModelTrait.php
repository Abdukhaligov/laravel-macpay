<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder create(array $attributes)
 * @method static Builder find(mixed $id, array $columns = ['*'])
 * @method static Builder where(Closure|string|array|Expression $column, mixed $operatorOrValue = null, mixed $value = null, string $boolean = 'and')
 * @method static Builder whereNotIn(string $column, mixed $values, string $boolean = 'and')
 * @method static Collection all(array|mixed $columns = ['*'])
 * @method static Collection get(array|mixed$columns = ['*'])
 */
trait ModelTrait {
}