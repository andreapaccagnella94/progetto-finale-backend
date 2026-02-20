@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Modifica Squadra: {{$squadra->nome}}</h2>
                </div>
                {{-- form --}}
                <div class="card-body">
                    {{-- enctype per caricamento immagini --}}
                    <form action="{{ route('teams.update', $squadra->id) }}" method="POST" enctype="multipart/form-data">
                        
                        @csrf

                        @method("PUT")
                
                        <div class="form-control mb-3">
                            <label for="nome" class="form-label">Nome Squadra</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{$squadra->nome}}" required>
                        </div>
                
                        <div class="form-control mb-3">
                            <label for="citta" class="form-label">Città</label>
                            <input type="text" name="citta" id="citta" class="form-control" value="{{$squadra->citta}}" required>
                        </div>
                
                        <div class="form-control mb-3">
                            <label for="stadio" class="form-label">Nome Stadio</label>
                            <input type="text" name="stadio" id="stadio" class="form-control" value="{{$squadra->stadio}}" required>
                        </div>
                
                        <div class="form-control mb-3">
                            <label for="anno_fondazione" class="form-label">Anno Fondazione</label>
                            <input type="number" name="anno_fondazione" id="anno_fondazione" min="1800" max="2026" value="{{$squadra->anno_fondazione}}" required>
                        </div>

                        {{-- aggiornamento logo squadra --}}
                        <div class="form-control mb-3 d-flex flex-wrap gap-3">
                            <label for="logo" class="form-label">Logo Squadra</label>
                            <input type="file" name="logo" id="logo">
                            @if ($squadra->logo)
                            <div id="squadra-logo">
                                <img class="img-fluid w-25" src="{{asset ("storage/".$squadra->logo)}}" alt="logo">
                            </div>
                            @endif
                        </div>
                
                        <button type="submit" class="btn btn-success">Salva Modifica Squadra</button>
                        <a href="{{ route('teams.show', $squadra->id) }}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

@endsection