@props(['header' => '', 'title' => '', 'admin' => false])

<header>
    <h3>{{ $title }}</h3>

    @if($admin && auth('admin')->check())
        @php
            $adminUser = auth('admin')->user();
        @endphp

        <div class="user-profile">
            <x-image-link
                :source="route('admin.settings')"
            >
                <h6>
                    HELLO,
                    {{ $adminUser->first_name }}
                    {{ $adminUser->last_name }}!
                </h6>
            </x-image-link>
        </div>
    @endif
</header>
