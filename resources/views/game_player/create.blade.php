@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>Crea Partecipazione Giocatore Partita</h2>
                </div>
                <div class="card-body">
                    {{-- gestione errore --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <form action="{{ route('game_player.store')}}" method="POST">
                        
                        @csrf
                
                        <div class="mb-3">
                            <label for="giocatore_id" class="form-label">Giocatore</label>
                            <select class="form-select" id="giocatore_id" name="giocatore_id" required>
                                <option value="">Seleziona un giocatore</option>
                                @foreach($giocatori as $giocatore)
                                    <option value="{{ $giocatore->id }}" {{ $giocatore_id == $giocatore->id ? 'selected' : '' }}>
                                        {{ $giocatore->nome }} {{ $giocatore->cognome }} ({{ $giocatore->team->nome ?? 'N/D' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="partita_id" class="form-label">Partita</label>
                            <select class="form-select" id="partita_id" name="partita_id" required>
                                <option value="">Seleziona una partita</option>
                                @foreach($partite as $partita)
                                    <option value="{{ $partita->id }}" {{ $partita_id == $partita->id ? 'selected' : '' }}>
                                        {{ $partita->teamHome->nome }} vs {{ $partita->teamAway->nome }}
                                        ({{ $partita->data }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                
                        <button type="submit" class="btn btn-success">Salva Partecipazione Giocatore Partita</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Indietro</a>
                    </form>    
                </div>

@endsection