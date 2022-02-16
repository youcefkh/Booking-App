<template>
    <div>
        <nav
            class="
                navbar navbar-expand-lg navbar-light
                bg-light
                w-100
                border-bottom
                flex-row
                justify-content-between
            "
        >
            <router-link class="navbar-brand" :to="{ name: 'home' }"
                >DZbnb</router-link
            >
            <div class="w-auto" id="navbarNav">
                <ul class="navbar-nav" v-if="isLoggedIn">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'home' }"
                            >Home</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            :to="{ name: 'bookables.index' }"
                            >Bookables</router-link
                        >
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-expanded="false"
                            href="#"
                        >
                            {{ user.username }}
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton"
                        >
                            <router-link
                                class="dropdown-item"
                                :to="{name: 'profile', params:{id: user.id}}"
                            >
                                <i class="fas fa-id-badge w-25"></i> Profile 
                            </router-link>
                            <a
                                class="dropdown-item"
                                href="#"
                                @click.prevent="logout"
                                ><i class="fas fa-sign-out-alt w-25"></i> Logout</a
                            >
                        </div>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'cart' }">
                            <i class="fas fa-shopping-cart"></i>
                            <span
                                v-if="itemsInCart > 0"
                                class="badge badge-danger"
                                >{{ itemsInCart }}
                            </span>
                        </router-link>
                    </li>
                </ul>

                <ul class="navbar-nav" v-else>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'login' }"
                            >Sign in</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'register' }"
                            >Register</router-link
                        >
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container my-5 min-vh-100">
            <router-view></router-view>
        </div>

        <footer-component></footer-component>
        
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import FooterComponent from './shared/components/FooterComponent.vue';
export default {
    components: {FooterComponent},
    computed: {
        ...mapState(["isLoggedIn", "user"]),
        ...mapGetters(["itemsInCart"]),
    },

    methods:{
        async logout(){
            try {
                await axios.post('/logout');
                this.$store.dispatch('logout');
                this.$router.push({name: 'home'})

            } catch (error) {
                this.$store.dispatch('logout');
                //this.$router.push({name: 'home'})
            }
        }
    },
};
</script>

<style></style>
