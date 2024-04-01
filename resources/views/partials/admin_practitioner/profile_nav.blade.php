<div class="card-header">
    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0">
        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioners.show', $practitioner->slug) ? 'active' : '' }}"
               href="{{ route('practitioners.show', $practitioner->slug) }}">
                <i class="fa fa-user"></i> Personal Details
            </a>
        </li>
        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioner-employments*', $practitioner->slug) ? 'active' : '' }}"
               href="{{ route('practitioner-employments.index', $practitioner->slug) }}">
                <i class="fa fa-black-tie"></i> Employment
            </a>
        </li>

        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioner-professions*') || Request::routeIs('practitioner-professional-qualifications*') ? 'active' : '' }}"
               href="{{ route('practitioner-professions.index', $practitioner->slug) }}">
                <i class="fa fa-user-md"></i> Professions
            </a>
        </li>

        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioner-professions*') || Request::routeIs('practitioner-professional-qualifications*') ? 'active' : '' }}"
               href="{{ route('practitioner-professions.index', $practitioner->slug) }}">
                <i class="fa fa-book"></i> CPDs
            </a>
        </li>

        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioner-professions*') || Request::routeIs('practitioner-professional-qualifications*') ? 'active' : '' }}"
               href="{{ route('practitioner-professions.index', $practitioner->slug) }}">
                <i class="fa fa-gavel"></i> Disciplinary Actions
            </a>
        </li>

        <li class="nav-item">
            <a style="font-size: 14px;"
               class="nav-link {{ Request::routeIs('practitioners.edit', $practitioner->slug) ? 'active' : '' }}"
               href="{{ route('practitioners.edit', $practitioner->slug) }}">
                <i class="fa fa-credit-card"></i> Payments
            </a>
        </li>

    </ul>
</div>
