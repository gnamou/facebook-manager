@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <h2 class="text-danger">{{ $page_name }}</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        
    </div>
    <div class="col-md-6 card">
        <div class="row card-body">
            <div class="col-md-12">
                <div class="">
                    <div class="">
                        <form class="formsubmit"  action="{{ route('publication') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" value="{{ $page_id }}" id="page_id" name="page_id">
                        <input type="hidden" value="{{ $access_token }}" id="access_token" name="access_token">
                        <div class="form-group">
                            <label for="crypt">Contenu de la publication</label>
                            <textarea name="contenu" id="contenu" cols="30" rows="5" class="form-control" name="contenu"></textarea>
                        </div>
                        <div class="form-group row">
                            &nbsp;&nbsp; image
                            <div class="col-md-12">
                                <div class="avatar-upload" style="margin: 2px;">
                                    <div class="avatar-edit">
                                        <input type="file" name="image" id="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-info" type="submit">Publier</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@push('script')
    <script>
        $( document ).ready(function() {
            
            $('body').on('submit', '.formsubmit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success: function (data) {
                    console.log(data.data);
                }
            });
        });

        });
    </script>
    @endpush
@endsection