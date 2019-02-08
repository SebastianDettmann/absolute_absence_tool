@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Auswertung') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($users as $user)
                            <h4> {{ $user->fullName() }} </h4>
                            @foreach($user->periods as $period)
                                <div class="row m-1 my-2">
                                    <div class="col-md-1">
                                        <button class="btn btn-default btn-icon"
                                                data-toggle="modal" data-target="#showModal"
                                                data-period="{{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}"
                                                data-comment="{{ __('Bemerkung: ') . $period->comment }}"
                                                dusk="button-show-modal">
                                            <i class="fa fa-sm fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-10"
                                         style="background-color: {{ $period->pendingColor()}}; color: #000000 ">
                                        {{ $period->start->format('d.m.y') . ' - ' . $period->end->format('d.m.y') . ' : ' . $period->pendingText() }}
                                    </div>
                                </div>

                            @endforeach
                            <hr/>
                        @endforeach
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
                    <div class="row m-2 pl-2">
                        <div class="col-md-12" id="period-discription"></div>
                    </div>
                    <div class="row m2 pl-2">
                        <div class="col-md-12 pl-2" id="period-comment"></div>
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