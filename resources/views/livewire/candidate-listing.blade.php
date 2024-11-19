<div class="mt-4">
    @if ($election)
        @foreach ($groups as $group)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 style="color: white">{{ $group->name }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($group->categories as $category)
                        <div class="mb-4">
                            <h5>{{ $category->name }}</h5>
                            <div class="row">

                                <!-- Track if we've displayed the Duly Elected badge -->
                                @php $dulyElectedShown = false; @endphp

                                    <!-- Prioritize Duly Elected Candidates -->
                                @foreach ($category->candidates->sortByDesc('status') as $candidate)
                                    @php
                                        $practitioner = $candidate->practitioner;
                                        $initials = strtoupper(substr($practitioner->first_name, 0, 1)) . strtoupper(substr($practitioner->last_name, 0, 1));
                                        $profession = optional($practitioner->practitionerProfessions->first()->profession)->name ?? 'N/A';
                                        $registrationNumber = $practitioner->practitionerProfessions->first()->registration_number ?? 'N/A';
                                        $hasVoted = in_array($candidate->id, $practitionerVotes);
                                        $isDulyElected = $candidate->status === 'Duly Elected';
                                    @endphp
                                    <div class="col-md-4 col-lg-3 mb-4">
                                        <div class="card team-box shadow-sm {{ $isDulyElected ? 'border-success' : '' }}">
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

                                                <!-- Display "Duly Elected" badge or the Vote button -->
                                                @if ($isDulyElected)
                                                    @if (!$dulyElectedShown)
                                                        <span class="badge bg-success mb-2">Duly Elected</span>
                                                        @php $dulyElectedShown = true; @endphp
                                                    @endif
                                                @else
                                                    @if ($isVotingAllowed)
                                                        <button
                                                            wire:click="vote({{ $candidate->id }})"
                                                            class="btn {{ $hasVoted ? 'btn-danger' : 'btn-primary' }} mt-2"
                                                            {{ $hasVoted ? 'disabled' : '' }}
                                                        >
                                                            {{ $hasVoted ? 'Voted' : 'Vote' }}
                                                        </button>
                                                    @else
                                                        <button class="btn btn-secondary mt-2" disabled>
                                                            Voting Closed
                                                        </button>
                                                    @endif
                                                @endif
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
    @else
        <div class="alert alert-danger">No election is currently active</div>
    @endif
</div>
