import Vuex from 'vuex'
import Vue from 'vue'
/**
 * {
 *  users:
     *  0: {
     *      id:1,
     *      name='test'
     *      unread: 0,
     *      count: nombre messages
     *      messages: tableau [id, form_id,to_id...]
     *  }
 * }
 */
Vue.use(Vuex);
/**
 * Fetch URL
 * @param url
 */
const fetchApi = async function (url, options={}) {
    let response = await fetch(url, {
        credentials: 'same-origin', //envoyer les cookies
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        ...options
    });
    if(response.ok) {
        return response.json()
    }
    else {
        let error = await response.json();
        throw new Error(error.message);
    }
    //debugger
};

// state parametres
const state =  {
    from: null,
    users: {}
};
// functions
const actions = {
    loadUsers: async function (context) {
        let response = await fetchApi('/api/messagerie/users')
        context.commit('addUsers', {users: response.users}) // faire appel à la fonction addUsers dans mutation
    },
    loadMessages: async function(context, userId) {
       if(!context.getters.user(userId).loaded) {     //éviter le chargement plusieurs fois..

           let response = await fetchApi('/api/messagerie/user/' + userId)
           //debugger
           context.commit('addMessages', {messages: response.messages, id: userId, count: response.count})

       }
    },
    sendMessage: async function(context, {content, userId}) {
        let response = await fetchApi('/api/messagerie/user/' + userId, {
            'method': 'POST',
            'body': JSON.stringify({
                content: content,
                to_id: userId
            })
        })
        console.log(response)
        //ajouter message récemment envoyé
        context.commit('addMessage', {message: response.message, id: userId})
    },
    //charger les messages
    loadPreviousMessages: async function(context, userId) {
        let msg = context.getters.messages(userId)[0]
        if(msg) {
            let response = await fetchApi('/api/messagerie/user/'+userId+'?before=' + msg.created_at)
            context.commit('preprendMessages', {messages: response.messages, id:userId})
            //debugger
        }
    }
};
//setters
const mutations = {
    // permet d'ajouter à la liste les utilisateurs récupérer.
    addUsers: function (state, {users}) {
        //let obj = {}
        users.forEach(function (usr) {
            let user = state.users[usr.id] || {}
            user = {...user, ...usr} //append back
            state.users = {...state.users, ...{[usr.id]: user}}
            //( pour ne pas écraser le contenu déjà dans le state..)
        })
        //state.users = obj
    },
    addMessages: function(state, {messages,id, count}) {
        //debugger
        let user = state.users[id] || {messages: [], count: 0}
        user.messages = messages
        user.count = count
        user.loaded = true
        state.users = {...state.users, ...{[id]: user}} //append*/
        //( pour ne pas écraser le contenu déjà dans le state..)
    },
    addMessage: function(state, {message, id}) {
        state.users[id].count++
      state.users[id].messages.push(message)
    },
    setMe: function(state, userId) {
        state.from = userId
    },
    preprendMessages: function(state, {messages, id}) {
        let user = state.users[id] || {}
        user.messages = [...messages,...user.messages]
        state.users = {...state.users, ...{[id]: user}}
        //debugger
    }
};
const getters = {
    users: function (state) {
        return state.users
    },
    messages: function (state) {
        return function(id) {
            let users = state.users[id]
            if(users && users.messages) {
                return users.messages
            }
            else {
                return []
            }
        }
    },
    user: function(state) {
        return function(id) {
            return state.users[id] || {};
        }
    },
    from: function(state) {
        return state.from;
    }
}
export default new Vuex.Store({
    strict: true,
    getters: getters,
    state: state,
    actions: actions,
    mutations: mutations,
})