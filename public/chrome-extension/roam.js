function roamIsFocusModeEnabled() {
    return document.querySelector('.roam-sidebar-container').style.visibility === 'hidden';
}

function roamEventListener(e) {
    let activeElement = document.activeElement;
    console.log(e);

    if (e.code === 'Escape') {
        activeElement.blur();
    } else if (e.code === 'KeyF' && e.altKey) {
        roamToggleFocus(activeElement, e);
    } else if (e.code === 'KeyL' && e.altKey) {
        roamClickLeftNav(activeElement, e);
    } else if ((e.code === 'Enter' || e.code === 'Tab') && roamAutocompleteIsOpen()) {
        roamSelectFirstAutocompleteOption(activeElement, e);
    } else if (e.code === 'ArrowDown' && e.altKey) {
        roamSelectLastBullet(activeElement, e);
    }
}

function roamSelectLastBullet(activeElement, e) {
    let evt = document.createEvent('MouseEvents')
    evt.initMouseEvent('mousedown', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.querySelectorAll('.roam-article .roam-block-container:last-of-type .roam-block')[0].dispatchEvent(evt)
    
    e.preventDefault();
}

function roamSelectFirstAutocompleteOption(activeElement, e) {
    console.log('select first auto complete option');
    document.querySelector('.bp3-elevation-3 .dont-unfocus-block').click();
    e.preventDefault();
}

function roamAutocompleteIsOpen() {
    return document.querySelector('.bp3-elevation-3') !== null;
}

function roamToggleFocus(activeElement, e) {
    let newVisibility = roamIsFocusModeEnabled() ? 'visible' : 'hidden';

    document.querySelector('.roam-sidebar-container').style.visibility = newVisibility;
    document.querySelector('.roam-topbar').style.visibility = newVisibility;
    document.querySelector('#buffer').style.visibility = newVisibility;
    document.querySelector('.rm-reference-main').style.visibility = newVisibility;
    document.querySelector('.roam-log-preview').style.visibility = newVisibility;
    document.querySelector('.roam-body-main').style.right = roamIsFocusModeEnabled() ? '91px' : 0;

    document.querySelector('#right-sidebar .bp3-button').style.visibility = newVisibility;

    e.preventDefault();
}

function roamClickLeftNav(activeElement, e) {
    console.log('click left nav');
    document.querySelector('.roam-topbar .bp3-button').click();
    e.preventDefault();
}