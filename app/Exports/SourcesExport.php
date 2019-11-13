<?php

namespace App\Exports;

use App\Source;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Class SourcesExport
 * @package App\Exports
 */
class SourcesExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithMapping
{
    /** @var User */
    private $user;

    /**
     * SourcesExport constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function collection(): Collection
    {
        return $this->user
            ->sources()
            ->get();
    }

    /**
     * @var Source $source
     * @return array
     */
    public function map($source): array
    {
        return [
            $source->external_id,
            $source->name,
            $source->phone,
            $source->country,
            $source->province,
            $source->city,
            $source->address,
            $source->postal_code,
            $source->website,
            $source->gmb_place_id
        ];
    }


    /**
     * {@inheritDoc}
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function headings(): array
    {
        return [
            'Number',
            'Location Name',
            'Phone',
            'Country',
            'Province',
            'City',
            'Address',
            'Postal code',
            'Website',
            'Google identifier'
        ];
    }

}
