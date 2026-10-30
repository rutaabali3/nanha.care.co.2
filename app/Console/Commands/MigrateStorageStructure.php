<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateStorageStructure extends Command
{
    protected $signature = 'nanhacare:migrate-storage';

    protected $description = 'Migrate files from user-ID-based folders to a flat UUID-based structure';

    private array $mappings;

    public function __construct()
    {
        parent::__construct();

        $this->mappings = [
            'avatars' => [
                ['table' => 'users', 'column' => 'avatar'],
                ['table' => 'babysitter_profiles', 'column' => 'avatar'],
            ],
            'logos' => [
                ['table' => 'shops', 'column' => 'logo'],
            ],
            'banners' => [
                ['table' => 'shops', 'column' => 'banner'],
            ],
            'products' => [
                ['table' => 'product_images', 'column' => 'path'],
            ],
            'doctor-photos' => [
                ['table' => 'doctor_profiles', 'column' => 'profile_photo'],
            ],
            'doctor_photos' => [
                ['table' => 'doctor_profiles', 'column' => 'profile_photo'],
            ],
            'doctor-documents' => [
                ['table' => 'doctor_profiles', 'column' => 'medical_license'],
                ['table' => 'doctor_profiles', 'column' => 'pmdc_cert'],
                ['table' => 'doctor_profiles', 'column' => 'cv'],
            ],
            'blog_covers' => [
                ['table' => 'blog_posts', 'column' => 'cover_image'],
            ],
            'certifications' => [],
            'shops/logos' => [
                ['table' => 'shops', 'column' => 'logo'],
            ],
            'shops/banners' => [
                ['table' => 'shops', 'column' => 'banner'],
            ],
        ];
    }

    public function handle(): void
    {
        $disk = Storage::disk('public');
        $migrated = 0;
        $updated = 0;

        foreach ($this->mappings as $category => $dbColumns) {
            if (! $disk->exists($category)) {
                continue;
            }

            $items = $disk->directories($category);

            foreach ($items as $dir) {
                $dirName = basename($dir);

                if (! is_numeric($dirName)) {
                    continue;
                }

                $files = $disk->files($dir);

                foreach ($files as $oldPath) {
                    $filename = basename($oldPath);
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $newFilename = Str::uuid().($ext ? '.'.$ext : '');
                    $newPath = $category.'/'.$newFilename;

                    $disk->move($oldPath, $newPath);

                    $this->updateDatabaseRecords($oldPath, $newPath, $dbColumns);

                    $migrated++;
                    $this->line("Migrated: {$oldPath} -> {$newPath}");
                }

                if (empty($disk->files($dir))) {
                    $disk->deleteDirectory($dir);
                    $this->line("Removed empty directory: {$dir}");
                }
            }
        }

        $this->info("Done! Migrated {$migrated} files and updated database records.");
    }

    private function updateDatabaseRecords(string $oldPath, string $newPath, array $dbColumns): void
    {
        if (empty($dbColumns)) {
            return;
        }

        foreach ($dbColumns as $mapping) {
            $updated = DB::table($mapping['table'])
                ->where($mapping['column'], $oldPath)
                ->update([$mapping['column'] => $newPath]);

            if ($updated > 0) {
                $this->line("  Updated {$mapping['table']}.{$mapping['column']} ({$updated} row(s))");
            }
        }
    }
}
