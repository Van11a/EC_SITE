<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\NewRequest;
use App\Http\Requests\Admin\User\EditRequest;
use App\Models\Admin\User;
use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * 一覧画面
     */
    public function index() {
        $users = $this->userService->getAllUser();
        return view('admin.user.index',compact('users'));
    }
    /**
     * 登録画面
     */
    public function create() {
        return view('admin.user.create');
    }
    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $user = $request->validated();
        return view('admin.user.create-confirm',compact('user'));
    }
    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $this->userService->createNewUser($request);
            return redirect()->route('user.complete');
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('user.index')->with([
                'msg' => '保存に失敗しました'
            ])->withInput(); 
        }
    }
    /**
     * 編集処理
     */
    public function edit($id)
    {
        $user = $this->userService->getUser($id);
        return view('admin.user.edit', compact('user'));
    }
    /**
     * 編集確認処理
     */
    public function edit_confirm(EditRequest $request) 
    {
        $user = $request->validated();
        $user['id'] = intval($request['id']);
        return view('admin.user.edit-confirm',compact('user'));
    }
    /**
     * 編集処理
     */
    public function update(Request $request, $id)
    {
        $this->userService->updateUser($request,$id);
        return redirect()->route('user.complete');
    }
    /**
     * 完了画面
     */
    public function complete()
    {
        return view('admin.user.complete');
    }
}