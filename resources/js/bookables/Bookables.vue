<template>
    <div>
        <div v-if="loading">
            loading...
        </div>
        <div class="row" v-else>
            <div
                class="col-lg-4 col-md-6 p-2"
                v-for="bookable in bookables.data"
                :key="'bookable' + bookable.id"
            >
                <bookable-list-item :item="bookable" />
            </div>
        </div>

        <pagination :data="bookables" :limit="2" :align="'center'" @pagination-change-page="getBookables" class="mb-4"></pagination>
    </div>
</template>

<script>
import BookableListItem from './BookableListItem.vue'
export default {
    components: {
        BookableListItem
    },

    data(){
        return{
            bookables: {},
            loading: true,
        }
    },

    methods:{
        getBookables(page = 1){
            axios.get('/api/bookables?page='+page)
            .then((result) => {
                if(result.status == 200){
                    this.bookables = result.data
                    this.loading = false
                }
            }).catch((err) => {
                console.log(err)
            });
        },
    },

    mounted(){
        this.getBookables()
    }
}
</script>

<style scoped>

</style>
