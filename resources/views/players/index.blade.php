@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Gestione Giocatori</h1>
            
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('players.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuovo Giocatore
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>     
                            <th>Cognome</th>
                            <th>Ruolo</th>
                            <th>Età</th>
                            <th>Squadra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($giocatori as $giocatore)
                        <tr>
                            <td>{{ $giocatore->numero_maglia }}</td>
                            <td>{{ $giocatore->nome }}</td>
                            <td>{{ $giocatore->cognome }}</td>
                            <td>{{ $giocatore->ruolo }}</td>
                            <td>{{ $giocatore->eta }} anni</td>
                            
                            <td>{{ $giocatore->team->nome ?? 'N/D' }}</td>
                            <td>
                                <div class="btn-group gap-2" role="group">
                                    <a href="{{ route('players.show', $giocatore->id) }}" class="btn btn-info btn-sm">
                                        Visualizza
                                    </a>
                                    <a href="{{ route('players.edit', $giocatore->id) }}" class="btn btn-warning btn-sm">
                                        Modifica
                                    </a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaGiocatore-{{ $giocatore->id }}">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $giocatori->links() }}
        </div>
    </div>
</div>
@endsection