@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        {{-- card giocatore --}}
        <div class="my-3 col-lg-4 col-md-12"  {{-- style="max-width: 540px;" --}}>
          <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="{{asset ("storage/" . $giocatore->foto)}}" class="img-fluid rounded-start" alt="img_{{$giocatore->cognome}}">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{$giocatore->nome}} {{$giocatore->cognome}} </h5>
                    <i class="bi bi-person-bounding-box"></i> {{ $giocatore->ruolo }} <br>
                    # {{ $giocatore->numero_maglia }} <br>
                    <p class="card-text"><small class="text-body-secondary"><i class="bi-calendar-date"></i> Età :{{ $giocatore->eta }}</small></p>
                    <h6 class="card-title">Squadra : {{$giocatore->team->nome}} </h6>
                </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-around">
                <a href="{{ route('game_player.create', ['giocatore_id' => $giocatore->id]) }}" class="btn btn-outline-primary btn-sm">
                    Aggiungi Partecipazione
                </a>
                <a href="{{ route('players.edit', $giocatore->id) }}" class="btn btn-outline-warning btn-sm">
                    Modifica
                </a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaGiocatore-{{ $giocatore->id }}">
                    Elimina
                </button>
                <!-- Modal -->
                <div class="modal fade" id="eliminaGiocatore-{{ $giocatore->id }}" tabindex="-1" aria-labelledby="eliminaGiocatoreLabel-{{ $giocatore->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> {{-- mettere al centro il modale --}}
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="eliminaGiocatoreLabel-{{ $giocatore->id }}">Elimina il giocatore: {{ $giocatore->nome }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Vuoi eliminare il giocatore "<strong>{{ $giocatore->nome }}</strong>"? Questa azione è definitiva.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <form action="{{ route('players.destroy', $giocatore->id) }}" method="POST">
        
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
        </div>
        {{-- Sezione Partite --}}
        <div class="mt-4 col-lg-8 col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    Partite Giocate
                </h5>
                <a href="{{ route('players.edit', $giocatore->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i>Gestisci Partecipazioni
                </a>
            </div>
            @if($giocatore->games->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Data</th>
                                <th>Partita</th>
                                <th>Risultato</th>
                                <th>Titolare</th>
                                <th>Minuti</th>
                                <th>Gol</th>
                                <th>Assist</th>
                                <th>Cartellini</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($giocatore->games->sortByDesc('data_ora') as $partita)
                            <tr>
                                <td {{-- data-order="{{ $partita->data_ora->timestamp }}" --}}>
                                    {{ $partita->data }}
                                    {{-- <div class="small text-muted">{{ $partita->data_ora->format('H:i') }}</div> --}}
                                </td>
                                <td>
                                    @if($partita->squadra_casa_id == $giocatore->squadra_id)
                                        <span class="badge bg-success">CASA</span>
                                        vs {{ $partita->teamAway->nome }}
                                    @else
                                        <span class="badge bg-info">TRASFERTA</span>
                                        vs {{ $partita->teamHome->nome }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($partita->gol_casa !== null && $partita->gol_trasferta !== null)
                                        <strong>{{ $partita->gol_casa }} - {{ $partita->gol_trasferta }}</strong>
                                        @if($partita->squadra_casa_id == $giocatore->squadra_id)
                                            @if($partita->gol_casa > $partita->gol_trasferta)
                                                <span class="badge bg-success">V</span>
                                            @elseif($partita->gol_casa < $partita->gol_trasferta)
                                                <span class="badge bg-danger">S</span>
                                            @else
                                                <span class="badge bg-warning">P</span>
                                            @endif
                                        @else
                                            @if($partita->gol_trasferta > $partita->gol_casa)
                                                <span class="badge bg-success">V</span>
                                            @elseif($partita->gol_trasferta < $partita->gol_casa)
                                                <span class="badge bg-danger">S</span>
                                            @else
                                                <span class="badge bg-warning">P</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="text-muted">ND</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($partita->pivot->titolare)
                                        <span class="badge bg-success">Sì</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $partita->pivot->minuti_giocati }}</td>
                                <td class="text-center">
                                    @if($partita->pivot->gol_segnati > 0)
                                        <span class="badge bg-primary">{{ $partita->pivot->gol_segnati }}</span>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($partita->pivot->assist > 0)
                                        <span class="badge bg-info">{{ $partita->pivot->assist }}</span>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($partita->pivot->cartellini_gialli > 0)
                                        <span class="badge bg-warning">{{ $partita->pivot->cartellini_gialli }}</span>
                                    @endif
                                    @if($partita->pivot->cartellini_rossi > 0)
                                        <span class="badge bg-danger">{{ $partita->pivot->cartellini_rossi }}</span>
                                    @endif
                                    @if($partita->pivot->cartellini_gialli == 0 && $partita->pivot->cartellini_rossi == 0)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('games.show', $partita->id) }}" class="btn btn-info btn-sm" title="Dettagli partita">
                                            Visualizza
                                        </a>
                                        <a href="{{ route('game_player.edit', $partita->pivot->id) }}" class="btn btn-warning btn-sm">
                                            Modifica
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Il giocatore non ha ancora disputato partite.
                </div>
            @endif
        </div>                
    </div>
</div>
    
@endsection