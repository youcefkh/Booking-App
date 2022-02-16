<template>
    <div class="col-md-8">
        <h4 class="mb-3 font-weight-bolder">Billing address</h4>
        <form class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">First name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="firstName"
                        placeholder=""
                        v-model="customer.first_name"
                        :class="[{'is-invalid': errorFor('customer.first_name')}]"
                    />
                    <div class="invalid-feedback" >
                        {{errorFor('customer.first_name')}}
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName">Last name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="lastName"
                        placeholder=""
                        v-model="customer.last_name"
                        :class="[{'is-invalid': errorFor('customer.last_name')}]"
                    />
                    <div class="invalid-feedback">
                        {{errorFor('customer.last_name')}}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="username">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                    </div>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        placeholder="Username"
                        v-model="customer.username"
                        :class="[{'is-invalid': errorFor('customer.username')}]"
                    />
                    <div class="invalid-feedback" style="width: 100%">
                        {{errorFor('customer.username')}}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email"
                    >Email <span class="text-muted">(Optional)</span></label
                >
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    v-model="customer.email"
                    placeholder="you@example.com"
                    :class="[{'is-invalid': errorFor('customer.email')}]"
                />
                <div class="invalid-feedback">
                    {{errorFor('customer.email')}}
                </div>
            </div>

            <div class="mb-3">
                <label for="address">Address</label>
                <input
                    type="text"
                    class="form-control"
                    id="address"
                    placeholder="1234 Main St"
                    v-model="customer.address"
                    :class="[{'is-invalid': errorFor('customer.address')}]"
                />
                <div class="invalid-feedback">
                    {{errorFor('customer.address')}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <input
                        type="text"
                        class="form-control d-block w-100"
                        id="country"
                        placeholder="Algeria"
                        v-model="customer.country"
                        :class="[{'is-invalid': errorFor('customer.country')}]"
                    />
                    <div class="invalid-feedback">
                        {{errorFor('customer.country')}}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city">City</label>
                    <input
                        type="text"
                        class="form-control d-block w-100"
                        id="city"
                        placeholder="Tlemcen"
                        v-model="customer.city"
                        :class="[{'is-invalid': errorFor('customer.city')}]"
                    />
                    <div class="invalid-feedback">
                        {{errorFor('customer.city')}}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input
                        type="text"
                        class="form-control"
                        id="zip"
                        placeholder="13000"
                        v-model="customer.zip_code"
                        :class="[{'is-invalid': errorFor('customer.zip_code')}]"
                    />
                    <div class="invalid-feedback">{{errorFor('customer.zip_code')}}</div>
                </div>
            </div>
            <hr class="mb-4" />
            <div class="custom-control custom-checkbox">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    id="same-address"
                />
                <label class="custom-control-label" for="same-address"
                    >Shipping address is the same as my billing address</label
                >
            </div>
            <div class="custom-control custom-checkbox">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    id="save-info"
                />
                <label class="custom-control-label" for="save-info"
                    >Save this information for next time</label
                >
            </div>
            <hr class="mb-4" />

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
                <div class="custom-control custom-radio">
                    <input
                        id="credit"
                        name="paymentMethod"
                        type="radio"
                        class="custom-control-input"
                        checked
                        value="credit"
                        v-model="customer.payment"
                    />
                    <label class="custom-control-label" for="credit"
                        >Credit card</label
                    >
                </div>
                <div class="custom-control custom-radio">
                    <input
                        id="debit"
                        name="paymentMethod"
                        type="radio"
                        class="custom-control-input"
                        value="debit"
                        v-model="customer.payment"
                        required
                    />
                    <label class="custom-control-label" for="debit"
                        >Debit card</label
                    >
                </div>
                <div class="custom-control custom-radio">
                    <input
                        id="paypal"
                        name="paymentMethod"
                        type="radio"
                        class="custom-control-input"
                        value="paypal"
                        v-model="customer.payment"
                        required
                    />
                    <label class="custom-control-label" for="paypal"
                        >Paypal</label
                    >
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cc-name">Name on card</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cc-name"
                        placeholder=""
                        v-model="customer.name_on_card"
                        :class="[{'is-invalid': errorFor('customer.name_on_card')}]"
                    />
                    <small class="text-muted"
                        >Full name as displayed on card</small
                    >
                    <div class="invalid-feedback">{{errorFor('customer.name_on_card')}}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cc-number">Credit card number</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cc-number"
                        placeholder=""
                        v-model="customer.card_number"
                        :class="[{'is-invalid': errorFor('customer.card_number')}]"
                    />
                    <div class="invalid-feedback">
                        {{errorFor('customer.card_number')}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="cc-expiration">Expiration</label>
                    <input
                        type="date"
                        class="form-control"
                        id="cc-expiration"
                        placeholder=""
                        v-model="customer.card_expiration"
                        :class="[{'is-invalid': errorFor('customer.card_expiration')}]"
                    />
                    <div class="invalid-feedback">{{errorFor('customer.card_expiration')}}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cc-expiration">CVV</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cc-cvv"
                        placeholder=""
                        v-model="customer.cvv"
                        :class="[{'is-invalid': errorFor('customer.cvv')}]"
                    />
                    <div class="invalid-feedback">{{errorFor('customer.cvv')}}</div>
                </div>
            </div>
            <hr class="mb-4" />
            <button class="btn btn-primary btn-lg btn-block" :disabled="(bookings && bookings.length == 0) || loading" type="submit"  @click.prevent="book">
                <i class="fas fa-spinner fa-pulse" v-if="loading"></i>
                <span v-else>
                    Book Now
                </span>
            </button>
            <p class="text-danger text-center w-100" v-if="bookings && bookings.length == 0">You can't book right now, your cart is empty</p>
        </form>
    </div>
</template>

<script>
import validationErrors from '../shared/mixins/validationErrors'
export default {
    mixins: [validationErrors], //contains data: errors & method: errorFor(field)
    props: ['bookings'],

    data(){
        return{
            customer: {
                first_name: null,
                last_name: null,
                username: null,
                email: null,
                address: null,
                country: null,
                city: null,
                zip_code: null,
                payment: "credit",
                name_on_card: null,
                card_number: null,
                card_expiration: null,
                cvv: null
            },
            loading: false,
        }
    },

    methods: {
        async book(){
            this.loading = true;
            this.errors = null;
            
            try {
                await axios.post(`api/checkout`, {
                    customer: this.customer,
                    bookings: this.bookings
                })

                this.$store.dispatch("clearCart");

                this.$emit('success')

            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false
        }
    }
};
</script>

<style></style>
