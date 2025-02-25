export default class HttpClient {

    constructor(baseUrl = '', csrfToken = '') {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

    request(url, method = 'GET', parameters = {}, headers = {}, callBack) {
        let fullUrl = this.baseUrl + url;
        console.log(url);
        console.log(fullUrl);
        if (method !== 'GET') {
            headers['X-CSRF-Token'] = this.csrfToken;
        }
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...headers
            }
        }
        if (method === 'GET' && Object.entries(parameters).length > 0) {
            const queryString = new URLSearchParams(parameters).toString();
            fullUrl = fullUrl + '?' + queryString;
        } else if (method !== 'GET') {
            options.body = JSON.stringify(parameters);
        }
        fetch(fullUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Unknown error');
                });
            }
            return response.json();
        })
            .then(data => {
                console.log("Data received from the server:", data);
                callBack(data);
            })
            .catch(error => {
                console.log(url, method, error);
            })
    }

    delete(url, parameters = {}, callBack) {
        this.request(url, 'DELETE', parameters, {}, callBack);
    }

    get(url, parameters = {}, callBack) {
        this.request(url, 'GET', parameters, {}, callBack);
    }

    post(url, parameters = {}, callBack) {
        this.request(url, 'POST', parameters, {}, callBack);
    }

    put(url, parameters = {}, callBack) {
        this.request(url, 'PUT', parameters, {}, callBack);
    }

    set csrf(csrfToken) {
        this.csrfToken = csrfToken;
    }
}