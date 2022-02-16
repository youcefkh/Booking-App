<template>
    <div>
        <div v-if="loading">Loading...</div>
        <!-- <div v-else>
            <div class="row" >
                <div class="col-md-8">
                    <div class="card mb-5 overflow-hidden">
                        <div class="card-body">
                            <h2 class="card-title">{{ bookable.title }}</h2>
                            <hr />
                            <article class="card-text overflow-hidden">{{ bookable.content }}</article>
                        </div>
                    </div>

                    <review-list :bookableId="this.$route.params.id"/>
                </div>
                
                <div class="col-md-4 px-4">
                    <availability class="mb-4" :bookableId="this.$route.params.id" @availability="checkPrice($event)"/>

                    <transition name="fade">
                        <div  v-if="price">
                            <price-breakdown :price="price"/>
                            <button class="btn btn-primary btn-block" @click="addToCart" v-if="!isInCart">
                                <i class="fas fa-shopping-cart"></i> Add To Cart
                            </button>
                        </div>
                    </transition>

                    <transition name="fade">
                        <div  v-if="isInCart">
                            <button class="btn btn-outline-danger btn-block" @click="removeFromCart">
                                <i class="far fa-trash-alt"></i> Remove From Cart
                            </button>
                        </div>
                    </transition>
                </div>
            </div>

        </div> -->
        <div v-else>
            <!-- header -->
            <div class="header d-flex justify-content-lg-between align-items-center mb-5">
                <div>
                    <h1 class="title font-weight-bolder">{{bookable.title}}</h1>
                    <p class="location font-weight-bolder text-muted my-0">
                        <i class="fas fa-map-marker-alt"></i> 
                        {{bookable.location.city}}, {{bookable.location.country}} 
                    </p>
                </div>
                <div class="price-wrapper">
                    <p class="price">
                        ${{ bookable.price }} Per Night
                    </p>
                </div>
            </div>

            <!-- gallery -->
            <gallery :photos="bookable.photos" class="mb-5"/>

            <!-- infos & availability -->
            <div class="row mx-0 mb-5">
                <div class="col-md-4 order-md-1 px-sm-0 pl-md-4">
                    <availability :bookableId="bookable.id" class="col-12 mb-4" @availability="checkPrice($event)"/>

                    <transition name="fade">
                        <div  v-if="price">
                            <price-breakdown :price="price"/>
                            <button class="btn btn-primary btn-block" @click="addToCart" v-if="!isInCart">
                                <i class="fas fa-shopping-cart"></i> Add To Cart
                            </button>
                        </div>
                    </transition>

                    <transition name="fade">
                        <div  v-if="isInCart">
                            <button class="btn btn-outline-danger btn-block" @click="removeFromCart">
                                <i class="far fa-trash-alt"></i> Remove From Cart
                            </button>
                        </div>
                    </transition>
                </div >

                <div class="infos col-md-8 order-md-0 px-0 rounded shadow">
                    <infos class="col-12" :item="bookable"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Review from '../review/Review.vue'
import Availability from './Availability.vue'
import ReviewList from './ReviewList.vue'
import PriceBreakdown from '../shared/components/PriceBreakdown.vue'

import { mapState, mapGetters } from 'vuex'
import Gallery from './Gallery.vue'
import Infos from './Infos.vue'

export default {
    components:{
        Availability,
        ReviewList,
        Review,
        PriceBreakdown,
        Gallery,
        Infos
    },

    data(){
        return{
            bookable: null,
            loading: true,
            price: null,
        }
    },

    computed: {
        ...mapState({    
            // map this.count to store.state.count
            lastSearch: 'lastSearch',
        }),

        isInCart(){
            return this.$store.getters.isInCart(this.bookable)
        }
    },

    methods: {
        async checkPrice(isAvailable){
            if(!isAvailable){
                this.price = null;
                return;
            }

            try {
                this.price = ( await axios.get(`/api/bookables/${this.$route.params.id}/price`, {
                    params: {
                        from: this.lastSearch.from,
                        to: this.lastSearch.to,
                    }
                }) ).data.data
            } catch (error) {
                console.log(error)
                this.price = null
            }
        },

        addToCart(){
            const id = this.$route.params.id
            console.log('bookable',id)
            this.$store.dispatch('addToCart', {
                bookable_id: id,
                price: this.price,
                date: this.lastSearch
            })
        },

        removeFromCart(){
            this.$store.dispatch('removeFromCart', {bookable_id: this.bookable.id})
        }
    },

    created(){
        const id = this.$route.params.id;
        axios.get(`/api/bookables/${id}`)
        .then((result) => {
            if(result.status == 200){
                this.bookable = result.data
                this.loading = false
            }
        }).catch((err) => {
            console.log(err)
        });
    }
}
</script>

<style scoped>
.header .title{
    font-size: 2rem;
    font-weight: 500;
    color: #013a51;
}
.header .price {
    font-size: 1.5rem;
    color: #2c99da;
    font-weight: 500;
    margin: 0;
    line-height: 26px;
}
.header .price-wrapper{
    border-left: 1px solid #e5d4d4;
    padding: 10px 0 10px 20px;
    align-items: center;
}
</style>