@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    @foreach($families as $familyLink)
                        <a href="/home?family={{ $familyLink->id }}" class="btn btn-default">{{ $familyLink->id }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <a data-toggle="collapse" href="#parents" style="text-decoration: none; color: black;">
                        <div class="row">
                            <div class="col-6">
                                <h4>{{ $family->father->name }}</h4>
                                <i>Grandfather</i>
                            </div>
                            <div class="col-6">
                                <h4>{{ $family->mother->name }}</h4>
                                <i>Grandfather</i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row collapse" id="parents">
        <div class="col-12" style="padding-left:35px;">
            <div class="row">
                @foreach($children as $child)
                    <div class="col-12">
                        <div class="card bg-info mb-2">
                            <div class="card-body">
                                <a data-toggle="collapse" href="#kids{{ $child->id }}" style="text-decoration: none; color: black;">
                                    <div class="row">
                                        <div class="col">
                                            <h5>{{ $child->name }}</h5>
                                            @if($child->gender->title === 'Male')
                                                <i>Son</i>
                                            @elseif($child->gender->title === 'Female')
                                                <i>Daughter</i>
                                            @else
                                                <i>Child</i>
                                            @endif
                                        </div>
                                        @if(isset($child->partner))
                                            <div class="col">
                                                <h5>{{ $child->partner->name }}</h5>
                                                <i>{{ $child->partnerRelationship->title }}</i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @if(count($child->children) > 0)
                            <div class="row">
                                <div class="col-12" style="padding-left:35px;">
                                    <div class="row collapse" id="kids{{ $child->id }}">
                                        @foreach($child->children as $grandChild)
                                            <div class="col-12">
                                                <div class="card bg-success text-white mb-2">
                                                    <div class="card-body">
                                                        <a data-toggle="collapse" href="#grandKids{{ $grandChild->id }}" style="text-decoration: none; color: black;">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5>{{ $grandChild->name }}</h5>
                                                                    @if($grandChild->gender->title === 'Male')
                                                                        <i>Grand Son</i>
                                                                    @elseif($grandChild->gender->title === 'Female')
                                                                        <i>Grand Daughter</i>
                                                                    @else
                                                                        <i>Grand Child</i>
                                                                    @endif
                                                                </div>
                                                                @if(isset($grandChild->partner))
                                                                    <div class="col">
                                                                        <h5>{{ $grandChild->partner->name }}</h5>
                                                                        <i>{{ $grandChild->partnerRelationship->title }}</i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                @if(count($grandChild->children) > 0)
                                                    <div class="row">
                                                        <div class="col-12" style="padding-left:35px;">
                                                            <div class="row collapse" id="grandKids{{ $grandChild->id }}">
                                                                @foreach($grandChild->children as $greatGrandChild)
                                                                    <div class="col-12">
                                                                        <div class="card bg-warning mb-2">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <h5>{{ $greatGrandChild->name }}</h5>
                                                                                        @if($greatGrandChild->gender->title === 'Male')
                                                                                            <i>Great Grand Son</i>
                                                                                        @elseif($greatGrandChild->gender->title === 'Female')
                                                                                            <i>Great Grand Daughter</i>
                                                                                        @else
                                                                                            <i>Great Grand Child</i>
                                                                                        @endif
                                                                                    </div>
                                                                                    @if(isset($greatGrandChild->partner))
                                                                                        <div class="col">
                                                                                            <h5>{{ $greatGrandChild->partner->name }}</h5>
                                                                                            <i>{{ $greatGrandChild->partnerRelationship->title }}</i>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
