<?php

namespace App\Livewire;

use App\Models\Communication;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CommunicationHandler extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->placeholder('Nome'),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefone de Contacto')
                    ->required(),
                Forms\Components\TextInput::make('cep')
                    ->label('CEP')
                    ->required(),

                Forms\Components\Repeater::make('people')
                    ->label('Pessoas')
                    ->reorderable(false)
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('contact')
                            ->label('Contacto')
                            ->required(),
                        Forms\Components\Checkbox::make('needs_medical_assistance')
                            ->label('Necessita de Resgate Médico'),
                    ]),

                Forms\Components\Repeater::make('animals')
                    ->label('Animais')
                    ->reorderable(false)
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('breed')
                            ->label('Espécie')
                            ->required(),
                        Forms\Components\Radio::make('size')
                            ->columnSpan(2)
                            ->inline()
                            ->label('Tamanho')
                            ->options([
                                'small' => 'Pequeno',
                                'medium' => 'Médio',
                                'large' => 'Grande',
                            ]),
                    ]),
            ])
            ->statePath('data')
            ->model(Communication::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Communication::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.communication-handler');
    }
}
