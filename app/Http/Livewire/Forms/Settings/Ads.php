<?php
namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;
use Livewire\Component;


class Ads extends Component
{
    public $appId = '';
    public $isBannerAdActive = false;
    public $isInterstitialAdActive = false;
    public $isOpenAdActive=false;
    public $bannerAdId='';
    public $interstitialAdId='';
    public $interstitialAdSetting='';
    public $OpenAdId='';

    public $label = 'ads';
    public $setting;

    public function mount(){
        $this->setting =  new SettingsModel;
        $data['label'] = $this->label;
        $ads_setting = $this->setting->get_settings($data);
        $this->appId = $ads_setting->appId;
        $this->isBannerAdActive = $ads_setting->isBannerAdActive  == '0' ? false:true;
        $this->isInterstitialAdActive = $ads_setting->isInterstitialAdActive  == '0' ? false:true;
        $this->isOpenAdActive = $ads_setting->isOpenAdActive  == '0' ? false:true;
        $this->bannerAdId = $ads_setting->bannerAdId;
        $this->interstitialAdId = $ads_setting->interstitialAdId;
        $this->interstitialAdSetting = $ads_setting->interstitialAdSetting;
        $this->OpenAdId = $ads_setting->OpenAdId;
        
    }

    public function render()
    {
        return view('livewire.forms.settings.ads');
    }
    
    public function update_ad_settings(){   
        $data = $this->validate([
            'appId' => 'required',
            'isBannerAdActive' => 'required',
            'isInterstitialAdActive' => 'required',
            'isOpenAdActive' => 'required',
            'bannerAdId' => 'required',
            'interstitialAdId' => 'required',
            'interstitialAdSetting' => 'required',
            'OpenAdId' => 'required',
        ]);
        SettingsModel::where(array('name'=>'appId','label'=>$this->label))->update(array('value'=>$this->appId));
        SettingsModel::where(array('name'=>'isBannerAdActive','label'=>$this->label))->update(array('value'=>$this->isBannerAdActive));
        SettingsModel::where(array('name'=>'isInterstitialAdActive','label'=>$this->label))->update(array('value'=>$this->isInterstitialAdActive));
        SettingsModel::where(array('name'=>'isOpenAdActive','label'=>$this->label))->update(array('value'=>$this->isOpenAdActive));
        SettingsModel::where(array('name'=>'bannerAdId','label'=>$this->label))->update(array('value'=>$this->bannerAdId));
        SettingsModel::where(array('name'=>'interstitialAdId','label'=>$this->label))->update(array('value'=>$this->interstitialAdId));
        SettingsModel::where(array('name'=>'interstitialAdSetting','label'=>$this->label))->update(array('value'=>$this->interstitialAdSetting));
        SettingsModel::where(array('name'=>'OpenAdId','label'=>$this->label))->update(array('value'=>$this->OpenAdId));
        
        
        $this->mount();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Ads Setting updated']);
    }
}
