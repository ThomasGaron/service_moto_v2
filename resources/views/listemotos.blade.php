@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-lg-10">
            <h1 class = "text-center my-5">@lang('general.Liste des motos')</h1>

        </div>

    </div>

    <div class="container">

        <div class="row">
            @foreach ($motos as $index => $moto)
                <div class="col-md-4">
                    <div class="card card-body">
                        {{--  si vous voulez avoir le titre de votre données cliquable (ici c'est le titre de l'moto) utiliser le bout de code ci-bas>    
               {{--  <a href="{{ url('motos/'. $moto->id) }}">
                <h2>
                        {{ $moto->title }}
                    </h2>
                   
                </a>  --}}
                        <h2>
                            {{ $moto->title }}
                        </h2>
                        @if ($moto->photo)
                            <img src="../images/upload/{{ $moto->photo }}" class="card-img-top img-fluid">
                        @endif
                        {{-- {{ $moto->content }} --}}
                        <div class="col-md-6">
                            <a href="{{ url('motos/' . $moto->id) }}"
                                class="btn btn-outline-primary">@lang('general.Savoir')</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class= "d-flex justify-content-center">
                {!! $motos->links() !!}
            </div>
        </div>
    </div>
@endsection
