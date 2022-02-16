<template>
    <section>
        <div class="container py-5 h-100 mb-5">
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
                    <h1 class="font-weight-bolder text-success">Register</h1>
                    <p class="text-muted">Please fill all the fields</p>
                    <hr />
                </div>
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img
                        :src="getImg('register2.png')"
                        class="img-fluid"
                        alt="Phone image"
                    />
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form>
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Name</label>
                            <input
                                type="text"
                                id="name"
                                placeholder="Enter your name"
                                class="form-control form-control-lg"
                                :class="[{ 'is-invalid': errorFor('name') }]"
                                v-model="user.name"
                            />
                            <div class="invalid-feedback">
                                {{ errorFor("name") }}
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
                                    class="form-control form-control-lg"
                                    id="username"
                                    placeholder="Enter a username"
                                    v-model="user.username"
                                    :class="[
                                        { 'is-invalid': errorFor('username') },
                                    ]"
                                />
                                <div
                                    class="invalid-feedback"
                                    style="width: 100%"
                                >
                                    {{ errorFor("username") }}
                                </div>
                            </div>
                        </div>

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
                                v-model="user.email"
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
                                            {
                                                'is-invalid':
                                                    errorFor('password'),
                                            },
                                        ]"
                                        v-model="user.password"
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

                        <!-- Confirm Password input -->
                        <div class="form-outline mb-4">
                            <label
                                class="form-label"
                                for="password_confirmation"
                                >Confirm password</label
                            >
                            <div class="password-container">
                                <div class="w-100">
                                    <input
                                        :type="confirm_pwd_type"
                                        id="password_confirmation"
                                        placeholder="Confirm your password"
                                        class="form-control form-control-lg"
                                        :class="[
                                            {
                                                'is-invalid': errorFor(
                                                    'password_confirmation'
                                                ),
                                            },
                                        ]"
                                        v-model="user.password_confirmation"
                                    />

                                    <div class="invalid-feedback">
                                        {{ errorFor("password_confirmation") }}
                                    </div>
                                </div>
                                <div
                                    class="eye"
                                    @click="toggleEye('password_confirmation')"
                                >
                                    <i
                                        class="fa fa-eye-slash"
                                        v-if="show_confirm_pwd"
                                    ></i>
                                    <i class="fas fa-eye" v-else></i>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 text-center my-4">
                            <p class="m-0 d-inline-block">Has an account ?</p>
                            <router-link :to="{ name: 'login' }"
                                >Sign in</router-link
                            >
                        </div>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            class="btn btn-success btn-lg btn-block"
                            @click.prevent="register"
                            :disabled="loading"
                        >
                            <i
                                class="fas fa-spinner fa-pulse"
                                v-if="loading"
                            ></i>
                            <span v-else> Register </span>
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
            user: {
                email: null,
                name: null,
                username: null,
                password: null,
                password_confirmation: null,
            },
            show_pwd: false,
            show_confirm_pwd: false,
            pwd_type: "password",
            confirm_pwd_type: "password",
            loading: false,
        };
    },

    methods: {
        async register() {
            this.loading = true;
            this.errors = null;

            try {
                const response = await axios.post("/register", this.user);

                if (response.status == 201) {
                    //logIn
                    logIn();
                    this.$store.dispatch("loadUser");
                    //redirect to the home page
                    this.$router.push({ name: "home" });
                }
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
            } else {
                this.show_confirm_pwd = !this.show_confirm_pwd;
                this.confirm_pwd_type = this.show_confirm_pwd
                    ? "text"
                    : "password";
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
.password-container {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.password-container .eye {
    position: absolute;
    right: 10px;
    cursor: pointer;
}
</style>
