@extends('density-list.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Density List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('lists.create') }}"> Create New</a>
            </div>

            <div class="pull-right" style="margin-right: 5px;">
                <a class="btn btn-success" href="/">Home</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Url</th>
            <th>Note</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($wordDensities as $wordDensity)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $wordDensity->url }}</td>
                <td>
                    <ul>
                        @foreach(json_decode($wordDensity->notes, 1) as $key => $density)
                            <li><strong>{{$key}}</strong>: {{$density}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>

                    <form action="{{ route('convertToHtml') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" placeholder="URL" name="url" value="{{$wordDensity->url}}" hidden>
                        <button type="submit" class="btn btn-warning">Search</button>
                    </form>

                    <a class="btn btn-info" href="{{ route('lists.show', $wordDensity->id) }}">View</a>

                    <a class="btn btn-primary" href="{{ route('lists.edit', $wordDensity->id) }}">Edit</a>

                    <form action="{{ route('lists.destroy', $wordDensity->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="d-flex justify-content-center text-center">
        {!! $wordDensities->links() !!}
    </div>

@endsection
