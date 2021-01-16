@extends('layouts.app')

@section('content')


<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('tags.create')}}" class="btn btn-success">Add Tag</a>
</div>
    <div class="card card-default">
        <div class="card-header">
            tags
        </div>
    
        <div class="card-body">
            @if ($tags->count() > 0)
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Post Count</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->posts->count()}}</td>
                            <td>
                                <a href="{{ route('tags.edit', $tag->id)}}" class="btn btn-info btn-sm">Edit</a>

                                <button type="submit" class="btn btn-danger btn-sm" onclick="handleDelete({{ $tag->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
            @else
            <h3 class="text-center">No tags Yet</h3>
            @endif


            <!-- Modal -->
            <div class="modal fade" id="deleteModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="" method="POST" id="deletetagForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="deleteModelLabel">Delete title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">
                                    Are you sure you want to delete this tag ? 
                                </p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Go back</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id) {
            let form = document.getElementById('deletetagForm')
            form.action = '/tags/' + id
            $('#deleteModel').modal('show')
        }
    </script>
@endsection