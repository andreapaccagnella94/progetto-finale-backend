@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Aggiungi Nuova Squadra</h2>
                </div>
                {{-- form --}}
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST">
                        
                        @csrf
                
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Squadra</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="citta" class="form-label">Città</label>
                            <input type="text" name="citta" id="citta" class="form-control" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="stadio" class="form-label">Nome Stadio</label>
                            <input type="text" name="stadio" id="stadio" class="form-control" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="anno_fondazione" class="form-label">Anno Fondazione</label>
                            <input type="number" name="anno_fondazione" id="anno_fondazione" min="1800" max="2026" required>
                        </div>
                
                        <button type="submit" class="btn btn-success">Salva Squadra</button>
                        <a href="{{ route('teams.index') }}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

@endsection