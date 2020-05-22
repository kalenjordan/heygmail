function roamIsFocusModeEnabled() {
    return document.querySelector('.roam-sidebar-container').style.visibility === 'hidden';
}

function roamEventListener(e) {
    let activeElement = document.activeElement;
    console.log(e);

    if (e.code === 'Escape') {
        activeElement.blur();
    } else if (e.code === 'KeyF' && e.altKey) {
        roamAltFKey(activeElement, e);
    }
}

function roamAltFKey(activeElement, e) {
    let newVisibility = roamIsFocusModeEnabled() ? 'visible' : 'hidden';
    console.log('new: ' + newVisibility);

    document.querySelector('.roam-sidebar-container').style.visibility = newVisibility;
    document.querySelector('.roam-topbar').style.visibility = newVisibility;
    document.querySelector('#buffer').style.visibility = newVisibility;
}