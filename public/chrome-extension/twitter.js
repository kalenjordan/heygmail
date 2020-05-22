function twitterInputFieldIsFocused() {
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

function twitterInputFieldIsntFocused() {
    return !twitterInputFieldIsFocused();
}

function hideUnfocusedTweets() {
    setTimeout(() => {
        let activeElement = document.activeElement;
        let role = activeElement.getAttribute('role');
        if (role !== 'article') {
            return;
        }

        let articles = document.querySelectorAll('article[role=article]:not(:focus)');
        for (i = 0; i < articles.length; ++i) {
            articles[i].style.opacity = 0;
        }
        activeElement.style.opacity = 1;
    }, 100);
}

function showAllTweets() {
    let articles = document.querySelectorAll('article[role=article]');
    for (i = 0; i < articles.length; ++i) {
        articles[i].style.opacity = 1;
    }
}

function isTwitterFocusModeEnabled() {
    return document.querySelector('header').style.display === 'none';
}

function twitterEventListener(e) {
    let activeElement = document.activeElement;

    if (e.code === 'Escape') {
        activeElement.blur();
    } else if (e.code === 'Enter' && e.metaKey) {
        document.querySelector("div[data-testid='nextButton']").click()
    } else if (e.key === 'j') {
        twitterJKey(activeElement, e);
    } else if (e.key === 'k') {
        twitterKKey(activeElement, e);
    } else if (e.key === 'f' && twitterInputFieldIsntFocused()) {
        twitterToggleFocusMode(activeElement, e);
    } else if (e.code === 'Slash' && e.shiftKey && e.altKey) {
        twitterShowKeyboardShortcuts();
    }
}

function twitterShowKeyboardShortcuts() {
    alert("" +
        "KJ Keyboard Shortcuts - version: " + version + "\n\n" +
        "j - Down" + "\n" +
        "k - Up" + "\n" +
        "f - Focus mode" + "\n" +
        ""
    );
}

function twitterJKey(activeElement, e) {
    if (isTwitterFocusModeEnabled()) {
        hideUnfocusedTweets();
    }

    if (activeElement.tagName === 'BODY') {
        document.querySelector('div[aria-label="Timeline: Messages"] div[role=tab]').focus()
    } else if (activeElement.tagName === 'DIV') {
        let next = activeElement.parentElement.parentElement.nextSibling.children[0].children[0];
        next.focus();
    }
}

function twitterKKey(activeElement, e) {
    if (isTwitterFocusModeEnabled()) {
        hideUnfocusedTweets();
    }

    if (activeElement.tagName === 'DIV') {
        let previous = activeElement.parentElement.parentElement.previousSibling.children[0].children[0];
        previous.focus();
    }
}

function twitterToggleFocusMode(activeElement, e) {
    let newVisibility = (isTwitterFocusModeEnabled()) ? 'block' : 'none';
    let newMargin = isTwitterFocusModeEnabled() ? 0 : '218px';

    setInterval(() => {
        document.title = 'focus';
    }, 100);

    document.querySelector('header').style.display = isTwitterFocusModeEnabled() ? "flex" : "none";
    document.querySelector("div[data-testid='sidebarColumn']").style.display = newVisibility;
    document.querySelector("main").style.marginLeft = newMargin;

    document.querySelector("div[role=progressbar]").parentElement.style.display = newVisibility;

    let homeH2 = document.querySelector("h2[role=heading][dir=ltr]");
    let parent = homeH2.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
    parent.style.display = newVisibility;

    if (!isTwitterFocusModeEnabled()) {
        showAllTweets();
    }
}