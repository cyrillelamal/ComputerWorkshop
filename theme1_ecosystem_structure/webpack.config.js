const path = require('path');

module.exports = {
    // watch: true,
    entry: './assets/js/app.js',
    output: {
        path: path.resolve('./dist'),
        filename: 'bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_moduels|bower_components)/,
                use: ['babel-loader']
            }
        ]
    }
}
