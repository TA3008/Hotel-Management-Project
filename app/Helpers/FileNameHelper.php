<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FileNameHelper
{
    public static function aliasImageName(UploadedFile $file, ?Model $record = null, string $prefix = ''): string
    {
        $extension = $file->getClientOriginalExtension();

        // Nếu record có name -> slug, nếu không thì lấy tên file gốc
        $name = Str::slug($record?->name ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        // Thêm prefix nếu cần (vd: room_types/images/)
        return ($prefix ? $prefix.'/' : '').$name.'.'.$extension;
    }
}
