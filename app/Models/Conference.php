<?php

namespace App\Models;

use App\Enums\Region;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conference extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'venue_id' => 'integer',
        'region' => Region::class
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class);
    }

    public function talks(): BelongsToMany
    {
        return $this->belongsToMany(Talk::class);
    }

    public static function getForm(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Conference')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('description')
                ->required()
                ->maxLength(255),
            Forms\Components\DateTimePicker::make('start_date')
                ->required(),
            Forms\Components\DateTimePicker::make('end_date')
                ->required(),
            Forms\Components\Toggle::make('is_published'),
            Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ])
                ->default('draft')
                ->required(),
            Forms\Components\Select::make('region')
                ->live()
                ->default(Region::US)
                ->enum(Region::class)
                ->options(Region::class)
                ->required(),
            Forms\Components\Select::make('venue_id')
                ->searchable()
                ->preload()
                ->createOptionForm(Venue::getForm())
                ->relationship('venue', 'name', modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                    return $query->where('region', $get('region'));
                }),
        ];
    }
}
