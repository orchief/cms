const config = {
    axios: {
        defaults: {
            // baseURL: 'http://pshop.pstech360.com/',
            // baseURL: 'http://pshop.com/v1/',
            baseURL: 'http://localhost/pshop/api/',
            timeout: 1000 * 15,
            withCredentials: true
        }
    },
    // ResourceBaseUrl: 'http://pshop.pstech360.com/'
        ResourceBaseUrl: 'http://localhost/pshop/api/public/'
        // ResourceBaseUrl: 'http://pshop.com/v1/public/'
}

export default config