/*jshint esversion: 6 */
const Timer = require('../assets/js/timer');

const should = require('should');

const
    n = 1,
    res = n * 1000,
    timer1 = new Timer(n);


describe('#start', function () {
    it('return n*1000', function () {
      return timer1.start.should.eventually.be.exactly(res);
    });
});
