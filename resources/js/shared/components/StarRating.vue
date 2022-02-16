<template>
    <div class="d-flex">
        <div
            class="star"
            v-for="(star, index) in fullStars"
            :key="'fullStar' + index"
            @click="$emit('rating:changed', star)"
            @mouseover="$emit('rating:hover', star)"
            @mouseleave="$emit('rating:leave', star)"
        >
            <i class="fas fa-star"></i>
        </div>
        <div v-if="halfStar" class="star">
            <i class="fas fa-star-half-alt"></i>
        </div>
        <div
            class="star"
            v-for="(star, index) in emtyStars"
            :key="'emptyStars' + index"
            @click="$emit('rating:changed', fullStars + star)"
            @mouseover="$emit('rating:hover', fullStars + star)"
            @mouseleave="$emit('rating:leave', fullStars + star)"
        >
            <i class="far fa-star"></i>
        </div>
    </div>
</template>

<script>
export default {
    props: ["value"],
    computed: {
        fullStars() {
            return Math.floor(this.value);
        },
        emtyStars() {
            return 5 - Math.ceil(this.value);
        },
        halfStar() {
            return this.value - Math.round(this.value) == 0 ? false : true;
        },
    },
};
</script>

<style scoped>
.star{
    cursor: pointer;
}
</style>
