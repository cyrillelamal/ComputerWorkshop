// encode your expression
// example
// (<?host_and_port>)?expr=2%2B2%2A2
const http = require('http');
const url = require('url');

const ACCEPTABLE_TERMS = '1234567890+-*/.'.split('')


const acceptableTerms = (str) => {
    if (!str) {
        return false;
    }

    for (let i = 0; i < str.length; i++) {
        if (ACCEPTABLE_TERMS.indexOf(str[i]) < 0) {
            return false;
        }
    }

    return true;
};

http.createServer((req, res) => {
    const q = url.parse(req.url, true).query;
    console.log(q);

    const expr = q.expr;

    const resCode = acceptableTerms(expr) ? 200 : 400;

    const result = 200 === resCode ? Number(eval(expr)) : null;

    res.writeHead(resCode, {'content-type': 'application/json'});
    res.end(JSON.stringify({
        result: result
    }))

}).listen(8080);
