@extends('layouts.elections')

@section('content')
    <div class="container-fluid">
        <div class="page-content">

            <a href="{{ route('elections.groups.categories.index', [$election->id, $category->group_id]) }}"
               class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Categories
            </a>

            <!-- Search and Add Candidate Section -->
            <h4 class="mb-4">{{$category->group->name}} - Add Candidate(s) to {{ $category->name }}
                for {{ $election->name }}</h4>
            <livewire:candidate-search :election="$election" :category="$category"/>

            <!-- Display Existing Candidates -->
            <livewire:candidate-list :election="$election" :category="$category"/>
        </div>
    </div>
@endsection
