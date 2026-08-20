import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import axios from 'axios';

window.axios = axios;

document.addEventListener('DOMContentLoaded', function () {

    // Share buttons
    document.querySelectorAll('[data-share]').forEach(function (btn) {

        btn.addEventListener('click', function () {

            const url = encodeURIComponent(
                btn.dataset.url || window.location.href
            );

            const title = encodeURIComponent(
                btn.dataset.title || document.title
            );

            const type = btn.dataset.share;

            const shareUrls = {
                facebook: 'https://www.facebook.com/sharer/sharer.php?u=' + url,

                whatsapp: 'https://wa.me/?text=' + title + '%20' + url,

                telegram: 'https://t.me/share/url?url=' + url + '&text=' + title,

                imo: 'https://imo.im/?link=' + url,

                email: 'mailto:?subject=' + title + '&body=' + url
            };

            if (shareUrls[type]) {
                window.open(
                    shareUrls[type],
                    '_blank',
                    'noopener,noreferrer'
                );
            }
        });
    });


    // Geolocation
    const geoButton = document.querySelector('[data-geolocate]');

    if (geoButton) {

        geoButton.addEventListener('click', function () {

            if (!navigator.geolocation) {
                alert('Geolocation is not supported by this browser.');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {

                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    const latInput = document.querySelector('[name="lat"]');
                    const lngInput = document.querySelector('[name="lng"]');
                    const locationLabel =
                        document.querySelector('[data-location-label]');

                    if (latInput) {
                        latInput.value = lat;
                    }

                    if (lngInput) {
                        lngInput.value = lng;
                    }

                    if (locationLabel) {
                        locationLabel.textContent =
                            lat.toFixed(5) + ', ' + lng.toFixed(5);
                    }
                },
                function () {
                    alert('Please allow location access.');
                }
            );
        });
    }
});