<div>
    <h4 class="mb-4">Ads Settings</h4>
    <form  wire:submit.prevent="update_ad_settings">
        
        <div class="form-group row mb-4">
            <label for="appId" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">App ID</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="text" class="form-control" id="appId" wire:model="appId" placeholder="Enter App Id" required>
            </div>
        </div>


        <div class="from-group row mb-4">
            <label for="isBannerAdActive" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Banner Ad</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input type="checkbox" id="isBannerAdActive" wire:model="isBannerAdActive">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="form-group row mb-4">
            <label for="bannerAdId" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Banner ID</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="text" class="form-control" id="bannerAdId" wire:model="bannerAdId" placeholder="Enter Banner Id" required>
            </div>
        </div>

        <div class="from-group row mb-4">
            <label for="isInterstitialAdActive" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Interstitial Ad</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input type="checkbox" id="isInterstitialAdActive" wire:model="isInterstitialAdActive">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="form-group row mb-4">
            <label for="interstitialAdId" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">interstitial ID</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="text" class="form-control" id="interstitialAdId" wire:model="interstitialAdId" placeholder="Enter interstitial ad Id" required>
            </div>
        </div>
        <div class="form-group row mb-4">
            <label for="interstitialAdSetting" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">interstitial Settings</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="text" class="form-control" id="interstitialAdSetting" wire:model="interstitialAdSetting" placeholder="Enter interstitial ad settings" required>
            </div>
        </div>

        <div class="from-group row mb-4">
            <label for="isOpenAdActive" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Open Ad</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input type="checkbox" id="isOpenAdActive" wire:model="isOpenAdActive">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="form-group row mb-4">
            <label for="OpenAdId" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Open ID</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="text" class="form-control" id="OpenAdId" wire:model="OpenAdId" placeholder="Enter Open ad Id" required>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </div>
    </form>   
</div>