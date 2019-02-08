@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Zeitraum anzeigen</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            {{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ __('Bemerkung: ') . $period->comment }}
                        </div>
                    </div>
                    @include('partials.show_bottom_buttons')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
