asds
@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="card mb-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Concern</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($concerns as $concern)
                            <tr>
                                <td>{{ $concern->name }}</td>
                                <td>{{ $concern->email }}</td>
                                <td>{{ $concern->contact }}</td>
                                <td>{{ Str::limit($concern->name, 50, '...') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{-- {{ $concerns->withQueryString()->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
