@vite(['resources/js/api/leaflet.js', 'resources/css/company/company-address.css'])

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<x-app  :noHeader="true" :navigation="true" :company="$company">

    <section class="main-content" style="margin-top:50px">
        <form action="{{route('company.change.client.address', ['id' => $id])}}" method="post">
            @csrf
            <div class="field-row">
                <x-form-input
                    type="text"
                    id="address"
                    name="address"
                    :readOnly="true"
                    label="Address"
                />
                <x-button-submit id="submit-btn">Confirm</x-button-submit>
            </div>
            <div class="field-row">
                <x-form-input
                    type="text"
                    name="latitude"
                    id="latitude"
                    :readOnly="true"
                    label="Latitude"
                />
                <x-form-input
                    type="text"
                    id="longitude"
                    name="longitude"
                    :readOnly="true"
                    label="Longitude"
                />
                <x-form-input
                    type="number"
                    id="radiusInput"
                    name="radius"
                    placeholder="Enter radius in meters"
                    label="Radius"
                />
            </div>
        </form>
        <div id="map"></div>
    </section>
</x-app>

