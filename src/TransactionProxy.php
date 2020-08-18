<?php

namespace Astrotomic\LaravelTransactionProxy;

use Illuminate\Support\Facades\DB;

class TransactionProxy
{
    protected object $object;

    /**
     * @param object $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __call(string $name, array $arguments)
    {
        return DB::transaction(fn () => call_user_func_array([$this->object, $name], $arguments));
    }
}
