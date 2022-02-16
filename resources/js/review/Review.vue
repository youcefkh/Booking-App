<template>
    <div>
        <div v-if="loading">Loading</div>
        <div v-else>
            <div v-if="isInvalidKey">
                <fatal-error />
            </div>
            <div v-else>
                <div class="alert alert-info" v-if="isExists">
                    You've already left a review for this booking
                </div>
                <div v-else>
                    <div v-if="!isReviewCreated">
                        <div class="alert alert-info">
                            <p>
                                You've stayed in
                                <router-link
                                    :to="{
                                        name: 'bookables.show',
                                        params: { id: booking.bookable_id },
                                    }"
                                    >{{ booking.bookable.title }}</router-link
                                >
                            </p>
                            <p>From {{booking.from}} to {{booking.to}} </p>
                        </div>
                        <div class="form-group">
                            <label for="rating" class="font-weight-bolder"
                                >Select the star rating (from 1 to 5)</label
                            >
                            <star-rating
                                :value="stars"
                                class="fa-3x"
                                @rating:changed="onRatingChanged"
                                @rating:hover="onRatingOver"
                                @rating:leave="onRatingLeave"
                            />
                            <div class="text-danger" v-if="errors && errors.rating"> {{errors.rating[0]}} </div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="font-weight-bolder"
                                >Comment</label
                            >
                            <textarea
                                id="comment"
                                cols="30"
                                rows="10"
                                class="form-control"
                                placeholder="Describe your experience"
                                v-model="content"
                                :class="[{'is-invalid': errors && errors.content}]"
                            ></textarea>
                            <div class="text-danger" v-if="errors && errors.content"> {{errors.content[0]}} </div>
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" @click="submit">
                            Send
                        </button>
                    </div>
                    <div v-else>
                        <success>Your review has been successfully sent</success>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from './../shared/mixins/validationErrors'
export default {

    mixins: [validationErrors],

    data() {
        return {
            stars: 0, //rating
            stars_tmp: 0, //temporary rating on hover
            content: null,
            isExists: false, //does the review key exists in reviews table
            loading: true,
            booking: null,
            isInvalidKey: false,
            isReviewCreated: false,
        };
    },

    methods: {
        onRatingChanged(rating) {
            this.stars = rating;
            this.stars_tmp = rating;
        },
        onRatingOver(rating) {
            this.stars = rating;
        },
        onRatingLeave(rating) {
            this.stars = this.stars_tmp;
        },
        submit(){
            axios.post('/api/reviews', 
            {
                id: this.$route.params.id,
                rating: this.stars,
                content: this.content
            })
            .then((result) => {
                if(result.status == 201){
                    this.isReviewCreated = true
                }
            }).catch((err) => {
                if(err.response.status == 422){
                    this.errors = err.response.data.errors
                }
            });
        }
    },

    async created() {
        /* try {
            this.isExists = await (axios.get(`/api/reviews/${this.$route.params.id}`)).status == 200
        } catch (err) {
            console.log(err)
            if (
                    err.response &&
                    err.response.status &&
                    err.response.status == 404
                )
                {
                    try {
                        this.booking = await (axios.get(`/api/booking-by-review/${this.$route.params.id}`) ).data
                    } catch (err) {
                        this.isInvalidKey = true;
                    }
                }
        }
        //this.loading = false */
        axios
            .get(`/api/reviews/${this.$route.params.id}`)
            .then((result) => {
                if (result.status == 200) {
                    this.isExists = true;
                }
            })
            .catch((err) => {
                if (
                    err.response &&
                    err.response.status &&
                    err.response.status == 404
                ) {
                    return axios
                        .get(`/api/booking-by-review/${this.$route.params.id}`)
                        .then((result) => {
                            this.booking = result.data;
                            console.log(result.data);
                        })
                        .catch((err) => {
                            this.isInvalidKey = true;
                        });
                }
            })
            .then(() => (this.loading = false));
    },
};
</script>

<style></style>
