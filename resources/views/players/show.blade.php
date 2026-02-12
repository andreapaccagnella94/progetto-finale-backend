@extends('layouts.app')

@section('content')

<div class="container-fluid d-flex justify-content-center">
    <div class="card w-100 my-3"  style="max-width: 540px;">
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
</div>
    
@endsection