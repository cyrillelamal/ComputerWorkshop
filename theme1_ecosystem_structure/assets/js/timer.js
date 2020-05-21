module.exports = class Timer {
    constructor(secs) {
        this.secs = secs;
    }
    get start() {
        return new Promise((resolve, reject) => {
            setTimeout(resolve.bind(null, this.secs * 1000), this.secs * 1000);
        });
    }
}
