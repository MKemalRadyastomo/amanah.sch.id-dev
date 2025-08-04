# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Starting Development Environment
- `composer dev` - Starts all development services concurrently (server, queue, logs, vite)
- `php artisan serve` - Start Laravel development server only
- `npm run dev` - Start Vite development server for frontend assets
- `npm run build` - Build production assets

### Testing
- `composer test` - Run full test suite (config:clear + artisan test)
- `php artisan test` - Run tests directly
- `vendor/bin/pest` - Run Pest PHP tests directly
- Tests use Pest PHP framework with Filament-specific configurations

### Code Quality
- `vendor/bin/pint` - Laravel Pint for code formatting (PSR-12)
- Code follows Laravel conventions and PSR-12 standards

### Database
- `php artisan migrate` - Run database migrations
- `php artisan db:seed` - Run database seeders
- Uses SQLite for testing environment (in-memory)

## Architecture Overview

### Technology Stack
- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Vite + TailwindCSS 4.0
- **Admin Panel**: Filament v3.3 (primary interface)
- **Testing**: Pest PHP with Laravel plugin
- **Database**: Supports multiple drivers, SQLite for testing

### Core Domain: Presence Management System
This is an employee presence/attendance tracking system for "Amanah School" with the following key components:

#### Models & States
- **User**: Employee model with roles, media attachments, and status states
  - Uses Spatie packages for permissions, media library, and model states
  - Default password is date of birth in 'dmy' format
  - Has relationship with presence records
- **Presence**: Daily attendance records with start/end times and status
  - Uses token-based check-in/out system
  - Tracks overtime and tardiness through `isOverdue()` and `isUntimely()` methods
  - Soft deletes enabled

#### State Management
- **PresenceStatus**: Abstract state class with multiple concrete states (Alpha, Late, Permit, Sick, etc.)
- **UserStatus**: User account states (Active, Inactive, DropOut)
- States provide color coding and labels for UI display

#### Filament Admin Panel
- **Resources**: PresenceResource, UserResource, AccountPresenceResource
- **Pages**: Dashboard, PresenceScanner (QR code scanning interface)
- **Widgets**: DailyActivityWidget, PresenceWidget for dashboard metrics
- **Exports**: PresenceExporter for data export functionality

#### Key Features
- QR code-based presence scanning system
- Token-based authentication for presence recording
- Date range filtering with Malzariey's daterangepicker
- Media management for user profiles
- Role-based permissions system
- Real-time presence monitoring dashboard

### Directory Structure Highlights
- `app/Filament/` - All Filament admin panel components
- `app/States/` - Spatie Model States for status management  
- `app/Settings/` - Laravel Settings for presence configuration
- `database/settings/` - Settings migrations for presence configuration
- `resources/views/filament/` - Custom Filament view overrides

### Package Dependencies
Key packages that define the architecture:
- `filament/filament` - Admin panel framework
- `spatie/laravel-model-states` - State machine implementation
- `spatie/laravel-permission` - Role/permission system
- `spatie/laravel-settings` - Application settings management
- `spatie/laravel-medialibrary` - File/media management
- `milon/barcode` - QR code generation for presence tokens

### Configuration Notes
- Presence check-in/out times configured via PresenceSetting class
- Uses Laravel Sanctum for API authentication
- Filament panels configured for staff access
- Queue system integrated for background processing