<template>
    <div class="h-100 w-100 overflow-hidden position-relative">
        <img :src="src" alt="cover" class="cover" ref="image" />
        <div class="options">
            <button class="btn btn-success mr-3" @click="save">Save</button>
            <button class="btn btn-outline-secondary" @click="cancel">
                Cancel
            </button>
        </div>
    </div>
</template>

<script>
import imageSrc from "../shared/mixins/imageSrc";
import Cropper from "cropperjs";
export default {
    mixins: [imageSrc],

    props: ["coverImg"],

    data() {
        return {
            src: this.coverImg,
            cropper: null,
            previewImg: this.coverImg,
            image: null,
            canvas: null,
            adjustMode: false,
        };
    },

    methods: {
        setCropper() {
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
                /* cropend: () => {
                    this.canvas = this.cropper.getCroppedCanvas();
                    this.previewImg = this.canvas.toDataURL('image/png');
                } */
            });
        },

        async save() {
            this.canvas = this.cropper.getCroppedCanvas();
            this.previewImg = this.canvas.toDataURL("image/png");

            this.canvas.toBlob(async(blob) => {
                const formData = new FormData();
                formData.append("cropped", blob);
                try {
                    await axios.post("/api/cover-image", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                    this.adjustMode = false;
                    this.cropper.destroy();
                    this.$emit("coverAdjusted", this.previewImg);
                } catch (error) {
                    console.log(error);
                }
            });
        },

        cancel() {
            this.cropper.destroy();
            this.$emit("CoverAdjustCanceled");
        },
    },

    mounted() {
        this.setCropper();
    },
};
</script>

<style scoped>
.cover {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: cover;
    z-index: 1;
}

.options {
    position: absolute;
    width: 100%;
    height: 50px;
    bottom: 10px;
    right: 20px;
    z-index: 9999;
    display: flex;
    align-items: center;
    align-content: center;
    flex-direction: row;
    justify-content: flex-end;
}
/* .cropper-crop-box{
    wi
} */
/* .cropper-canvas{
    width: 100% !important;
    height: 100% !important;
    transform: none !important;
}
.cropper-container img {
    width: 100% !important;
    height: 100% !important;
    transform: none !important;
    object-fit: cover !important;
} */
</style>
