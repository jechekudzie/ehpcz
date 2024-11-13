<div class="mt-4">
   {{-- @if($successMessage)
        <div class="alert alert-success">{{ $successMessage }}</div>
    @endif

    @if($errorMessage)
        <div class="alert alert-danger">{{ $errorMessage }}</div>
    @endif--}}

    @foreach($groups as $group)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 style="color: white">{{ $group->name }}</h3>
            </div>
            <div class="card-body">
                @foreach($group->categories as $category)
                    <div class="mb-4">
                        <h5>{{ $category->name }}</h5>
                        <div class="row">
                            @foreach($category->candidates as $candidate)
                                @php
                                    $practitioner = $candidate->practitioner;
                                    $initials = strtoupper(substr($practitioner->first_name, 0, 1)) . strtoupper(substr($practitioner->last_name, 0, 1));
                                    $profession = optional($practitioner->practitionerProfessions->first()->profession)->name ?? 'N/A';
                                    $registrationNumber = $practitioner->practitionerProfessions->first()->registration_number ?? 'N/A';
                                @endphp
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card team-box shadow-sm">
                                        <div class="team-cover">
                                            <img src="https://placehold.co/800x533/405189/FFFFFF?text={{ $practitioner->first_name.'+'.$practitioner->last_name }}"
                                                 alt="Cover Image" class="img-fluid" style="border-radius: 8px 8px 0 0;"/>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="avatar-lg img-thumbnail rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                <div class="avatar-title bg-soft-primary text-primary rounded-circle" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                    {{ $initials }}
                                                </div>
                                            </div>
                                            <h5>{{ $practitioner->first_name }} {{ $practitioner->last_name }}</h5>
                                            <p class="text-muted mb-1">{{ $profession }}</p>
                                            <p class="text-muted">Reg No: {{ $registrationNumber }}</p>
                                            <a href="{{ route('practitioners.show', $practitioner->slug) }}" class="btn btn-outline-primary btn-sm mt-2">View Profile</a>
                                          <br/>

                                            <!-- Vote Button -->
                                            @php
                                                $hasVoted = in_array($candidate->id, $practitionerVotes);
                                            @endphp

                                            <button
                                                wire:click="vote({{ $candidate->id }})"
                                                class="btn {{ $hasVoted ? 'btn-danger' : 'btn-primary' }} mt-2"
                                                {{ $hasVoted ? 'disabled' : '' }}
                                            >
                                                {{ $hasVoted ? 'Voted' : 'Vote' }}
                                            </button>



                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach


</div>


