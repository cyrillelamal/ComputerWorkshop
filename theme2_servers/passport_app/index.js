// server
const express = require('express')
const bcrypt = require('bcrypt')
const passport = require('passport')
const session = require('express-session')
const methodOverride = require('method-override')
const app = express()

const initializePassport = require('./passport-config')
initializePassport(
  passport,
  email => users.find(user => user.email === email),
  id => users.find(user => user.id === id)
)

// my little data base
const users = []

app.use(express.urlencoded({ extended: false }))
app.use(session({
  secret: 'secret',
  resave: false,
  saveUninitialized: false
}))
app.use(passport.initialize())
app.use(passport.session())
app.use(methodOverride('_method'))

app.post('/login', checkNotAuthenticated, passport.authenticate('local', {
  successRedirect: '/',
  failureRedirect: '/login',
  failureFlash: false
}))
app.post('/register', checkNotAuthenticated, async (req, res) => {
  try {
    const hashedPassword = await bcrypt.hash(req.body.password, 10)
    const user = {
      id: Date.now().toString(),
      name: req.body.name,
      email: req.body.email,
      password: hashedPassword
    }
    users.push(user)
    res.json({ user: user })
  } catch {
    res.json({ err: 'Some fields are not provided'})
  }
})
app.delete('/logout', (req, res) => {
  req.logOut()
  res.json({ msg: 'You are successfully logged out' })
})

function checkNotAuthenticated(req, res, next) {
  if (req.isAuthenticated()) {
    return res.json({ err: 'You are already authenticated' })
  }
  next()
}

app.listen(3000)
