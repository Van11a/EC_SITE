<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\KeyVisual\NewRequest;
use App\Http\Requests\Admin\KeyVisual\EditRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\KeyVisual;
use App\Http\Controllers\Controller;
use App\Services\Admin\KeyVisualService;
class KeyVisualController extends Controller
{
    private $keyVisualService;
    public function __construct(KeyVisualService $keyVisualService)
    {
        $this->keyVisualService = $keyVisualService;
    }
    /**
     * 一覧画面
     */
    public function index() {
        try {
            $key_visuals = $this->keyVisualService->getAllKeyVisual();
            return view('admin.keyvisual.index',compact('key_visuals'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
    /**
     * 登録画面
     */
    public function create() {
        return view('admin.keyvisual.create');
    }
    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $key_visual = $request->validated();
        $key_visual = $this->keyVisualService->uploadImageToTemporaryServer($request,$key_visual);
        return view('admin.keyvisual.create-confirm',compact('key_visual'));
    }
    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $this->keyVisualService->createNewKeyVisual($request);
            return redirect()->route('keyvisual.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('keyvisual.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput(); 
        }
        
    }
    /**
     * 編集処理
     */
    public function edit($id)
    {
        $key_visual = $this->keyVisualService->getKeyVisual($id);
        return view('admin.keyvisual.edit', compact('key_visual'));
    }
    /**
     * 編集確認処理
     */
    public function edit_confirm(EditRequest $request, $id) 
    {
        $key_visual = $request->validated();
        $key_visual['id'] = intval($request['id']);
        $key_visual = $this->keyVisualService->uploadImageToTemporaryServer($request,$key_visual);
        return view('admin.keyvisual.edit-confirm',compact('key_visual'));
    }
    /**
     * 編集処理
     */
    public function update(Request $request, $id)
    {
        try{
            $this->keyVisualService->updateKeyVisual($request,$id);
            return redirect()->route('keyvisual.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('keyvisual.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput(); 
        }
    }
    /**
     * 完了画面
     */
    public function complete()
    {
        $this->keyVisualService->deleteImagesOnTemporaryServer();
        return view('admin.keyvisual.complete');
    }
    /**
     * 削除確認処理
     */
    public function destroy_confirm($id) 
    {
        $key_visual = $this->keyVisualService->getKeyVisual($id);
        return view('admin.keyvisual.destroy-confirm',compact('key_visual'));
    }
    
    /**
     * 削除機能
     */
    public function destroy($id)
    {
        try{
            $this->keyVisualService->destroyKeyVisual($id);
            return view('admin.keyvisual.complete');
        } catch (\Throwable $e){
            report($e);
            return redirect()->route('keyvisual.index')->with([
                'message' => '削除に失敗しました'
            ])->withInput(); 
        }
    }
}
