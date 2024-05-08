@extends('layouts.app')

@section('content')

    <div class="flex justify-center">
        <div class="flex-1 max-w-xl mt-12">
            @livewire(\App\Livewire\CommunicationHandler::class)
        </div>
    </div>

@endsection
