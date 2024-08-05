<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeficaExport implements FromArray, WithHeadings
{
    protected $table;

    public function __construct(array $table)
    {
        $this->table = $table;
    }

    public function array(): array
    {
        return $this->table;
    }

    public function headings(): array
    {
        $headings = [''];
        for ($i = 0; $i < 59; $i++) {
            $headings[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        return $headings;
    }
}
