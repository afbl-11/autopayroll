const map = L.map('map').setView([14.5757186, 121.0341171], 13);

L.tileLayer('https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=3A9A7JZIVmptjIhW5v0o', {
    attribution:
        '&copy; <a href="https://www.maptiler.com/" target="_blank">MapTiler</a> ' +
        '<a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
}).addTo(map);

let marker = null;
let circle = null;

function setLocation(latlng) {
    if (!marker) {
        marker = L.marker(latlng, {draggable: true}).addTo(map);
        marker.on('drag', e => {
            const pos = e.target.getLatLng();
            updatePosition(pos);
        });
    } else {
        marker.setLatLng(latlng);
    }
    updatePosition(latlng);
}

map.on('click', function (e) {
    setLocation(e.latlng);

    // Reverse geocode
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('address').value = data.display_name;
        });
});

function updatePosition(latlng) {
    document.getElementById('latitude').value = latlng.lat.toFixed(6);
    document.getElementById('longitude').value = latlng.lng.toFixed(6);

    if (circle) {
        circle.setLatLng(latlng);
    }
}

map.on('click', function (e) {
    setLocation(e.latlng);
});

document.getElementById('radiusInput').addEventListener('input', function () {
    const radius = Number(this.value);

    if (!isNaN(radius) && radius > 0) {
        if (!circle && marker) {
            circle = L.circle(marker.getLatLng(), {radius}).addTo(map);
        } else if (circle) {
            circle.setRadius(radius);
        }
    } else if (circle) {
        map.removeLayer(circle);
        circle = null;
    }
});

L.Control.geocoder({
    defaultMarkGeocode: false,
    geocoder: L.Control.Geocoder.nominatim({
        geocodingQueryParams: {countrycodes: 'ph'}
    })
})
    .on('markgeocode', function (e) {
        const latlng = e.geocode.center;
        setLocation(latlng);
        map.setView(latlng, 16);
    })
    .addTo(map);
