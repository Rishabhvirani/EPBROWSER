<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>
    <x-slot name="form">
        <div class="form-group row mb-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="col-xl-10 col-lg-9 col-sm-10" wire:model.defer="state.name" autocomplete="name" />
        </div>
        <div class="form-group row mb-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="col-xl-10 col-lg-9 col-sm-10" wire:model.defer="state.email" />
        </div>
        <div class="text-right">
            <x-jet-input-error for="name" class="mt-2" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
    </x-slot>
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>
        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>