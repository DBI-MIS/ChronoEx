<?php

namespace App\Filament\Resources\TemplateScheduleResource\Pages;

use App\Filament\Resources\TemplateScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTemplateSchedules extends ManageRecords
{
    protected static string $resource = TemplateScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
