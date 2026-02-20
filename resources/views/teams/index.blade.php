@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="my-4">Gestione Squadre</h1>
            
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('teams.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuova Squadra
                </a>
            </div>
            
            
            {{-- Griglia delle cards --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($squadre as $squadra)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        {{-- Logo squadra se presente --}}
                        @if($squadra->logo && Storage::disk('public')->exists($squadra->logo))
                        <div class="card-header text-white d-flex align-items-center">
                            <div class="me-3">
                                {{-- Logo immagine dallo storage --}}
                                <img src="{{ asset ("storage/". $squadra->logo) }}" 
                                    alt="Logo {{ $squadra->nome }}" 
                                    class="rounded-circle border border-light"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                                
                            </div>
                        </div>    
                        @endif
                           
                        <div class="card-body">
                            <h5 class="card-title">{{ $squadra->nome }}</h5>
                            <p class="card-text">
                                <i class="bi bi-geo-alt"></i>{{ $squadra->citta }}<br>
                                <i class="bi bi-building"></i>{{ $squadra->stadio }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">ID: {{ $squadra->id }}</small>
                                <small class="text-muted">
                                    Creato: {{ $squadra->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100 gap-2" role="group">
                                <a href="{{ route('teams.show', $squadra->id) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye">Visualizza</i>
                                </a>
                                <a href="{{ route('teams.edit', $squadra->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit">Modifica</i>
                                </a>
                                {{-- Button trigger modal --}}
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaSquadra-{{ $squadra->id }}">
                                    Elimina
                                </button>
                                {{-- Modal --}}
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
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection