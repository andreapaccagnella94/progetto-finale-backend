@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Crea Giocatore</h2>
                </div>
                {{-- form --}}
                <div class="card-body">
                    <form action="{{ route('players.store')}}" method="POST">
                        
                        @csrf
                
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome giocatore</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cognome" class="form-label">Cognome giocatore</label>
                            <input type="text" name="cognome" id="cognome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="ruolo" class="form-label">Ruolo</label>
                            <select name="ruolo" id="ruolo" class="form-control" required>
                                <option value="">Seleziona Ruolo</option>
                                @foreach ($ruoli as $ruolo)
                                    <option value="{{$ruolo}}">{{$ruolo}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="numero_maglia" class="form-label">Numero Maglia</label>
                            <input type="number" name="numero_maglia" id="numero_maglia" min="1" max="99" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="eta" class="form-label">Età</label>
                            <input type="number" name="eta" id="eta" min="15" max="99" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="squadra_id" class="form-label">Selezione Squadra</label>
                            <select name="squadra_id" id="squadra_id" class="form-control" required>
                                <option value="">Seleziona Squadra</option>
                                @foreach ($squadre as $squadra)
                                    <option value="{{$squadra->id}}">{{$squadra->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                
                        
                
                        <button type="submit" class="btn btn-success">Salva Modifica Giocatore</button>
                        <a href="{{ route('players.index') }}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

@endsection