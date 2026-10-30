<?php

namespace App\Services;

use App\Contracts\IFileUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService implements IFileUploadService
{
    public function save(mixed $file, string $category): string
    {
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();

        return $file->storeAs($category, $filename, 'public');
    }

    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
