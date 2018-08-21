module.exports = {
    props:['guard'],
    data(){
        return {
            endpoints: {
                web: null,
                team: null,
                client: null,
            }
        }
    },
    methods:{
        guardAllowed(guards = ['web', 'employee', 'client'],callback){
            let self = this
            if(_.includes(guards, self.guard)){
                callback
                self.resetEndpoints()
            }else{
                self.$popup({ message: 'You Are Not Authorized To Do That Action!' })
            }
        },
        resetEndpoints(){

            this.endpoints = {
                web: null,
                team: null,
                client: null,
            }

        },
        guardedLocation({web,team,client} = this.endpoints){

            let self = this
            if(self.guard === 'client'){
                return client
            }else if(self.guard === 'employee'){
                return team
            }else{
                return web
            }

        },
    }
};
 
