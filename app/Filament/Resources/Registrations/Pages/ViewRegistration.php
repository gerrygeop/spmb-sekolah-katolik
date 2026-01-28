<?php

namespace App\Filament\Resources\Registrations\Pages;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\Registrations\RegistrationResource;
use Filament\Actions\EditAction;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Utilities\Get;

class ViewRegistration extends ViewRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
            Actions\Action::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-o-check-circle')
                ->modalWidth('md')
                ->modalHeading('Update Status Pendaftaran')
                ->form([
                    Forms\Components\Select::make('status')
                        ->options(
                            collect(RegistrationStatus::cases())
                                ->mapWithKeys(fn(RegistrationStatus $status) => [
                                    $status->value => $status->getLabel()
                                ])
                        )
                        ->required()
                        ->default(fn() => $this->record->status->value)
                        ->live(),

                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan')
                        ->helperText('Wajib diisi jika status Perlu Perbaikan')
                        ->placeholder('Tambahkan catatan ...')
                        ->default(fn() => $this->record->notes)
                        ->required(fn(Get $get) => $get('status') === RegistrationStatus::PERBAIKAN->value),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => $data['status'],
                        'notes' => $data['notes'],
                    ]);

                    $status = RegistrationStatus::from($data['status']);

                    Notification::make()
                        ->title('Status Diperbarui')
                        ->body("Status pendaftaran telah diubah menjadi: {$status->getLabel()}")
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
                }),
        ];
    }
}
