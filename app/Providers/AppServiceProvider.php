<?php

namespace App\Providers;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Indicator;
use Illuminate\Support\ServiceProvider;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('scanner', 'https://unpkg.com/html5-qrcode'),
        ]);

        TextColumn::macro('spatieBadge', function () {
            $this->badge();
            $this->formatStateUsing(fn ($state) => $state?->label() ?: 'Unknown');
            $this->color(fn ($state) => $state?->color());

            return $this;
        });

        TextColumn::macro('spatieState', function () {
            $this->formatStateUsing(fn ($state) => $state?->label() ?: 'Unknown');

            return $this;
        });

        TextColumn::macro('spatieBadge', function () {
            $this->formatStateUsing(fn ($state) => $state?->label() ?: 'Unknown');
            $this->badge();
            $this->color(fn ($state) => $state?->color());

            return $this;
        });

        SpatieMediaLibraryFileUpload::macro('image', function () {
            $this->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp']);

            return $this;
        });

        DateRangePicker::configureUsing(function (DateRangePicker $dateRangePicker) {
            $dateRangePicker->autoApply();
            $dateRangePicker->disableRanges();
            $dateRangePicker->displayFormat('DD MMMM YYYY', true);
            $dateRangePicker->format('d F Y');
        });

        DateRangeFilter::configureUsing(function (DateRangeFilter $dateRangeFilter) {
            $dateRangeFilter->autoApply();
            $dateRangeFilter->withIndicator();
            $dateRangeFilter->disableRanges();
            $dateRangeFilter->displayFormat('DD MMMM YYYY', true);
            $dateRangeFilter->format('d F Y');
        });

        DateRangeFilter::macro('removableIndicator', function (?bool $condition = true) {
            if (! $condition) {
                /** @var DateRangeFilter $this */
                $this->indicateUsing(function (array $data, DateRangeFilter $filter) {
                    $datesString = data_get($data, $filter->getName());

                    if (empty($datesString)) {
                        return null;
                    }

                    $label = __('filament-daterangepicker-filter::message.period', [
                        'label' => $filter->getLabel(),
                        'column' => $filter->getName(),
                        'period' => $datesString,
                    ]);

                    return Indicator::make($label)->removable(false);
                });
            }

            return $this;
        });
    }
}
