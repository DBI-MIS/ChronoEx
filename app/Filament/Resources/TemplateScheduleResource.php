<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateScheduleResource\Pages;
use App\Filament\Resources\TemplateScheduleResource\RelationManagers;
use App\Models\TemplateSchedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplateScheduleResource extends Resource
{
    protected static ?string $model = TemplateSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('day_of_week')
                    ->label('Day of Week')
                    ->options([
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        7 => 'Sunday',
                    ])
                    ->required(),

                Forms\Components\Select::make('week')
                    ->label('Week')
                    ->options([
                        1 => 'Week 1',
                        2 => 'Week 2',
                    ])
                    ->default(1)
                    ->required(),

                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->required(),

                Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->required()
                    ->after('start_time'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),
                TextColumn::make('day_of_week')
                ->label('Day of Week')
                ->formatStateUsing(fn ($state) => match ($state) {
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    7 => 'Sunday',
                    default => 'Unknown',
                }),
                TextColumn::make('week')
                ->label('Week')
                ->formatStateUsing(fn ($state) => $state === 1 ? 'Week 1' : 'Week 2'),
                TextColumn::make('start_time')
                ->label('Start Time')
                ->time(),
                TextColumn::make('end_time')
                ->label('End Time')
                ->time(),
                TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTemplateSchedules::route('/'),
        ];
    }
}
