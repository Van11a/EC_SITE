<?php
namespace App\Repositories\Admin;
use App\Models\Admin\Transfer;
class TransferRepository
{
    protected $transfer;
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }
    public function getById($id)
    {
        return $this->transfer->find($id);
    }
    public function getByQuery($query)
    {
        return $query->paginate(10);
    }
    public function create(array $data)
    {
        return $this->transfer->create($data);
    }
    public function update(array $data, $id)
    {
        return $this->transfer->where('id', $id)->update($data);
    }
    public function destroy($id)
    {
        return $this->transfer->destroy($id);
    }
}