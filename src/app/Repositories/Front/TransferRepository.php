<?php
namespace App\Repositories\Front;
use App\Models\Admin\Transfer;
class TransferRepository
{
    protected $transfer;
    public function __construct(Transfer $transfer)
    {
        return $this->transfer = $transfer;
    }
    public function getById($id)
    {
        return $this->transfer->find($id);
    }
    public function getByManagementNumber($management_number)
    {
        return $this->transfer->where('management_number', $management_number)->first();
    }
    public function save($transfer)
    {
        return $transfer->save();
    }
}