<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Transfer\NewRequest;
use App\Http\Requests\Admin\Transfer\EditRequest;
use App\Models\Admin\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\TransferService;
class TransferController extends Controller
{
    private $transferService;
    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }
    /**
     * 一覧画面
     */
    public function index(Request $request) {
        try {
            $transfers = $this->transferService->searchTransfer($request);
            return view('admin.transfer.index',compact('transfers','request'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
    /**
     * 登録画面
     */
    public function create() {
        return view('admin.transfer.create');
    }
    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $transfer = $request->validated();
        return view('admin.transfer.create-confirm',compact('transfer'));
    }
    /**
     * 登録処理
     */
    public function store(NewRequest $request)
    {
        try {
            $this->transferService->createNewTransfer($request);
            return redirect()->route('transfer.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('transfer.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput(); 
        }
        
    }
    /**
     * 編集処理
     */
    public function edit($transfer_id)
    {
        $transfer = $this->transferService->getTransfer($transfer_id);
        return view('admin.transfer.edit', compact('transfer'));
    }
    /**
     * 編集確認処理
     */
    public function edit_confirm(EditRequest $request, $id) 
    {
        $transfer = $this->transferService->getTransfer($id);
        $transfer = $request->validated();
        $transfer['id'] = intval($request['id']);
        return view('admin.transfer.edit-confirm',compact('transfer'));
    }
    /**
     * 編集処理
     */
    public function update(EditRequest $request, $id)
    {
        try{
            $this->transferService->updateTransfer($request,$id);
            return redirect()->route('transfer.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('transfer.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput(); 
        }
    }
    /**
     * 詳細画面
     */
    public function show($id)
    {
        $transfer = $this->transferService->getTransfer($id);
        return view('admin.transfer.show', compact('transfer'));
    }
    /**
     * 完了画面
     */
    public function complete()
    {
        return view('admin.transfer.complete');
    }
    /**
     * 削除確認処理
     */
    public function destroy_confirm($id) 
    {
        $transfer = $this->transferService->getTransfer($id);
        return view('admin.transfer.destroy-confirm',compact('transfer'));
    }
    
    /**
     * 削除機能
     */
    public function destroy($id)
    {
        try{
            $this->transferService->destroyTransfer($id);
            return view('admin.transfer.complete');
        } catch (\Throwable $e){
            report($e);
            return redirect()->route('transfer.index')->with([
                'message' => '削除に失敗しました'
            ])->withInput(); 
        }
    }
}