console.log("Running Chrome Extension");

function inputFieldIsFocused()
{
    let activeElement = document.activeElement;
    let role = activeElement.getAttribute('role');
    if (!role) {
        return false;
    }

    if (role === 'textbox') {
        return true;
    }

    return false;
}

function inputFieldIsntFocused()
{
    return ! inputFieldIsFocused();
}

function hideUnfocusedTweets()
{
    setTimeout(() => {
        let activeElement = document.activeElement;
        let role = activeElement.getAttribute('role');
        if (role !== 'article') {
            return;
        }

        let articles = document.querySelectorAll('article[role=article]:not(:focus)');
        for (i = 0; i < articles.length; ++i) {
            console.log('in loop ' + i);
            articles[i].style.opacity = 0;
        }
        activeElement.style.opacity = 1;
    }, 100);
}

function showAllTweets()
{
    let articles = document.querySelectorAll('article[role=article]');
    for (i = 0; i < articles.length; ++i) {
        console.log('in loop ' + i);
        articles[i].style.opacity = 1;
    }
}

function isFocusModeEnabled()
{
    return document.querySelector('header').style.display === 'none';
}

document.addEventListener('keydown', function (e) {
    let activeElement = document.activeElement;
    let role = activeElement.getAttribute('role');
    // console.log('active element: ');
    // console.log(activeElement);

    if (e.code === 'Escape') {
        activeElement.blur();
    }

    if (e.code === 'Enter' && e.metaKey) {
        document.querySelector("div[data-testid='nextButton']").click()
    }

    if (e.key === 'j' ) {
        if (isFocusModeEnabled()) {
            hideUnfocusedTweets();
        }

        if (activeElement.tagName === 'BODY') {
            document.querySelector('div[aria-label="Timeline: Messages"] div[role=tab]').focus()
        } else if (activeElement.tagName === 'DIV') {
            let next = activeElement.parentElement.parentElement.nextSibling.children[0].children[0];
            // console.log('next: ');
            next.focus();
        }
    }

    if (e.key === 'k' ) {
        if (isFocusModeEnabled()) {
            hideUnfocusedTweets();
        }

        if (activeElement.tagName === 'DIV') {
            let previous = activeElement.parentElement.parentElement.previousSibling.children[0].children[0];
            previous.focus();
        }
    }

    if (e.key === 'f' && inputFieldIsntFocused() ) {
        let newVisibility = (isFocusModeEnabled()) ? 'block' : 'none';
        let newMargin = isFocusModeEnabled() ? 0 : '200px';

        setInterval(() => {
            document.title = 'focus';
        }, 100);

        document.querySelector('header').style.display = newVisibility;
        document.querySelector("div[data-testid='sidebarColumn']").style.display = newVisibility;
        document.querySelector("h2[role=heading]").style.display = newVisibility;
        document.querySelector("main").style.marginLeft = newMargin;

        if (!isFocusModeEnabled()) {
            showAllTweets();
        }
    }
});
