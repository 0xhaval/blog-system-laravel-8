@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <!--here use one view for tow methods-->
        <div class="card-header">
            {{isset($category) ? 'Edit Category' : 'Add Category'}}
        </div>

        <div class="card-body">
            <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store')}}" method="POST">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{isset($category) ? $category->name : ''}}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ isset($category) ? 'Update catgeory' : 'Add category'}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection