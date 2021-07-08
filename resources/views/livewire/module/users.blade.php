<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            @livewire('forms.user.create')
            <div class="table-responsive">
                <table id="usertable" class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%" >
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Points</th>
                            <th>Usd</th>
                            <th>Country</th>
                            <th>Email Verified</th>
                            <th>Mobile Verified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@livewire('forms.user.edit')






                <!-- <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Create User</h4>
                        </div>                                                                        
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form  wire:submit.prevent="register">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="username" name="username" wire:model="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" id="Email" wire:model="email" placeholder="Email address">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control" id="Password" wire:model="password" placeholder="Password">
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <div class="form-group mb-3">
                            <input type="number" class="form-control" id="mobile" wire:model="mobile" placeholder="Mobile Number">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" id="points" wire:model="point" placeholder="Points">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" id="coin" wire:model="coin" placeholder="Coins">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="ref_code" wire:model="ref_code" placeholder="Referal Code">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="coin_address" wire:model="coin_address" placeholder="Epcoin Address">
                        </div>
                        <div class="text-left">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>
                    </form>
                </div>
                -->