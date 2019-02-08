@extends('layouts.app')

@section('content')
    @include('partials.second_navbar')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{  __('Verwaltung: Alle User') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('user.create') }}">
                            <button class="btn btn-default btn-block col-md-3 mb-4">{{ __('Neuer User') }}</button>
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Admin') }}</th>
                                <th>{{ __('Zugänge') }}</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('user.edit', [$user->id]) }}">
                                                <button class="btn btn-default btn-icon" dusk="button-edit">
                                                    <i class="fa  fa-sm fa-edit"></i>
                                                </button>
                                            </a>
                                            @if($user->id !== 1)
                                                {!! \Form::open([
                                                    'route' => ['user.destroy',$user->id],
                                                    'method' => 'DELETE'
                                                ]) !!}
                                                <button class="btn btn-danger btn-icon" type="submit"
                                                        dusk="button-delete">
                                                    <i class="fa fa-sm fa-trash"></i>
                                                </button>
                                                {!! \Form::close() !!}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {!!  $user->fullName() !!}
                                    </td>
                                    <td>
                                        {!!  $user->email !!}
                                    </td>
                                    <td>
                                        @if($user->admin)
                                            <i class="fa  fa-sm fa-check-square"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($user->accesses as $access)
                                            {{ $access->title }}
                                            <br/>
                                        @endforeach
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
