@vite('resources/css/components/adjustment-card.css')


<div
    {{$attributes->class('adjustment-card')}}
    data-employee="{{$employeeId}}"
    data-request="{{$requestId}}"

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
    <div class="link">
{{--        <a href="{{route($link)}}">View Details</a>--}}
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
