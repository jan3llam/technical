@extends('layouts.layout')
@section('vendors')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col">
                <h2>Subscribers List</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('subscribers.create') }}" class="btn btn-primary">Create New Subscriber</a>
            </div>
        </div>
        <form action="{{ route('subscribers.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Name"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table id="subscribersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $subscriber)
                    <tr data-subscriber-id="{{ $subscriber->id }}">
                        <td>{{ $subscriber->name }}</td>
                        <td>{{ $subscriber->username }}</td>
                        <td>{{ ucfirst($subscriber->status) }}</td>
                        <td>
                            <a href="{{ route('subscribers.edit', $subscriber->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-subscriber"
                                data-subscriber-id="{{ $subscriber->id }}">Delete</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $subscribers->links() }}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#subscribersTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.delete-subscriber').click(function() {
                const subscriberId = $(this).data('subscriber-id');
                if (confirm('Are you sure you want to delete this subscriber?')) {
                    axios.delete("{{ url('subscribers') }}/" + subscriberId, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(function(response) {
                            alert("Subscriber Removed");
                            $('#subscribersTable').DataTable().row($('tr[data-subscriber-id="' +
                                    subscriberId + '"]'))
                                .remove().draw();
                        })
                        .catch(function(error) {
                            console.error('Error deleting subscriber:', error);
                        });
                }
            });
        });
    </script>
@endsection
