import { defineStore } from 'pinia'

export const useAuth = defineStore('auth', {

    state: ()  => {
        return {
            showModal: false,
            user: {},
            logged: null as any
        }
    },


    actions: {

        openModal(){
            this.showModal = true
        },

        closeModal(){
            this.showModal = false
        },

        async isLogged() {

            if (this.logged === null) {
                try {

                    this.logged = true

                } catch (error) {
                    this.logged = false
                }
            }

            return this.logged

        },

        async login(email: string, password: string) {
            try {

                this.logged = true
            } catch (error) {
                this.logged = false
            }
        },

        async logout() {
            try {

                this.logged = false
                this.user = {}
                return true
            } catch (error) {
                return false
            }
        },
    }


})