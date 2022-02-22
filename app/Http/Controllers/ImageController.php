<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Response\SuccessResponse;
use DevRecord\Infrastructure\Storage\StorageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(StorageInterface $storage)
    {
        $images = DB::table('images')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $imagesFormatted = array_map(function ($image) use ($storage) {
            $image->url = $storage->url($image->name);

            return $image;
        }, $images);

        return (new SuccessResponse(['list' => $imagesFormatted]))->toArray();
    }

    public function store(Request $request, StorageInterface $storage)
    {
        $file     = $request->file('image');
        $fileSize = getimagesize($file->getRealPath());
        $fileName = $file->getClientOriginalName();

        if (DB::table('images')->where('name', $fileName)->exists()) {
            $extension = $file->getClientOriginalExtension();
            $fileName  = pathinfo($fileName)['filename'] . '_' . uniqid() . '.' . $extension;
        }

        DB::table('images')->insert([
            'id'         => $id = uniqid(),
            'name'       => $fileName,
            'width'      => $fileSize[0],
            'height'     => $fileSize[1],
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('images')->where('id', $id)->first();
        Storage::disk(config('filesystems.default'))->put($fileName, $file->getContent(), 'public');

        $filePath = $storage->url($fileName);

        return (new SuccessResponse(['fileName' => $fileName, 'url' => $filePath]))->toArray();
    }
}
