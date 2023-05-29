<template>
    <div>
        <success v-if="success">Your purchase has been successfull</success>
        <div class="row" v-else>
            <cart-list class="order-md-2 mb-5" />
            <checkout :bookings="bookings" @success="showSuccess" class="order-md-1"/>

        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import CartList from './CartList.vue';
import Checkout from './Checkout.vue';
export default {
    components: {Checkout, CartList},
    computed: {
        ...mapGetters({
            nbrItems: "itemsInCart",
        }),

        ...mapState({
            items: (state) => state.cart.items,
        }),

        bookings(){
            return this.items.map(item => {
                return {
                    bookable_id: item.bookable_id,
                    from: item.from,
                    to: item.to,
                }
            })
        }
    },

    data(){
        return {
            success: false,
        }
    },

    methods: {
        showSuccess(){
            this.success = true;
            setTimeout(() => {
                this.success = false
            }, 3000);
        }
    }

};
</script>

<style scoped>

</style>
