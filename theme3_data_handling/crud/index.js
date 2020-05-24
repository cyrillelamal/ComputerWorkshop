const express = require('express')
const sqlite3 = require('sqlite3').verbose()
const bcrypt = require('bcrypt')

const app = express()
app.use(express.urlencoded())
app.use(express.json())

// CREATE: {"user": {"email": "mail@lorem.com", "password": "plainPassword"}
// READ {"all": false, "email": "some@mail.com"}
// etc.

const hashString = async (str) => bcrypt.hash(str, 10)

const db = new sqlite3.Database(':memory:')

// test/demonstration suite
db.run('CREATE TABLE user (email TEXT PRIMARY KEY, password_hash TEXT NOT NULL)')

// TODO: authenticate
app.post('/create', async (req, res) => {
    const email = req.body.user.email
    const plainPassword = req.body.user.password

    if (email && plainPassword) {
        try {
            const hash = await hashString()

            const sql = 'INSERT INTO user (email, password_hash) VALUES (?, ?)'
            const params = [email, hash]

            db.run(sql, params, (err) => res.status(400).json({err: err}))

            res.status(201).json({msg: 'User has been added'})
        } catch (e) {
            res.status(400).json({err: e})
        }
    }

    res.status(400).json({ err: 'Some fields are not provided' })
})
app.get('/read', (req, res) => {
    const all = req.body.all
    const email = req.body.email

    let sql = ''
    let params = []

    if (all) {
        sql = 'SELECT FROM user WHERE 1'
    } else if (email) {
        sql = 'SELECT FROM user WHERE email=?'
        params.push(email)
    }

    if (sql) {
        db.all(sql, params, (err, rows) => {
            if (err) {
                res.status(400).json({ err: err })
            }
            res.json({ rows: rows })
        })
    }
})
app.put('/update', (req, res) => {
    const oldEmail = req.body.oldEmail
    const newEmail = req.body.newEmail
    const newPassword = req.body.newPassword

    let sql = 'UPDATE user SET'
    let params = []
    let resErr = null  // whether there is error in request
    // TODO: check the old email, password, etc.

    if (newPassword) {
        sql += ' password=?,'
        params.push(newPassword)
    }
    if (newEmail) {
        sql += ' email=?,'
        params.push(newEmail)
    }

    if (sql.endsWith(',')) {
        sql = sql.substr(0, -1)
    }

    if (newEmail || newPassword) {
        if (oldEmail) {
            sql += ' WHERE email=?'
            params.push(oldEmail)

            db.run(sql, params, (err) => resErr = err)
        } else {
            resErr = 'The current email is not provided'
        }
    } else {
        resErr = 'Incorrect data'
    }

    res.status(400).json({ err: resErr })
})
app.delete('/delete', (req, res) => {
    const email = req.body.user.email

    if (email) {
        const sql = 'DELETE FROM user WHERE email=?'

        db.run(sql, [email], (err) => res.status(500).json({ err: err }))
        res.json({ removedEmail: email })

    }
})
app.listen(8000)
db.close()
