<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class SignaturePad extends Field
{
    protected string $view = 'forms.components.signature-pad';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (SignaturePad $component, $state) {
            // Load existing signature if available
            $component->state($state);
        });

        $this->dehydrateStateUsing(function ($state) {
            // Return the base64 signature data
            return $state;
        });
    }
}
