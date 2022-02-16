<template>
    <div class="py-3 px-4">
        <div class="header row">
            <div class="col-9">
                <h2 class="title font-weight-bolder row">
                    {{ item.property_type }} by {{ item.user.name }}
                </h2>
                <div class="row">
                    <p class="font-weight-bolder my-0 col-lg-4 px-0 mb-2">
                        <i class="fas fa-clock"></i> 
                        {{ item.created_at | fromNow }}
                    </p>
                    <!-- rating -->
                    <div class="d-flex justify-content-start col-lg-4 px-0 mb-2">
                        <star-rating
                            :value="item.average_rating[0]['rating']"
                        />
                        <span class="ml-2 font-weight-bolder">
                            {{
                                parseFloat(
                                    item.average_rating[0]["rating"]
                                ).toFixed(1)
                            }}
                        </span>
                    </div>
                    <!-- favorite heart -->
                    <div class="favorite-wrapper font-weight-bolder col-lg-4 px-0 mb-2">
                        <span>Save : </span>
                        <span v-if="loadingFav">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                        <span v-else>
                            <i
                                class="fas fa-heart text-danger"
                                v-if="favorites.includes(item.id)"
                                @click="dislike"
                            ></i>
                            <i class="far fa-heart" v-else @click="like"></i>
                            
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-3 mb-3">
                <div class="profile-img mx-auto">
                    <img
                        :src="getUsersImage(item.user.profile_image.cropped)"
                        alt=""
                    />
                </div>
            </div>
        </div>

        <hr />
        <!-- equipments -->
        <div class="d-flex justify-content-start align-items-center mb-4">
            <div
                class="
                    equipments
                    d-flex
                    flex-column
                    justify-content-center
                    align-items-center
                    mr-4
                "
            >
                <p class="font-weight-bolder" style="color: #013a51">Rooms</p>

                <div
                    class="
                        d-flex
                        justify-content-around
                        align-items-center
                        w-100
                    "
                >
                    <i class="fas fa-door-open fa-2x text-primary mb-1"></i>
                    <span class="font-weight-bolder">{{ item.rooms }}</span>
                </div>
            </div>

            <div
                class="
                    equipments
                    d-flex
                    flex-column
                    justify-content-center
                    align-items-center
                    mr-4
                "
            >
                <p class="font-weight-bolder" style="color: #013a51">Beds</p>

                <div
                    class="
                        d-flex
                        justify-content-around
                        align-items-center
                        w-100
                    "
                >
                    <i class="fas fa-bed fa-2x text-primary"></i>
                    <span class="font-weight-bolder">{{ item.beds }}</span>
                </div>
            </div>

            <div
                class="
                    equipments
                    d-flex
                    flex-column
                    justify-content-center
                    align-items-center
                    mr-4
                "
            >
                <p class="font-weight-bolder" style="color: #013a51">
                    Bathrooms
                </p>

                <div
                    class="
                        d-flex
                        justify-content-around
                        align-items-center
                        w-100
                    "
                >
                    <i class="fas fa-shower fa-2x text-primary"></i>
                    <span class="font-weight-bolder">{{ item.bathrooms }}</span>
                </div>
            </div>

            <div
                class="
                    equipments
                    d-flex
                    flex-column
                    justify-content-center
                    align-items-center
                    mr-4
                "
            >
                <p class="font-weight-bolder" style="color: #013a51">Guests</p>

                <div
                    class="
                        d-flex
                        justify-content-around
                        align-items-center
                        w-100
                    "
                >
                    <i class="fas fa-users fa-2x text-primary"></i>
                    <span class="font-weight-bolder">{{ item.travelers }}</span>
                </div>
            </div>
        </div>

        <hr />
        <!-- description -->
        <div class="description mb-4">
            <h4 class="text-primary font-weight-bolder">Description</h4>
            <p>
                {{ item.content }} As soon as you walk into this Point Grey home
                you will be struck by the open space and clean lines – the
                perfect canvas on which to create your dream home. Situated
                across from unique Elk Lake, the floor plan has been beautifully
                adapted to modern life. Over 1,100 sq ft of living space which
                includes 2 beds and 2 bathrooms. Unique zoning for the building
                allows for legal short term rentals, pets allowed and a great
                onsite caretaker make this a worry free home. The extensive 2007
                renovation has expanded floor space and functionality while
                respecting the integrity of the original design. It is ideally
                situated on a very private lot along a whisper quiet street.
                Beautiful log construction home on 1 acre. Smart Wiring Options,
                granite island, feature wall unit w/fireplace, field stone
                fireplace and drive in garage with workshop area lend a
                sophisticated feel to the home.
            </p>
        </div>

        <hr />
        <!-- amenities -->
        <div>
            <h4 class="text-primary font-weight-bolder mb-3">What this place offers</h4>
            <guest-favorites :items="item.favorite_equipments" class="mb-3"/>
            <standout :items="item.extraodinary_equipments" class="mb-3"/>
            <safety :items="item.security_equipments" class="mb-3"/>
        </div>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import { mapState } from "vuex";
import Safety from './amenities/Safety.vue';
import Standout from './amenities/standout.vue';
import GuestFavorites from './amenities/GuestFavorites.vue';
export default {
  components: { Safety, Standout, GuestFavorites },
    props: ["item"],
    mixins: [imageSrc],
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
};
</script>

<style scoped>
.header .title {
    font-size: 1.5rem;
    font-weight: 500;
    color: #013a51;
}
.profile-img {
    position: relative;
    height: 56px;
    width: 56px;
    border-radius: 50%;
    overflow: hidden;
}
.profile-img > img {
    position: static;
    height: 100%;
    width: 100%;
    object-fit: cover;
}
.favorite-wrapper i {
    font-size: 1.2rem;
    cursor: pointer;
}
.equipments {
    min-width: 68px;
}
</style>
