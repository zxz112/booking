export default {
    data() {
        return {
            errors: null
        }
    },
    methods: {
        errorFor(field) {
            console.log(this.errors)
            return this.errors != null && this.errors[field] ? this.errors[field] : null;
        }
    }
}
