<?php

namespace App\Filament\Resources\SelectionSchedules;

use App\Filament\Resources\SelectionSchedules\Pages\CreateSelectionSchedule;
use App\Filament\Resources\SelectionSchedules\Pages\EditSelectionSchedule;
use App\Filament\Resources\SelectionSchedules\Pages\ListSelectionSchedules;
use App\Filament\Resources\SelectionSchedules\Pages\ViewSelectionSchedule;
use App\Filament\Resources\SelectionSchedules\Schemas\SelectionScheduleForm;
use App\Filament\Resources\SelectionSchedules\Schemas\SelectionScheduleInfolist;
use App\Filament\Resources\SelectionSchedules\Tables\SelectionSchedulesTable;
use App\Models\SelectionSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SelectionScheduleResource extends Resource
{
    protected static ?string $model = SelectionSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string | UnitEnum | null $navigationGroup = 'Kelola SPMB';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Jadwal Seleksi';
    protected static ?string $label = 'Jadwal Seleksi';
    protected static ?string $slug = 'jadwal-seleksi';

    public static function form(Schema $schema): Schema
    {
        return SelectionScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SelectionScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SelectionSchedulesTable::configure($table);
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
            'index' => ListSelectionSchedules::route('/'),
            'create' => CreateSelectionSchedule::route('/create'),
            'view' => ViewSelectionSchedule::route('/{record}'),
            'edit' => EditSelectionSchedule::route('/{record}/edit'),
        ];
    }
}
