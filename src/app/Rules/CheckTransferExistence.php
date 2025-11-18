<?php
namespace App\Rules\Front;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin\Transfer;
class CheckTransferExistence implements Rule
{
    private $management_number;
    private $last_name_kana;
    private $first_name_kana;
    private $tel;
    private $postcode;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($management_number,$last_name_kana,$first_name_kana,$tel,$postcode)
    {
        $this->management_number = $management_number;
        $this->last_name_kana = $last_name_kana;
        $this->first_name_kana = $first_name_kana;
        $this->tel = $tel;
        $this->postcode = $postcode;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //振込情報から検索
        $transfer = Transfer::where('management_number',$this->management_number)
            ->where('last_name_kana',$this->last_name_kana)
            ->where('first_name_kana',$this->first_name_kana)
            ->where('tel',$this->tel)
            ->where('postcode',$this->postcode)->first();
        if(isset($transfer)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '入力された情報が一致しません';
    }
}