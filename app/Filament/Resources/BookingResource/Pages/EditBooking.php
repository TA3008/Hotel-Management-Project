<?php

namespace App\Filament\Resources\BookingResource\Pages;

use Filament\Actions;
use App\Mail\BookingStatusConfirmedMail;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BookingResource;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $originalStatus = $this->record->status;

        // Nếu trạng thái chuyển sang confirmed
        if ($originalStatus !== $data['status'] && $data['status'] === BookingStatusEnum::Confirmed->value) {
            Mail::to($this->record->customer_email)
                ->send(new BookingStatusConfirmedMail($this->record));
        }

        return $data;
    }
}
