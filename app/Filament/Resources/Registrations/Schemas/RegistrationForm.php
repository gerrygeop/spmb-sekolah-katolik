<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('registration_code')
                    ->required(),
                Select::make('school_level')
                    ->options(['sd' => 'Sd', 'smp' => 'Smp', 'sma' => 'Sma'])
                    ->required(),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'pending_payment' => 'Pending payment',
            'payment_verified' => 'Payment verified',
            'verification_pending' => 'Verification pending',
            'need_revision' => 'Need revision',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ])
                    ->default('draft')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
