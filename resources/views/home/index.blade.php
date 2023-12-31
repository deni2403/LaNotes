@extends('layouts.master')

@section('content')
    @if ($notes->isEmpty())
        <div class="text-center m-5">Empty, there are no notes.</div>
    @else
        @foreach ($notes as $note)
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> <a
                            href="details/index/{{ $note['id'] }}">{{ $note['title'] }}</a></h6>
                </div>
                <div class="card-body">
                    <p>{{ $note['content'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
    @endif
@endsection
