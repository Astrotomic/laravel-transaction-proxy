# Laravel TransactionProxy

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-transaction-proxy.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-transaction-proxy)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-transaction-proxy.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-transaction-proxy/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/laravel-transaction-proxy)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/laravel-transaction-proxy/run-tests?style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/laravel-transaction-proxy/actions?query=workflow%3Arun-tests)
[![StyleCI](https://styleci.io/repos/288458669/shield)](https://styleci.io/repos/288458669)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/laravel-transaction-proxy.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/laravel-transaction-proxy)

This package provides a trait and class to call methods in a database transaction.
This is useful if you have any listeners also running database queries, like deleting child models.

## Installation

You can install the package via composer:

```bash
composer require astrotomic/laravel-transaction-proxy
```

## Usage

The easiest will be to use the `\Astrotomic\LaravelTransactionProxy\HasTransactionCalls` trait which adds a `transaction()` method.

```php
use Astrotomic\LaravelTransactionProxy\HasTransactionalCalls;

class MyClass
{
    use HasTransactionalCalls;
}
```

### Transaction chained Method

You can call the `transaction()` without any argument and the method after will be called in a transaction.

This example will call the `delete()` method in a transaction.
This is useful if you have any listeners also running database queries, like deleting child models.
The transaction will prevent you from corrupted data if any of the queries fails.

```php
$model->transaction()->delete();

// vs

use Illuminate\Support\Facades\DB;
DB::transaction(fn() => $model->delete());
```

### Conditional Callback

If you want you can also pass a callback to the `transaction()` method you will get the calling object as first argument.

```php
$model->transaction(function(Model $model) {
    $model->update();
    $model->child->update();
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) for details. You could also be interested in [CODE OF CONDUCT](https://github.com/Astrotomic/.github/blob/master/CODE_OF_CONDUCT.md).

### Security

If you discover any security related issues, please check [SECURITY](https://github.com/Astrotomic/.github/blob/master/SECURITY.md) for steps to report it.

## Credits

-   [Tom Witkowski](https://github.com/Gummibeer)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment I would highly appreciate you buying the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to [plant trees](https://www.bbc.co.uk/news/science-environment-48870920). If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/laravel-transaction-proxy)

Read more about Treeware at [treeware.earth](https://treeware.earth)
