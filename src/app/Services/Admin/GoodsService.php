<?php

namespace App\Services\Admin;

use App\Models\Admin\Goods;
use App\Repositories\Admin\GoodsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoodsService
{
    private $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }

    public function getAllGoods()
    {
        return $this->goodsRepository->getAll();
    }

    public function getGoods($id)
    {
        return $this->goodsRepository->getById($id);
    }

    public function uploadImageToTemporaryServer(array $validated_data, Request $request)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($request->file('image' . $i)) {
                $file = $request->file('image' . $i);
                $path = $file->store('goods/tmp');
                $validated_data['image' . $i] = $path;
            } elseif (isset($validated_data['before_image' . $i])) {
                $validated_data['image' . $i] = $validated_data['before_image' . $i];
            }
        }
        return $validated_data;
    }

    public function uploadImageToServer(Request $request, $index)
    {
        $key = 'image' . $index;
        $oldPath = $request->input($key);

        // パスが空でなく、かつ実際にファイルが存在するか確認
        if ($oldPath && Storage::exists($oldPath)) {
            $newPath = 'goods/' . basename($oldPath);
            Storage::move($oldPath, $newPath);

            return $newPath;
        }

        return "";
    }

    public function updateuploadedImageToServer(array $request, array $data)
    {
        for ($i = 1; $i <= 5; $i++) {
            $key = 'image' . $i;
            $beforeKey = 'before_image' . $i;

            if (!empty($request[$key])) {
                $tempPath = $request[$key];

                $fileName = basename($tempPath);
                $newPath = 'goods/' . $fileName;

                if (Storage::exists($tempPath)) {
                    Storage::move($tempPath, $newPath);

                    $data[$key] = $newPath;
                    $beforeImage = $request[$beforeKey] ?? null;

                    //更新前の画像を削除
                    if ($beforeImage && $beforeImage !== $newPath && Storage::exists($beforeImage)) {
                        Storage::delete($beforeImage);
                    }
                }
            }
        }
        return $data;
    }

    public function deleteImagesOnTemporaryServer()
    {
        $files = Storage::files('goods/tmp');
        foreach ($files as $file) {
            // 各ファイルを削除
            Storage::delete($file);
        }
    }

    public function createNewGoods(Request $request)
    {
        $data = $request->only(['part_number', 'name', 'category_id', 'text', 'image1', 'image2', 'image3', 'image4', 'image5', 'before_image1', 'before_image2', 'before_image3', 'before_image4', 'before_image5', 'is_display', 'is_reccomend', 'public_start_date', 'public_end_date', 'stock', 'amount', 'cost']);
        for ($i = 1; $i <= 5; $i++) {
            $data['image' . $i] = $this->uploadImageToServer($request, $i);
        }
        $this->goodsRepository->create($data);
    }
}
