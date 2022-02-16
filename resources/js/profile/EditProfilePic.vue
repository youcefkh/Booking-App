<template>
    <div class="profile-wrapper edit-profile-pic">
        <div
            class="
                wrapper
                shadow
                d-flex
                justify-content-center
                align-items-center
                flex-column
            "
        >
            <div class="close text-primary" @click="close" v-show="!adjustMode">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="back text-primary" @click="back" v-show="adjustMode">
                <i class="fas fa-arrow-left"></i>
            </div>

            <h2 class="mb-4">Edit profile picture</h2>

            
            <div v-show="adjustMode" class="justify-content-around align-items-center w-100 mb-5" :class="{'d-flex': adjustMode}">
                <div class="pic-container">
                    <img :src="src" alt="avatar" ref="image" />
                </div>
            </div>

            <div class="pic-container  mb-5" v-if="!adjustMode">
                <img :src="src" alt="avatar"/>
            </div>
        

            <div class="options">
                <div v-if="!adjustMode">
                    <input
                        type="file"
                        accept="image/*"
                        ref="profilePic"
                        class="d-none"
                        @change="change"
                    />
                    <button
                        class="btn btn-primary"
                        @click="$refs.profilePic.click()"
                    >
                        Select image
                    </button>
                    <button class="btn btn-outline-secondary" @click="adjust">Adjust image</button>
                </div>
                <button class="btn btn-success" v-else @click="save">Save</button>
            </div>

        </div>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import Cropper from "cropperjs";
export default {
    mixins: [imageSrc],

    props: ["profileImg"],

    data() {
        return {
            src: this.profileImg,
            cropper: null,
            previewImg: this.profileImg,
            image: null,
            imageFile: null,
            canvas: null,
            adjustMode: false,
        };
    },

    methods: {
        async change(e) {
            this.imageFile = e.target.files[0];


            let reader = new FileReader();
            reader.readAsDataURL(this.imageFile);
            reader.onload = (e) => {
                this.src = e.target.result;
                this.previewImg = e.target.result;
            };

            const formData = new FormData();
            formData.append('original', this.imageFile);
            console.log(formData)
            try {
                await axios.post('/api/profile-image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.$store.dispatch('loadUser')
            } catch (error) {
                console.log(error)
            }
        },

        adjust() {
            this.adjustMode = true;
            this.image = this.$refs.image;
            this.cropper = new Cropper(this.image, {

                dragMode: "move",
                viewMode: 3,
                aspectRatio: NaN,
                autoCropArea: 1,
                background: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
            });
        },

        save(){
            this.canvas = this.cropper.getCroppedCanvas();
            this.previewImg = this.canvas.toDataURL('image/png');

            this.canvas.toBlob(async(blob) => {
                const formData = new FormData();
                formData.append("cropped", blob);
                try {
                    await axios.post("/api/profile-image", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                    this.adjustMode = false;
                    this.cropper.destroy();
                    this.$emit('imgChange', this.previewImg)
                } catch (error) {
                    console.log(error);
                }
            });
        },

        back(){
            this.cropper.destroy()
            this.adjustMode = false
        },

        close(){
            this.$emit('closeEdit')
        }
    },
};
</script>

<style scoped>
.profile-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    background: rgb(76 65 65 / 69%);
    z-index: 999;
}
.wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 30px;
    height: 60%;
    width: 50%;
    background: white;
    border-radius: 10px;
    z-index: 9999999999;
}
.back, .close{
    position: absolute;
    top: 10px;
    left: 20px;
    font-size: 1.2rem;
    cursor: pointer;
}
.pic-container {
    position: relative;
    width: 200px;
    height: 200px;
    /* min-width: 150px;
    min-height: 150px;
    max-width: 208px;
    max-height: 160px; */
    overflow: hidden;
}
.pic-container img {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: cover;
}
.preview {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    z-index: 99;
    overflow: hidden;
    border: 4px solid rgb(156, 156, 156);
}
.preview img {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: cover;
    z-index: 1;
}
</style>
