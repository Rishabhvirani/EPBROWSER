<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use App\Models\UsersModel;

class Referal implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $message;
    public $data;

    public function __construct($data)
    {
        $this->data=$data;
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
        if($value != null){
            $user = UsersModel::where('ref_code','=',strtolower($value))->where('status','0')->first();
            if(strtolower($this->data['username']) == strtolower($value)){
                $this->message = ':attribute can not be same as username';
                return false;
            }else if(!$user){
                $this->message = ":attribute is invalid";
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
        return $this->message;
    }
}
