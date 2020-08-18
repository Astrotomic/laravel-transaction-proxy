<?php

namespace Astrotomic\LaravelTransactionProxy;

use Closure;
use Illuminate\Support\Facades\DB;

trait HasTransactionalCalls
{
    /**
     * @param Closure|null $callback
     *
     * @return static|TransactionProxy|mixed
     */
    public function transaction(?Closure $callback = null)
    {
        if ($callback === null) {
            return new TransactionProxy($this);
        }

        return DB::transaction(fn () => $callback($this));
    }
}
