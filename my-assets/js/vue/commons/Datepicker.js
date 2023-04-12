Vue.component('datepicker', {
    template: `
  <div>
  <input class="form-control" v-model="date" @input="value" :disabled="disabled">
  </div>
`,
    props: ['initial', 'disabled'],
    data() {
        return {
            date: this.initial
        };
    },
    mounted() {
        $(this.$el).datetimepicker({
            format: 'Y-m-d H:i:s',
            onChangeDateTime:(dp, $input) => {
                this.$emit('changed', $input.val());
                this.date = $input.val();
            }
        });
    },
    methods: {
        value(){
            this.$emit('changed', this.date);
        }
    }
});
