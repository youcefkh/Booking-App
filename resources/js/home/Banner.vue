<template>
    <div class="banner-wrapper row pt-4 position-relative">
        <div class="col-md-6 position-relative">
            <h2 class="font-weight-bolder display-3">
                Hotels, villas & much more
            </h2>

            <p class="h4 text-muted my-4">
                Accompanying us, you have a trip full of experiences. With
                Chisfis, booking accommodation, resort villas, hotels
            </p>

            <router-link
                :to="{ name: 'bookables.index' }"
                class="btn btn-primary btn-lg active my-4 rounded-pill"
                role="button"
                aria-pressed="true"
            >
                Start your search
            </router-link>
        </div>

        <div class="col-md-6 position-relative">
            <div class="blob"></div>
            <img :src="getImg('hero-right.png')" alt="" srcset="" class="img-fluid">
        </div>

        <hero-search-form class="hero-form" />
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import HeroSearchForm from './HeroSearchForm.vue';
export default {
  components: { HeroSearchForm },
    mixins: [imageSrc],
};
</script>

<style scoped>
.banner-wrapper {
  padding-bottom: 60px;
}
.blob {
  position: absolute;
  width: 500px;
  height: 500px;
  background: linear-gradient(
    180deg,
    rgba(47, 184, 255,0.42) 31.77%,
    #5c9df1 100%
  );
  -webkit-animation: move 25s infinite alternate;
          animation: move 25s infinite alternate;
  transition: 1s cubic-bezier(0.07, 0.8, 0.16, 1);
  z-index: -1;
}

.blob:hover {
  width: 520px;
  height: 520px;
  -webkit-filter: blur(30px);
          filter: blur(30px);
  box-shadow:
    inset 0 0 0 5px rgba(255,255,255, 0.6),
    inset 100px 100px 0 0px #fa709a,
    inset 200px 200px 0 0px #784ba8,
    inset 300px 300px 0 0px #2b86c5;
}

@-webkit-keyframes move {
  from {
    transform: translate(100px, -50px) rotate(-90deg);
    border-radius: 24% 76% 35% 65% / 27% 36% 64% 73%;
  }

  to {
    transform: translate(-500px, 0) rotate(-10deg);
    border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
  }
}

@keyframes move {
  from {
    transform: translate(100px, -50px) rotate(-90deg);
    border-radius: 24% 76% 35% 65% / 27% 36% 64% 73%;
  }

  to {
    transform: translate(-500px, 0) rotate(-10deg);
    border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
  }
}

.hero-form {
    position: absolute;
    bottom: 0px;
    left: 0;
}
</style>
