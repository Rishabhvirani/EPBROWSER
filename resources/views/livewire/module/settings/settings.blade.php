<div class="container-fluid">
    <div class="row">
        <div id="flStackForm" class="col-lg-8 col-md-8 col-sm-12 layout-spacing layout-top-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Settings</h4>
                        </div>                                                                        
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row mb-4 mt-3">
                        <div class="col-sm-3 col-12">
                            <div class="nav flex-column nav-pills mb-sm-0 mb-3 text-center mx-auto" id="v-line-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active mb-3" id="v-line-pills-home-tab" data-toggle="pill" href="#referal" role="tab" aria-controls="v-line-pills-home" aria-selected="true">Referals</a>
                                <a class="nav-link mb-3  text-center" id="v-line-pills-profile-tab" data-toggle="pill" href="#ads" role="tab" aria-controls="v-line-pills-ads" aria-selected="false">Ads</a>
                                <a class="nav-link mb-3  text-center" id="v-line-pills-profile-tab" data-toggle="pill" href="#conversion" role="tab" aria-controls="v-line-pills-conversion" aria-selected="false">Conversion</a>
                                <a class="nav-link mb-3  text-center" id="v-line-pills-profile-tab" data-toggle="pill" href="#general" role="tab" aria-controls="v-line-pills-general" aria-selected="false">General</a>
                            </div>
                        </div>
                        <div class="col-sm-9 col-12">
                            <div class="tab-content" id="v-line-pills-tabContent">
                                <div class="tab-pane fade show active" id="referal" role="tabpanel" aria-labelledby="v-line-pills-referal-tab">
                                    @livewire('forms.settings.referal')
                                </div>
                                <div class="tab-pane fade show" id="ads" role="tabpanel" aria-labelledby="v-line-pills-ads-tab">
                                @livewire('forms.settings.ads')
                                </div>
                                <div class="tab-pane fade show" id="conversion" role="tabpanel" aria-labelledby="v-line-pills-conversion-tab">
                                @livewire('forms.settings.conversion')
                                </div>
                                <div class="tab-pane fade show" id="general" role="tabpanel" aria-labelledby="v-line-pills-general-tab">
                                @livewire('forms.settings.general')
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
