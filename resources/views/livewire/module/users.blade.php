<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="text-right">
            @livewire('forms.user.create')
            
            </div>
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover dataTable table-highlight-head mb-4" style="width:100%">
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
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    foreach($users as $user){
                        ?>
                        <tr>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->points}}</td>
                            <td>{{$user->usd}}</td>
                            <td>{{$user->country}}</td>
                            <td>{{$user->email_verified}}</td>
                            <td>{{$user->mobile_verified}}</td>
                            <td>
                                <span data-toggle="modal" data-target="#edit" wire:click="openEdit('{{ $user->u_id }}')" class="badge badge-warning">Edit</span>
                            </td>
                            <!-- <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></td> -->
                        </tr>
                    <?php } ?>
                    </tfoot>
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