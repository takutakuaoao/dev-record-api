<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller\ImageController;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageIndexActionTest extends TestCase
{
    public function test_一覧表示(): void
    {
        Storage::fake('upload');
        DB::table('images')->insert(['id' => 'test', 'name' => 'test.png', 'width' => 10, 'height' => 30]);
        Storage::disk('upload')->put('test.png', UploadedFile::fake()->create('test.png')->getContent());

        $response = $this->get(route('image.index'));
        $images   = $response['data']['list'];

        $this->assertSame('test', $images[0]['id']);
        $this->assertSame('test.png', $images[0]['name']);
        $this->assertSame(10, $images[0]['width']);
        $this->assertSame(30, $images[0]['height']);
        $this->assertSame(config('app.url') . '/storage/upload/test.png', $images[0]['url']);
    }
}
