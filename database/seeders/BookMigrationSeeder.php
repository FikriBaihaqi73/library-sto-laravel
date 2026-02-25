<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFilePath = '/Users/programmer/Downloads/db_09022026/opac (2).sql';
        
        if (!file_exists($sqlFilePath)) {
            $this->command->error("File SQL tidak ditemukan: $sqlFilePath");
            return;
        }

        $this->command->info("Memulai migrasi data dari SQL...");

        $publishers = [];
        $places = [];
        $authors = [];
        $gmds = [];
        $biblioAuthors = [];
        $itemCounts = []; // biblio_id => count
        $itemCodes = []; // biblio_id => [codes]

        $handle = fopen($sqlFilePath, "r");
        $currentTable = null;

        $this->command->info("Tahap 1: Membaca tabel master dan menghitung eksemplar...");

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '--') || str_starts_with($line, '/*')) continue;

            if (preg_match("/INSERT INTO `([^`]+)`/", $line, $matches)) {
                $currentTable = $matches[1];
            }

            if (str_starts_with($line, '(') && $currentTable) {
                $values = $this->parseSqlValues(rtrim($line, ',;'));
                
                if ($currentTable === 'mst_publisher') {
                    $publishers[$values[0]] = $values[1];
                } elseif ($currentTable === 'mst_place') {
                    $places[$values[0]] = $values[1];
                } elseif ($currentTable === 'mst_author') {
                    $authors[$values[0]] = $values[1];
                } elseif ($currentTable === 'mst_gmd') {
                    $gmds[$values[0]] = $values[2];
                } elseif ($currentTable === 'biblio_author') {
                    $biblioAuthors[$values[0]][] = $values[1];
                } elseif ($currentTable === 'item') {
                    $biblioId = $values[1]; // Index 1 is biblio_id in item table
                    if ($biblioId) {
                        $itemCounts[$biblioId] = ($itemCounts[$biblioId] ?? 0) + 1;
                        if (isset($values[4])) {
                            $itemCodes[$biblioId][] = $values[4]; // Index 4 is item_code
                        }
                    }
                }
            }
        }
        fclose($handle);

        $this->command->info("Tahap 2: Memasukkan data buku ke database...");

        $handle = fopen($sqlFilePath, "r");
        $currentTable = null;
        $insertedCount = 0;
        $chunk = [];
        $now = Carbon::now();

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (preg_match("/INSERT INTO `([^`]+)`/", $line, $matches)) {
                $currentTable = $matches[1];
            }

            if ($currentTable === 'biblio' && str_starts_with($line, '(')) {
                $values = $this->parseSqlValues(rtrim($line, ',;'));
                if (count($values) < 17) continue;

                $biblioId = $values[0];
                $authorNames = [];
                if (isset($biblioAuthors[$biblioId])) {
                    foreach ($biblioAuthors[$biblioId] as $authId) {
                        if (isset($authors[$authId])) $authorNames[] = $authors[$authId];
                    }
                }

                $chunk[] = [
                    'id'                    => $biblioId, // Keep original ID for debugging/linking
                    'title'                 => $values[2] ?? 'Unknown Title',
                    'author'                => implode(', ', $authorNames) ?: '-',
                    'publisher'             => $publishers[$values[5]] ?? '-',
                    'place_of_publication'  => $places[$values[12]] ?? '-',
                    'year_of_publication'   => $values[6] ?? '-',
                    'isbn_issn'             => $values[4] ?? null,
                    'language'              => $values[10] ?? 'id',
                    'collation'             => $values[7] ?? null,
                    'gmd_type'              => $gmds[$values[1]] ?? null,
                    'classification'        => $values[13] ?? null,
                    'call_number'           => $values[9] ?? null,
                    'abstract'              => $values[14] ?? null,
                    'cover_image'           => $values[15] ?? null,
                    'series_title'          => $values[8] ?? null,
                    'attachment'            => $values[16] ?? null,
                    'edition'               => $values[3] ?? null,
                    'total_items'           => $itemCounts[$biblioId] ?? 0,
                    'item_code'             => isset($itemCodes[$biblioId]) ? implode(', ', $itemCodes[$biblioId]) : null,
                    'is_featured'           => (isset($values[18]) && $values[18] == 1) ? true : false,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ];

                if (count($chunk) >= 500) {
                    DB::table('books')->insert($chunk);
                    $insertedCount += count($chunk);
                    $this->command->info("Telah memasukkan $insertedCount buku...");
                    $chunk = [];
                }
            }
        }

        if (count($chunk) > 0) {
            DB::table('books')->insert($chunk);
            $insertedCount += count($chunk);
        }

        fclose($handle);
        $this->command->info("Selesai! Total $insertedCount buku telah dimigrasi dengan jumlah eksemplar yang sesuai.");
    }

    private function parseSqlValues($str)
    {
        $str = ltrim($str, '(');
        $str = rtrim($str, ')');
        $values = [];
        $currentValue = '';
        $inString = false;
        $escaped = false;

        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];
            if ($escaped) { $currentValue .= $char; $escaped = false; continue; }
            if ($char === '\\') { $escaped = true; continue; }
            if ($char === "'") { $inString = !$inString; continue; }
            if ($char === ',' && !$inString) {
                $val = trim($currentValue);
                $values[] = ($val === 'NULL') ? null : $val;
                $currentValue = '';
                continue;
            }
            $currentValue .= $char;
        }
        $val = trim($currentValue);
        $values[] = ($val === 'NULL') ? null : $val;
        return $values;
    }
}
