<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VendorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendorResource\RelationManagers;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Select::make('status')
                ->options([
                    'pending'  => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->default('pending')
                ->required(),
        ]);
}

  public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('User'),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger'  => 'rejected',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
        ])
        ->actions([
            Action::make('approve')
                ->label('Approve')
                ->color('success')
                ->icon('heroicon-o-check')
                ->visible(fn (Vendor $record) => $record->status === 'pending')
                ->action(function (Vendor $record) {
                    $record->update(['status' => 'approved']);
                    $record->user->update(['role' => 'vendor']);

                    Notification::make()
                        ->title('Vendor Approved')
                        ->success()
                        ->send();
                }),
    //             Actions\Action::make('approve')
    // ->action(function (Vendor $record) {
    //     $record->update(['status' => 'approved']);
    //     $record->user->update(['role' => 'vendor']);
    // })

            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->visible(fn (Vendor $record) => $record->status === 'pending')
                ->action(function (Vendor $record) {
                    $record->update(['status' => 'rejected']);

                    Notification::make()
                        ->title('Vendor Rejected')
                        ->danger()
                        ->send();
                }),
    //             Actions\Action::make('reject')
    // ->action(fn (Vendor $record) =>
    //     $record->update(['status' => 'rejected'])
    // )

            Tables\Actions\EditAction::make(),
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
