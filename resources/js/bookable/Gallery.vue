<template>
    <div class="photo-grid">
        <div
            class="photo"
            v-for="index in 5"
            :key="'photo' + index"
            :class="{ 'first-photo': index - 1 == 0 }"
            @click="slider(index-1)"
        >
            <img
                v-if="photos[index - 1]"
                :src="getBookableImg(photos[index - 1]['name'])"
                :alt="photos[index - 1]['name']"
            />
        </div>
        <div class="photo">
            <img
                v-if="photos[1]"
                :src="getBookableImg(photos[1]['name'])"
                :alt="photos[1]['name']"
            />
        </div>

        <transition name="fade">
            <slider
                :photos="photos"
                :current="currentIndex"
                v-if="showSlider"
                @closeSlider="showSlider = false"
            />
        </transition>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import Slider from "./Slider.vue";
export default {
    components: { Slider },
    props: ["photos"],
    mixins: [imageSrc],
    data() {
        return {
            currentIndex: 0,
            showSlider: false,
        };
    },

    methods:{
        slider(index){
            this.currentIndex = index;
            this.showSlider = true;
        },
    }
};
</script>

<style>
.photo-grid {
    display: grid;
    gap: 4px;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    grid-auto-rows: 220px;
}
.photo {
    overflow: hidden;
    cursor: pointer;
}
.photo > img {
    height: 100%;
    width: 100%;
    object-fit: cover;
}
@media screen and (min-width: 750px) {
    .first-photo {
        grid-row: span 2 / auto;
        grid-column: span 2 / auto;
    }
}
</style>
