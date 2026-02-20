@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Modifica Giocatore: {{$giocatore->nome}} {{$giocatore->cognome}}</h2>
                </div>
                {{-- form --}}
                <div class="card-body">
                    {{-- enctype per caricamento immagini --}}
                    <form action="{{ route('players.update', $giocatore->id) }}" method="POST" enctype="multipart/form-data">
                        
                        @csrf

                        @method("PUT")
                
                        <div class="form-control mb-3">
                            <label for="nome" class="form-label">Nome giocatore</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{$giocatore->nome}}" required>
                        </div>

                        <div class="form-control mb-3">
                            <label for="cognome" class="form-label">Cognome giocatore</label>
                            <input type="text" name="cognome" id="cognome" class="form-control" value="{{$giocatore->cognome}}" required>
                        </div>

                        <div class="form-control mb-3">
                            <label for="ruolo" class="form-label">Ruolo</label>
                            <select name="ruolo" id="ruolo" class="form-control" required>
                                @foreach ($ruoli as $ruolo)
                                    <option value="{{$ruolo}}" {{ $giocatore->ruolo == $ruolo ? "selected" : ""}} >{{$ruolo}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control mb-3">
                            <label for="numero_maglia" class="form-label">Numero Maglia</label>
                            <input type="number" name="numero_maglia" id="numero_maglia" min="1" max="99" value="{{$giocatore->numero_maglia}}" required>
                        </div>
                
                        <div class="form-control mb-3">
                            <label for="eta" class="form-label">Età</label>
                            <input type="number" name="eta" id="eta" min="15" max="99" value="{{$giocatore->eta}}" required>
                        </div>

                        {{-- aggiornamento foto giocatore --}}
                        <div class="form-control mb-3">
                            <label for="foto" class="form-label">Foto Giocatore</label>
                            <input type="file" name="foto" id="foto">
                            @if ($giocatore->foto)
                                <div id="giocatore-foto">
                                    <img class="img-fluid w-25" src="{{asset ("storage/". $giocatore->foto)}}" alt="foto">
                                </div>
                            @endif
                        </div>
                
                        <div class="form-control mb-3">
                            <label for="squadra_id" class="form-label">Selezione Squadra</label>
                            <select name="squadra_id" id="squadra_id" class="form-control" required>
                                @foreach ($squadre as $squadra)
                                    <option value="{{$squadra->id}}" {{ $giocatore->squadra_id == $squadra->id ? "selected" : ""}} >{{$squadra->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Sezione Partite con Checkbox -->
                        <div class="form-control mb-3">
                            <label class="form-label">Partecipazione alle Partite</label>
                            <div class="alert alert-info">
                                <small>Seleziona/deseleziona le partite in cui il giocatore ha partecipato</small>
                            </div>
                            
                            @if ($partite->count() > 0)
                            <div id="partite-container">
                                <div class="text-muted">
                                    @foreach ($partite as $partita)
                                    <div class="partita me-3">
                                        <input type="checkbox" name="games[]" value="{{$partita->id}}" id="game-{{$partita->id}}" {{$giocatore->games->contains($partita->id) ? "checked" : ""}} >
                                        <label for="game-{{$partita->id}}" class="form-label">{{ $partita->teamHome->nome }} vs {{ $partita->teamAway->nome }}</label>
                                    </div>    
                                    @endforeach
                                </div>
                            </div>
                            @else 
                            <div class="alert alert-warning">
                                Nessuna partita disponibile del giocatore selezionato selezionata.
                            </div>
                            @endif
                        </div>
                
                        <button type="submit" class="btn btn-success">Salva Modifica Giocatore</button>
                        <a href="{{ route('players.show', $giocatore->id) }}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

@endsection