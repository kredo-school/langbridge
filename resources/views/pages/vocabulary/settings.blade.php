@extends('layouts.app')

@section('title',__('messages.vocabulary_quiz'))

@section('content')
<div class="container">
    <h1>{{__('messages.quiz_settings')}}</h1>
    <div class='w-25 mx-auto mt-5'>
        <form action="{{ route('quiz.settings.step1')}}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="order" class="form-label">{{__('messages.order')}}</label>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="order" id="order" value="added">
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
                        <input class="form-check-input" type="radio" name="only_unmastered" id="only_unmastered" value="1">
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
                        <input class="form-check-input" type="radio" name="question_side" id="question_side" value="front">
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
            <button type="submit" class="btn-yellow d-block mx-auto">{{__('messages.next')}}</button>
        </form>
    </div>
</div>
@endsection