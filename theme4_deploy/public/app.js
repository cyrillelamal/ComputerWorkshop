const loadToken = () => {
    const tokenSpan = document.getElementById('jsToken')
    return null !== tokenSpan
        ? tokenSpan.textContent
        : null
}

/**
 * Send request and delete the theme node.
 * @param evt
 * @param themeContainer
 */
const deleteTheme = (evt, themeContainer) => {
    evt.preventDefault()

    fetch(evt.target.getAttribute('href'), {method: 'DELETE'})
        .then(r => r.json())
        .then(r => {
            const {delCount} = r

            if (delCount) {
                // removed successfully
                themeContainer.parentNode.removeChild(themeContainer)
            } else {
                console.log('API changed (delete)')
            }

            deleteThemeLoader()
        }).catch(reason => console.log(reason))
}

/**
 * Delete theme buttons (on index)
 */
const deleteThemeLoader = () => {
    (document.querySelectorAll('div.app-theme') || []).forEach(themeContainer => {
        themeContainer.querySelector('a.app-delete')
            .addEventListener('click', evt => deleteTheme(evt, themeContainer))
    })
}

const createTheme = (evt, formContainer) => {
    // submit form handler
    evt.preventDefault()

    const themeNameInput = formContainer.querySelector('input[name="theme-name"]')
    const themeSlugInput = formContainer.querySelector('input[name="theme-slug"]')

    const requestBody = {
        themeName: themeNameInput.value,
        themeSlug: themeSlugInput.value
    }

    fetch(formContainer.getAttribute('action'), {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        body: JSON.stringify(requestBody)
    })
        .then(r => r.json())
        .then(r => {
            const {name, themeDetailLink, themeDeleteLink} = r

            // empty template
            const themeNode = document.querySelector('div.app-theme-template')
                .cloneNode(true).querySelector('div.app-theme')

            // theme name
            const themeNameContainer = themeNode.querySelector('div.app-theme-name')
            // theme detail link
            const themeDetailNode = themeNode.querySelector('a.app-detail')
            // theme delete link
            const themeDeleteNode = themeNode.querySelector('a.app-delete')

            themeNameContainer.textContent = name
            themeDetailNode.setAttribute('href', themeDetailLink)
            themeDeleteNode.setAttribute('href', themeDeleteLink)

            // list of themes
            document.querySelector('div.app-themes').appendChild(themeNode)

            deleteThemeLoader()
        }).catch(reason => console.log(reason))
}

/**
 * Create theme button (on index)
 */
const createThemeLoader = () => {
    const formContainer = document.querySelector('form.app-create-theme')

    if (formContainer) {
        formContainer.querySelector('button[type="submit"]')
            .addEventListener('click', evt => createTheme(evt, formContainer,))
    }
}

const createArticle = (evt, formContainer) => {
    evt.preventDefault()

    const title = formContainer.querySelector('input[name="title"]').value
    const body = formContainer.querySelector('textarea[name="body"]').value
    const slug = formContainer.querySelector('input[name="slug"]').value

    const requestBody = {
        title: title,
        body: body,
        slug: slug
    }

    fetch(formContainer.getAttribute('action'), {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json'
        },
        body: JSON.stringify(requestBody)
    })
        .then(r => r.json())
        .then(r => {
            const { articleDetailLink, articleDeleteLink, title } = r

            if (articleDetailLink && articleDeleteLink && title) {
                const articleNode = document.querySelector('div.app-article-template')
                    .cloneNode(true).querySelector('div.app-article')

                articleNode.querySelector('p.app-title').textContent = title

                articleNode.querySelector('a.app-detail').setAttribute('href', articleDetailLink)
                articleNode.querySelector('a.app-delete').setAttribute('href', articleDeleteLink)

                const articlesContainer = document.querySelector('div.app-articles')
                articlesContainer.appendChild(articleNode)
            }

            deleteArticleLoader()
        })
        .catch(reason => console.log(reason))
}

const createArticleLoader = () => {
    const formContainer = document.querySelector('form.app-create-article')

    if (formContainer) {
        formContainer.querySelector('button[type="submit"')
            .addEventListener('click', evt => createArticle(evt, formContainer))
    }
}

const deleteArticle = (evt, articleContainer) => {
    evt.preventDefault()

    fetch(evt.target.getAttribute('href'), {method: 'DELETE'})
        .then(r => r.json())
        .then(r => {
            const { msg, err } = r

            if (msg && !err) {
                articleContainer.parentNode.removeChild(articleContainer)
            }

            deleteArticleLoader()
        })
        .catch(reason => console.log(reason))
}

const deleteArticleLoader = () => {
    document.querySelectorAll('div.app-article' || []).forEach(articleContainer => {
        articleContainer.querySelector('a.app-delete')
            .addEventListener('click', evt => deleteArticle(evt, articleContainer))
    })
}

// main
const TOKEN = loadToken()

window.addEventListener('DOMContentLoaded', () => {
    if (TOKEN) {
        createThemeLoader()
        deleteThemeLoader()
        createArticleLoader()
        deleteArticleLoader()
    }
})
