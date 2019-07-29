class BirdboardForm {

    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.errors = {};
    }

    data() {
        let data = {};

        for (let attribute in this.originalData) {
            data[attribute] = this[attribute];
        }

        return data;
    }

    submit(endpoint) {
        return axios.post(endpoint, this.data())
            .catch(this.onFail.bind(this));
    }

    onFail(error) {
        this.errors = error.response.data.errors;
    }

    reset() {
        Object.assign(this, this.originalData);
    }
}

export default BirdboardForm;