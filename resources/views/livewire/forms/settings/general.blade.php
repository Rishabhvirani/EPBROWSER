<form  wire:submit.prevent="update">
    <div class="from-group row mb-4">
        <label for="isNotificationEnabled" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Notification </label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input type="checkbox" id="isNotificationEnabled" wire:model="isNotificationEnabled">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="from-group row mb-4">
        <label for="isTimerActive" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Timer Earning </label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input type="checkbox" id="isTimerActive" wire:model="isTimerActive">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    

    <div class="form-group row mb-4">
        <label for="TimerParentEarning" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Timer Referal Earning(%)</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="text" class="form-control" id="TimerParentEarning" wire:model="TimerParentEarning" placeholder="Enter Timer Referal Earning" required>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label for="appVersion" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">App Version</label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <input type="text" class="form-control" id="appVersion" wire:model="appVersion" placeholder="Enter Live App version" required>
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