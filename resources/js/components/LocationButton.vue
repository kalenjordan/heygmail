<script>
    export default {
        props: ['apiKey', 'locationProp'],
        mounted() {
            this.location = this.locationProp;
            console.log('location: ' + this.location);
        },
        methods: {
            shareLocation() {
                console.log('getting position from browser...');
                this.loading = true;
                navigator.geolocation.getCurrentPosition((position) => {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    console.log('lat/lon: ' + latitude + ', ' + longitude);

                    let url = '/api/geocode?latlon=' +
                        latitude + ',' + longitude + '&api_key=' + this.apiKey;

                    console.log('geolocating from api: ' + url);
                    axios.get(url).then((response) => {
                        console.log('location from api: ' + response.data.location);
                        this.location = response.data.location;
                        this.loading = false;
                    });
                }, function() {
                    console.log('error');
                });
            },
            deleteLocation() {
                let url = '/api/geocode-delete?api_key=' + this.apiKey;
                axios.get(url).then((response) => {
                    this.location = null;
                });
            },
        },
        data() {
            return {
                location: null,
                loading: false
            }
        }
    }
</script>
