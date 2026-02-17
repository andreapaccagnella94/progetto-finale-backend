@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Modifica Statistiche</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route("game_player.update", $partecipazione->id) }}" method="POST">
                        
                        @csrf
                        
                        @method('PUT')
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" 
                                   id="titolare" name="titolare" value="1"
                                   {{ $partecipazione->titolare ? 'checked' : '' }}>
                            <label class="form-check-label" for="titolare">Titolare</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="minuti_giocati" class="form-label">Minuti giocati</label>
                            <input type="number" class="form-control" 
                                   id="minuti_giocati" name="minuti_giocati" 
                                   value="{{ $partecipazione->minuti_giocati }}" min="0" max="120">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gol_segnati" class="form-label">Gol segnati</label>
                                    <input type="number" class="form-control" 
                                           id="gol_segnati" name="gol_segnati" 
                                           value="{{ $partecipazione->gol_segnati }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assist" class="form-label">Assist</label>
                                    <input type="number" class="form-control" 
                                           id="assist" name="assist" 
                                           value="{{ $partecipazione->assist }}" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cartellini_gialli" class="form-label">Cartellini gialli</label>
                                    <input type="number" class="form-control" 
                                           id="cartellini_gialli" name="cartellini_gialli" 
                                           value="{{ $partecipazione->cartellini_gialli }}" min="0" max="2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cartellini_rossi" class="form-label">Cartellini rossi</label>
                                    <input type="number" class="form-control" 
                                           id="cartellini_rossi" name="cartellini_rossi" 
                                           value="{{ $partecipazione->cartellini_rossi }}" min="0" max="1">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Indietro</a>
                            <button type="submit" class="btn btn-primary">Aggiorna Statistiche</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection