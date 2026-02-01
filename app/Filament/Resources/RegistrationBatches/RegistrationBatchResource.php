<?php

namespace App\Filament\Resources\RegistrationBatches;

use App\Filament\Resources\RegistrationBatches\Pages\CreateRegistrationBatch;
use App\Filament\Resources\RegistrationBatches\Pages\EditRegistrationBatch;
use App\Filament\Resources\RegistrationBatches\Pages\ListRegistrationBatches;
use App\Filament\Resources\RegistrationBatches\Pages\ViewRegistrationBatch;
use App\Filament\Resources\RegistrationBatches\Schemas\RegistrationBatchForm;
use App\Filament\Resources\RegistrationBatches\Schemas\RegistrationBatchInfolist;
use App\Filament\Resources\RegistrationBatches\Tables\RegistrationBatchesTable;
use App\Models\RegistrationBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrationBatchResource extends Resource
{
    protected static ?string $model = RegistrationBatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Periode Pendaftaran';
    protected static ?string $label = 'Periode Pendaftaran';

    public static function form(Schema $schema): Schema
    {
        return RegistrationBatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RegistrationBatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistrationBatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegistrationBatches::route('/'),
            'create' => CreateRegistrationBatch::route('/create'),
            'view' => ViewRegistrationBatch::route('/{record}'),
            'edit' => EditRegistrationBatch::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
