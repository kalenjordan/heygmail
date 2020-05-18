<script>
    export default {
        mounted() {
            // console.log('mounted');
        },
        methods: {
            subscribe() {
                let email = this.$refs.email.value;
                axios.get('/api/newsletter-subscribe?email=' + email).then((response) => {
                    alert('Thanks!');
                }).catch(function (error) {
                    alert(error.response.data.error);
                })
            }
        },
        data() {
            return {
                email: null
            }
        }
    }
</script>
