@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">AbleTo Questionnaire</div>

                <div class="panel-body">
                    @include('layouts.flash')

                    @if (count($questionnaires) > 0)
                        @foreach ($questionnaires as $questionnaire)
                            <form method="POST" action="/answers">
                                {{ csrf_field() }}

                                <h3>{{ $questionnaire->name }}</h3>

                                @foreach ($questions as $question)
                                    <div class="question-group">
                                        @php
                                            $questionChoicesList = $questionChoices[$questionnaire->id][$question->id];
                                            $userAnswersList = array_key_exists($question->id, $userAnswers) ? $userAnswers[$question->id] : [];
                                        @endphp

                                        {{ $loop->index + 1 }}. <label for="q{{ $question->id }}" class="question-label">{{ $question->label }}</label>
                                        
                                        @if ($question->type == 'dropdown')
                                            <select name="q{{ $question->id }}" id="q{{ $question->id }}">
                                                @foreach ($questionOptionList as $questionOption)
                                                    <option value="{{ $questionOption->id }}">
                                                        {{ $questionOption->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            @foreach ($questionChoicesList as $questionChoice)
                                                <div class="question-option-group">
                                                    <input type="{{ $question->type }}"
                                                           id="q{{ $question->id }}-c{{ $questionChoice->id }}"
                                                           class="input-{{ $question->type }}"
                                                           name="q{{ $question->id }}{{ $question->type == 'checkbox' ? '[]' : '' }}"
                                                           value="{{ $questionChoice->id }}"
                                                           {{ in_array($questionChoice->id, $userAnswersList) ? 'checked="checked"' : '' }}
                                                           {{ $question->required && $question->type != 'checkbox' ? 'required="required"' : '' }}>

                                                    <label for="q{{ $question->id }}-c{{ $questionChoice->id }}" class="question-choice-label">
                                                        {{ $questionChoice->label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach

                                <input type="hidden" name="questionnaire" value="{{ $questionnaire->id }}">

                                <button type="submit" class="btn btn-primary">
                                    {{  count($userAnswers) == 0 ? 'Submit' : 'Update' }}
                                </button>
                            </form>
                        @endforeach
                    @else
                        <div>There are no questions to display.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
