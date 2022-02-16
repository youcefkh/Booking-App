<template>
    <div>
        <banner class="banner" />

        <div>
            <div class="menu p-5">
                <ul class="d-flex justify-content-start align-items-center mb-0 pl-0">
                    <li
                        @click="content = 'posts'"
                        :class="{ 'bg-white active': content == 'posts' }"
                    >
                        <i class="fas fa-address-card"></i> My posts
                    </li>
                    <li
                        @click="content = 'infos'"
                        :class="{ 'bg-white active': content == 'infos' }"
                    >
                        <i class="fas fa-user-shield"></i> My credentials
                    </li>
                    <li
                        @click="content = 'favs'"
                        :class="{ 'bg-white active': content == 'favs' }"
                    >
                        <i class="fas fa-heart"></i> My favorites
                    </li>
                </ul>
                <div class="content p-4">
                    <div v-if="!loading">

                        <div class="posts" v-if="content == 'posts'" >
                            <div class="m-auto" v-show="!bookables.data">
                                <p class="text-muted">You haven't post anything yet</p>
                            </div>
                            <div class="row">
                                <div v-for="bookable in bookables.data" :key="'bookable' + bookable.id" class="col-lg-6">
                                    <bookable-list-item :item="bookable" />
                                </div>
                            </div>
                            
                            <pagination :data="bookables" :limit="2" :align="'center'" @pagination-change-page="getBookables" class="row"></pagination>
                        </div>

                        <div class="infos" v-else-if="content == 'infos'">
                            <credentials />
                        </div>

                        <div class="favs" v-else>
                            <div class="m-auto" v-show="!favorites.data">
                                <p class="text-muted">Your favorites list is empty</p>
                            </div>
                            <div class="row">
                                <div v-for="bookable in favorites.data" :key="'favorite' + bookable.id" class="col-lg-6">
                                    <bookable-list-item :item="bookable" />
                                </div>
                            </div>

                            <pagination :data="favorites" :limit="2" :align="'center'" @pagination-change-page="getFavorites" class="row"></pagination>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BookableListItem from '../bookables/BookableListItem.vue';
import Banner from "../profile/Banner.vue";
import Credentials from '../profile/Credentials.vue';
export default {
    components: { Banner, BookableListItem, Credentials },
    data() {
        return {
            content: "posts",
            bookables: {},
            favorites: {},
            loading: false,
        };
    },

    methods:{
        getBookables(page = 1){
            this.loading = true;
            const id = this.$route.params.id;
            axios.get(`/api/users/${id}/bookables?page=${page}`)
            .then((result) => {
                if(result.status == 200 && result.data.data){
                    this.bookables = result.data
                    this.loading = false
                }
            }).catch((err) => {
                console.log(err)
            });
        },

        getFavorites(page = 1){
            this.loading = true;
            const id = this.$route.params.id;
            axios.get(`/api/users/${id}/favorites?page=${page}`)
            .then((result) => {
                if(result.status == 200 && result.data.data){
                    this.favorites = result.data
                    this.loading = false
                }
            }).catch((err) => {
                console.log(err)
            });
        }
    },

    mounted(){
        this.getBookables()
        this.getFavorites()
    }
};
</script>

<style scoped>
.banner {
    margin-bottom: 80px;
}
.content{
    position: relative;
    background: #fff;
    box-shadow: -2px 2px 11px 0px #c6c1c1ab;
    border-radius: 0px 10px 10px 10px;
    z-index: 2;
}
li {
    position: relative;
    list-style: none;
    padding: 2px 5px;
    background: #efefef;
    border-radius: 10px 10px 0 0;
    margin-right: 4px;
    cursor: pointer;
    font-weight: bolder;
    font-size: 1rem;
    z-index: 1;
}
li.active{
    box-shadow: rgb(198 193 193 / 67%) -7px -1px 11px 0px;
}
li.active::after{
    content: "";
    position: absolute;
    bottom: -1px;
    left: 0px;
    height: 5px;
    width: 100%;
    background: #741616;
}
</style>
