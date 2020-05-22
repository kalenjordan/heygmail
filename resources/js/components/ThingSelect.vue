<template>
    <div>
        <multiselect track-by="id" :loading="isLoading" @input="saveSelectedThingIds" @search-change="asyncFind"
                     :taggable="true" @tag="addNewTag" tag-placeholder="Press enter to create this" tag-position="bottom"
                     :multiple="true" v-model="selectedThings" :options="options" placeholder="Pick your favorite things"
                     label="name" :option-height="104" :show-labels="false">
            <template slot="noOptions">
                Type the name of one of your favorite things!
            </template>
            <template slot="singleLabel" slot-scope="props">
                <span class="option__title">{{ props.option.name }}</span>
            </template>
            <template slot="option" slot-scope="props">
                <span class="ml-1 text-sm">{{ props.option.name }}</span>
            </template>
        </multiselect>
        <input type="hidden" name="favorite_things" class="selectedThings" v-model="selectedThingIds">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    // register globally
    Vue.component('multiselect', Multiselect);

    export default {
        // OR register locally
        components: { Multiselect },
        props: ['things'],
        data () {
            return {
                selectedThings: [],
                options: [],
                isLoading: false,
                selectedThingIds: null
            }
        },
        mounted() {
            this.selectedThings = this.things;
        },
        methods: {
            asyncFind (query) {
                this.isLoading = true;
                axios.get('/api/things?query=' + query).then((response) => {
                    this.options = response.data;
                    this.isLoading = false;
                });
            },
            saveSelectedThingIds() {
                let ids = [];
                this.selectedThings.forEach(element => {
                    ids.push(element.id);
                });
                this.selectedThingIds = ids;
            },
            addNewTag(newThingName) {
                let newThing = {
                    name: newThingName,
                    id: 'new_' + newThingName
                };
                this.options.push(newThing);
                this.selectedThings.push(newThing);
                this.saveSelectedThingIds();
            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    /*your styles*/
</style>