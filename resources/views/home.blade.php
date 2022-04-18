@extends('layouts.app')

@section('content')
    <div class="px-3 text-center">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('err'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session('err')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (isset($errors) && count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="container">
        
            @foreach ($pages as $page)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-deck mb-3 text-center">
                            <div class="card mb-4 box-shadow">
                                <div class="card-header">
                                    <h4 class="my-0 font-weight-normal">{{$page['name']}}</h4>
                                </div>
                                <div class="card-body">
                                    <button type="button" class="btn btn-lg btn-block btn-outline-primary" data-toggle="modal" data-target="#formulaire{{$page['id']}}">
                                        Faire une publication
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- Modal -->
                <div class="modal fade add_modal" id="formulaire{{$page['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form class="formsubmit" id="form{{$page['id']}}" action="{{route('publication')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $page['id'] }}" id="page_id{{ $page['id'] }}" name="page_id">
                                <input type="hidden" value="{{ $page['access_token'] }}" id="access_token{{ $page['id'] }}" name="access_token">
                                <div class="form-group">
                                    <label for="crypt">Contenu de la publication</label>
                                    <textarea name="contenu" id="contenu{{ $page['id'] }}" cols="30" rows="5" class="form-control" name="contenu"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Image optionnel</label>
                                <input type="file" id="image{{ $page['id'] }}" name="image" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" form="form{{$page['id']}}" class="btn btn-primary">Publier</samp></button>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
@endsection
