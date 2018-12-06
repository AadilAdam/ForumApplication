<template>

    <button :class="classes" @click="subscribe">Subscribe</button>

</template>



<script>
    export default {
        props: ['active'],


        computed: {

            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-secondary'];
            }
        },
        methods: {
            subscribe() {

                axios[(
                    this.active ? 'delete' : 'post'
                    )](location.pathname + '/subscriptions');
                    
                this.active = ! this.active;

            }
        }
    }
</script>



// customer error happens for all the products that have the word "customer" - like custom products, settings, diamonds, gifts. 
// but only when you add a quote and save it for the first time.

// engraving text errors happens for custom products like warranty, insurance, repeat customer gift, settings, gifts- blankee, tower holder etc.. 
// it happens on second save. and appends the engraving text/font  to the previouys text.
// add a quote, save a quote with some txt for diamonds, gifts, overpayemnt, settings, pendants
