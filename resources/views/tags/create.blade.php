@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <!--here use one view for tow methods-->
        <div class="card-header">
            {{isset($tag) ? 'Edit Tag' : 'Add Tag'}}
        </div>

        <div class="card-body">
            <form action="{{ isset($tag) ? route('tags.update', $tag->id) : route('tags.store')}}" method="POST">
                @csrf
                @if (isset($tag))
                    @method('PUT')
                @endif
                @include('partials.errors')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{isset($tag) ? $tag->name : ''}}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ isset($tag) ? 'Update catgeory' : 'Add tag'}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection