<?php

namespace Tests\Feature\packages\Controller\ImageController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ImageIndexActionTest extends TestCase
{
    public function test_一覧表示(): void
    {
        DB::table('images')->insert(['id' => 'test', 'name' => 'test.png', 'width' => 10, 'height' => 30]);
        $response = $this->get(route('image.index'));
        $images = $response['data']['list'];

        $this->assertSame('test', $images[0]['id']);
        $this->assertSame('test.png', $images[0]['name']);
        $this->assertSame(10, $images[0]['width']);
        $this->assertSame(30, $images[0]['height']);
        $this->assertSame(config('app.url') . '/storage/upload/test.png', $images[0]['url']);
    }
}
