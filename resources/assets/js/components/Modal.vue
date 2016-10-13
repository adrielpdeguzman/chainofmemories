<template>
    <transition name="fade">
        <div :class="['Modal', {'Modal--large': large}]" v-if="show" @click.self="close" @keyup.esc="close">
            <div class="Modal__container">
                <div class="Modal__heading">
                    <slot name="heading">Modal Title</slot>
                </div>

                <div class="Modal__body">
                    <slot name="body">Modal Body</slot>
                </div>

                <div class="Modal__footer">
                    <slot name="footer">
                        <button type="button" class="button button--primary" @click="callback">{{ okText }}</button>
                        <button type="button" class="button" @click="close">{{ cancelText }}</button>
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

            large: {
                type: Boolean,
                default: false,
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
        align-items: flex-start
        background: rgba(33, 33, 33, 0.5)
        display: flex
        height: 100%
        justify-content: center
        left: 0
        overflow-y: scroll
        position: fixed
        top: 0
        width: 100%
        
        &__container
            background: #fff
            border: 1px solid #eee
            margin-top: 32px
            width: 480px
            
            .Modal--large &
                width: 720px
        
            > div
                padding: 10px
                
        &__heading
            font-size: 16px
            font-weight: bold
        
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
        overflow-y: hidden
        opacity: 0
</style>
