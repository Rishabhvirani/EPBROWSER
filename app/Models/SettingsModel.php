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
    
    public function get_settings($term = 'general'){
        $settings = Model::where('label',$term)->get();
        $return_setting;
        if(count($settings) > 1){
            foreach($settings as $setting){
                $return_setting[$setting['name']] = $setting['value'];
            }
        }
        return json_decode(json_encode($return_setting));
    }

}
