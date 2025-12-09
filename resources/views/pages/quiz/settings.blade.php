@extends('layouts.app')

@section('title',__('messages.vocabulary_quiz'))

@section('content')
<div class="container">
    <h1>{{__('messages.quiz_settings')}}</h1>
    <div class='w-25 mx-auto mt-5 p-3'>
        <form action="{{ route('quiz.settings.step1')}}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="order" class="form-label">{{__('messages.order')}}</label>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="order" id="order" value="added" {{ old('order', 'added') == 'added' ? 'checked' : ''}}>
                        <label class="form-check-label" for="added">
                            {{__('messages.added')}}
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="order" id="order" value="random">
                        <label class="form-check-label" for="random">
                            {{__('messages.random')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="order" class="form-label">{{__('messages.only_unmastered')}}</label>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="only_unmastered" id="only_unmastered" value="1" {{ old('order', '1') == '1' ? 'checked' : ''}}>
                        <label class="form-check-label" for="1">
                            {{__('messages.on')}}
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="only_unmastered" id="only_unmastered" value="0">
                        <label class="form-check-label" for="0">
                            {{__('messages.off')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="order" class="form-label">{{__('messages.question_side')}}</label>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_side" id="question_side" value="front" {{ old('order', 'front') == 'front' ? 'checked' : ''}}>
                        <label class="form-check-label" for="front">
                            {{__('messages.front')}}
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_side" id="question_side" value="back">
                        <label class="form-check-label" for="back">
                            {{__('messages.back')}}
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-yellow d-block mx-auto w-100 mt-3">{{__('messages.next')}}</button>
        </form>
    </div>

    @if(isset($max_questions))
    <div class="mt-5 p-3 border rounded w-25 mx-auto">

        <form action="{{ route('quiz.start') }}" method="post">
            @csrf
            <input type="hidden" name="order" value="{{ $inputs['order'] }}">
            <input type="hidden" name="only_unmastered" value="{{ $inputs['only_unmastered'] }}">
            <input type="hidden" name="question_side" value="{{ $inputs['question_side'] }}">

            <div class="mb-3">
                <label for="count" class="form-label">
                    {{ __('messages.nofq') }}
                </label>
                <input type="number" 
                       name="count" 
                       id="count" 
                       class="form-control" 
                       min="1" 
                       max="{{ $max_questions }}" 
                       value="{{ $max_questions }}"
                       required>
                <p class="text-muted small">
                    ({{ __('messages.max')}}: {{ $max_questions }})
                </p>
            </div>

            <button type="submit" class="btn-yellow w-100">
                {{ __('messages.start') }}
            </button>
        </form>

    </div>
@endif

</div>
@endsection