<template>
    <div class="slider">
        <button @click="close" class="close">
            <i class="far fa-window-close"></i>
        </button>
        <button @click="slideRight" class="arrow btn btn-light">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="container-slides">
            <img
                class="image"
                v-for="photo in photos"
                :key="'slider' + photo.id"
                :src="getBookableImg(photo['name'])"
                :style="'transform: translateX('+translate+'%) scale(1)'"
                @click="zoom"
                @mousemove="move"
            />
        </div>
        <button @click="slideLeft" class="arrow btn btn-light">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
export default {
    props: ["photos", "current"],
    mixins: [imageSrc],

    data() {
        return {
            translate: this.current * -100,
        };
    },
    methods: {
        close() {
            this.$emit("closeSlider");
        },

        slideLeft() {
            if (this.translate == (this.photos.length - 1) * -100) {
                this.translate = 0;
            } else {
                this.translate -= 100;
            }

            //remove zoomed and zoom-out cursor
            const zoomed = document.querySelectorAll('.zoomed')
            zoomed.forEach(img => {
                img.classList.remove("zoomed")
                img.style.cursor = "zoom-in"
            }) 
        },

        slideRight() {
            if (this.translate == 0) {
                this.translate = (this.photos.length - 1) * -100;
            } else {
                this.translate += 100;
            }

            //remove zoomed and zoom-out cursor
            const zoomed = document.querySelectorAll('.zoomed')
            zoomed.forEach(img => {
                img.classList.remove("zoomed")
                img.style.cursor = "zoom-in"
            }) 
        },

        zoom(e){
            e.target.classList.toggle("zoomed");

            if(e.target.classList.contains("zoomed")){
                e.target.style.transform = 'translateX('+this.translate+'%) scale(2)'
                e.target.style.cursor = "zoom-out"

            }else{
                e.target.style.transform = 'translateX('+this.translate+'%) scale(1)'
                e.target.style.cursor = "zoom-in"
            }
        },
        move(e){
            
            if(e.target.classList.contains("zoomed")){
                const x = (e.clientX - e.target.getBoundingClientRect().left)/2; //divide by beacause scale = 2
                const y = (e.clientY - e.target.getBoundingClientRect().top)/2;
                e.target.style.transformOrigin = x+'px '+y+'px';
            }
        }
    },
};
</script>

<style scoped>
.close {
    position: absolute;
    top: 20px;
    right: 20px;
    color: white;
}
.slider {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    background: rgba(0, 0, 0, 0.562);
    z-index: 999999;
    overflow: hidden;
    padding: 0 5px;
}
.container-slides {
    overflow: hidden;
    position: relative;
    width: 80%;
    height: 80%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
.container-slides .image {
    width: 100% !important;
    min-height: 100% !important;
    transition: transform 0.7s ease-in;
    cursor: zoom-in;
}
.arrow {
    height: 50px;
    font-size: 1rem;
}
</style>
