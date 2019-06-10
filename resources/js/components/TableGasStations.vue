<template>
    <b-table selectable striped small :items="values" :fields="stations_fields"
             :busy="isBusy"
             select-mode="single" select-variant="success" @row-selected="onRowSelected">

        <template slot="table-busy">
            <div class="d-flex justify-content-center">
                <div class="align-self-center">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Cargando...</strong>
                </div>
            </div>
        </template>

        <template slot="index" slot-scope="data">
            {{data.index + 1}}
        </template>

        <template slot="direccion" slot-scope="data">
            {{data.calle}} {{data.colonia}}, C.P. {{data.codigopostal}}
        </template>


    </b-table>
</template>

<script>
    export default {
        name:    "TableGasStations",
        model:   {
            prop:  'values',
            event: 'change'
        },
        props:   {
            values: {
                type:     Array,
                required: false
            },
            isBusy: {
                type:    Boolean,
                default: false
            }
        },
        data() {
            return {
                stations_fields: [
                    {key: 'razonsocial', label: 'Nombre', sortable: false},
                    {key: 'direccion', label: 'Dirección', sortable: false},
                    {key: 'regular', label: 'Magna', sortable: true},
                    {key: 'premium', label: 'Premium', sortable: true},
                    {key: 'dieasel', label: 'Diésel', sortable: true}
                ]
            }
        },
        methods: {
            onRowSelected(items) {
                this.$emit('row-selected', items)
            }
        }
    }
</script>

<style scoped>

</style>