<?php
namespace App\Repositories\Admin;
use App\Models\Admin\User;
class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getById($id)
    {
        return $this->user->find($id);
    }

    public function getAll()
    {
        return $this->user->paginate(10);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $data)
    {
        return $user->update($data);
    }
}