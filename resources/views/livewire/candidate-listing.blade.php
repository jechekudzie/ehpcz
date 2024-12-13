<div class="mt-4">
    @if ($election)
        @foreach ($groups as $group)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3>{{ $group->name }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($group->categories as $category)
                        <div class="mb-4">
                            <h5>{{ $category->name }}</h5>
                            <div class="row">
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
                                            <div class="card-body text-center">
                                                <!-- Avatar -->
                                                <div class="avatar-lg img-thumbnail rounded-circle mx-auto mb-3">
                                                    @if($practitioner->image)
                                                        <img src="{{ asset($practitioner->image) }}"
                                                             alt="Profile Image"
                                                             class="rounded-circle img-fluid"
                                                             style="object-fit: cover; width: 100%; height: 100%;">
                                                    @else
                                                        <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                            {{ $initials }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Practitioner Details -->
                                                <h5>{{ $practitioner->first_name }} {{ $practitioner->last_name }}</h5>
                                                <p class="text-muted mb-1">{{ $profession }}</p>
                                                <p class="text-muted">Reg No: {{ $registrationNumber }}</p>

                                                <!-- Badge or Vote Button -->
                                                @if ($isDulyElected)
                                                    <span class="badge bg-success mb-2">Duly Elected</span>
                                                @else
                                                    @if ($hasVoted)
                                                        <!-- Show disabled "Voted" button if practitioner has already voted -->
                                                        <button class="btn btn-danger mt-2" disabled>Voted</button>
                                                    @else
                                                        @if ($isVotingAllowed)
                                                            <button
                                                                wire:click="vote({{ $candidate->id }})"
                                                                class="btn btn-primary mt-2">
                                                                Vote
                                                            </button>
                                                        @else
                                                            <button class="btn btn-secondary mt-2" disabled>
                                                                Voting Closed
                                                            </button>
                                                        @endif
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
