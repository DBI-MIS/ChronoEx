<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                DateTimePicker::make('time_in')->label('Time In'),
                DateTimePicker::make('time_out')->label('Time Out'),
                DateTimePicker::make('lunch_start')->label('Lunch Start'),
                DateTimePicker::make('lunch_end')->label('Lunch End'),
                DateTimePicker::make('break_start')->label('Break Start'),
                DateTimePicker::make('break_end')->label('Break End'),
                TextInput::make('is_timed_in')->default('pending'),
                TextInput::make('is_timed_out')->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('time_in')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('time_out')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('is_timed_in')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_timed_out')
                    ->searchable(),
                    TextColumn::make('user.name')->label('User'),
                    TextColumn::make('time_in')->label('Time In'),
                    TextColumn::make('time_out')->label('Time Out'),
                    TextColumn::make('lunch_start')->label('Lunch Start'),
                    TextColumn::make('lunch_end')->label('Lunch End'),
                    TextColumn::make('break_start')->label('Break Start'),
                    TextColumn::make('break_end')->label('Break End'),
                    TextColumn::make('calculateWorkHours')->label('Work Hours')->getStateUsing(fn ($record) => $record->calculateWorkHours()),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAttendances::route('/'),
        ];
    }
}
