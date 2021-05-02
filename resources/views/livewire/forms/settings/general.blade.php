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
    <label for="isWithdrwalEnabled" class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Withdrwal </label>
        <div class="col-xl-10 col-lg-9 col-sm-10">
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input type="checkbox" id="isWithdrwalEnabled" wire:model="isWithdrwalEnabled">
                <span class="slider"></span>
            </label>
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