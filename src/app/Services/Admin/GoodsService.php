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
        $newPath = "";
        $key = 'image' . $index;
        $oldPath = $request->input($key);

        // 1. パスが空でなく、かつ実際にファイルが存在するか確認
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            $newPath = 'goods/' . basename($oldPath);
            Storage::disk('public')->move($oldPath, $newPath);
        }
        return $newPath;
    }

    public function updateuploadedImageToServer(array $request, $data)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($request['image' . $i]) {
                $before_image = $request['before_image' . $i];
                $newPath = 'goods/' . basename($request['image' . $i]);

                Storage::move($request['image' . $i], $newPath);
                $data['image'] = $newPath;

                //更新前の画像を削除
                if ($before_image != $request['image'] && Storage::exists($before_image)) {
                    Storage::delete($before_image);
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
