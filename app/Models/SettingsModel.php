<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_settings';
    protected $keyType = 'string';
    protected $primaryKey = 'name';
    protected $fillable = ['name','value','label','type'];
    

    public function get_settings($data){
            $settings = Model::where($data)->get();
            $return_setting=[];
            if(count($settings) > 1){
                foreach($settings as $setting){
                    $return_setting[$setting['name']] = $setting['value'];
                }
            }else{
                $return_setting[$settings[0]['name']] = $settings[0]['value'];
            }
            return json_decode(json_encode($return_setting));
        }



    public function get_typewise_settings($type){
        $settings = Model::where('type',$type)->get();
        $return_setting;
        if(count($settings) > 1){
            foreach($settings as $setting){
                $return_setting[$setting['name']] = $setting['value'];
            }
        }else{
            $return_setting[$settings[0]['name']] = $settings[0]['value'];
        }
        return json_decode(json_encode($return_setting));
    }



}
