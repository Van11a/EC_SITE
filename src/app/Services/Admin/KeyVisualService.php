<?php

namespace App\Services\Admin;

use App\Models\Admin\KeyVisual;
use App\Repositories\Admin\KeyVisualRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KeyVisualService
{
    private $keyVisualRepository;

    public function __construct(KeyVisualRepository $keyVisualRepository)
    {
        $this->keyVisualRepository = $keyVisualRepository;
    }

    public function getAllKeyVisual()
    {
        return $this->keyVisualRepository->getAll();
    }

    public function uploadImageToTemporaryServer(array $validated_data, Request $request)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = $file->store('key_visuals/tmp');
            $validated_data['image'] = $path;
        } else {
            $validated_data['image'] = $validated_data['before_image'];
        }
        return $validated_data;
    }

    public function uploadImageToServer(Request $request)
    {
        $newPath = 'key_visuals/' . basename($request['image']);
        Storage::move($request['image'], $newPath);
        return $newPath;
    }

    public function updateuploadedImageToServer(array $request, $data)
    {
        if ($request['image']) {
            $before_image = $request['before_image'];
            $newPath = 'key_visuals/' . basename($request['image']);

            Storage::move($request['image'], $newPath);
            $data['image'] = $newPath;

            //更新前の画像を削除
            if ($before_image != $request['image'] && Storage::exists($before_image)) {
                Storage::delete($before_image);
            }
        }
        return $data;
    }

    public function deleteImagesOnTemporaryServer()
    {
        $files = Storage::files('key_visuals/tmp');
        foreach ($files as $file) {
            // 各ファイルを削除
            Storage::delete($file);
        }
    }

    public function createNewKeyVisual(Request $request)
    {
        $data = $request->only(['title', 'url', 'is_new_window', 'public_start_date', 'public_end_date', 'display_order', 'is_display', 'image']);
        $data['image'] = $this->uploadImageToServer($request);
        $this->keyVisualRepository->create($data);
    }

    public function updateKeyVisual(KeyVisual $key_visual, array $request)
    {
        $data = Arr::only($request, ['title', 'url', 'is_new_window', 'public_start_date', 'public_end_date', 'display_order', 'is_display', 'image', 'before_image']);
        $data = $this->updateuploadedImageToServer($request, $data);
        $this->keyVisualRepository->update($key_visual, $data);
    }

    public function deleteKeyVisual(KeyVisual $key_visual)
    {
        $this->keyVisualRepository->delete($key_visual);
    }
}
