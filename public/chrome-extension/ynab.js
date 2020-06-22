function ynabEventListener(e) {
    let activeElement = document.activeElement;
    console.log(e);

    if (e.code === 'Escape') {
        activeElement.blur();
        ynabCancelEdit();
    } else if (e.code === 'KeyC') {
        ynabCategorize(activeElement, e);
    } else if (e.code === 'KeyA' && e.altKey) {
        ynabApprove(activeElement, e);
    }
}

function ynabCategorize() {
    document.querySelector('.ynab-grid-body-row').click();
    // triggerMouseDown('.ynab-grid-cell.ynab-grid-cell-subCategoryName');
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
            }
        }, 250);
    }

    e.preventDefault();
}
