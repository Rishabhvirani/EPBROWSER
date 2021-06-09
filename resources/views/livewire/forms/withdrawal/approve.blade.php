<div>
    <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="approveLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form  wire:submit.prevent="update">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CreateLabel">Approve Withdrawal</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="username" name="username" wire:model.defer="state.username" placeholder="Username" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" id="email" wire:model.defer="state.email" placeholder="Email address" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" id="usd" name="usd" wire:model.defer="state.usd" placeholder="usd" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" id="epc" wire:model.defer="state.epc" placeholder="epc address" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="epc_address" name="epc_address" wire:model.defer="state.epc_address" placeholder="usd" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id" wire:model.defer="state.transaction_id" placeholder="Enter Transaction ID" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="url" name="url" wire:model.defer="state.url" placeholder="Enter Transaction URL" required/>
                                </div>
                            </div>
                        </div>                        
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
