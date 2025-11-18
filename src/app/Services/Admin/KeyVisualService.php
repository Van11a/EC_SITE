<?php
namespace App\Services\Admin;
use App\Models\Admin\KeyVisual;
use App\Repositories\Admin\KeyVisualRepository;
use Illuminate\Support\Facades\Storage;
class KeyVisualService
{
    private $keyVisualRepository;
    public function __construct(KeyVisualRepository $keyVisualRepository)
    {
        $this->keyVisualRepository = $keyVisualRepository;
    }
    public function getKeyVisual($id)
    {
        return $this->keyVisualRepository->getById($id);
    }
    public function getAllKeyVisual()
    {
        return $this->keyVisualRepository->getAll();
    }
    public function uploadImageToTemporaryServer($request,$key_visual)
    {
        if($request->file('image')){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $path = isset($fileName) ? $file->store('key_visuals/tmp', 'public') : '';
            $key_visual['image'] = $path;
        }else{
            $key_visual['image'] = $key_visual['before_image'];
        }
        return $key_visual;
    }
    public function uploadImageToServer($request)
    {
        Storage::move('public/'.$request['image'], '/public/key_visuals/'.basename($request['image']));
        return 'key_visuals/'.basename($request['image']);
    }
    public function updateuploadedImageToServer($request,$date)
    {
        if($request['image']){
            $before_image = $request['before_image'];
            Storage::move('public/'.$request['image'], '/public/key_visuals/'.basename($request['image']));
            $date['image'] = 'key_visuals/'.basename($request['image']);
            //更新前の画像を削除
            if($before_image != $request['image'] && Storage::exists('public/'.$before_image)){
                Storage::delete('public/'.$before_image);
            }
        }
        return $date;
    }
    public function deleteImagesOnTemporaryServer()
    {
        $dir = glob(base_path('storage/app/public/key_visuals/tmp/*'));
        foreach ($dir as $file){
            unlink($file);
        }
    }
    public function createNewKeyVisual($request)
    {
        $date = $request->only(['title','url','is_new_window','public_start_date','public_end_date','display_order','is_display','image']);
        $date['image'] = $this->uploadImageToServer($request);
        $this->keyVisualRepository->create($date);
    }
    public function updateKeyVisual($request,$id)
    {
        $date = $request->only(['title','url','is_new_window','public_start_date','public_end_date','display_order','is_display','image']);
        $date = $this->updateuploadedImageToServer($request,$date);
        $this->keyVisualRepository->update($date,$id);
    }
    public function destroyKeyVisual($id)
    {
        $this->keyVisualRepository->destroy($id);
    }
}