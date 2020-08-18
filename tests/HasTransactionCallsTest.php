<?php

namespace Astrotomic\LaravelTransactionProxy\Tests;

use Astrotomic\LaravelTransactionProxy\Tests\Models\Post;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use RuntimeException;

final class HasTransactionCallsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /** @test */
    public function chain_it_commits_on_success()
    {
        $post = Post::create([
            'name' => 'test',
        ]);

        $post->transaction()->update([
            'name' => 'committed',
        ]);

        $this->assertSame('committed', $post->refresh()->name);
    }

    /** @test */
    public function chain_it_rollbacks_on_exception()
    {
        $post = Post::create([
            'name' => 'test',
        ]);

        try {
            $post->transaction()->updateException();
        } catch (Exception $exception) {
            $this->assertInstanceOf(RuntimeException::class, $exception);
        }

        $this->assertSame('test', $post->refresh()->name);
    }

    /** @test */
    public function callback_it_commits_on_success()
    {
        $post = Post::create([
            'name' => 'test',
        ]);

        $post->transaction(fn (Post $post) => $post->update([
            'name' => 'committed',
        ]));

        $this->assertSame('committed', $post->refresh()->name);
    }

    /** @test */
    public function callback_it_rollbacks_on_exception()
    {
        $post = Post::create([
            'name' => 'test',
        ]);

        try {
            $post->transaction(fn (Post $post) => $post->updateException());
        } catch (Exception $exception) {
            $this->assertInstanceOf(RuntimeException::class, $exception);
        }

        $this->assertSame('test', $post->refresh()->name);
    }
}
