<template>
    <div class="mb-5">
        <div class="card mb-4 overflow-hidden shadow">
            <div class="card-header p-0">
                <img
                    :src="getBookableImg(item.thumbnail[0]['name'])"
                    alt="thuumbnail"
                    @click="show"
                />

                <!-- favorite heart -->
                <div class="favorite-wrapper">
                    <div v-if="loadingFav">
                        <i class="fas fa-circle-notch fa-spin"></i>
                    </div>
                    <div v-else>
                        <i class="fas fa-heart text-danger" v-if="favorites.includes(item.id)" @click="dislike"></i>
                        <i class="far fa-heart" v-else @click="like"></i>
                    </div>
                </div>
                <!-- user info -->
                <router-link
                    :to="{ name: 'profile', params: { id: item.user_id } }"
                    class="
                        text-decoration-none
                        user-info
                        d-flex
                        align-items-center
                    "
                >
                    <div class="profile-img mr-2">
                        <img
                            :src="
                                getUsersImage(item.user.profile_image.cropped)
                            "
                            alt=""
                        />
                    </div>
                    <div class="name">
                        <p class="text-white font-weight-bolder my-0">
                            {{ item.user.name }}
                        </p>
                        <p class="text-white-50 my-0">
                            @{{ item.user.username }}
                        </p>
                    </div>
                </router-link>
            </div>
            <div class="card-body">
                <h5 class="card-title font-weight-bolder" @click="show">
                    {{ item.title }}
                </h5>

                <p class="location overflow-hidden">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ item.location.city }}, {{ item.location.country }}
                </p>

                <!-- rating -->
                <div class="row">
                    <div class="d-flex justify-content-start col-6 px-0">
                        <star-rating
                            :value="item.average_rating[0]['rating']"
                        />
                        <p class="ml-2 font-weight-bolder">
                            {{
                                parseFloat(
                                    item.average_rating[0]["rating"]
                                ).toFixed(1)
                            }}
                        </p>
                    </div>
                    <div
                        class="text-muted col-6 text-right"
                        style="font-size: 0.8rem"
                    >
                        <i class="fas fa-clock"></i>
                        {{ item.created_at | fromNow }}
                    </div>
                </div>

                <!-- equipments -->
                <div
                    class="
                        d-flex
                        justify-content-between
                        align-items-center
                        mb-4
                    "
                >
                    <div
                        class="
                            equipments
                            d-flex
                            flex-column
                            justify-content-center
                            align-items-start
                        "
                    >
                        <p class="font-weight-bolder" style="color: #013a51">
                            Rooms
                        </p>

                        <div
                            class="
                                d-flex
                                justify-content-between
                                align-items-center
                                w-100
                            "
                        >
                            <i class="fas fa-door-open fa-2x text-muted mb-1"></i>
                            <span class="font-weight-bolder">{{
                                item.rooms
                            }}</span>
                        </div>
                    </div>

                    <div
                        class="
                            equipments
                            d-flex
                            flex-column
                            justify-content-center
                            align-items-start
                        "
                    >
                        <p class="font-weight-bolder" style="color: #013a51">
                            Bathrooms
                        </p>

                        <div
                            class="
                                d-flex
                                justify-content-between
                                align-items-center
                                w-100
                            "
                        >
                            <i class="fas fa-shower fa-2x text-muted"></i>
                            <span class="font-weight-bolder">{{
                                item.bathrooms
                            }}</span>
                        </div>
                    </div>

                    <div
                        class="
                            equipments
                            d-flex
                            flex-column
                            justify-content-center
                            align-items-start
                        "
                    >
                        <p class="font-weight-bolder" style="color: #013a51">
                            Guests
                        </p>

                        <div
                            class="
                                d-flex
                                justify-content-between
                                align-items-center
                                w-100
                            "
                        >
                            <i class="fas fa-users fa-2x text-muted"></i>
                            <span class="font-weight-bolder">{{
                                item.travelers
                            }}</span>
                        </div>
                    </div>
                </div>

                <!-- price -->
                <div class="row">
                    <p class="price font-weight-bolder col-md-12 px-0">
                        ${{ item.price }}/<span style="font-size: 0.9rem"
                            >Night</span
                        >
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import imageSrc from "../shared/mixins/imageSrc";
export default {
    mixins: [imageSrc],
    props: ["item"],
    computed: {
        ...mapState(["user"]),
        favorites() {
            return Object.keys(this.user.favorites).map(key => {
                return this.user.favorites[key]["bookable_id"];
            });
        },
    },
    data(){
        return{
            loadingFav: false
        }
    },
    methods: {
        show() {
            this.$router.push({
                name: "bookables.show",
                params: { id: this.item.id },
            });
        },

        async like(){
            this.loadingFav = true;
            try {
                await axios.post(`/api/favorites/${this.item.id}/create`)
                await this.$store.dispatch('loadUser');
            } catch (error) {
                console.log(err)
            }
            this.loadingFav = false
        },

        async dislike(){
            this.loadingFav = true;
            try {
                await axios.post(`/api/favorites/${this.item.id}/delete`)
                await this.$store.dispatch('loadUser');
            } catch (error) {
                console.log(err)
            }
            this.loadingFav = false
        }
    },

    mounted() {
    },
};
</script>

<style scoped>
.card-header {
    position: relative;
    height: 280px;
}
.equipments {
    min-width: 56px;
}
.card-header > img {
    position: absolute;
    top: 50%;
    left: 50%;
    height: 100%;
    width: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: 0.5s all;
    transform: scale(1.1) translate(-50%, -50%);
}
.card-header > img:hover {
    transform: scale(1) translate(-50%, -50%);
}
.card-title {
    max-height: 40px;
    color: #013a51;
    font-size: 19px;
    cursor: pointer;
}
.location {
    color: #477c9c;
    font-size: 0.9rem;
}
.card-title,
.location {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1; /* number of lines to show */
    -webkit-box-orient: vertical;
}
.price {
    font-size: 18px;
    color: #2c99da;
    font-weight: 500;
    margin: 0;
    line-height: 26px;
}

.user-info {
    position: absolute;
    bottom: 10px;
    left: 20px;
    cursor: pointer;
}
.profile-img {
    position: relative;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    border: 3px solid #fff;
    overflow: hidden;
}
.profile-img > img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: 100%;
    width: 100%;
    object-fit: cover;
}

.user-info .name {
    line-height: 1.2;
}

.favorite-wrapper {
    position: absolute;
    top: 10px;
    right: 15px;
    height: 30px;
    width: 30px;
    font-size: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px;
}
.favorite-wrapper i {
    cursor: pointer;
}
</style>
