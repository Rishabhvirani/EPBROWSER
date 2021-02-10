@props(['submit'])
<div id="flHorizontalForm" class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">                                
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <x-jet-section-title>
                    <x-slot name="title">{{ $title }}</x-slot>
                    <x-slot name="description">{{ $description }}</x-slot>
                </x-jet-section-title>
                </div>                                                                        
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form wire:submit.prevent="{{ $submit }}">
                {{$form}}
                @if (isset($actions))
                    <div class="text-right">
                        {{ $actions }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>