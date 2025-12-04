@extends('layouts.app')

@section('title',__('messages.vocabulary'))

@section('content')
<livewire:vocabulary-modal />

<div class="container">
    <div class="row align-items-center">
        <div class="col">
            <h1>{{__('messages.vocabulary_list')}}</h1>
        </div>
        <div class="col-auto">
            <a href="#" class="btn-yellow">{{__('messages.vocabulary_quiz')}}</a> <!--add the route to vocabulary quiz later-->
        </div>
        <div class="col-auto">
            <button type="button" class="btn-red" wire:click="$emit('openVocabularyModal')">{{__('messages.add_vocabulary')}}</button>
        </div>
    </div>

</div>
@endsection