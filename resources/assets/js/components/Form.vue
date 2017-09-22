<template>
<v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
        <v-flex xs5 offset-xs3>
            <v-card class="text-xs-center white elevation-0">
                <v-card-text>
                    <h5>Send message to all subsribed users</h5>
                </v-card-text>
                <v-form>
                    <v-text-field
                        label="Message"
                        v-model="message"
                        multi-line
                        required
                    ></v-text-field>
                    <v-btn @click="submit" primary>Send</v-btn>
                </v-form>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
export default {
    data() {
        return { message: '' }
    },
    methods: {
        submit() {
            axios.post('/send', { 'message': this.message })
                .then(res => {
                    this.message = '';
                })
        }
    }
}
</script>
