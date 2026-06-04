<div class="pm-page">
    <header class="pm-top-row pm-reveal">
        <div>
            <p class="pm-eyebrow">{{ __('navigation.account') }}</p>
            <h1 class="pm-headline">{{ __('navigation.personal_details') }}</h1>
            <p class="pm-subhead">{{ auth()->user()->email }}</p>
        </div>
    </header>

    <div class="pm-divider"></div>

    <section class="pm-panel pm-reveal" style="animation-delay: 80ms">
        <div class="grid md:grid-cols-2 gap-4">
            <x-form.input name="first_name" type="text" :label="__('general.input.first_name')"
                :placeholder="__('general.input.first_name_placeholder')" wire:model="first_name" required dirty />
            <x-form.input name="last_name" type="text" :label="__('general.input.last_name')"
                :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name" required dirty />

            <x-form.input name="email" type="email" :label="__('general.input.email')"
                :placeholder="__('general.input.email_placeholder')" required wire:model="email" dirty />

            <x-form.properties :custom_properties="$custom_properties" :properties="$properties" dirty />
        </div>

        <x-button.primary wire:click="submit" class="mt-6 md:!w-fit">
            {{ __('general.update') }}
        </x-button.primary>
    </section>
</div>
