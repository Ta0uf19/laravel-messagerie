<template>
    <div class="container">
    <div class="columns is-marginless">
    <div class="column is-3">
        <div id="chatbox">
            <div id="friendslist">
                <div id="topmenu">
                    <span class="friends"></span>
                </div>
                <template v-for="user in users">
                    <router-link :to="{name: 'messages', params: {id: user.id}}">
                    <div id="friends">
                        <div class="friend">
                            <img src="/uploads/avatars/default.jpg" />
                            <p>
                                <template v-if="user.unread != 0">
                                    <strong class="badge" v-bind:data-badge="user.unread" >
                                        {{ user.name }}
                                    </strong>
                                </template>
                                <template v-else>
                                    <strong>{{ user.name }}</strong>
                                </template>
                                <span>{{ user.email }}</span>
                            </p>
                            <div class="status away"></div>
                        </div>
                    </div>
                    </router-link>
                </template>

            </div>
        </div>
    </div>
     <router-view></router-view>

    </div>
    </div>

</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        props: {
            user: Number  //id
        },
        computed: {
            ...mapGetters(['users'])
        },
        mounted () { //monté le store
            this.$store.dispatch('loadUsers') // appelé l'action loadUsers
            this.$store.commit('setMe', this.user) // récupérer Auth::client()->id et le mettre dans
        }
    }
</script>