<div class="row">
    <div id="flStackForm" class="col-lg-6 layout-spacing layout-top-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">                                
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Create User</h4>
                    </div>                                                                        
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form  wire:submit.prevent="submit">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" id="username" name="username"  placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" id="Email" placeholder="Email address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" class="form-control" id="Password" placeholder="Password">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" id="mobile" placeholder="Mobile Number">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="number" class="form-control" id="points"  placeholder="Points">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="number" class="form-control" id="coin" placeholder="Coins">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="mobile" placeholder="Referal Code">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="coin_address" placeholder="Epcoin Address">
                    </div>
                    <div class="text-left">
                        @error('username') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>