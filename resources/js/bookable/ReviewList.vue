<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div>
                <h6 class="text-uppercase font-weight-bolder">
                    <i class="fas fa-comments"></i> Reviews
                </h6>

                <div
                    class="review px-4"
                    v-for="(review, index) in reviews.data"
                    :key="'review' + index"
                >
                    <div class="row pt-4">
                        <div class="d-flex justify-content-start col-md-6">
                            <div
                                class="
                                    d-flex
                                    justify-content-start
                                    align-items-center
                                "
                            >
                                <div class="profile-img mr-2">
                                    <img
                                        :src="
                                            getUsersImage(
                                                review.user.profile_image
                                                    .cropped
                                            )
                                        "
                                        alt=""
                                    />
                                </div>
                                <div class="name-time d-flex justify-content-center align-items-start">
                                    <router-link
                                        class="name d-flex flex-column"
                                        :to="{
                                            name: 'profile',
                                            params: { id: review.user_id },
                                        }"
                                    >
                                        <p class="font-weight-bolder my-0 mr-3">
                                            {{ review.user.name }}
                                        </p>
                                        <p class="text-muted my-0">
                                            @{{ review.user.username }}
                                        </p>
                                    </router-link>

                                    <div>
                                        <span class="text-muted">{{
                                            review.created_at | fromNow
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <star-rating :value="review.rating" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-muted"></div>
                    </div>
                    <div class="row py-4">
                        <div class="col-12">
                            {{ review.content }}
                        </div>
                    </div>
                </div>
            </div>

            <pagination
                :data="reviews"
                :limit="2"
                :align="'center'"
                @pagination-change-page="getReviews"
                class="my-4"
            ></pagination>
        </div>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import StarRating from "../shared/components/StarRating.vue";
/* import moment from 'moment' */

export default {
    mixins: [imageSrc],
    components: { StarRating },
    props: ["bookableId"],

    data() {
        return {
            loading: false,
            reviews: [],
        };
    },

    methods: {
        getReviews(page = 1) {
            this.loading = true;
            axios
                .get(`/api/bookables/${this.bookableId}/reviews?page=${page}`)
                .then((result) => {
                    if (result.status == 200) {
                        this.reviews = result.data;
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
                .then(() => (this.loading = false));
        },
    },

    created() {
        this.getReviews();
    },
};
</script>

<style scoped>
.name {
    color: black;
    
}
.name-time{
    line-height: 1.2;
}
.review:not(:last-child) {
    border-bottom: 1px solid rgb(216, 212, 212);
}

.profile-img {
    position: relative;
    height: 50px;
    width: 50px;
    border-radius: 50%;
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
</style>
