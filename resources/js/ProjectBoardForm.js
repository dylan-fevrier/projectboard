class ProjectBoardForm {

    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.errors = {};
    }

    data() {
        return Object.keys(this.originalData).reduce((data, attribute) => {
            data[attribute] = this[attribute];
            return data;
        }, {});
    }

    post(endpoint) {
        return this.submit(endpoint);
    }

    patch(endpoint) {
        return this.submit(endpoint, 'patch');
    }

    delete(endpoint) {
        return this.submit(endpoint, 'delete');
    }

    submit(endpoint, requestType = 'post') {
        return axios[requestType](endpoint, this.data())
            .catch(this.onFail.bind(this));
    }

    onFail(error) {
        this.errors = error.response.data.errors;

        throw error;
    }

    reset() {
        Object.assign(this, this.originalData);
    }
}

export default ProjectBoardForm;
