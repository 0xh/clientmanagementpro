/**
 * Export the root Evolutly application.
 */
module.exports = {
    el: '#evolutly-app',


    /**
     * Initial FrontEnd State
     */

    data: {
        // loaded by default
        user: Evolutly.state.user,
        tenant: Evolutly.state.tenant,
        employees: Evolutly.state.employees,
        clients: Evolutly.state.clients,
        // loaded depending on route
        projects: (Evolutly.state.projects ? Evolutly.state.projects : []),
    },

    /**
     * The component has been created by Vue.
     */
    created() {
    },

    /**
     * Prepare the application.
     */
    mounted() {
        this.whenReady();
    },

    methods: {
        whenReady() {
            //
        },
    },
};
