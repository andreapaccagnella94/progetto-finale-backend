@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Gestione Partite</h1>
            
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('games.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuova Partita
                </a>
            </div>
                        
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Data/ora</th>
                            <th>Casa</th>     
                            <th>Risultato</th>
                            <th>Ospite</th>
                            <th>Competizione</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partite as $partita)
                        <tr>
                            <td>{{ $partita->data }}</td>
                            <td>{{ $partita->teamHome->nome }}</td>
                            <td>
                                @if ($partita->gol_casa !== null && $partita->gol_trasferta !== null)
                                    {{$partita->gol_casa}} - {{$partita->gol_trasferta}}
                                @else
                                    N/D
                                @endif
                            </td>
                            <td>{{ $partita->teamAway->nome}}</td>
                            <td>{{ $partita->competizione }}</td>
                            <td>
                                <div class="btn-group gap-2" role="group">
                                    <a href="{{ route('games.show', $partita->id) }}" class="btn btn-info btn-sm">
                                        Visualizza
                                    </a>
                                    <a href="{{ route('games.edit', $partita->id) }}" class="btn btn-warning btn-sm">
                                        Modifica
                                    </a>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection