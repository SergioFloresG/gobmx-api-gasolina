<template>

    <b-form @submit.prevent="onSubmit" validated>
        <ui-block :show="isBusy" class="text-primary"></ui-block>

        <b-form-group id="state" description="Estado de la republica mexicana">
            <b-form-select v-model="state" :options="states" required @change="onChangeState">
                <template slot="first">
                    <option :value="null" disabled>Selecionar estado</option>
                </template>
            </b-form-select>
        </b-form-group>

        <b-form-group id="township" descripcion="Delegación, Municipio o poblado">
            <b-form-select v-model="township" :options="townships" required>
                <template slot="first">
                    <option :value="null" disabled>Selecionar municipio</option>
                </template>
            </b-form-select>
        </b-form-group>

        <div class="btn-group d-flex">
            <button class="btn btn-primary btn-block" type="submit">
                <fa icon="search"></fa>
                Buscar
            </button>
            <button class="btn btn-danger" type="button" @click="onCancel">
                <fa icon="chevron-up"></fa>
            </button>
        </div>

    </b-form>

</template>

<script>
    import UiBlock from './UiBlock';

    export default {
        name:       "FormSearch",
        components: {UiBlock},
        data() {
            return {
                isBusy:    false,
                state:     null,
                township:  null,
                states:    [],
                townships: []
            }
        },
        beforeMount() {
            this.isBusy = true;
            axios.get('/api/postal/state')
                .then((response) => {
                    this.states.length = 0;
                    response.data.data.forEach((d) => {
                        this.states.push({
                            value: d,
                            text:  d.name
                        })
                    });
                })
                .catch((error) => {
                    console.error(error);
                    this.$bvToast.toast(error.message || 'Ocurrio un errora al cargar los estados', {
                        variant: 'danger'
                    })
                }).then(() => this.isBusy = false);
        },
        methods:    {
            onChangeState(state) {
                this.isBusy = true;
                axios.get(`/api/postal/state/${state.id}`)
                    .then((response) => {
                        this.townships.length = 0;
                        this.township         = null;
                        response.data.data.forEach((t) => {
                            this.townships.push({
                                value: t,
                                text:  t.name
                            });
                        })
                    })
                    .catch((error) => {
                        console.error(error);
                        this.$bvToast.toast(error.message || 'Ocurrio un errora al cargar los estados', {
                            variant: 'danger'
                        })
                    })
                    .then(() => this.isBusy = false)
            },
            onSubmit(evt) {
                const state    = this.state;
                const township = this.township;
                this.$emit('submit', {state, township});
            },
            onCancel() {
                this.$emit('cancel')
            }

        }
    }
</script>

<style scoped>

</style>