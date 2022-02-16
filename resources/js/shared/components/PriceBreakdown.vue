<template>
    <div class="bg-white rounded shadow p-3 mb-4">
        <h6 class="text-uppercase text-secondary font-weight-bolder">price breakdown</h6>

        <div class="d-flex justify-content-between align-items-center border-top py-2">
            <p class="font-weight-bold">$/Night:</p>  
            <p>${{price.night}}</p>
        </div>
        <div class="d-flex justify-content-between border-top py-2">
            <p class="font-weight-bold">Duree:</p>  
            <p>{{price.duree}}</p>
        </div>
        <div class="d-flex justify-content-between border-top py-2">
            <p class="font-weight-bold">Total:</p>  
            <p>${{price.total}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['price']
}
</script>

<style>

</style>