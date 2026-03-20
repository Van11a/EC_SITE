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
    public function index()
    {
        try {
            $key_visuals = $this->keyVisualService->getAllKeyVisual();
            return view('admin.keyVisual.index', compact('key_visuals'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * 登録画面
     */
    public function create(Request $request)
    {
        // 確認画面から『戻る』ボタンで戻ってきた時用のセッション保存処理
        if ($request->isMethod('post')) {
            $request->flash();
        }
        return view('admin.keyVisual.create');
    }

    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $validated_data = $request->validated();
        $key_visual = $this->keyVisualService->uploadImageToTemporaryServer($validated_data, $request);
        return view('admin.keyVisual.create-confirm', compact('key_visual'));
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $this->keyVisualService->createNewKeyVisual($request);
            return redirect()->route('key_visual.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('key_visual.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 編集処理
     */
    public function edit(KeyVisual $key_visual)
    {
        return view('admin.keyVisual.edit', compact('key_visual'));
    }

    /**
     * 編集確認処理
     */
    public function edit_confirm(KeyVisual $key_visual, EditRequest $request)
    {
        $validated_data = $request->validated();
        $result_data = $this->keyVisualService->uploadImageToTemporaryServer($validated_data, $request);
        $request->session()->flash('input_data', $result_data);
        return view('admin.keyVisual.edit-confirm', compact('key_visual'));
    }

    /**
     * 編集処理
     */
    public function update(KeyVisual $key_visual, Request $request)
    {
        if ($request->get('action') === 'back') {
            return redirect()->route('key_visual.edit', ['key_visual' => $key_visual->id])->withInput();
        }

        $validated_data = $request->session()->get('input_data');
        try {
            $this->keyVisualService->updateKeyVisual($key_visual, $validated_data);
            return redirect()->route('key_visual.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('key_visual.index')->with([
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
        return view('admin.keyVisual.complete');
    }

    /**
     * 削除確認処理
     */
    public function destroy_confirm(KeyVisual $key_visual)
    {
        return view('admin.keyVisual.destroy-confirm', compact('key_visual'));
    }

    /**
     * 削除機能
     */
    public function destroy(KeyVisual $key_visual)
    {
        try {
            $this->keyVisualService->deleteKeyVisual($key_visual);
            return view('admin.keyVisual.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('key_visual.index')->with([
                'message' => '削除に失敗しました'
            ])->withInput();
        }
    }
}
