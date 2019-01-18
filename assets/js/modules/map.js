import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default class Map {
    static init() {
        let map = document.querySelector('#map')
        if (map === null) {
            return
        }

        let icon = L.icon({
            iconUrl: 'http://localhost/symfony-first-step/public/images/marker-icon.png',
        });

        let center = [map.dataset.lat, map.dataset.lng]
        map = L.map('map').setView(center, 13)
        let token = 'pk.eyJ1IjoiYnVsaW5hdG9yIiwiYSI6ImNqcjI2MHNzejA4dnE0Mm85YnlteGJnOHYifQ.hQk0KMV8y3AfKhEJJknjeA'
        L.tileLayer(`https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=${token}`, {
            maxZoom: 18,
            minZoom: 12,
            attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map)
        L.marker(center, {icon}).addTo(map);
    }
}