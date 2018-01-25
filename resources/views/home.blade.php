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
                            <div>
                                {{ $loop->index + 1 }}. <label for="question_{{ $loop->index }}">{{ $question->label }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
