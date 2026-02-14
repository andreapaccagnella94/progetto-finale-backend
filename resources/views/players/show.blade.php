@extends('layouts.app')

@section('content')

<div class="container-fluid d-flex justify-content-center">
    <div class="card w-100 my-3"  style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="#" class="img-fluid rounded-start" alt="img_{{$giocatore->cognome}}">
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
    
@endsection