<template>
    <div class="ui-block-wrapper" v-show="show">
        <div class="ui-block d-flex justify-content-center" v-bind:style="rectangle">
            <div class="align-self-center">
                <b-spinner></b-spinner>
                <strong>Cargando...</strong>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:    "UiBlock",
        props:   {
            show: {
                type:    Boolean,
                request: true
            }
        },
        data() {
            return {
                rectangle: {
                    // top:    0,
                    // left:   0,
                    width:  0,
                    height: 0
                }
            }
        },
        methods: {
            calculateRectangle() {
                const $parent = this.$el.parentNode;
                // this.rectangle.top    = $parent.offsetTop;
                // this.rectangle.left   = $parent.offsetLeft;
                this.rectangle.width  = $parent.offsetWidth + 'px';
                this.rectangle.height = $parent.offsetHeight + 'px';
            }
        },
        mounted() {
            this.calculateRectangle();
        },
        updated() {
            this.calculateRectangle();
        }
    }
</script>

<style scoped type="scss">
    .ui-block-wrapper {
        width: 0;
        height: 0;
    }

    .ui-block {
        position: relative;
        background-color: rgba(255, 255, 255, 0.60);
    }
</style>