<?php

namespace Database\Seeders;

use App\Models\Handover;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HandoverAddonSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/addons_import.csv');
        $handle = fopen($file, 'r');

        // Skip header row
        fgetcsv($handle);

        $maxSeq = (int) Handover::where('doc_number', 'like', 'IT/%')
            ->selectRaw('MAX(CAST(SUBSTRING_INDEX(doc_number, \'/\', -1) AS UNSIGNED)) as max_seq')
            ->value('max_seq');

        $seq = $maxSeq + 1;
        $usedDocNumbers = Handover::pluck('doc_number')->all();

        while (($row = fgetcsv($handle)) !== false) {
            $toName = trim($row[3] ?? '');
            if ($toName === '') {
                continue;
            }

            $dept = trim($row[0] ?? '');
            $date = trim($row[1] ?? '');
            $fromName = trim($row[2] ?? '') ?: '-';
            $merek = $this->nullable($row[4] ?? '');
            $typeDevice = $this->nullable($row[5] ?? '');
            $serial = trim($row[6] ?? '');
            $processor = $this->nullable($row[7] ?? '');
            $storage = $this->nullable($row[8] ?? '');
            $ram = $this->nullable($row[9] ?? '');
            $screenSize = $this->nullable($row[10] ?? '');
            $os = $this->nullable($row[11] ?? '');
            $officeSw = $this->nullable($row[12] ?? '');
            $notes = $this->nullable($row[13] ?? '');

            $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][now()->month - 1];
            $docNumber = sprintf('IT/%s/%s/%04d', $roman, now()->year, $seq++);

            while (in_array($docNumber, $usedDocNumbers)) {
                $docNumber = sprintf('IT/%s/%s/%04d', $roman, now()->year, $seq++);
            }

            $usedDocNumbers[] = $docNumber;

            Handover::create([
                'doc_number' => $docNumber,
                'type' => 'add_on',
                'handover_date' => $this->parseDate($date),
                'from_name' => $fromName,
                'from_department' => $dept ?: null,
                'to_name' => $toName,
                'to_department' => $dept ?: null,
                'merek' => $merek,
                'type_device' => $typeDevice,
                'serial_number' => ($serial === '' || $serial === '-') ? null : $serial,
                'processor' => $processor,
                'storage' => $storage,
                'ram' => $ram,
                'screen_size' => $screenSize,
                'os' => $os,
                'office_sw' => $officeSw,
                'notes' => $notes,
                'software_list' => [],
                'accessories_list' => [],
                'status' => 'active',
            ]);
        }

        fclose($handle);
    }

    private function nullable(string $value): ?string
    {
        $v = trim($value);

        return ($v === '' || $v === '-') ? null : $v;
    }

    private function parseDate(string $date): string
    {
        if ($date === '' || $date === '#N/A') {
            return now()->format('Y-m-d');
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception) {
            return now()->format('Y-m-d');
        }
    }
}
