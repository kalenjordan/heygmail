console.log("Running Chrome Extension");

document.addEventListener('keydown', function (e) {
    let activeElement = document.activeElement;
    console.log('active element: ');
    console.log(activeElement.tagName);

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
});
