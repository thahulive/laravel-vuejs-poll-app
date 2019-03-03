<template>
    <v-container>
        <div class="text-xs-right">
            Any suggestion? <v-btn flat small @click="optionRequest">Add Options</v-btn>
        </div>
        <v-dialog v-model="showdialogue" max-width="500px">
        <v-card>
          <v-card-title>
            Suggest new Options
          </v-card-title>
          <v-card-text>
            <template v-for="(option, index) in options">
                <v-text-field
                    :key="index"
                    label="what is your best framework?"
                    v-model="option.option"
                    single-line
                    full-width
                    hide-details
                    clearable
                    append-outer-icon="delete"
                    @click:append-outer="deleteOption(index)"
                ></v-text-field>
            </template> 
          </v-card-text>
          <v-card-actions>
            <v-btn
                color="primary"
                @click="suggestOptions"
                :loading="isLoading"
                >
                Submit
            </v-btn>
            <v-btn color="primary" flat @click="showdialogue=false">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            showdialogue: false,
            options: [
                {
                    option: ''
                }
            ]
        }
    },
    watch: {
        options: {
            handler(val, oldVal) {
                this.watchOptionCount()
            },
            deep: true       
        }
    },
    methods: {
        optionRequest () {
            this.showdialogue = true
        },
        watchOptionCount() {
            const optionsCount = this.options.length
            if(this.options[optionsCount-1].option !== '')
                this.options.push({
                    option: ''
                })
        },
        deleteOption(index) {
            if(this.options.length == 1) {
                this.options.push({
                    option: ''
                })
            }
            this.options.splice(index, 1);
        },
        async suggestOptions() {
            this.isLoading = true
            let res = await this.$store.dispatch('suggestOptions', this.options)
            if(res == 'created'){
                this.isLoading = false
                this.options = [{ option: '' }]
            }else
                this.isLoading = false
        },
    }

}
</script>

<style>

</style>
