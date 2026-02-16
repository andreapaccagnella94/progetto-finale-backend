@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col md-8">
            @if ($allert)

            <div class="alert alert-danger" role="alert">
                Squadre uguali inserisci nuovamente la partita!!
            </div>
                
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Crea Partita</h2>
                </div>
                {{-- form --}}
                <div class="card-body">
                    <form action="{{ route('games.store')}}" method="POST">
                        
                        @csrf

                        <div class="mb-3">
                            <label for="data" class="form-label">Data partita</label>
                            <input type="date" name="data" id="data" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="competizione" class="form-label">Competizione partita</label>
                            <input type="text" name="competizione" id="competizione" class="form-control" value="Serie A" required>
                        </div>

                        <div class="mb-3">
                            <label for="squadra_casa_id" class="form-label">Squadra Casa</label>
                            <select name="squadra_casa_id" id="squadra_casa_id" class="form-control" required>
                                <option value="">Seleziona Squadra</option>
                                @foreach ($squadre as $squadra)
                                    <option value="{{$squadra->id}}">{{$squadra->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="squadra_trasferta_id" class="form-label">Squadra Trasferta</label>
                            <select name="squadra_trasferta_id" id="squadra_trasferta_id" class="form-control" required>
                                <option value="">Seleziona Squadra</option>
                                @foreach ($squadre as $squadra)
                                    <option value="{{$squadra->id}}">{{$squadra->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Salva Partita</button>
                        <a href="{{ route('games.index') }}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>    
            </div>    
        </div>        
    </div>
</div>

@endsection