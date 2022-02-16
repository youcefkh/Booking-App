<template>
    <div class="bg-white rounded shadow p-3">
        <h6 class="text-uppercase font-weight-bolder">
            Check Availability
            <transition name="slide-fade">
                <span v-if="isAvailable == true" class="text-success">(Available)</span>
                <span v-else-if="isAvailable == false" class="text-danger">(Not Available)</span>
            </transition>
        </h6>

        <div class="form-row">
            <div class="form-group col-12 mb-4">
                <label for="from">From</label>
                <input
                    type="date"
                    id="from"
                    v-model="from"
                    class="form-control form-control-sm"
                    placeholder="Start date"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': errors && errors['from'] }]"
                />
                <transition name="slide-fade">
                    <div
                        class="invalid-feedback"
                        v-if="errors && errors['from']"
                    >
                        {{ errors["from"][0] }}
                    </div>
                </transition>
            </div>
            <div class="form-group col-12 mb-4">
                <label for="to">To</label>
                <input
                    type="date"
                    id="to"
                    v-model="to"
                    class="form-control form-control-sm"
                    placeholder="End date"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': errors && errors['to'] }]"
                />
                <transition name="slide-fade">
                    <div class="invalid-feedback" v-if="errors && errors['to']">
                        {{ errors["to"][0] }}
                    </div>
                </transition>
            </div>
        </div>

        <button
            class="btn btn-outline-secondary btn-block"
            @click="check"
            :disabled="loading"
        >
            <i class="fas fa-spinner fa-pulse" v-if="loading"></i>
            <span v-else>
                <i class="fas fa-search"></i> Check
            </span>
        </button>
    </div>
</template>

<script>
export default {
    props: ["bookableId"],

    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            errors: null,
            isAvailable: null,
        };
    },

    methods: {
        check() {
            this.loading = true;
            this.errors = null;
            this.isAvailable = null;

            axios
                .get(`/api/bookables/${this.bookableId}/availability`, {
                    params: { from: this.from, to: this.to },
                })
                .then((result) => {
                    if (result.status == 200) {
                        this.isAvailable = true;

                        this.$store.dispatch("setLastSearch", {
                            from: this.from,
                            to: this.to,
                        });

                        this.$emit('availability', this.isAvailable)
                    }
                })
                .catch((err) => {
                    if (err.response.status == 422) {
                        this.errors = err.response.data.errors;

                    } else if (err.response.status == 404) {
                        this.isAvailable = false;
                        this.$store.dispatch("setLastSearch", {
                            from: this.from,
                            to: this.to,
                        });

                        this.$emit('availability', this.isAvailable)
                    }
                })
                .then(() => (this.loading = false));
        },
    },
};
</script>

<style scoped>
label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: gray;
    font-weight: bolder;
}
</style>
