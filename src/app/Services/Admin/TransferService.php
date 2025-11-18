<?php
namespace App\Services\Admin;
use Illuminate\Support\Str;
use App\Models\Admin\Transfer;
use App\Repositories\Admin\TransferRepository;
class TransferService
{
    private $transferRepository;
    public function __construct(TransferRepository $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }
    public function getTransfer($id)
    {
        return $this->transferRepository->getById($id);
    }
    public function searchTransfer($request)
    {
        $request->only(['name','name_kana','email','tel','postcode','status']);
        //検索用処理
        $query = Transfer::query();
        if($request['name']){
            $query->where('last_name','LIKE',"%{$request['name']}%")->orwhere('first_name','LIKE',"%{$request['name']}%");
        }
        if($request['name_kana']){
            $query->where('last_name_kana','LIKE',"%{$request['name_kana']}%")->orwhere('first_name_kana','LIKE',"%{$request['name_kana']}%");
        }
        if($request['email']){
            $query->where('email','LIKE',"%{$request['email']}%");
        }
        if($request['tel']){
            $query->where('tel','LIKE',"%{$request['tel']}%");
        }
        if($request['postcode']){
            $query->where('postcode','LIKE',"%{$request['postcode']}%");
        }
        if(!is_null($request['status'])){
            $query->where('status', $request['status']);
        }
        return $this->transferRepository->getByQuery($query);
    }
    public function createNewTransfer($request)
    {
        $date = $request->only(['last_name','first_name','last_name_kana','first_name_kana','tel','postcode','email','settlement_amount','remarks']);
        $date['management_number'] = $this->generateTransferManagementNumber();
        $this->transferRepository->create($date);
    }
    public function updateTransfer($request,$id)
    {
        $date = $request->only(['last_name','first_name','last_name_kana','first_name_kana','tel','postcode','email','settlement_amount','remarks']);
        $this->transferRepository->update($date,$id);
    }
    public function destroyTransfer($id)
    {
        $this->transferRepository->destroy($id);
    }
    public function generateTransferManagementNumber()
    {
        do {
            $rand_num = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $management_number = "C".$rand_num;
        } while (Transfer::where('management_number', $management_number)->exists());
        return $management_number;
    }
}