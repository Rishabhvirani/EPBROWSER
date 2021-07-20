<form  wire:submit.prevent="update">
    <div class="from-group row mb-4">
        <label for="isConversionEnabled" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Conversion </label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input type="checkbox" id="isConversionEnabled" wire:model="isConversionEnabled">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="form-group row mb-4">
            <label for="points" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Points</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="number" class="form-control" id="points" wire:model="points"  step=".01" placeholder="Enter Points" required>
            </div>
        </div>
        
        <div class="form-group row mb-4">
            <label for="dollar" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">USD</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="number" class="form-control" id="dollar" wire:model="dollar" step=".01" placeholder="Enter USD" required>
            </div>
        </div>

        <div class="form-group row mb-4">
            <label for="MinConversion" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Minimun Conversion</label>
            <div class="col-xl-10 col-lg-9 col-sm-10">
                <input type="number" class="form-control" id="MinConversion" wire:model="MinConversion" step=".01" placeholder="Enter Minimum Conversion" required>
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