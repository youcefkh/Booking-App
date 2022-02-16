<template>
    <div>
        <h5 class="font-weight-bolder"><i class="fas fa-sun"></i> Standout amenities</h5>
        <div v-if="items.length == 0" class="w-100 text-center">
            <span class="text-muted"><i class="fas fa-times"></i> No standout amenities are included in this property</span>
        </div>
        <div v-else class="row">
            <div v-for="(item, index) in filteredItems" :key="'standout'+index" class="col-md-6">
                <icons :name="item.name" class="d-inline-block"/>
                <span>{{item.name}} </span>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from '../../shared/components/Icons.vue'
export default {
    components: { Icons },
    props: ['items'],
    data(){
        return{
            filteredItems : this.items.filter((v,i,a)=>a.findIndex(t=>(t.name===v.name))===i) //delete doublons
        }
    }
    //['Pool', 'Hot tub', 'Patio', 'BBQ grill', 'Fire pit', 'Pool table', 'Indoor fireplace', 'Outdoor dining area','Exercice Equipment']
}
</script>

<style>

</style>