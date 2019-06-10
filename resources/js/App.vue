<template>
    <div id="app" class="container-fluid">

        <main role="main" class="h-100">
            <div class="row d-flex h-100">

                <div class="col-12 col-md-6 col-lg-8 order-md-1 order-lg-1  p-0">
                    <div class="card w-100 h-100 border-0">
                        <lf-map :zoom="mapZoom" :center="mapCenter">
                            <lf-titlelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></lf-titlelayer>
                            <lf-circle-marker
                                    v-for="gas in gasStations" v-bind:key="gas._id"
                                    :lat-lng="[gas.latitude, gas.longitude]" :radius="4"
                                    :color="gas._id === selectedGasStation ? 'red' : 'cyan'"></lf-circle-marker>
                        </lf-map>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 order-md-0 order-lg-0">
                    <div class="search-card card border-0 fade shadow"
                         v-bind:class="{show: searchVisible}"
                         v-show="searchVisible">
                        <div class="card-body">
                            <form-search @submit="onSearch" @cancel="onSearch"></form-search>
                        </div>
                    </div>

                    <div class=" card border-0  fade" v-bind:class="{show: !searchVisible}"
                         v-show="!searchVisible">
                        <div class="card-body">
                            <div class="float-right">
                                <button class="btn btn-outline-primary" @click="searchVisible = true">
                                    <fa icon="search"></fa>
                                </button>
                            </div>
                            <div v-if="searchData !== null">
                                <h5>{{searchData.state.name}}</h5>
                                <h6>{{searchData.township.name}}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="card-gasstations card border-0 bg-transparent">
                        <div class="overflow-auto">
                            <table-gas-stations v-model="gasStations" :is-busy="isRequesting"
                                                @row-selected="onSelectStation"></table-gas-stations>
                        </div>
                    </div>
                </div>


            </div>

        </main>

        <footer class="footer fixed-bottom mt-auto py-3 border-top ">
            <div class="container">
                <span class="text-muted">by MrGenis</span>
                <fa icon="code-branch"></fa>
            </div>
        </footer>
    </div>
</template>

<script>

    import { LMap, LTileLayer, LMarker, LCircleMarker } from 'vue2-leaflet'
    import TableGasStations                             from './components/TableGasStations';
    import FormSearch                                   from './components/FormSearch';
    // import MapGasStations from './components/MapGasStations';

    export default {
        name:       "App",
        components: {
            FormSearch,
            TableGasStations,
            'lf-map':           LMap,
            'lf-titlelayer':    LTileLayer,
            'lf-marker':        LMarker,
            'lf-circle-marker': LCircleMarker
        },
        data() {
            return {
                isRequesting:       false,
                searchVisible:      true,
                searchData:         null,
                gasStations:        [],
                selectedGasStation: null,
                //
                mapZoom:            5,
                mapCenter:          [19.4978, -99.1269]
            }
        },
        methods:    {
            onSearch(params) {
                this.searchVisible = false;
                if (!params) {
                    // Se cancelo la busqueda
                    return;
                }

                this.isRequesting = true;
                this.searchData   = params;
                axios.get(`/api/gobmx/gasstation/${params.state.id}/${params.township.id}`)
                    .then((result) => {
                        this.gasStations = result.data;
                    })
                    .catch((error) => {
                        this.$bvToast.toast(error.message || 'Ocurrio un errora al buscar las gasolineras', {
                            variant: 'danger'
                        })
                    })
                    .then(() => {
                        this.isRequesting = false;
                        this.calculateMapCenter();
                    })
            },
            calculateMapCenter() {
                if (this.gasStations.length === 0) {
                    this.mapCenter = [19.4978, -99.1269];
                    this.mapZoom   = 5;
                }

                // latitud minima y maxima
                let latitudeMax  = -Infinity, latitudeMin = Infinity;
                let longitudeMax = -Infinity, longitudeMin = Infinity;
                this.gasStations.forEach((g) => {
                    g.latitude  = parseFloat(g.latitude);
                    g.longitude = parseFloat((g.longitude));

                    if (!isNaN(g.latitude)) {
                        if (latitudeMax < g.latitude) {
                            latitudeMax = g.latitude;
                        }
                        if (latitudeMin > g.latitude) {
                            latitudeMin = g.latitude;
                        }
                    }

                    if (!isNaN(g.longitude)) {
                        if (longitudeMax < g.longitude) {
                            longitudeMax = g.longitude;
                        }
                        if (longitudeMin > g.longitude) {
                            longitudeMin = g.longitude;
                        }
                    }
                });

                this.mapCenter = [(latitudeMax + latitudeMin) / 2, (longitudeMax + longitudeMin) / 2];
                this.mapZoom   = 12;
            },
            onSelectStation(gasstation) {
                this.selectedGasStation = gasstation[0]._id;
            }
        }
    }
</script>

<style scoped>
    main {
        padding-bottom : 3.5rem !important;
    }

    .search-card {
        z-index : 1035;
    }

    .card-gasstations {
        position : absolute;
        top      : 100px;
        left     : 0;
        right    : 0;
        bottom   : 0;
    }
</style>