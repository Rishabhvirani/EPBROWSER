<form  wire:submit.prevent="update">
    <div class="from-group row mb-4">
    <label for="isWithdrwalEnabled" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Withdrawal </label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input type="checkbox" id="isWithdrwalEnabled" wire:model="isWithdrwalEnabled">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="form-group row mb-4">
        <label for="epc_rate" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">EPC rate</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="number" class="form-control" id="epc_rate" wire:model="epc_rate" step="0.001" placeholder="Enter epc rate" required>
        </div>
    </div>
    <div class="form-group row mb-4">
        <label for="MinWithdrawal" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Minimun Conversion</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="number" class="form-control" id="MinWithdrawal" wire:model="MinWithdrawal" step=".01" placeholder="Enter Minimum Conversion" required>
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