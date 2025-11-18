<?php
namespace App\Services\Admin;
use App\Models\Admin\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Admin\UserRepository;
class UserService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getUser($id)
    {
        return $this->userRepository->getById($id);
    }
    public function getAllUser()
    {
        return $this->userRepository->getAll();
    }
    public function createNewUser($request)
    {
        $result = $request->only(['name','login_id']);
        $date = array_merge($result, ([
            'unid' => (string) Str::uuid(),
            'password' => Hash::make($request['password']),
        ]));
        $this->userRepository->create($date);
    }
    public function updateUser($request,$id)
    {
        $date = $request->only(['name','login_id','password']);
        if(isset($date['password'])){
            $date['password'] = Hash::make($request['password']);
        }else{
            unset($date['password']);
        }
        $this->userRepository->update($date,$id);
    }
}