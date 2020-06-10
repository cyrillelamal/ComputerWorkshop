const express = require('express');
const { get } = require('axios');

const URL = 'https://kodaktor.ru/j/users';

const PORT = 8001;
const app = express()

app
    .get('/users', async r => {
        const { data: {users: items } } = await get(URL);
        r.res.render('list', { title: 'Login list', items })
    })
    .use(r => r.res.status(404).end('Not found'))
    .use((e, r, res, n) => res.status(500).end(`Error: ${e}`))
    .set('view engine', 'pug')
    .set('views', './views')
    .listen(PORT)
;
