@extends('layouts.app')

@section('content')
    <div class="text-center text-secondary">
        <strong>Erreur: vous n'avez aucune page facebook</strong>
        <div><a href="{{route('home')}}" class="btn btn-outline-secondary">Revenir en arrière</a></div>
    </div>
@endsection