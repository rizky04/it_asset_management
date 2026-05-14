<?php

namespace Database\Seeders;

use App\Models\Handover;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HandoverSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/handovers_import.csv');
        $handle = fopen($file, 'r');

        // Skip header row
        fgetcsv($handle);

        $usedDocNumbers = [];
        $seq = 37; // Start after existing IT/I/2025/0036

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
            $docNumber = trim($row[14] ?? '');

            $handoverDate = $this->parseDate($date);

            if ($docNumber === '' || $docNumber === '-') {
                $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][now()->month - 1];
                $docNumber = sprintf('IT/%s/%s/%04d', $roman, now()->year, $seq++);
            }

            if (in_array($docNumber, $usedDocNumbers)) {
                $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][now()->month - 1];
                $docNumber = sprintf('IT/%s/%s/%04d', $roman, now()->year, $seq++);
            }

            $usedDocNumbers[] = $docNumber;

            Handover::create([
                'doc_number' => $docNumber,
                'type' => 'laptop',
                'handover_date' => $handoverDate,
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
