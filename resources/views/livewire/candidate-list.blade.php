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
                <th>Bio</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($candidates as $index => $candidate)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $candidate->practitioner->first_name }} {{ $candidate->practitioner->last_name }}</td>
                    <td>{{ $candidate->practitioner->practitionerProfessions->first()->registration_number }}</td>
                    <td>{{ $candidate->status }}</td>
                    <td>
                        <!-- add modal trigger button -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bioModal{{$candidate->id}}">
                            View Bio
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('elections.categories.candidates.bio', [ $candidate->election_id,$candidate->profession_category_id, $candidate->id]) }}" class="btn btn-primary btn-sm">
                            Add Bio
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>

        </table>

        @foreach($candidates as $index => $candidate)
            <div class="modal fade" id="bioModal{{$candidate->id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $candidate->practitioner->first_name }} {{ $candidate->practitioner->last_name }}'s Bio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                                <p>{{ $candidate->bio }}</p>
                          {{--  @else
                                <p class="text-muted">No bio available for this candidate.</p>
                            @endif--}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
