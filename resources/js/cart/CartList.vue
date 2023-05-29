<template>
    <div class="col-md-4 cart-container pl-md-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-secondary">
                <i class="fas fa-shopping-cart"></i>
            </h4>
            <h4 class="rounded">
                <span class="badge badge-secondary">
                    {{ nbrItems }} Item<span v-if="nbrItems > 1">s</span>
                </span>
            </h4>
        </div>

        <transition name="fade" v-if="nbrItems == 0">
            <div class="bg-white p-3 rounded items-container text-sm-center text-muted" >Your cart is empty</div>
        </transition>
        
        <transition-group v-else name="list" tag="div" class="bg-white p-3 rounded items-container">
            <div v-for="(item, index) in items" :key="'item' + item.bookable_id"  :class="[{ 'border-bottom': index+1 !== items.length}]">
                <div class="py-2 d-flex justify-content-between">
                    <router-link
                        class="font-weight-bolder"
                        :to="{
                            name: 'bookables.show',
                            params: { id: item.bookable_id },
                        }"
                        >{{ item.title }}
                    </router-link>
                    <span class=""
                        >${{ item.price }}</span
                    >
                </div>

                <div class="py-2 d-flex justify-content-between date">
                    <span class="text-muted">From {{ item.from }} </span>
                    <span class="text-muted">To {{ item.to }} </span>
                </div>

                <div class="py-2 text-right">
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        @click="
                            $store.dispatch('removeFromCart', {bookable_id: item.bookable_id})
                        "
                    >
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </transition-group>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
export default {

    computed: {

        ...mapGetters({
            nbrItems: "itemsInCart",
        }),

        ...mapState({
            items: (state) => state.cart.items,
        }),
    },
};
</script>

<style scoped>
.cart-container{
    height: fit-content;
}
a {
    color: black;
    text-decoration: none;
    font-size: 1rem;
}
a:hover {
    color: rgb(66, 63, 63);
}
.date {
    font-size: 0.8rem;
}
.items-container{
    box-shadow: 1px 5px 5px 0px #e7e7e7;
}
</style>
