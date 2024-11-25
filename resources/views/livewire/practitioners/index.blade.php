<div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-sm-4">
                    <div class="search-box">
                        <input wire:model.live="search" id="search" type="text" class="form-control"
                               placeholder="Search by name or registration number">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="col-sm-auto ms-auto">
                    <div class="list-grid-nav hstack gap-1">

                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmembers"><i
                                class="ri-add-fill me-1 align-bottom"></i> Add New Practitioner
                        </button>
                    </div>
                </div>

            </div>
            <!--end row-->


        </div>
    </div>
    <div class="team-list grid-view-filter row">
        @foreach($practitioners as $practitioner)
            <!--start practitioner col-->
            <div class="col-md-3">
                <div class="card team-box">
                    <div class="team-cover">
                        <img
                            src="https://placehold.co/800x533/405189/FFFFFF?text={{$practitioner->first_name.'+'.$practitioner->last_name}}"
                            alt="" class="img-fluid"/>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center team-row">
                            <div class="col team-settings">
                                <div class="row">
                                    <div class="col">
                                        <div class="bookmark-icon flex-shrink-0 me-2"></div>
                                    </div>
                                    <div class="col text-end dropdown">
                                        <a href="javascript:void(0);" id="dropdownMenuLink3"
                                           data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill fs-17"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuLink3">
                                            <li><a class="dropdown-item" href="javascript:void(0);">Renewal
                                                    Status</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Payments</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Certificates</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                   wire:click="deletePractitioner({{ $practitioner->id }})"
                                                   onclick="return confirm('Are you sure you want to delete this practitioner?')">
                                                    Delete Practitioner
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-4 col">
                                <div class="team-profile-img">
                                    <div
                                        class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">

                                        @if($practitioner->image)
                                            <div
                                                class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">
                                                <img src="{{ asset($practitioner->image) }}" alt=""
                                                     class="img-fluid d-block rounded-circle"/>
                                            </div>
                                        @else
                                            @php
                                                $initials = '';
                                                if ($practitioner->first_name) {
                                                    $initials .= strtoupper($practitioner->first_name[0]);
                                                }
                                                if ($practitioner->last_name) {
                                                    $initials .= strtoupper($practitioner->last_name[0]);
                                                }
                                            @endphp
                                            <div
                                                class="avatar-title bg-soft-danger text-danger rounded-circle">
                                                {{ $initials }}
                                            </div>
                                        @endif


                                    </div>
                                    <div class="team-content">
                                        <a data-bs-toggle="offcanvas" href="#offcanvasExample"
                                           aria-controls="offcanvasExample">
                                            <h5 class="fs-16 mb-1">{{ $practitioner->first_name.' '.$practitioner->last_name }}</h5>
                                        </a>
                                        <p class="text-muted mb-0">
                                            @if($practitioner->practitionerProfessions)
                                                <!-- Display the first profession -->
                                                @foreach($practitioner->practitionerProfessions as $profession)
                                                    {{ $profession->profession->name }} <br/>
                                                    {{ $profession->registration_number }}
                                                    @break
                                                @endforeach

                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-2 col">
                                <div class="text-end">
                                    <a href="{{route('practitioners.show',$practitioner->slug)}}"
                                       class="btn btn-light view-btn">View
                                        Profile
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-2 col">


                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end practitioner col-->
        @endforeach

    </div>
    {!! $practitioners->links() !!}
</div>
