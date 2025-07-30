<?php

namespace App\Filament\Pages\System;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

class ViewLogs extends Page
{
    protected static string $view = 'filament.pages.view-logs';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Quản trị hệ thống';
    protected static ?string $title = 'System Logs';
    protected static ?int $navigationSort = 5;

    public $logs = [];

    public function mount(): void
    {
        $rawLogs = DB::connection('mongodb')
            ->getMongoClient()
            ->selectDatabase(config('database.connections.mongodb.database'))
            ->selectCollection('logs')
            ->find([], [
                'sort' => ['datetime' => -1],
                'limit' => 50,
            ])
            ->toArray();

        // Convert BSON → array
        $this->logs = array_map(function ($log) {
            return [
                '_id'        => isset($log['_id']) ? (string) $log['_id'] : null,
                'level_name' => $log['level_name'] ?? '',
                'message'    => $log['message'] ?? '',
                'datetime'   => (isset($log['datetime']) && $log['datetime'] instanceof UTCDateTime)
                    ? $log['datetime']->toDateTime()->format('Y-m-d H:i:s')
                    : null,
            ];
        }, $rawLogs);
    }
}
