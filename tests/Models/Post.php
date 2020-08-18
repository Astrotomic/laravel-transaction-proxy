<?php

namespace Astrotomic\LaravelTransactionProxy\Tests\Models;

use Astrotomic\LaravelTransactionProxy\HasTransactionalCalls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * @method static self create(array $attributes)
 */
class Post extends Model
{
    use HasTransactionalCalls;

    protected $table = 'posts';

    protected $guarded = [];

    public function exception(): void
    {
        throw new RuntimeException();
    }

    public function updateException(): void
    {
        $this->update([
            'name' => Str::random(),
        ]);

        $this->exception();
    }
}
