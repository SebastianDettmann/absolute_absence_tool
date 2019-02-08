@extends('layouts.app')

@section('content')
    @include('partials.second_navbar')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{  __('Verwaltung: Alle Zugänge') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('access.create') }}">
                            <button class="btn btn-default btn-block col-md-3 mb-4">{{ __('Neuer Zugang') }}</button>
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('Bezeichnung') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th>{{ __('Image URL') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($accesses as $access)
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('access.edit', [$access->id]) }}">
                                                <button class="btn btn-default btn-icon" dusk="button-edit">
                                                    <i class="fa fa-sm fa-edit"></i>
                                                </button>
                                            </a>
                                            {!! \Form::open([
                                                'route' => ['access.destroy', $access->id],
                                                'method' => 'DELETE'
                                            ]) !!}
                                            <button class="btn btn-danger btn-icon" type="submit" dusk="button-delete">
                                                <i class="fa fa-sm fa-trash"></i>
                                            </button>
                                            {!! \Form::close() !!}
                                        </div>
                                    </td>
                                    <td>
                                        {!! $access->title !!}
                                    </td>
                                    <td>
                                        {!! $access->url !!}
                                    </td>
                                    <td>
                                        {!! $access->image !!}
                                    </td>
                                    <td>
                                        <img class="mt-1" src="{{ asset($access->image) }}" height="30"
                                             alt="{{ __('Logo für ') . __($access->title) }}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
