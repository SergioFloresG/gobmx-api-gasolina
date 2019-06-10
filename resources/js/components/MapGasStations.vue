<template>

    <div class="h-100 w-100">
        <lf-map :zoom="13" :center="[47.413220, -1.219482]">
            <lf-titlelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></lf-titlelayer>
            <lf-marker :lat-lng="[47.413220,-1,219482]"></lf-marker>
        </lf-map>
    </div>

</template>

<script>

    import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'

    export default {
        name:       "MapGasStations",
        components: {
            'lf-map':        LMap,
            'lf-titlelayer': LTileLayer,
            'lf-marker':     LMarker
        }
    }
</script>

<style scoped>

</style>