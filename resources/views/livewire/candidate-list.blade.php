<div class="card mt-4">
    <div class="card-header">Candidates</div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Registration Number</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($candidates as $index => $candidate)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $candidate->practitioner->first_name }} {{ $candidate->practitioner->last_name }}</td>
                    <td>{{ $candidate->practitioner->practitionerProfessions->first()->registration_number }}</td>
                    <td>{{ $candidate->status }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
