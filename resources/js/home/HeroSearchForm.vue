<template>
    <div class="wrapper w-100 bg-white rounded-pill shadow-lg">
        <form action="" class="row">
            <div
                class="col-4 d-flex align-items-center py-3"
                :class="{ active: option == 'location' }"
                @click="showOptions($event, 'location')"
            >
                <div class="d-flex align-items-center w-100 px-4">
                    <i class="fas fa-map-marker-alt text-muted mr-2"></i>
                    <div class="w-100">
                        <input
                            type="text"
                            class="form-control border-0 px-1 py-0"
                            placeholder="Location"
                            v-model="location"
                        />
                        <span class="px-1 text-muted"
                            >Where are you going?</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="col-4 py-3 position-relative"
                :class="{ active: option == 'date' }"
                @click="showOptions($event, 'date')"
            >
                <div
                    class="d-flex align-items-center w-100 px-4"
                    :class="{
                        'left-border':
                            option !== 'location' && option !== 'date',
                        'right-border':
                            option !== 'guests' && option !== 'date',
                    }"
                >
                    <i class="fas fa-calendar text-muted mr-2"></i>
                    <div class="w-100">
                        <p type="text" class="form-control border-0 px-1 m-0">
                            {{ moment(date.start).format("MMMM Do") }} -
                            {{ moment(date.end).format("MMMM Do") }}
                        </p>
                        <span class="px-1 text-muted"
                            >Check in - Check out</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="col-4 py-3"
                :class="{ active: option == 'guests' }"
                @click="showOptions($event, 'guests')"
            >
                <div class="row w-100 px-4">
                    <div class="col-8 d-flex align-items-center">
                        <i class="fas fa-users text-muted mr-2"></i>
                        <div class="w-100">
                            <p
                                type="text"
                                class="form-control border-0 px-1 m-0"
                            >
                                {{
                                    guests.adults +
                                    guests.children +
                                    guests.infants
                                }}
                                Guests
                            </p>
                            <span class="px-1 text-muted">Guests</span>
                        </div>
                    </div>

                    <div class="col-4 d-flex align-items-center">
                        <router-link
                            :to="{ name: 'bookables.index' }"
                            class="
                                btn btn-primary btn-lg
                                active
                                rounded-circle
                                ml-auto
                                search
                            "
                            role="button"
                            aria-pressed="true"
                        >
                            <i class="fas fa-search"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </form>

        <transition name="fade">
            <div
                key="1"
                class="location-container"
                v-show="option == 'location'"
            >
                <h4 class="px-4 mb-3 font-weight-bolder">Popular searches</h4>
                <ul class="list-group">
                    <li
                        class="
                            list-group-item list-group-item-action
                            border-0
                            px-4
                            py-3
                            h5
                            font-weight-bolder
                            text-dark
                            pointer-event
                        "
                        @click="location = 'Paris, France'"
                    >
                        <i class="fas fa-globe-europe mr-2"></i> Paris, France
                    </li>
                    <li
                        class="
                            list-group-item list-group-item-action
                            border-0
                            px-4
                            py-3
                            h5
                            font-weight-bolder
                            text-dark
                        "
                        @click="location = 'New York, USA'"
                    >
                        <i class="fas fa-globe-europe mr-2"></i> New York, USA
                    </li>
                    <li
                        class="
                            list-group-item list-group-item-action
                            border-0
                            px-4
                            py-3
                            h5
                            font-weight-bolder
                            text-dark
                        "
                        @click="location = 'Tokyo, Japan'"
                    >
                        <i class="fas fa-globe-europe mr-2"></i> Tokyo, Japan
                    </li>
                    <li
                        class="
                            list-group-item list-group-item-action
                            border-0
                            px-4
                            py-3
                            h5
                            font-weight-bolder
                            text-dark
                        "
                        @click="location = 'Barcelona, Spain'"
                    >
                        <i class="fas fa-globe-europe mr-2"></i> Barcelona,
                        Spain
                    </li>
                </ul>
            </div>
        </transition>

        <transition name="fade">
            <div key="2" class="calendar-container" v-show="option == 'date'">
                <date-picker
                    class="mx-4"
                    v-model="date"
                    is-range
                    :columns="2"
                ></date-picker>
            </div>
        </transition>

        <transition name="fade">
            <div key="3" class="guests-container" v-show="option == 'guests'">
                <div
                    class="
                        adults
                        d-flex
                        justify-content-between
                        align-items-center
                        mx-4
                        mb-4
                    "
                >
                    <div class="guests-category">
                        <h5 class="text-dark mb-0 font-weight-bolder">Adults</h5>
                        <span class="text-muted">Ages 13 and above</span>
                    </div>
                    <div class="guests-action d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-light rounded-circle mr-2"
                            @click="guests.adults--"
                            :disabled="guests.adults == 0"
                        >
                            -
                        </button>
                        <span class="h5 mr-2 mb-0 text-dark">{{
                            guests.adults
                        }}</span>
                        <button
                            type="button"
                            class="btn btn-secondary rounded-circle"
                            @click="guests.adults++"
                        >
                            +
                        </button>
                    </div>
                </div>
                <div
                    class="
                        adults
                        d-flex
                        justify-content-between
                        align-items-center
                        mx-4
                        mb-4
                    "
                >
                    <div class="guests-category">
                        <h5 class="text-dark mb-0 font-weight-bolder">Children</h5>
                        <span class="text-muted">Ages 2-12</span>
                    </div>
                    <div class="guests-action d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-light rounded-circle mr-2"
                            @click="guests.children--"
                            :disabled="guests.children == 0"
                        >
                            -
                        </button>
                        <span class="h5 mr-2 mb-0 text-dark">{{
                            guests.children
                        }}</span>
                        <button
                            type="button"
                            class="btn btn-secondary rounded-circle"
                            @click="guests.children++"
                        >
                            +
                        </button>
                    </div>
                </div>
                <div
                    class="
                        adults
                        d-flex
                        justify-content-between
                        align-items-center
                        mx-4
                    "
                >
                    <div class="guests-category">
                        <h5 class="text-dark mb-0 font-weight-bolder">Infants</h5>
                        <span class="text-muted">Ages 0-2</span>
                    </div>
                    <div class="guests-action d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-light rounded-circle mr-2"
                            @click="guests.infants--"
                            :disabled="guests.infants == 0"
                        >
                            -
                        </button>
                        <span class="h5 mr-2 mb-0 text-dark">{{
                            guests.infants
                        }}</span>
                        <button
                            type="button"
                            class="btn btn-secondary rounded-circle"
                            @click="guests.infants++"
                        >
                            +
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <div class="overlay" v-if="option !== null" @click="hideOptions"></div>
    </div>
</template>

<script>
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import moment from "moment";

export default {
    components: {
        Calendar,
        DatePicker,
    },
    data() {
        return {
            moment: moment,
            date: {
                start: new Date(),
                end: new Date().setDate(new Date().getDate() + 15),
            },
            option: null,
            location: "",
            guests: {
                adults: 2,
                children: 0,
                infants: 0,
            },
        };
    },

    methods: {
        showOptions(e, el) {
            const target = e.currentTarget;

            switch (el) {
                case "location":
                    target
                        .getElementsByTagName("input")[0]
                        .focus(); /* input child */
                    let dateFirstDiv =
                        target.nextElementSibling.getElementsByTagName(
                            "div"
                        )[0];
                    /* dateFirstDiv.classList.remove("left-border");
                    dateFirstDiv.classList.add("right-border"); */
                    break;

                case "date":
                    const firstChildDiv = target.getElementsByTagName("div")[0];
                    /* firstChildDiv.classList.remove(
                        "left-border",
                        "right-border"
                    ); */
                    break;

                case "guests":
                    dateFirstDiv =
                        target.previousElementSibling.getElementsByTagName(
                            "div"
                        )[0];
                    /* dateFirstDiv.classList.remove("right-border");
                    dateFirstDiv.classList.add("left-border"); */
                    break;

                default:
                    break;
            }

            this.option = el;
        },

        hideOptions(event) {
            this.option = null;
        },
    },
};
</script>

<style scoped>
.wrapper {
    z-index: 10;
}

form > div {
    cursor: pointer;
    overflow: hidden;
}

form > div.active {
    border-radius: 50rem;
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}

form i {
    font-size: x-large;
}

form .left-border {
    border-left: 1px solid #f3f4f5 !important;
}

form .right-border {
    border-right: 1px solid #f3f4f5 !important;
}

.form-control::placeholder,
.form-control {
    color: #000000;
    opacity: 1;
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 2;
}
.form-control:focus::placeholder {
    color: #524d4d;
}
.form-control:focus {
    box-shadow: none;
}

.search {
    height: 60px;
    width: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.location-container,
.calendar-container,
.guests-container {
    position: absolute;
    background: #fff;
    padding: 30px 0;
    bottom: -10px;
    border-radius: 10px;
    z-index: 9999999999999;
    border: 1px solid #dee3e7;
}
.location-container {
    min-width: 400px;
    left: 0;
    transform: translate(0, 100%);
}
.calendar-container {
    left: 50%;
    transform: translate(-50%, 100%);
    display: flex;
    gap: 20px;
}
.guests-container {
    min-width: 400px;
    right: -10px;
    transform: translate(0, 100%);
}
.guests-container .guests-action button {
    height: 35px;
    width: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
}
.guests-container .guests-category span {
    font-size: 0.8rem;
}

.calendar-container .mx-4.vc-container.vc-blue {
    border: 0;
}

.list-group-item {
    cursor: pointer;
}

.overlay {
    height: 100vh;
    width: 100vw;
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
}
</style>
