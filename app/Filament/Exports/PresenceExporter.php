<?php

namespace App\Filament\Exports;

use App\Models\Presence;
use App\States\PresenceStatus\PresenceStatus;
use Carbon\Carbon;
use Exception;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class PresenceExporter extends Exporter
{
    protected static ?string $model = Presence::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')
                ->label('Nama'),
            ExportColumn::make('created_at')
                ->label('Tanggal')
                ->formatStateUsing(fn (?Carbon $state) => $state?->format('d F Y')),
            ExportColumn::make('start_at')
                ->label('Masuk')
                ->formatStateUsing(fn (?Carbon $state) => $state?->format('H:i')),
            ExportColumn::make('end_at')
                ->label('Pulang')
                ->formatStateUsing(fn (?Carbon $state) => $state?->format('H:i')),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (?PresenceStatus $state) => $state->label()),
            ExportColumn::make('reason')
                ->label('Keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        if ($export->total_rows == 0) {
            return 'Tidak ada data di tanggal yang dipilih.';
        }

        if ($export->getFailedRowsCount() === $export->total_rows) {
            return 'Terjadi kesalahan saat merekap. Silakan coba lagi';
        }

        return 'Proses rekap selesai. Silakan unduh file berikut.';
    }

    public static function getCompletedNotificationTitle(Export $export): string
    {
        return 'Rekap Kehadiran Selesai';
    }

    /**
     * @throws Exception
     */
    public static function getOptionsFormComponents(): array
    {
        return [
            DateRangePicker::make('created_at')
                ->label('Tanggal'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return 'rekap-kehadiran-'.now()->timestamp;
    }

    public function getFormats(): array
    {
        return [
            ExportFormat::Xlsx,
        ];
    }
}
