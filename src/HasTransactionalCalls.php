<?php

namespace Astrotomic\LaravelTransactionProxy;

use Closure;
use Illuminate\Support\Facades\DB;

trait HasTransactionalCalls
{
    /**
     * @param Closure|null $callback
     *
     * @return static|TransactionProxy
     */
    public function transaction(?Closure $callback = null)
    {
        if ($callback === null) {
            return new TransactionProxy($this);
        }

        DB::transaction(fn() => $callback($this));

        return $this;
    }
}
