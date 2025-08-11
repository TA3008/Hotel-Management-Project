<?php

namespace App\Filament\Resources\Admin\BookingResource\Pages;

use Filament\Actions;
use App\Enums\BookingStatusEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusConfirmedMail;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Admin\BookingResource;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Config;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;
    protected string $originalStatus;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->originalStatus = $this->record->status->value; // trạng thái trước khi update
        return $data;
    }

    protected function afterSave(): void
    {
        $originalStatus = $this->record->getOriginal('status');
        $currentStatus = $this->record->status;

        if ($originalStatus !== $currentStatus && $currentStatus === BookingStatusEnum::Confirmed) {
            Mail::to($this->record->customer->email)
                ->send(new BookingStatusConfirmedMail($this->record));
        }
    }

}
