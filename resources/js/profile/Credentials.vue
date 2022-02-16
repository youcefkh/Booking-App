<template>
    <div class="p-3">
        <h4 class="mb-4"><i class="fas fa-user-cog"></i> Update your personal information</h4>
        <transition name="fade" v-if="isInfosUpdated">
            <div class="alert alert-success" role="alert">
                Your personal infos have been updated successfully
            </div>
        </transition>
        <form class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name">Name</label>
                <input
                    type="text"
                    class="form-control form-control-lg"
                    id="name"
                    placeholder=""
                    v-model="form.name"
                    :class="[{ 'is-invalid': errorFor('name') }]"
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
                        placeholder="Username"
                        v-model="form.username"
                        :class="[{ 'is-invalid': errorFor('username') }]"
                    />
                    <div class="invalid-feedback" style="width: 100%">
                        {{ errorFor("username") }}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input
                    type="email"
                    class="form-control form-control-lg"
                    id="email"
                    v-model="form.email"
                    placeholder="you@example.com"
                    :class="[{ 'is-invalid': errorFor('email') }]"
                />
                <div class="invalid-feedback">
                    {{ errorFor("email") }}
                </div>
            </div>

            <button
                class="btn btn-primary btn-lg btn-block"
                :disabled="loadingInfos"
                @click.prevent="updateInfos"
            >
                <i class="fas fa-spinner fa-pulse" v-if="loadingInfos"></i>
                <span v-else> Update infos </span>
            </button>
        </form>

        <hr class="my-5" />

        <h4 class="mb-4"><i class="fas fa-user-lock"></i> Update your password</h4>

        <transition name="fade" v-if="isPasswordUpdated">
            <div class="alert alert-success" role="alert">
                Your password have been updated successfully
            </div>
        </transition>

        <form class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name">Current password</label>
                <div class="password-container">
                    <div class="w-100">
                        <input
                            :type="current_pwd"
                            placeholder="Enter your current password"
                            class="form-control form-control-lg"
                            :class="[{ 'is-invalid': errorFor('current') }]"
                            v-model="password.current"
                        />

                        <div class="invalid-feedback">
                            {{ errorFor("current") }}
                        </div>
                    </div>
                    <div class="eye" @click="toggleEye('current_pwd')">
                        <i class="fa fa-eye-slash" v-if="show_current_pwd"></i>
                        <i class="fas fa-eye" v-else></i>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="name">New password</label>

                <div class="password-container">
                    <div class="w-100">
                        <input
                            :type="new_pwd"
                            placeholder="Enter your new password"
                            class="form-control form-control-lg"
                            :class="[{ 'is-invalid': errorFor('new') }]"
                            v-model="password.new"
                        />

                        <div class="invalid-feedback">
                            {{ errorFor("new") }}
                        </div>
                    </div>
                    <div class="eye" @click="toggleEye('new_pwd')">
                        <i class="fa fa-eye-slash" v-if="show_new_pwd"></i>
                        <i class="fas fa-eye" v-else></i>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="name">Confirm new password</label>
                <div class="password-container">
                    <div class="w-100">
                        <input
                            :type="confirm_pwd"
                            placeholder="Confirm your new password"
                            class="form-control form-control-lg"
                            :class="[{ 'is-invalid': errorFor('confirm') }]"
                            v-model="password.confirm"
                        />

                        <div class="invalid-feedback">
                            {{ errorFor("confirm") }}
                        </div>
                    </div>
                    <div class="eye" @click="toggleEye('confirm_pwd')">
                        <i class="fa fa-eye-slash" v-if="show_confirm_pwd"></i>
                        <i class="fas fa-eye" v-else></i>
                    </div>
                </div>
            </div>

            <button
                class="btn btn-success btn-lg btn-block"
                @click.prevent="updatePassword"
                :disabled="loadingPassword"
            >
                <i class="fas fa-spinner fa-pulse" v-if="loadingPassword"></i>
                <span v-else> Update password </span>
            </button>
        </form>
    </div>
</template>

<script>
import { mapState } from "vuex";
import validationErrors from "../shared/mixins/validationErrors";
export default {
    mixins: [validationErrors],

    computed: {
        ...mapState(["user"]),
        form() {
            return {
                name: this.user.name,
                username: this.user.username,
                email: this.user.email,
            };
        },
    },

    data() {
        return {
            password: {
                current: null,
                new: null,
                confirm: null,
            },

            show_current_pwd: false,
            current_pwd: "password",

            show_new_pwd: false,
            new_pwd: "password",

            show_confirm_pwd: false,
            confirm_pwd: "password",

            loadingInfos: false,
            loadingPassword: false,

            isInfosUpdated: false,
            isPasswordUpdated: false,
        };
    },

    methods: {
        toggleEye(input) {
            if (input == "current_pwd") {
                this.show_current_pwd = !this.show_current_pwd;
                this.current_pwd = this.show_current_pwd ? "text" : "password";
            } else if (input == "new_pwd") {
                this.show_new_pwd = !this.show_new_pwd;
                this.new_pwd = this.show_new_pwd ? "text" : "password";
            } else {
                this.show_confirm_pwd = !this.show_confirm_pwd;
                this.confirm_pwd = this.show_confirm_pwd ? "text" : "password";
            }
        },

        async updateInfos() {
            this.errors = null;
            this.loadingInfos = true;
            this.isInfosUpdated = false
            try {
                await axios.post("/api/users/infos", this.form);
                this.isInfosUpdated = true
                this.$store.dispatch('loadUser');
            } catch (error) {
                this.errors = error.response
                    ? error.response.data.errors
                    : null;
            }
            this.loadingInfos = false;
        },

        async updatePassword() {
            this.errors = null;
            this.loadingPassword = true;
            this.isPasswordUpdated = false
            try {
                await axios.post("/api/users/password", this.password);
                this.isPasswordUpdated = true
            } catch (error) {
                this.errors = error.response
                    ? error.response.data.errors
                    : null;
            }
            this.loadingPassword = false;
        },
    },
};
</script>

<style scoped>
.password-container {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.password-container .eye {
    position: absolute;
    right: 10px;
}
</style>
