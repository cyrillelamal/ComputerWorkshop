// CommonJS require
// The browser JS is not familiar with 'require' and 'module.exports'.
// Here webpack comes.

// Look At These Dudes!
const log = require('./log.js')
import config from './config.json'
import $ from 'jquery'
const Timer = require('./timer')

// The most useful script ever
log('Hello')

console.log(config)

$('body').append($('<p>JQuery element.</p>'))

const timer = new Timer(2)
timer.start.then( x => { document.title = String(x) })
