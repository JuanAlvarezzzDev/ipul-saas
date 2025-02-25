<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionsResource\Pages;
use App\FilaTment\Resources\TransactionsResource\RelationManagers;
use App\Models\Transactions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;
    protected static ?string $tenantOwnershipRelationshipName = 'workspace';
    protected static ?string $tenantRelationshipName = 'transactions';
    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $modelLabel = 'Movimiento';
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('church_id', Auth::user()->church_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('concept_id')
                    ->relationship('transactionConcept', 'name')
                    ->label('Concepto')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('transaction_date')
                    ->label('Fecha del Movimiento')
                    ->native(false)
                    ->required(),
                    Forms\Components\TextInput::make('description')
                    ->label('Descripción (opcional)')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachments')
                ->label('Archivos adjuntos (opcional)')
                    ->openable()
                    ->multiple()
                    ->disk('r2')
                    ->visibility('private')
                    ->directory('transactions-attachments')
                    ->previewable()
                    ->downloadable()
                    ->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto')
                    ->sortable()
                    ->money('PAB')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('transactionConcept.name')
                    ->label('Conceptos')
                    ->sortable()
                    ->searchable(),    
                Tables\Columns\TextColumn::make('transactionConcept.transaction_type')
                    ->label('Movimientos')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripcion')
                    ->sortable()
                    ->searchable()
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Fecha del Movimiento')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   

            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}
