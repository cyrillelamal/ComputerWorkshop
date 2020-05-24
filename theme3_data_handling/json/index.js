const fs = require('fs')

const filePath = '../crud/package.json'

fs.readFile(filePath, 'utf-8', (err, data) => {
    if (err) {
        console.log(err)
    } else {
        const obj = JSON.parse(data)
        console.log(obj.dependencies)
    }
})
