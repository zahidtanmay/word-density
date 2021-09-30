@extends('density-list.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Density</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('lists.index') }}"> Back</a>
            </div>
            <div class="pull-right" style="margin-right: 5px;">
                <a class="btn btn-success" href="/">Home</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>URL:</strong>
                {{ $list->url }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Density:</strong>
                <ul>
                    @foreach(json_decode($list->notes, 1) as $key => $density)
                        <li><strong>{{$key}}</strong>: {{$density}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
