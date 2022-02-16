<template>
    <section class="min-vh-100">
        <div class="container py-5 h-100">
            <div
                class="
                    row
                    d-flex
                    align-items-center
                    justify-content-center
                    h-100
                "
            >
                <div class="text-center w-75 mx-auto">
                    <h1 class="font-weight-bolder text-primary">Sign in</h1>
                    <p class="text-muted">
                        Please enter your email and password
                    </p>
                    <hr />
                </div>
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img
                        src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="img-fluid"
                        alt="Phone image"
                    />
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example13"
                                >Email address</label
                            >
                            <input
                                type="email"
                                id="form1Example13"
                                placeholder="Enter your e-mail"
                                class="form-control form-control-lg"
                                :class="[{ 'is-invalid': errorFor('email') }]"
                                v-model="email"
                            />
                            <div class="invalid-feedback">
                                {{ errorFor("email") }}
                            </div>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example23"
                                >Password</label
                            >
                            <div class="password-container">
                                <div class="w-100">
                                    <input
                                        :type="pwd_type"
                                        id="form1Example23"
                                        placeholder="Enter your password"
                                        class="form-control form-control-lg"
                                        :class="[
                                            { 'is-invalid': errorFor('password') },
                                        ]"
                                        v-model="password"
                                    />

                                    <div class="invalid-feedback">
                                        {{ errorFor("password") }}
                                    </div>
                                </div>
                                <div class="eye" @click="toggleEye('pwd')">
                                    <i
                                        class="fa fa-eye-slash"
                                        v-if="show_pwd"
                                    ></i>
                                    <i class="fas fa-eye" v-else></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="
                                d-flex
                                justify-content-around
                                align-items-center
                                mb-4
                            "
                        >
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="form1Example3"
                                    checked
                                />
                                <label
                                    class="form-check-label"
                                    for="form1Example3"
                                >
                                    Remember me
                                </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg btn-block"
                            @click.prevent="login"
                            :disabled="loading"
                        >
                            <i
                                class="fas fa-spinner fa-pulse"
                                v-if="loading"
                            ></i>
                            <span v-else> Sign in </span>
                        </button>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted">
                                OR
                            </p>
                        </div>

                        <a
                            class="btn btn-primary btn-lg btn-block"
                            style="background-color: #3b5998"
                            href="#!"
                            role="button"
                        >
                            <img
                                :src="getImg('icons8-facebook.svg')"
                                alt=""
                                class="icon"
                            />
                            Continue with Facebook
                        </a>
                        <a
                            class="btn btn-primary btn-lg btn-block"
                            style="background-color: #55acee"
                            href="#!"
                            role="button"
                        >
                            <img
                                :src="getImg('icons8-twitter.svg')"
                                alt=""
                                class="icon"
                            />
                            Continue with Twitter
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors.js";
import imageSrc from "../shared/mixins/imageSrc.js";
import { logIn, isLoggedIn } from "../shared/utils/auth";

export default {
    mixins: [validationErrors, imageSrc],

    data() {
        return {
            email: null,
            password: null,
            show_pwd: false,
            pwd_type: "password",
            loading: false,
            icon: "icons8-twitter.svg",
        };
    },

    methods: {
        async login() {
            this.loading = true;
            this.errors = null;

            try {
                await axios.get("/sanctum/csrf-cookie");
                await axios.post("/login", {
                    email: this.email,
                    password: this.password,
                });

                //logIn
                logIn();
                this.$store.dispatch("loadUser");

                //redirect to the home page
                this.$router.push({ name: "home" });
            } catch (error) {
                this.errors = error.response
                    ? error.response.data.errors
                    : null;
            }

            this.loading = false;
        },

        toggleEye(input) {
            if (input == "pwd") {
                this.show_pwd = !this.show_pwd;
                this.pwd_type = this.show_pwd ? "text" : "password";
            }
        },
    },
};
</script>

<style scoped>
.divider:after,
.divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
}

.icon {
    height: 25px;
    width: fit-content;
    margin-right: 6px;
}
.btn {
    display: flex;
    justify-content: center;
    align-items: center;
}
.password-container{
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.password-container .eye{
    position: absolute;
    right: 10px;
    cursor: pointer;
}
</style>
