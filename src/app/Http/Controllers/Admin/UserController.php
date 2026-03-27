<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\NewRequest;
use App\Http\Requests\Admin\User\EditRequest;
use App\Models\Admin\User;
use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Exception;

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
    public function index()
    {
        try {
            $users = $this->userService->getAllUser();
            return view('admin.user.index', compact('users'));
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('admin.dashboard')->with([
                'error' => '一覧の取得に失敗しました'
            ]);
        }
    }

    /**
     * 登録画面
     */
    public function create(Request $request)
    {
        // セッションに保存された入力値があれば取得、なければ空の配列
        $user = $request->session()->get('user_input', []);

        return view('admin.user.create', compact('user'));
    }

    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $user = $request->validated();
        $request->session()->put('user_input', $user);
        return view('admin.user.create-confirm', compact('user'));
    }

    /**
     * 登録処理
     */
    public function store(NewRequest $request)
    {
        try {
            $this->userService->createNewUser($request->validated());
            return redirect()->route('user.complete');
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('user.create')->with([
                'error' => '保存に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        try {
            $user = $this->userService->getUser($id);
            return view('admin.user.edit', compact('user'));
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('user.index')->with([
                'error' => 'ユーザーの取得に失敗しました'
            ]);
        }
    }

    /**
     * 編集確認画面
     */
    public function edit_confirm(User $user, EditRequest $request)
    {
        $validated_data = $request->validated();
        $request->session()->flash('input_data', $validated_data);
        return view('admin.user.edit-confirm', compact('user', 'validated_data'));
    }

    /**
     * 編集処理
     */
    public function update(User $user, Request $request)
    {
        try {
            $validated_data = $request->session()->get('input_data');
            if (!$validated_data) {
                return redirect()->route('user.edit', $user)->with([
                    'error' => '確認画面を経由して送信してください'
                ]);
            }
            $this->userService->updateUser($user, $validated_data);
            return redirect()->route('user.complete');
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('user.edit', $user)->with([
                'error' => '更新に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 完了画面
     */
    public function complete()
    {
        return view('admin.user.complete');
    }
}
