@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">AbleTo Questionnaire</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/">
                        Return to home page
                    </a>

                    <div class="user-answer-section">
                        @if (count($userAnswers) > 0)
                            <p>Your answers for today were:</p>

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
