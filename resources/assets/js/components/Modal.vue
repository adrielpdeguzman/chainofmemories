<template>
    <transition name="fade">
        <div class="Modal" v-if="show" @click.self="close" @keyup.esc="close">
            <div class="Modal__container">
                <div class="Modal__heading">
                    <slot name="heading">Modal Title</slot>
                </div>

                <div class="Modal__body">
                    <slot name="body">Modal Body</slot>
                </div>

                <div class="Modal__footer">
                    <slot name="footer">
                        <button type="button" @click="callback">{{ okText }}</button>
                        <button type="button" @click="close">{{ cancelText }}</button>
                    </slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
                default: false,
            },

            callback: {
                type: Function,
                default () {},
            },

            okText: {
                type: String,
                default: 'Ok',
            },

            cancelText: {
                type: String,
                default: 'Cancel',
            },
        },

        methods: {
            close() {
                this.$emit('close');
            },
        },

        watch: {
            show() {
                document.querySelector('body').classList.toggle('utility-no-scroll');
            },
        },
    }
</script>

<style lang="stylus" scoped>
    .Modal
        align-items: center
        background: rgba(33, 33, 33, 0.5)
        display: flex
        height: 100%
        justify-content: center
        left: 0
        position: fixed
        top: 0
        width: 100%
        
        &__container
            background: #fff
            border: 1px solid #eee
            display: flex
            flex-direction: column
            width: 480px
        
            > div
                padding: 20px
        
        &__body
            border-bottom: 1px solid #eee
            border-top: 1px solid #eee
        
        &__footer
            text-align: right
    
    .fade-enter-active
    .fade-leave-active
        transition: opacity .25s
        
    .fade-enter
    .fade-leave-active
        opacity: 0
</style>
