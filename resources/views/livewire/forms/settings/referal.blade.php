<form  wire:submit.prevent="update">
    <div class="from-group row mb-4">
    <label for="hEmail" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Referal Earning</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input type="checkbox" wire:model="isReferalActive">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="form-group row mb-4">
        <label for="hEmail" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Parent Earning</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="number" class="form-control" id="parentEarning" wire:model="parentEarning" placeholder="Enter Points" required>
        </div>
    </div>
    <div class="form-group row mb-4">
        <label for="hEmail" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Child Earning</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="number" class="form-control" id="childEarning" wire:model="childEarning" placeholder="Enter Points" required>
        </div>
    </div>
    
    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
</form>   