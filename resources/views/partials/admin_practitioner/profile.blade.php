<div class="col-xxl-3" style="font-weight: bold;color: black;!important;">
    <div class="card mt-n5">
        <div class="card-body p-4">
            <div class="text-center">
                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                    @if($practitioner->image)
                        <img src="{{ asset($practitioner->image) }}"
                             class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                             alt="user-profile-image">
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
                        <img src="https://placehold.co/200x200/405189/FFFFFF?text={{ $initials }}"
                             class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                             alt="user-profile-image">
                    @endif
                    <div data-bs-toggle="modal"
                         data-bs-target="#editPractitioner" class="avatar-xs p-0 rounded-circle profile-photo-edit">
                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="fa fa-camera"></i>
                                                    </span>
                        </label>
                    </div>
                </div>
                <h5 class="fs-16 mb-1">{{ $practitioner->first_name.' '.$practitioner->last_name }}</h5>
                <p class="text-black mb-0">
                    @if($practitioner->practitionerProfessions)
                        {{ $practitioner->practitionerProfessions->first()->profession->name ?? 'Not Available' }}
                    @endif
                </p>
                <p class="text-black mb-0">
                    Registration Number:
                    @if($practitioner->practitionerProfessions)
                        {{ $practitioner->practitionerProfessions->first()->registration_number ?? 'Not Available'}}
                    @endif
                </p>
            </div>
        </div>
    </div>
    <!--end card-->
    <!-- Contact card -->
    <div class="card">
        @if(session()->has('errors'))
            @php $errors = session('errors')->getBag('contactErrors') @endphp
            @if($errors->any())
                <!-- Boostrap dismsable alert -->
                <div class="alert-message col-12 alert alert-danger alert-dismissible fade show"
                     role="alert">
                    <strong>Message!</strong>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>

            @endif
        @endif
        @if(session('contact_success'))
            <!-- Success Alert -->
            <div class="alert-message col-12 alert alert-secondary alert-dismissible fade show"
                 role="alert">
                <strong>Message!</strong> {{ session('contact_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif
        <div class="card-body">
                <span class="float-end badge bg-primary align-middle fs-10">
                    <a style="font-size: 12px;color:white;" href="#"
                       class="link-primary fw-medium" data-bs-toggle="modal"
                       data-bs-target="#addContact">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </span>
            <h5 class="card-title mb-3">CONTACT</h5>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                    @if($practitioner->contacts)
                        @foreach($practitioner->contacts as $contact)
                            <tr>
                                <th class="ps-0" scope="row">
                                    @if($contact->contactType)
                                        {{ $contact->contactType->name }}:
                                    @endif
                                </th>
                                <td style="font-weight: normal;" class="text-black">
                                    @if($contact->contactType)
                                        @if($contact->contactType->name === 'Email')
                                            {{ $contact->contact ?? 'Not Available' }}
                                        @else
                                           {{$contact->contact ?? 'Not Available'}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div><!-- end card body -->
    </div>
    <!-- Contact card -->

    <!-- Address card -->
    <div class="card">
        @if(session()->has('errors'))
            @php $errors = session('errors')->getBag('addressErrors') @endphp
            @if($errors->any())
                <div class="alert-message col-12 alert alert-danger alert-dismissible fade show"
                     role="alert">
                    <strong>Message!</strong>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>

            @endif
        @endif
        @if(session('address_success'))
            <div class="alert-message col-12 alert alert-secondary alert-dismissible fade show"
                 role="alert">
                <strong>Message!</strong> {{ session('address_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif
        <div class="card-body">
                                <span class="float-end badge bg-primary align-middle fs-10">
                                <a style="font-size: 12px;color:white;"
                                   href="#"
                                   class="link-primary fw-medium" data-bs-toggle="modal" data-bs-target="#addAddress">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                                </span>
            <h5 class="card-title  mb-3">ADDRESS</h5>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">

                    @if($practitioner->addresses)
                        @foreach($practitioner->addresses as $address)
                            <tbody>
                            <tr>
                                <th class="ps-0" scope="row">
                                    @if($address->addressType)
                                        {{ $address->addressType->name }}:
                                    @endif
                                </th>
                                <td style="font-weight: normal;" class="text-black">{{$address->address}}
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Province:</th>
                                <td style="font-weight: normal;"
                                    class="text-black">
                                    @if($address->province)
                                        {{$address->province->name}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">City:</th>
                                <td style="font-weight: normal;" class="text-black">
                                    @if($address->city)
                                        {{$address->city->name}}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    @endif


                </table>
            </div>
        </div><!-- end card body -->
    </div>
    <!-- Address card -->
</div>
