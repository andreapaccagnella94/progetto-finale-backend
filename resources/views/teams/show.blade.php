@extends('layouts.app')

@section('content')

<div class="container-fluid d-flex justify-content-center">
    <div class="row">
        <div class="card w-100 my-3"  style="max-width: 720px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="#" class="img-fluid rounded-start" alt="stemma_{{$squadra->nome}}">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{$squadra->nome}}</h5>
                <p class="card-text"><i class="bi bi-geo-alt"></i>{{ $squadra->citta }}<br></p>
                <p class="card-text"><small class="text-body-secondary"><i class="bi bi-building"></i>{{ $squadra->stadio }}</small></p>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-around">
            <a href="{{ route('teams.edit', $squadra->id) }}" class="btn btn-outline-warning btn-sm">
                Modifica
            </a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaSquadra-{{ $squadra->id }}">
                Elimina
            </button>
            <!-- Modal -->
            <div class="modal fade" id="eliminaSquadra-{{ $squadra->id }}" tabindex="-1" aria-labelledby="eliminaSquadraLabel-{{ $squadra->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"> {{-- mettere al centro il modale --}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="eliminaSquadraLabel-{{ $squadra->id }}">Elimina la Squadra: {{ $squadra->nome }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Vuoi eliminare la squadra "<strong>{{ $squadra->nome }}</strong>"? Questa azione è definitiva.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <form action="{{ route('teams.destroy', $squadra->id) }}" method="POST">
    
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
        <div class="accordion" id="accordionExample" >
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Rosa
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @if($squadra->players->count() > 0)
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Ruolo</th>
                                        <th>Età</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($squadra->players as $giocatore)
                                    <tr>
                                        <td>{{ $giocatore->numero_maglia }}</td>
                                        <td>{{ $giocatore->nome }} {{ $giocatore->cognome }}</td>
                                        <td>{{ $giocatore->ruolo }}</td>
                                        <td>{{ $giocatore->eta }}</td>
                                        <td>
                                            <a href="{{ route('players.show', $giocatore->id) }}" class="btn btn-outline-info btn-sm">
                                                Visualizza
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p>Nessun giocatore registrato per questa squadra.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Partite
                </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Qua dovrebbero vedersi le partite della Squadra</strong>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
@endsection