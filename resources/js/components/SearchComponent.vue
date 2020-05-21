<template>
    <ais-index :app-id="appId" :api-key="publicApiKey" :index-name="'all'">
        <ais-search-box autofocus></ais-search-box>
        <ais-results>
            <template slot-scope="{ result }">
                <a class="ais-result-link no-link" :href="result.url" v-shortkey="['enter']" @shortkey="submitSearch">
                    {{ result.search_title }}
                </a>
            </template>
        </ais-results>
        <ais-pagination></ais-pagination>
    </ais-index>

</template>

<script>
    export default {
        props: ['appId', 'publicApiKey'],
        mounted() {
            document.addEventListener('keydown', function (e) {
                let activeElement = document.activeElement;
                if (e.code === 'Enter') {
                    document.querySelector('.ais-results a:first-of-type').click();
                }
            });
        },
        data() {
            return {
                //
            };
        },
        methods: {
            submitSearch() {
                document.querySelector('.ais-results a:first-of-type').click();
            }
        },
    };
</script>
