<template>
    <div class="column">
        <div id="chatview" class="p1">
            <div id="profile">
                <img :src="'/uploads/avatars/' + user.avatar" class="floatingImg">
                <p>{{ user.name }}</p>
                <span>{{ user.email }}</span>
            </div>
            <div id="chat-messages">
                <label><a class="button is-loading" v-if="loading">Loading</a></label>
                <!--<label>Jeudi 02</label>-->
                <template v-for="message in messages">
                <div :class="cls(message.from_id)">
                    <img :src="'/uploads/avatars/' + message.user.avatar" />
                    <div class="bubble">
                        {{ message.content }}
                        <div class="corner"></div>
                        <span>{{ formatDate(message.created_at) }}</span>
                    </div>
                </div>
                </template>
        </div>
        <div id="sendmessage">
            <input type="text" name="content" v-model="content" placeholder="Entrez un message..." @keypress.enter="sendMessage"/>
        </div>
    </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import moment from 'moment'
    export default {
        data() {
          return {
              errors: {},     //variables
              content: '',
              loading: false,
              $messages: null
          }
        },
        computed: {
            messages: function () {
                return this.$store.getters.messages(this.$route.params.id)
            },
            user: function() {
                return this.$store.getters.user(this.$route.params.id)
            },
            ...mapGetters(['from']),
            count: function() {
                let use = this.$store.getters.user(this.$route.params.id).count;
                if(use) {
                    return use;
                }
                else {
                    return 0
                }
            }
        },
        mounted () {
            this.loadMessages()
            this.$messages = this.$el.querySelector('#chat-messages')
        },
        watch: {  // voir les changements de variables
            '$route.params.id': function () {    // si la param id change //relancer
                this.loadMessages()
            }
        },
        methods: {
            cls (userId) {
                let cls = 'message'
                if(userId === this.from) {
                    cls += ' right'
                }
                return cls;
            },
            async onScroll() {
                if(this.$messages.scrollTop === 0) {
                    this.loading = true
                    this.$messages.removeEventListener('scroll', this.onScroll)
                    let privHeight = this.$messages.scrollHeight;
                    //debugger
                    await this.$store.dispatch('loadPreviousMessages', this.$route.params.id)
                    this.$nextTick(function () {
                        this.$messages.scrollTop = this.$messages.scrollHeight - privHeight;
                    });
                    console.log(this.count);
                    console.log(Object.keys(this.messages).length)
                    if( (Object.keys(this.messages).length) < this.count) {
                        this.$messages.addEventListener('scroll', this.onScroll)
                    }
                    this.loading = false
                }
            },
            scrollBottom() {
                this.$nextTick(() => {
                    this.$messages.scrollTop =  this.$messages.scrollHeight
                })
            },
            async loadMessages () {
                await this.$store.dispatch('loadMessages',this.$route.params.id)
                this.scrollBottom()
                if( (Object.keys(this.messages).length) < this.count) {
                    this.$messages.addEventListener('scroll', this.onScroll)
                }
            },
            async sendMessage(e) {
                if(e.shiftKey === false) { //permettre à l'utisateur de faire un saut de ligne.
                    await this.$store.dispatch('sendMessage', {
                        content: this.content,
                        userId: this.$route.params.id
                    })
                    this.content = ""
                    this.scrollBottom()
                }

            },
            formatDate(m) {
                moment.locale('fr')
                return moment(m).fromNow();
            }
        }
    }
</script>