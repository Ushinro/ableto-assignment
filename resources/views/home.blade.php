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

                    <form action="/answers">
                        @foreach ($questions as $question)
                            @php
                                $questionOptionList = $questionOptions[$question->id];
                            @endphp

                            <div class="question-section">
                                {{ $loop->index + 1 }}. <label for="question_{{ $loop->index }}">{{ $question->label }}</label>

                                @foreach ($questionOptionList as $questionOption)
                                    <div class="question-options-section">
                                        <input type="{{ $question->type }}"
                                               id="q_{{ $question->id }}_c_{{ $questionOption->id }}"
                                               name="q{{ $question->id }}"
                                               value="{{ $questionOption->id }}">

                                        <label for="q_{{ $question->id }}_c_{{ $questionOption->id }}">
                                            {{ $questionOption->label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
