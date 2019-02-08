@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zugang anlegen') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! \Form::open(['route' => ['access.store']]) !!}

                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    {!! BTForm::text('title') !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    {!! BTForm::text('url') !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    {!! BTForm::text('image') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('partials.form_bottom_buttons')

                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
