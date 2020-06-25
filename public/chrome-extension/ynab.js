function ynabEventListener(e) {
    let activeElement = document.activeElement;
    console.log(e);

    if (e.code === 'Escape') {
        activeElement.blur();
        ynabCancelEdit();
    } else if (e.code === 'ArrowDown') {
        ynabDown(activeElement, e);
    } else if (e.code === 'KeyC' && notTyping()) {
        ynabCategorize(activeElement, e);
    } else if (e.code === 'KeyA' && notTyping()) {
        ynabApprove(activeElement, e);
    }
}

function ynabDown() {
    if (document.querySelector('.ynab-grid-body-row.is-checked')) {
        return;
    }

    document.querySelector('.ynab-grid-body-row').click();
}

function ynabCategorize(activeElement, e) {
    // setTimeout(() => {
    //     document.querySelector('.ynab-grid-body-row.is-checked').click();
    //     setTimeout(() => {
    //         document.querySelector('.ynab-grid-cell-subCategoryName input').click();
    //     }, 100);
    // }, 100);

    e.preventDefault();
}

function ynabCancelEdit() {
    if (document.querySelector('.button-cancel')) {
        document.querySelector('.button-cancel').click();
    }
}

function ynabApprove(activeElement, e) {
    // if (document.querySelector('.ynab-grid-actions-buttons .button-primary')) {
    //     document.querySelector('.ynab-grid-actions-buttons .button-primary').click();
    // }

    console.log('approve');
    if (document.querySelector('.accounts-toolbar-edit-transaction')) {
        document.querySelector('.accounts-toolbar-edit-transaction').click();
        setTimeout(() => {
            let approveButton = document.querySelector('.modal-list li:nth-of-type(4) button');
            if (approveButton && approveButton.textContent.trim() === 'Approve') {
                approveButton.click();
                setTimeout(() => {
                    ynabDown();
                }, 250);
            }
        }, 250);
    }

    e.preventDefault();
}
