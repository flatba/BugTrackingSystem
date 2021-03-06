Vue.component('text-editor', {
    template: '#tmpl-wpuf-text-editor',

    props: ['rich'],

    computed: {
        site_url: function () {
            return wpuf_form_builder.site_url;
        },

        is_full: function () {
            return 'yes' === this.rich;
        }
    }
});
