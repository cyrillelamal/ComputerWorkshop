const http = require('http')
const moment = require('moment')

const server = http.createServer()
server.on('request', (req, res) => {
    res.setHeader('Content-type', 'application/json; charset=utf-8')
    res.end(JSON.stringify({ date: moment().format('DD.MM.YYYY HH:mm:ss')}))
})

console.log('Listening on 8001')
server.listen(8001)
