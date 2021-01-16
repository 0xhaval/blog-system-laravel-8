@extends('layouts.app')

@section('content')
    <div class="card card-deault">
        <div class="card-header">
            {{ isset($post) ? 'Edit a Post' : 'Create a New Post'}}
        </div>

        <div class="card-body">
            <!-- add enctype if form have multimedia-->
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($post)
                    @method('PUT')
                @endisset
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ isset($post) ? $post->title : ''}}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ isset($post) ? $post->description : ''}}</textarea>
                    
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <input type="hidden" name="content" id="content" value="{{ isset($post) ? $post->content : ''}}">
                    <trix-editor input="content"></trix-editor>
                </div>

                <div class="form-group">
                    <label for="published_at">Published At</label>
                    <input type="text" name="published_at" id="published_at" class="form-control" value="{{ isset($post) ? $post->published_at : ''}}">
                </div>

                @if (isset($post))
                    <div class="form-group">
                        <img src="{{ asset('/storage/'.$post->image)}}" alt="" style="width: 100%">
                    </div>
                @endif
                <div class="form-group">
                    <label for="image">Upload image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if (isset($post))
                                    @if ($category->id == $post->category_id)
                                        selected
                                    @endif
                                @endif
                                >
                                {{ $category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ isset($post) ? 'Update Post' : 'Add Post'}}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#published_at', {
        enableTime: true,
    })
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection