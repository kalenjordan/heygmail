<script>
    export default {
        props: ['apiKey'],
        mounted() {
            // console.log('mounted');
        },
        methods: {
            shareLocation() {
                console.log('getting position from browser...');
                navigator.geolocation.getCurrentPosition((position) => {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    console.log('lat/lon: ' + latitude + ', ' + longitude);

                    let url = '/api/geocode?latlon=' +
                        latitude + ',' + longitude + '&api_key=' + this.apiKey;

                    console.log('geolocating from api: ' + url);
                    axios.get(url).then((response) => {
                        this.setLocation(response.location);
                    });
                }, function() {
                    console.log('error');
                });
            }
        },
        data() {
            return {
                // email: null
            }
        }
    }
</script>
