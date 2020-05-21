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


document.addEventListener('keydown', function (e) {
    let activeElement = document.activeElement;
    console.log('active element: ');
    console.log(activeElement);
    if (activeElement.getAttribute('role')) {
        console.log('role:');
        console.log(activeElement.getAttribute('role'));
    }

    if (e.code === 'Escape') {
        activeElement.blur();
    }

    if (e.code === 'Enter' && e.metaKey) {
        document.querySelector("div[data-testid='nextButton']").click()
    }

    if (e.key === 'j' ) {
        if (activeElement.tagName === 'BODY') {
            document.querySelector('div[aria-label="Timeline: Messages"] div[role=tab]').focus()
        } else if (activeElement.tagName === 'DIV') {
            let next = activeElement.parentElement.parentElement.nextSibling.children[0].children[0];
            // console.log('next: ');
            next.focus();
        }
    }

    if (e.key === 'k' ) {
        if (activeElement.tagName === 'DIV') {
            let previous = activeElement.parentElement.parentElement.previousSibling.children[0].children[0];
            previous.focus();
        }
    }

    if (e.key === 'f' && inputFieldIsntFocused() ) {
        let currentVisibility = document.querySelector('header').style.visibility;
        newVisibility = (!currentVisibility  || currentVisibility === 'visible') ? 'hidden' : 'visible';
        document.querySelector('header').style.visibility = newVisibility;
        document.querySelector("div[data-testid='sidebarColumn']").style.visibility = newVisibility;
    }
});
