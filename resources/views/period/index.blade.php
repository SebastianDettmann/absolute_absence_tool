@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Meine Abwesenheit') }}</div>
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
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Abwesenheit in diesem Jahr') }}</div>
                    <div class="card-body">
                        <h5>{{ __('zukünftig') }}</h5>
                        @foreach($periods_year_now_future as $period)
                            <div class="row my-2">
                                <div class="btn-group col-md-2 mr-1">
                                    <button class="btn btn-default btn-icon"
                                            data-toggle="modal" data-target="#showModal"
                                            data-period="{{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}"
                                            data-comment="{{ __('Bemerkung: ') . $period->comment }}"
                                            dusk="button-show-modal">
                                        <i class="fa fa-sm fa-eye"></i>
                                    </button>
                                    {!! \Form::open([
                                        'route' => ['period.destroy',$period->id],
                                        'method' => 'DELETE'
                                    ]) !!}
                                    <button class="btn btn-danger btn-icon" type="submit" dusk="button-delete">
                                        <i class="fa fa-sm fa-trash"></i>
                                    </button>
                                    {!! \Form::close() !!}
                                </div>
                                <div class="col-md-9"
                                     style="background-color: {{ $period->pendingColor()}}; color: #000000 ">
                                    {{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}
                                </div>
                            </div>
                        @endforeach
                        <hr/>
                        <h5>{{ __('aktuell') }}</h5>
                        @foreach($periods_year_now_current as $period)
                            <div class="row my-2">
                                <div class="btn-group col-md-1 mr-1">
                                    <button class="btn btn-default btn-icon"
                                            data-toggle="modal" data-target="#showModal"
                                            data-period="{{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}"
                                            data-comment="{{ __('Bemerkung: ') . $period->comment }}"
                                            dusk="button-show-modal">
                                        <i class="fa fa-sm fa-eye"></i>
                                    </button>
                                </div>
                                <div class="col-md-9 offset-md-1"
                                     style="background-color: {{ $period->pendingColor()}}; color: #000000 ">
                                    {{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}
                                </div>
                            </div>
                        @endforeach
                        <hr/>
                        <h5>{{ __('vergangen') }}</h5>
                        @foreach($periods_year_now_past as $period)
                            <div class="row my-2">
                                <div class="btn-group col-md-1 mr-1">
                                    <button class="btn btn-default btn-icon"
                                            data-toggle="modal" data-target="#showModal"
                                            data-period="{{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}"
                                            data-comment="{{ __('Bemerkung: ') . $period->comment }}"
                                            dusk="button-show-modal">
                                        <i class="fa fa-sm fa-eye"></i>
                                    </button>
                                </div>
                                <div class="col-md-9 offset-md-1"
                                     style="background-color: {{ $period->pendingColor()}}; color: #000000 ">
                                    {{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Neue Abwesenheit') }}</div>
                    <div class="card-body">
                        {!! \Form::open(['route' => ['period.store']]) !!}

                        <div class="row">
                            <div class="col-md-12">
                                <label for="reason_id" class="mr-sm-2">{{ __('Gründe') }}</label>
                                <select class="custom-select mr-sm-2" name="reason_id" id="reason_id">
                                    <option selected>{{__('Gründe')}}</option>
                                    @foreach($reasons as $reason)
                                        <option value="{{ $reason->id }}"
                                                style="background-color: {{ $reason->hex_color }}">{{ $reason->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! \BTForm::text('start', null, '', [
                                'class' => 'datepicker',
                                'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! \BTForm::text('end', null, '', [
                                'class' => 'datepicker',
                                'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! \BTForm::text('comment') !!}
                            </div>
                        </div>
                        @include('partials.form_bottom_buttons')

                        {!! \Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--period show modal--}}
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Zeige Abwesenheit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-2">
                    <div class="row m-2">
                        <div class="col-md-11 offset-md-1" id="period-discription"></div>
                    </div>
                    <div class="row m2 pl-3">
                        <div class="col-md-11 offset-md-1" id="period-comment"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default bottom-right"
                            data-dismiss="modal">{{ __('Schließen') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('foot-scripts')

    <script type="application/javascript">
        window.addEventListener('load', function () {
            $(".datepicker").datepicker($.datepicker.regional["de"]);
            $('#calendar-{{ $calendar->getId() }}').fullCalendar({!! $calendar->getOptionsJson() !!});
            $('#showModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var period = button.data('period');
                var comment = button.data('comment');
                var modal = $(this);
                modal.find('#period-discription').text(period);
                modal.find('#period-comment').text(comment);
            })
        });
    </script>
@endpush
