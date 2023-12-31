<div class="profile-card p-20 bg-white rad-10 mt-20">
    <h2 class="mt-0 mb-10 text-capitalize">my educations</h2>
    <p class="mt-0 mb-20 c-grey fs-15 text-capitalize">what stages education i finished</p>

    <x-alerts.alert :success="session('success-education')" :fail="session('fail-education')"/>

    <livewire:add-education :notHasRecord="$educations->isEmpty()"/>

    <ul class="txt-c-mobile mt-6">
        @foreach($educations as $education)
            <li class="education-card">
                <div class="period">
                    <span class="join">{{ $education->start_date }}</span>
                    <span class="dash">-</span>
                    <span class="leave">{{ $education->finish_date }}</span>
                </div>

                <form action="{{ route('profile.delete.education') }}" method="post"
                      class="d-flex justify-between w-full px-1">
                    @csrf @method('delete')
                    <input type="hidden" name="id" value="{{ $education->id }}">
                    <div class="content">
                        <div class="name">
                            <span class="name">{{ Str::limit($education->name )  }}</span>
                            <span class="at">At</span>
                            <a href="{{ $education->organisation_url }}">{{ $education->organisation_name }}</a>
                        </div>


                    </div>

                    <button class="text-danger">
                        <i class="fa fa-trash"></i>
                    </button>

                </form>
            </li>
        @endforeach
    </ul>
</div>
