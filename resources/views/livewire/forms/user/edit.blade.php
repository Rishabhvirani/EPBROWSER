<div>
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form  wire:submit.prevent="update">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CreateLabel">Edit User</h5>
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
                        <div class="mb-2">
                                <div style="display:flex;padding:5px;">
                                    <label for="email_verified" style="margin-right:10px">Email Verified</label>
                                    <label class="switch s-icons s-outline  s-outline-primary mr-2">
                                        <input type="checkbox" id="email_verified" wire:model="state.email_verified">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                        </div>
                        <div class="mb-2">
                            <div style="display:flex;padding:5px;">
                                <label for="mobile_verified" style="margin-right:10px">Mobile Verified</label>
                                <label class="switch s-icons s-outline  s-outline-primary   mr-2">
                                    <input type="checkbox" id="mobile_verified" wire:model="state.mobile_verified">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div style="display:flex;padding:5px;">
                                <label for="user_banned" style="margin-right:10px">User Banned</label>
                                <label class="switch s-icons s-outline  s-outline-primary  mr-2">
                                    <input type="checkbox" id="user_banned" wire:model="state.user_banned">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <!-- <div class="form-group mb-4">
                            <input type="password" class="form-control" id="password" wire:model.defer="state.password" placeholder="Password">
                        </div>
                        <div class="form-group mb-4">
                            <input type="password" class="form-control" id="password_confirmation" wire:model.defer="state.password_confirmation" placeholder="Confirm Password">
                        </div> -->
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
                        <!-- <div class="form-group mb-3">
                            <input type="text" class="form-control" id="ref_code" wire:model.defer="state.ref_code" placeholder="Enter Referal ID">
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>  
            </form>
        </div>
    </div>
</div>
