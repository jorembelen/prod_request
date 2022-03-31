export default {
    methods: {
        getImgUrl(pic) {
            return '../images/'+pic
        },
        getImgUrlFromStorage(pic) {
            var url = pic.replace('public', '../storage')
            return url
        }
    }
}