<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller\ImageController;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageStoreActionTest extends TestCase
{
    public function test_画像の新規登録(): void
    {
        Storage::fake('upload');
        $file     = UploadedFile::fake()->image($name = 'test.png', 30, 50);
        $response = $this->post(route('image.store'), ['image' => $file]);

        $this->assertTrue($response['result']);
        $this->assertDatabaseHas('images', ['name' => $name, 'width' => 30, 'height' => 50]);
        $this->assertTrue(Storage::disk('upload')->exists($name));
    }

    public function test_ファイル名が重複した場合は末尾にユニークの値をつける(): void
    {
        Storage::fake('upload');
        $file = UploadedFile::fake()->image('test.png', 30, 50);

        $this->post(route('image.store'), ['image' => $file]);
        $response2 = $this->post(route('image.store'), ['image' => $file]);

        $this->assertTrue(Storage::disk('upload')->exists($response2['data']['fileName']));
    }
}
