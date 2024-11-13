<div>
    <!-- Notifications -->
    @if ($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $errorMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Message!</strong> {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Candidate Search and Result Section -->
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Search by name or registration number..." wire:model="search">
    </div>

    <!-- Practitioners List -->
    <div class="list-group">
        @if ($practitioners->isNotEmpty())
            <div class="mt-3">
                <h5>Search Results</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration Number</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($practitioners as $index => $practitioner)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $practitioner->first_name }}</td>
                            <td>{{ $practitioner->last_name }}</td>
                            <td>{{ $practitioner->practitionerProfessions->first()->registration_number ?? 'N/A' }}</td>
                            <td>
                                <button wire:click="addCandidate({{ $practitioner->id }})" class="btn btn-primary btn-sm">
                                    Add as Candidate
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
