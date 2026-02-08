<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul'),

                        TextEntry::make('sort_order')
                            ->label('Urutan'),

                        TextEntry::make('image_url')
                            ->label('Path Gambar')
                            ->columnSpanFull(),

                        TextEntry::make('caption')
                            ->label('Deskripsi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('is_active')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn(bool $state) => $state ? 'Aktif' : 'Nonaktif'),
                        TextEntry::make('created_at')
                            ->label('Waktu dibuat')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Terkahir diperbarui')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
