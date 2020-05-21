/*jshint esversion: 6 */
const fetch = require('node-fetch');

const should = require('should');

const URI = 'https://kodaktor.ru/api/md5/';
const BODY = 'src= ';

const RES = '7215ee9c7d9dc229d2921a40e899ec5f';

describe('md5', () => {
    it('return md5 of the space character', () => {
        return fetch(URI, {
            method: 'POST',
            body: BODY
        })
            .then(res => res.json())
            .then(json => json.md5)
            .should.eventually.be.exactly(RES);
    })
})
