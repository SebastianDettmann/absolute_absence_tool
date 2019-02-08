@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Im Büro?') }}</div>
                    <div class="card-body">
                        {!! $calendar->calendar() !!}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            @foreach($reasons as $reason)
                                <div class="col-md-2 m-1 pl-3 "
                                     style="background-color: {{ $reason->hex_color}}; color: #000000 ">
                                    {{ $reason->title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('foot-scripts')
    <script type="application/javascript">
        window.addEventListener('load', function () {
            $('#calendar-{{ $calendar->getId() }}').fullCalendar({!! $calendar->getOptionsJson() !!});
            $('#calendar-{{ $calendar->getId() }}').fullCalendar('option', 'contentHeight', 800);
        });
    </script>
@endpush
