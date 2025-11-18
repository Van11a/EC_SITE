<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}