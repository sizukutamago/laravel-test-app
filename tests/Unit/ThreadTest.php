<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function 複数の返信()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );
    }

    /** @test */
    public function 文字列のパスを作成できる()
    {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path()
        );
    }

    /** @test */
    public function 一人の作成者()
    {
        $this->assertInstanceOf(
            'App\User', $this->thread->creator
        );
    }

    /** @test */
    public function 返信を追加することが出来る()
    {
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function スレッドは一つのチャンネルに属する()
    {
        $this->assertInstanceOf(
            'App\Channel', $this->thread->channel
        );
    }
}
