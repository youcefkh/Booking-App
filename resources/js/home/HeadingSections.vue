<template>
    <div>
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="font-weight-bolder">Popular destinations</h1>
                <p>Discover our best destinations</p>
            </div>

            <div class="arrows">
                <button
                    type="button"
                    class="btn btn-light rounded-circle"
                    @click="slide('left')"
                >
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button
                    type="button"
                    class="btn btn-light rounded-circle"
                    @click="slide('right')"
                >
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <div
            class="section-wrapper"
            @mousedown="handleMouseDown"
            @mousemove="handleMouseMove"
            @mouseup="handleMouseUp"
            @mouseleave="handleMouseUp"
            @touchstart="handleMouseDown"
            @touchmove="handleMouseMove"
            @touchend="handleMouseUp"
            ref="slider"
            draggable="false"
        >
            <div class="section-group" >
                <div
                    class="section"
                    v-for="(section, index) in sections"
                    :key="index"
                    ref="section"
                    :data-city="section.name"
                >
                    <div class="section-thumbnail mb-2">
                        <img :src="getImg(section.image)" alt="" />
                    </div>
                    <h5 class="section-name mb-2 font-weight-bolder">{{ section.name }}</h5>
                    <span class="section-detail">{{ section.detail }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ImageSrc from "../shared/mixins/imageSrc";
export default {
    mixins: [ImageSrc],

    data() {
        return {
            sections: [
                {
                    image: "/cities/new-york.jpeg",
                    name: "New York",
                    detail: "188,288 properties",
                },
                {
                    image: "/cities/london.jpeg",
                    name: "London",
                    detail: "188,288 properties",
                },
                {
                    image: "/cities/paris.jpeg",
                    name: "Paris",
                    detail: "188,288 properties",
                },
                {
                    image: "/cities/tokyo.jpeg",
                    name: "Tokyo",
                    detail: "188,288 properties",
                },
                {
                    image: "/cities/singapore.jpeg",
                    name: "Singapore",
                    detail: "188,288 properties",
                },
                {
                    image: "/cities/maldives.jpeg",
                    name: "Maldives",
                    detail: "188,288 properties",
                },
            ],

            isDragging: false,
            prevPageX: 0,
            prevScrollLeft: 0,
            scrollRightEnd: false,
            scrollLeftEnd: true,
        };
    },

    methods: {
        handleMouseDown(e) {
            this.isDragging = true;
            this.prevPageX = e.pageX || e.touches[0].pageX; //touch for mobiles
            this.prevScrollLeft = this.$refs.slider.scrollLeft;
            this.$refs.slider.style.scrollBehavior = "unset";
            this.$refs.slider.classList.add("dragging");
        },

        handleMouseMove(e) {
            if (this.isDragging) {
                this.$refs.section.forEach(section => section.removeEventListener('click', this.sectionClick)); //remove click on section (child element)
                e.preventDefault(); //prevent dragging images
                const delta = (e.pageX || e.touches[0].pageX) - this.prevPageX;
                this.$refs.slider.scrollLeft = this.prevScrollLeft - delta;
            }
        },

        handleMouseUp() {
            this.isDragging = false;
            this.$refs.slider.style.scrollBehavior = "smooth";
            this.$refs.slider.classList.remove("dragging");

            const newScrollLeft = this.$refs.slider.scrollLeft;
            const sectionWidth = this.getSectionFullWidth();

            //trigger snap scroll
            if (newScrollLeft % sectionWidth >= sectionWidth / 2) {
                this.$refs.slider.scrollLeft +=
                    sectionWidth - (newScrollLeft % sectionWidth); //scroll when half of the section is hidden
            } else {
                this.$refs.slider.scrollLeft -= newScrollLeft % sectionWidth; //cancel scroll
            }

            //delay because of the scroll sooth behavior
            setTimeout(() => {
                this.handleEndofScroll(this.$refs.slider);
                this.$refs.section.forEach(section => section.addEventListener('click', this.sectionClick)); //add back the event on section
            }, 400);
        },

        slide(direction) {
            //slide to right if it's in the start and vise versa
            if (this.scrollLeftEnd && direction == "left") {
                this.$refs.slider.scrollLeft = this.$refs.slider.scrollWidth;
                this.scrollRightEnd = true;
                this.scrollLeftEnd = false;
                return;
            } else if (this.scrollRightEnd && direction == "right") {
                this.$refs.slider.scrollLeft = 0;
                this.scrollRightEnd = false;
                this.scrollLeftEnd = true;
                return;
            }

            const width = this.getSectionFullWidth();
            this.$refs.slider.scrollLeft +=
                direction == "left" ? -width : width;

            //add delay because of smooth scroll-behaviour
            setTimeout(() => {
                this.handleEndofScroll(this.$refs.slider);
            }, 400);
        },

        //check if the slider reached the limit (right or left)
        handleEndofScroll(elem) {
            let newScrollLeft = elem.scrollLeft,
                width = elem.clientWidth,
                scrollWidth = elem.scrollWidth;

            if (Math.floor(scrollWidth - newScrollLeft) == width) {
                this.scrollRightEnd = true;
                this.scrollLeftEnd = false;
            } else if (newScrollLeft == 0) {
                this.scrollLeftEnd = true;
                this.scrollRightEnd = false;

            } else {
                this.scrollRightEnd = false;
                this.scrollLeftEnd = false;
            }
        },

        getSectionFullWidth() {
            const firstSection = document.querySelectorAll(
                ".section-group .section"
            )[0];
            const width = firstSection.clientWidth;
            const style = window.getComputedStyle(firstSection, null);
            const margin = parseInt(style.marginRight);

            return width + margin;
        },

        setSectionWidth(e) {
            const sliderWidth = this.$refs.slider.clientWidth;
            const sections = document.querySelectorAll('.section');

            if (window.innerWidth < 550) {
                sections.forEach(section => {
                    section.style.width = (sliderWidth - 25) / 2 + "px"; //in 2 visible sections there is 1 visible margins (3*margin)
                });
            } else if(window.innerWidth < 790) {
                sections.forEach(section => {
                    section.style.width = (sliderWidth - 2*25) / 3 + "px"; //in 3 visible sections there is 2 visible margins (3*margin)
                });
            }else if(window.innerWidth < 1200){
                sections.forEach(section => {
                    section.style.width = (sliderWidth - 3*25) / 4 + "px";
                });
            }else{
                sections.forEach(section => {
                    section.style.width = (sliderWidth - 4*25) / 5 + "px";
                });
            }
        },

        sectionClick(e) {
            const city = e.currentTarget.getAttribute('data-city');
            this.$router.push({ name: 'bookables.index', query: {city: city} })
        }
    },

    mounted() {
        this.setSectionWidth();
        window.addEventListener("resize", this.setSectionWidth);
        this.$refs.section.forEach(section => section.addEventListener('click', this.sectionClick));
    },

    unmounted() {
        window.removeEventListener("resize", this.setSectionWidth);
    },
};
</script>

<style scoped>
.section-wrapper {
    width: 100%;
    overflow: hidden;
    scroll-behavior: smooth;
}

.section-wrapper.dragging {
    cursor: grab;
}

.section-group {
    width: max-content;
    display: flex;
}

.section-group .section {
    width: 250px;
    cursor: pointer;
}

.section-group .section:not(:last-child) {
    margin-right: 25px;
}

.section-group .section .section-thumbnail {
    height: 280px;
    width: 100%;
    overflow: hidden;
    border-radius: 1rem;
}

.section-thumbnail img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    -webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}

/* zoom in */
.section-thumbnail:hover img {
	-webkit-transform: scale(1.3);
	transform: scale(1.3);
}

.arrows {
    display: flex;
    gap: 10px;
}

.arrows button {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    width: 40px;
    border: 1px solid #949aa0;
}

.arrows i {
    font-size: 20px;
    color: #949aa0;
}

@media screen and (max-width: 900px) {
    .section-group .section {
        width: 169px;
    }
}
</style>
