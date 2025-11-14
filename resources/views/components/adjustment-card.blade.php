@vite('resources/css/components/adjustment-card.css')


<div
    {{$attributes->class('adjustment-card')}}
    data-employee="{{$employeeId}}"
    data-request="{{$requestId}}"
    data-name="{{$name}}"
    data-type="{{$type}}"
    data-message="{{$message}}"
    data-affected-date="{{ $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : '' }}"
    data-start-date="{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') : '' }}"
    data-end-date="{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') : '' }}"

>
    <div class="card-wrapper">
        <div class="image">
            <img src="{{asset('assets/default_profile.png')}}" alt="">
        </div>
        <div class="card-info">
            <div class="name">
                {{$name}}
            </div>
            <div class="type">
               <small>Adjustment Type: {{$type}}</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.adjustment-card');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');

                const employeeId = card.dataset.employee;
                const requestId = card.dataset.request;
                console.log('Selected Employee:', employeeId, 'Request:', requestId);

            });
        });
    });


</script>
