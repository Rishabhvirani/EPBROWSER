<div>
    <button type="button" wire:click="openform" class="btn btn-primary mb-2 mr-2" >Create User</button>
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="CreateLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form  wire:submit.prevent="register">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CreateLabel">Create User</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" id="username" name="username" wire:model.defer="state.username" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" id="email" wire:model.defer="state.email" placeholder="Email address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" class="form-control" id="password" wire:model.defer="state.password" placeholder="Password">
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" class="form-control" id="password_confirmation" wire:model.defer="state.password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <select wire:model="state.country" class="custom-select" id="countries">
                                @foreach($countries as $i => $country)
                                <option wire:key="{{ $loop->index }}" value="{{ $i }}" >{{ $i }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="tel" class="form-control" wire:model.defer="state.mobile" placeholder="Mobile Number">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="ref_code" wire:model.defer="state.ref_code" placeholder="Enter Referal ID">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>  
            </form>
        </div>
    </div>
</div>
