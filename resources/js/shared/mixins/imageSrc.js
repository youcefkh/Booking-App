import { mapState } from "vuex";
export default{

    computed: {
        ...mapState({
            profileO: state => state.user.profile.original,
            profileC: state => state.user.profile.cropped,
            coverO: state => state.user.cover.original,
            coverC: state => state.user.cover.cropped,
        }),

        profileOriginal(){
            
            return "/assets/profile/originals/" + this.profileO;
            
        },

        profileCropped(){
            
            return "/assets/profile/thumbnails/" + this.profileC;
            
        },

        coverCropped(){
            
            return "/assets/cover/thumbnails/" + this.coverC;
            
        },

        coverOriginal(){
            
            return "/assets/cover/originals/" + this.coverO;
            
        },
    },
    methods: {
        getProfileImg(type){
            if(this.user.profile){
                return type === 'original' ? "/assets/profile/originals/" + this.user.profile.original : "/assets/profile/thumbnails/" + this.user.profile.cropped;

            }
        },

        getCoverImg(type){

            if(this.user.cover){
                return type === 'original' ? "/assets/cover/originals/" + this.user.cover.original : "/assets/cover/thumbnails/" + this.user.cover.cropped;

            }
        },

        getImg(img){
            return "/assets/" + img
        },

        getBookableImg(img){
            return "/assets/bookable/"+img
        },

        getUsersImage(img){
            return "/assets/profile/thumbnails/" + img;
        },

        getIcon(img, ext="svg"){
            return "/assets/icons/" + img + "." + ext;
        }
    },
} 