<div class="row layout-top-spacing">
    <div class="col-xl-8 col-lg-8 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">                                
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Timers</h4>
                        <br>
                    </div>                                                                        
                </div>
            </div>
            <div class="widget-content">
                    @foreach($timers as $i=>$timer)
                    <div class="from-group row mb-2">
                        <label for="" class="col-xl-2 col-sm-2 col-form-label">Timer {{$i+1}}</label>
                        <div class="col-xl-3 col-lg-3 col-sm-3">
                            <input type="number" class="form-control" wire:model="timers.{{ $i }}.timer" placeholder="time" required>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-sm-3">
                            <input type="number" class="form-control" wire:model="timers.{{ $i }}.points"  placeholder="points" required>
                        </div>
                        @if($enabled_counter == $i+1 || $enabled_counter == $i)
                        <div class="col-xl-2 col-lg-2 col-sm-4">
                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                <input type="checkbox" id="active" wire:model="timers.{{ $i }}.active" />
                                <span class="slider"></span>
                            </label>
                        </div>
                        @else
                            <div class="col-xl-2 col-lg-2 col-sm-4">
                                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                    <input type="checkbox" id="active" wire:model="timers.{{ $i }}.active" disabled/>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endif
                        <div class="col-xl-2 col-xl-2">
                            <button wire:click="update({{ $i }})" class="btn btn-warning">update</button>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>