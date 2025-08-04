<x-filament-panels::page>
    <div x-data="{ html5QrCode: new Html5Qrcode('reader') }">
        <div
                id="reader"
                class="w-full h-full"
                x-init="html5QrCode.start(
                    {
                        facingMode: 'environment'
                    },
                    {
                        fps: 60
                    },
                    (content) => {
                        $dispatch('submit', { token: content })
                        html5QrCode.stop()
                    },
                )"
        ></div>
        <div wire:loading.flex wire:loading.class="items-center justify-center w-full">
            <x-filament::loading-indicator class="h-5 w-5" />
            <div style="margin-left: 0.5rem">Loading</div>
        </div>
    </div>
</x-filament-panels::page>
