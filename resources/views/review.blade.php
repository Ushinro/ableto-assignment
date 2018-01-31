@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">AbleTo Questionnaire Review</div>

                <div class="panel-body">
                    @include('layouts.flash')

                    <div class="user-answer-section">
                        @if (count($userAnswers) > 0)
                            <h3>Your answers for today were:</h3>

                            <div class="questionnaires-container">
                                <div class="questionnaire-submission">
                                    {{-- The flow of the names is not coherent... --}}
                                    @foreach ($userAnswers as $question)
                                        <p>
                                            <div>
                                                <b>{{ $question[0]->question }}</b>
                                            </div>

                                            @foreach ($question as $userAnswer)
                                                <div>
                                                    {{ $userAnswer->answer }}
                                                </div>
                                            @endforeach
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            You have not answered the survey for today.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
