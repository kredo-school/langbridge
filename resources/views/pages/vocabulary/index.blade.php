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
            <button type="button" class="btn-red" onclick="document.dispatchEvent(new CustomEvent('openVocabularyModal'))">{{__('messages.add_vocabulary')}}</button>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>{{__('messages.front')}}</th>
                <th>{{__('messages.back')}}</th>
                <th>{{__('messages.note')}}</th>
                <th>{{__('messages.status')}}</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($vocabularies as $vocabulary)
                <tr>
                    <td>{{ $vocabulary->front }}</td>
                    <td>{{ $vocabulary->back }}</td>
                    <td>{{ $vocabulary->note }}</td>
                    <td>{{ $vocabulary->status }}</td>
                    <td>
                        <button type="button" class="btn-yellow" onclick="document.dispatchEvent(new CustomEvent('openVocabularyModal','{{ $vocabulary->front }}', '{{ $vocabulary->back }}', '{{ $vocabulary->note}}'))"><i class="fa-solid fa-pen"></i></button>
                    </td>
                    <td>
                        <form method='post' action="{{ route('vocabulary.delete', $vocabulary->id )}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-red"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"><p class="text-center">{{__('messages.no_vocabulary')}}</p></td>
                </tr>
            @endforelse
        </tbody>
    
    </table>

</div>
@endsection