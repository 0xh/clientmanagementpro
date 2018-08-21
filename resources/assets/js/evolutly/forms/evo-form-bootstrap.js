/**
 * You Can Extend Some Forms, to Add Extra Field Without Messing Up With Your Current Field
 *  Note: if You Declare Something Like On Your evolutly.js where we declare a new Vue Instance
 *  Added Inside evolytly.js (main) 
 *  Evolutly.forms.sampleForm = {
 *  currency: ''
 *  };
 *  the field is added to the existing new EvolutlyForm
 *  Add this inside your data() for props or data in the main vue instance
 *  Example:
 *  sampleForm: new EvolutlyForm({
 *               name: '',
 *               number: '',
 *               cvc: '',
 *               month: '',
 *               year: '',
 *           })
 *  Note: to module.exports the component that contains the form
 *  For Example We Declare sampleForm in our data() or data
 *  sampleForm: $.extend(true, new EvolutlyForm({
 *               invitation: null
 *              }), Spark.forms.register)
 *  
 */

Evolutly.forms = {
    editProjectForm:{
        id: '',
        client_name: '', 
        client_id: '', 
        website: '',
        newclient: false,
        client: {
            name: '',
            email: '', 
            password: ''
        },
    },
    projectForm: {
        client_name: '', 
        client_id: '', 
        website: '',
        newclient: false,
        client: {
            name: '',
            email: '', 
            password: ''
        },
    },
    employeeSubtaskForm: {
        subtasks: []
    },
    cloneForm:{
        client_name: '',
        client_id: '', 
        newclient: false,
        client: {
            name: '', 
            email: '', 
            password: '',
            website: '',
        },
        users: [{
            name: '',
            email: '',
            password: '',
        }],
        due_date: moment(new Date).add(1, 'day').endOf('day').format('YYYY-MM-DD'),

    },
    cloneCampaignForm: {
        campaigns: []
    },
    campaignForm: {
        campaign_name: '',
        campaign_order: 0
    },
    campaignOrderForm: {
        campaign_order: ''
    },
    taskForm: {
        task_name: '',
        task_description: '',
        task_link: '',
        task_recurring: false,
        task_interval: 0,
    },
    subtaskForm:{
        name: '',
        description: '',
        points: 1,
        priority: 1,
        link: '',
        due_date:  moment(new Date).add(1, 'day').endOf('day').format('YYYY-MM-DD'),
        done: false,
        newCollaborator: false,
        users: [{
            name: '',
            email: '',
            password: '',
        }],
        showEditor: false,
        sendEmail: false,
        assignedEmployees: []

    },
    editSubtaskForm:{
        name: '',
        description: '',
        points: '',
        priority: '',
        link: '',
        due_date:  '', // moment(new Date).add(1, 'day').endOf('day').format('YYYY-MM-DD')
        done: false,
        newCollaborator: false,
        users: [{
            name: '',
            email: '',
            password: '',
        }],
        showEditor: false,
        sendEmail: false,
        assignedEmployees: [{}]

    },
    commentForm: {
        title: '',
        body: ''
    },
    formBuilderForm: { // Not Yet Used
        title: '',
        body: ''
    },
    fileForm: {
        name: '',
        lastModified: '',
        lastModifiedDate: '',
        size: '',
        type: '',
        webkitRelativePath: ''
    },
    ratingForm: {
        subtask_priority: 1
    },
    commentForm: {
        to: '',
        from: '', // Should be Defaulted to The Current Auth User
        message: ''
    },
    registerForm:{
        name: '',
        email:'',
        password: '',
        hidden: true,
        password_confirmation: '',
        sendEmail: false,
        lifetime: true,
    },
    registerClientForm:{
        name: '',
        website: '',
        first_name: '',
        last_name: '',
        phone: '',
        address: '',
        address_line_2: '',
        city: '',
        zip: '',
        country: '',
        country_code: '',
        links: {
            facebook: '',
            linkedin: '',
            twitter: '',
            instagram: '',
            youtube: '',
            googleplus: '',
            website: ''
        },
        email:'',
        password: '',
        hidden: true,
        password_confirmation: '',
        new_project: false,
        projects: [{
            name: '',
        }],
        assignedProjects: null
    },
    jobDeleteForm:{
        subtasks:[]
    },
    fileEditForm:{
        name: null,
    },
    editForm: {
        task_description: null
    },
    editSubForm: {
        description: null
    }


};

/**
 * Load the Evolutly form helper class.
 */
// relative path set on our webpack.mix.js 
// resources/assets/js/evolutly
require('forms/evo-form');

/**
 * Define the Evolutly form Error collection class.
 */
// relative path set on our webpack.mix.js
// resources/assets/js/evolutly
require('forms/evo-errors');

/**
 * Add additional HTTP / form helpers to the Evolutly object.
 */
// relative path set on our webpack.mix.js
// resources/assets/js/evolutly
$.extend(Evolutly, require('forms/evo-http'));
