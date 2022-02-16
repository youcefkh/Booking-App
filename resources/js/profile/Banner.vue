<template>
    <div>
        <edit-profile-pic
            v-if="editProfile"
            :profileImg="profileOriginal"
            @imgChange="updateProfilePic"
            @closeEdit="editProfile=false"
        />

        <div class="header">
            <div class="h-100 w-100 overflow-hidden">
                <img
                    :src="coverCropped"
                    alt="cover"
                    class="cover"
                    v-if="!editCover"
                />

                <edit-cover-pic
                    :coverImg="coverOriginal"
                    @coverAdjusted="updateCoverPic"
                    @CoverAdjustCanceled="setEditCover(false)"
                    v-else
                />

                <div class="infos">
                    <h3 class="name m-0">{{name}}</h3>
                    <div class="biography">
                        Lorem, ipsum dolor sit amet consectetur adipisicing
                        elit. Dolores, aliquam.
                    </div>
                </div>
                <div class="layer cover-layer" v-show="!editCover">

                    <div class="dropdown">
                        <button
                            class="btn btn-dark dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="fas fa-pencil-alt ml-1"></i> Edit
                        </button>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton"
                        >
                            <input type="file" accept="image/*" ref="cover" class="d-none" @change="coverChange" />
                            <a class="dropdown-item" href="#" @click.prevent="$refs.cover.click()">Select image</a>
                            <a class="dropdown-item" href="#" @click.prevent="setEditCover">Adjust Image</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-pic">
                <img
                    :src="profileCropped"
                    alt=""
                    ref="profilePic"
                    id="profile-pic"
                />
                <div class="layer profile-layer">
                    <button class="btn btn-dark" @click="setEditProfile(true)">
                        <i class="fas fa-pencil-alt ml-1"></i> Edit
                    </button>
                    <input type="file" accept="image/*" ref="" class="d-none" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
import imageSrc from "../shared/mixins/imageSrc";
import EditProfilePic from "../profile/EditProfilePic.vue";
import EditCoverPic from "../profile/EditCoverPic.vue";
export default {
    components: { EditProfilePic, EditCoverPic },
    mixins: [imageSrc],

    data() {
        return {
            editProfile: false,
            editCover: false,
            coverFile: null,
        };
    },

    computed:{
        ...mapState({
            name: state => state.user.name
        })
    },

    methods: {
        setEditProfile() {
            this.editProfile = true;
        },
        setEditCover(bool) {
            this.editCover = bool;
        },

        updateProfilePic(img) {
            this.editProfile = false;
            this.$store.dispatch('loadUser')
        },

        updateCoverPic(cover) {
            this.editCover = false;
            this.$store.dispatch('loadUser')
        },

        async coverChange(e){
            this.coverFile = e.target.files[0];

            let reader = new FileReader();
            reader.readAsDataURL(this.coverFile);
            reader.onload = (e) => {
                this.srcCover = e.target.result;
            };

            const formData = new FormData();
            formData.append('original', this.coverFile);
            console.log(formData)
            try {
                await axios.post('/api/cover-image', formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                });
                this.$store.dispatch('loadUser')
            } catch (error) {
                console.log(error)
            }
        }
    },
};
</script>

<style scoped>
.header {
    height: 200px;
    width: 100%;
    position: relative;
}
.cover,
.profile-pic img {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: cover;
    z-index: 1;
}
.profile-pic {
    position: absolute;
    bottom: -30px;
    left: 50px;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    z-index: 99;
    overflow: hidden;
    border: 4px solid #fff;
}
.infos {
    position: absolute;
    bottom: 10px;
    left: 180px;
    max-width: 300px;
    z-index: 99;
    color: white;
}
.biography {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* number of lines to show */
    line-clamp: 2;
    -webkit-box-orient: vertical;
    color: rgb(184, 184, 184);
    line-height: 1rem;
}
.layer {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgb(6 6 6 / 34%);
    z-index: 2;
}
.layer:hover {
    opacity: 1;
}
.cover-layer .dropdown {
    position: absolute;
    bottom: 10px;
    right: 20px;
}
.profile-layer .btn {
    position: absolute;
    top: 50px;
    left: 50px;
    transform: translate(-50%, -50%);
    background: #00000059;
    width: 80%;
}

</style>
