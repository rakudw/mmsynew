@props(['application'])

<div class="timeline timeline-one-side">
    @forelse($application->timelines as $timeline)
        <div class="timeline-block mb-3">
            <span class="timeline-step">
                <em class="material-icons text-success text-gradient">notifications</em>
            </span>
            <div class="timeline-content">
                @php($creator = $timeline->creator)
                <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $timeline->new_status->value }}</h6>
                <figure>
                    <blockquote class="blockquote border-0" class="Remarks">
                        <p>{{ $timeline->remarks }}</p>
                    </blockquote>
                    <figcaption class="blockquote-footer" title="User">
                        {{ $creator->name }} <cite
                            title="User's Role">({{ $timeline->creator_role_id ? $timeline->creatorRole->name : 'Applicant' }})</cite>
                    </figcaption>
                </figure>
                <time class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $timeline->created_at }}</time>
            </div>
        </div>
    @empty
        <div class="timeline-block mb-3">
            <span class="timeline-step">
                <em class="material-icons text-danger text-gradient">hourglass_disabled</em>
            </span>
            <div class="timeline-content">
                <h6 class="text-warning text-sm font-weight-bold mb-0">
                    No activity yet!</h6>
            </div>
        </div>
    @endforelse
</div>