<?php
namespace App\Rules\Front;
use Illuminate\Contracts\Validation\Rule;
class CheckPhoneNumber implements Rule
{
    private $tel1;
    private $tel2;
    private $tel3;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tel1,$tel2,$tel3)
    {
        $this->tel1 = $tel1;
        $this->tel2 = $tel2;
        $this->tel3 = $tel3;
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
        if($this->tel1 != "" && $this->tel2 != "" &&  $this->tel3 != "")
        {
            if(!preg_match("/\A0\d{10,11}\z/", $this->tel1.$this->tel2.$this->tel3))
            {
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '電話番号は半角数字で指定してください';
    }
}