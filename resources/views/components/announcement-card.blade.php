@vite(['resources/css/components/announce-card.css'])

<div {{$attributes->class('announce-card')}} onclick="window.location.href='{{route('announce.detail', ['id' => $id])}}'" >
  <div class="title">
        {{$title}}
  </div>
    <div class="message">
        {{$message}}
    </div>
    <div class="date">
        {{$date}}
    </div>

</div>

