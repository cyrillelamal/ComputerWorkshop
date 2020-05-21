// CommonJS require
// The browser JS is not familiar with 'require' and 'module.exports'.
// Here webpack comes.

// Look At This Dude!
const log = require('./log.js')
import config from './config.json'
import $ from 'jquery'

// The most useful script ever
log('Hello')

console.log(config)

$('body').append($('<p>JQuery element.</p>'))
