const loadToken = () => {
    const tokenSpan = document.getElementById('jsToken')
    return null !== tokenSpan
        ? tokenSpan.textContent
        : null
}

const TOKEN = loadToken()

const removeTheme = (e, res) => {
    console.log(e, res) // TODO: paren nodes after front
}

const appendTheme = (e, res) => {
    console.log(e, res) // TODO: paren nodes after front
}

const removeArticle = (e, res) => {

}

// // delete buttons
// document.querySelectorAll('a.delete').forEach(el => {
//     el.addEventListener('click', e => {
//         e.preventDefault()
//
//         const el = e.target
//
//         if (TOKEN) {
//             fetch(el.getAttribute('href'), {method: 'DELETE'})
//                 .then(res => res.json())
//                 .then(res => removeTheme(e, res))
//         } else {
//             console.log('Tu te crois malin ?')
//         }
//     })
// })
//
// // input form
// try {
//     document.querySelector('input.create').addEventListener('click', e => {
//         e.preventDefault()
//
//         const el = e.target
//
//         const form = el.parentNode
//         const addr = form.getAttribute('action')
//
//         const themeName = form.querySelector('[name="theme-name"]').value
//         const themeSlug = form.querySelector('[name="theme-slug"]').value
//
//         fetch(addr, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({
//                 'theme-name': themeName,
//                 'theme-slug': themeSlug
//             })
//         })
//             .then(res => res.json())
//             .then(res => appendTheme(e, res))
//     })
//
// } catch (e) {}

if (TOKEN) {
    // article delete
    document.querySelectorAll('div.app-article a.app-delete').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault()
            const el = e.target

            const addr = el.getAttribute('href')

            fetch(addr, {method: 'DELETE'})
                .then(res => res.json())
                .then(res => removeArticle(e, res)) // TODO: remove the block
        })
    })

}

window.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.editable')

    if (null !== elements) {
        elements.forEach(el => new Minislate.simpleEditor(el))
        elements.forEach(el => {
            el.addEventListener('input', e => document.getElementById('body').textContent = e.target.textContent)
        })
    }
});
//

