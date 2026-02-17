@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Partita: {{ $partita->teamHome->nome }} vs {{ $partita->teamAway->nome }}</h4>
                    <div>
                        <a href="{{ route('games.edit', $partita->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaPartita-{{ $partita->id }}">
                            Elimina
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="eliminaPartita-{{ $partita->id }}" tabindex="-1" aria-labelledby="eliminaPartitaLabel-{{ $partita->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> {{-- mettere al centro il modale --}}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="eliminaPartitaLabel-{{ $partita->id }}">Elimina la partita tra : {{ $partita->teamHome->nome }} e {{$partita->teamAway->nome}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Vuoi eliminare questa partita "<strong>{{$partita->gol_casa}} - {{$partita->gol_trasferta}}</strong>"? Questa azione è definitiva.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('games.destroy', $partita->id) }}" method="POST">

                                            @csrf

                                            @method('DELETE')

                                            <input type="submit" class="btn btn-danger" value="Elimina definitivamente">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Data e ora</th>
                                    <td>{{ $partita->data}}</td>
                                </tr>
                                <tr>
                                    <th>Competizione</th>
                                    <td>{{ $partita->competizione }}</td>
                                </tr>
                                <tr>
                                    <th>Squadra casa</th>
                                    <td>
                                        <a href="{{ route('teams.show', $partita->squadra_casa_id) }}">
                                            {{ $partita->teamHome->nome }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Squadra ospite</th>
                                    <td>
                                        <a href="{{ route('teams.show', $partita->squadra_trasferta_id) }}">
                                            {{ $partita->teamAway->nome }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Risultato</th>
                                    <td>
                                        @if($partita->gol_casa !== null && $partita->gol_trasferta !== null)
                                            {{ $partita->gol_casa }} - {{ $partita->gol_trasferta }}
                                        @else
                                            ND
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Creato il</th>
                                    <td>{{ $partita->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Ultima modifica</th>
                                    <td>{{ $partita->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Formazione</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ $partita->teamHome->nome }} (Casa)</h6>
                                    <ul class="list-group">
                                        @foreach($partita->players->where('squadra_id', $partita->squadra_casa_id) as $giocatore)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $giocatore->numero_maglia }}. {{ $giocatore->cognome }}
                                                {{-- DA MODIFICARE --}}
                                                {{-- <span class="badge bg-primary rounded-pill">
                                                    {{ $giocatore->pivot->gol_segnati }} gol
                                                </span> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ $partita->teamAway->nome }} (Ospite)</h6>
                                    <ul class="list-group">
                                        @foreach($partita->players->where('squadra_id', $partita->squadra_trasferta_id) as $giocatore)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $giocatore->numero_maglia }}. {{ $giocatore->cognome }}
                                                {{-- DA MODIFICARE --}}
                                                {{-- <span class="badge bg-primary rounded-pill">
                                                    {{ $giocatore->pivot->gol_segnati }} gol
                                                </span> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h5>Dettagli partecipazione</h5>
                    @if($partita->players->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Giocatore</th>
                                <th>Squadra</th>
                                <th>Titolare</th>
                                <th>Minuti</th>
                                <th>Gol</th>
                                <th>Assist</th>
                                <th>Cartellini</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partita->players as $giocatore)
                            <tr>
                                <td>{{ $giocatore->nome }} {{ $giocatore->cognome }}</td>
                                <td>{{ $giocatore->team->nome }}</td>
                                <td>{{ $giocatore->pivot->titolare ? 'Sì' : 'No' }}</td>
                                <td>{{ $giocatore->pivot->minuti_giocati }}</td>
                                <td>{{ $giocatore->pivot->gol_segnati }}</td>
                                <td>{{ $giocatore->pivot->assist }}</td>
                                <td>
                                    G: {{ $giocatore->pivot->cartellini_gialli }} 
                                    R: {{ $giocatore->pivot->cartellini_rossi }}
                                </td>
                                <td class="gap-1">
                                    <a href="{{ route('players.show', $giocatore->id) }}" class="btn btn-info btn-sm">
                                        Vedi giocatore
                                    </a>
                                    <a href="{{ route('game_player.edit', $giocatore->pivot->id) }}" class="btn btn-warning btn-sm">
                                        Modifica
                                    </a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaGiocatore-{{ $giocatore->pivot->id }}">
                                        Elimina
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="eliminaGiocatore-{{ $giocatore->pivot->id }}" tabindex="-1" aria-labelledby="eliminaGiocatoreLabel-{{ $giocatore->pivot->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> {{-- mettere al centro il modale --}}
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="eliminaGiocatoreLabel-{{ $giocatore->pivot->id }}">Elimina partecipazione di: {{ $giocatore->nome }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Vuoi eliminare la partecipazione di "<strong>{{ $giocatore->nome }}</strong>"? Questa azione è definitiva.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                        <form action="{{ route('game_player.destroy', $giocatore->pivot->id) }}" method="POST">
                            
                                                            @csrf
                            
                                                            @method('DELETE')
                            
                                                            <input type="submit" class="btn btn-danger" value="Elimina definitivamente">
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Nessun giocatore registrato per questa partita.</p>
                    @endif
                    {{-- aggiungere button per aggiungere giocatori alla partita --}}
                    <div class="mt-3">
                        <a href="{{ route('game_player.create', ['partita_id' => $partita->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Aggiungi giocatore alla partita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection